<?php

@session_start();

class Pedido
{

    public function __construct()
    {
        if (ClienteSessao::get_id() <= 0) {
            Http::redirect_to('/entrar/?carrinho');
        }
    }

    public function indexAction()
    {
        $pagamento = (new pagamentoModel)->get_all();
        $config = (new configModel)->get_config();
        $cliente = ClienteSessao::get_obj();
        $cliente_id = ClienteSessao::get_id();
        $endereco = (new enderecoModel)->get_by_cliente($cliente_id);
        $dados = [
            'config' => $config,
            'cliente' => $cliente,
            'pagamento' => $pagamento,
            'endereco' => $endereco
        ];
        if ($pagamento->pagamento_status == 1) {
            $cred = self::pagseguro_get_session($pagamento->pagamento_usuario, $pagamento->pagamento_senha, $pagamento->pagamento_gw);
            $dados['url_js'] = $cred->url_js;
            $cred->url_ssid = (array)$cred->url_ssid;
            if (($cred->url_ssid[0])) {
                $dados['url_ssid'] = $cred->url_ssid[0];
            } else {
                $dados['url_ssid'] = $cred->url_ssid;
            }
        }
        if (Carrinho::isfull()) {
            $itens = Carrinho::get_all();
            $dados['itens'] = $itens;
        } else {
            Http::redirect_to('/meus-pedidos/');
        }
        Tpl::view("site.carrinho", $dados);
    }

    public function aplica_cupom()
    {
        $cupom = Post::get('cupom', 'string');
        $local = Post::get('local', 'int');
        $obs = Post::get('obs', 'string');
        if ($local >= 0) {
            $_SESSION['__LOCAL__'] = $local;
        }
        if ($obs != "") {
            $_SESSION['__OBS__'] = $obs;
        }
        if (strlen($cupom) > 0) {
            $dados = (new cupomModel)->get_by_nome($cupom);
            if (isset($dados->cupom_id) && $dados->cupom_id > 0) {
                if (!isset($_SESSION['__CUPOM__']) && empty($_SESSION['__CUPOM__'])) {
                    $_SESSION['__CUPOM__'] = $dados;
                    echo 1;
                    exit;
                } else {
                    echo 0;
                    exit;
                }
            } else {
                echo 0;
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    public function remove_cupom()
    {
        if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
            unset($_SESSION['__CUPOM__']);
        }
    }

    public function lista()
    {
        $config = (new configModel)->get_config();
        $cliente_id = ClienteSessao::get_id();
        $pedido = (new pedidoModel)->get_by_cliente($cliente_id);
        $dados = array(
            'pedido' => $pedido,
            'config' => $config,
        );
        Tpl::view("site.pedido-lista", $dados);
    }

    public function exibir()
    {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(1, 'int');
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $cliente = ClienteSessao::get_obj();
        if ($pedido == null) {
            Http::redirect_to("/meus-pedidos/?pedido-nao-encontrato");
        }
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        if (empty($pedido->endereco_id) && empty($pedido->endereco_cliente)) {
            $endereco = null;
            $pedido->retirar_no_local = "Retirar no Local";
        } else {
            $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        }
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'cliente' => $cliente,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("site.pedido-exibir", $dados);
    }

    public function confirmar()
    {
        if (Carrinho::isfull()) {
            $cart = Carrinho::get_all();
            $cliente = ClienteSessao::get_obj();
            $local = Post::get('pedido_local', 'int');
            $bairro = Post::get_and_drop('pedido_bairro');
            if ($local == 0) {
                $local = 0;
                $entrega_valor = 0;
            } else {
                $entrega_valor = self::get_preco_entrega($bairro);
            }
            $p = new stdClass;
            $p->pedido_cliente = $cliente->cliente_id;
            $p->pedido_data = date('Y-m-d H:i:s');
            $p->pedido_local = $local;
            $p->pedido_total = Currency::moedaUS(Post::get('pedido_total'));
            $p->pedido_entrega = Currency::moedaUS($entrega_valor);
            $p->pedido_entrega_prazo = Post::get('pedido_entrega_prazo');
            if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
                if ($_SESSION['__CUPOM__']->cupom_tipo == 1) {
                    $cupom_valor = "R$ " . Currency::moeda(floatval($_SESSION['__CUPOM__']->cupom_valor));
                } else {
                    $cupom_valor = (intval($_SESSION['__CUPOM__']->cupom_percent)) . "%";
                }
                $str_cupom = '<br>Cupom ' . $_SESSION['__CUPOM__']->cupom_nome . ' - ' . $cupom_valor;
                $p->pedido_obs = Filter::antiSQL(Post::get('pedido_obs'), true) . $str_cupom;
            } else {
                $p->pedido_obs = Filter::antiSQL(Post::get('pedido_obs'), true);
            }
            $p->pedido_obs_pagto = Filter::antiSQL(Post::get('pedido_obs_pagto'), true);
            $p->pedido_id = (new pedidoModel)->incluir($p, $cart);
            $_SESSION['__LAST__PEDIDO__']['ID'] = $p->pedido_id;
            $_SESSION['__LAST__PEDIDO__']['STATUS'] = 1;
            if ($p->pedido_id > 0) {
                foreach ($cart as $item) {
                    self::atualiza_estoque($item);
                }
                self::notificarPedido($p);
                Carrinho::clear();
                Http::redirect_to("/detalhes-do-pedido/$p->pedido_id/?new");
            } else {
                Http::redirect_to("/pedido/?error");
            }
        } else {
            Http::redirect_to("/");
        }
    }

    static public function atualiza_estoque($item)
    {
        $decrement = "UPDATE item SET item_estoque = (item_estoque - $item->qtde) WHERE item_id = $item->item_id;";
        (new Factory('item'))->query($decrement);
    }

    static public function get_preco_entrega($bairro)
    {
        $preco = (new Factory('bairro'))->find($bairro);
        return $preco->bairro_preco;
    }

    static public function getfaixaParam($cep)
    {
        $intervalos = (new entregaModel)->get_faixas();
        //$cep = explode("-", $cep)[0];
        $v = (int)preg_replace("/\D+/", "", $cep);
        $rs = '-1';
        foreach ($intervalos as $faixa) {
            $range = [$faixa->entrega_inicio, $faixa->entrega_fim];
            list($min, $max) = $range;
            if ($v >= $min && $v <= $max) {
                $rs = "$faixa->entrega_taxa <br>";
            }
        }
        return $rs;
    }

    public function notificarPedido($pedido)
    {
        $conf = (new configModel)->get_config();
        /* NOTIFICA CLIENTE */
        $cliente = ClienteSessao::get_obj();
        //$url = Http::base() . '/pedido-ficha-cliente/' . $pedido->pedido_id . '/';
        //$body = Request::open_curl($url, $cliente);
        $body = "Recebemos seu pedido!";
        $data = array(
            'destinatario' => "$cliente->cliente_email",
            'assunto' => "$conf->config_nome - Seu Pedido NÂº $pedido->pedido_id",
            'mensagem' => $body,
        );
        Sender::mail($data);
        /* NOTIFICA ADM */
        $host = new smtpModel();
        //$url = Http::base() . '/pedido-ficha-admin/' . $pedido->pedido_id . '/';
        $body = "Novo Pedido";
        $data = array(
            'destinatario' => $host->__get('email'),
            'bcc' => array($host->__get('bcc')),
            'assunto' => "$conf->config_nome - Novo Pedido NÂº $pedido->pedido_id",
            'mensagem' => $body,
        );
        Sender::mail($data);
    }

    public function ficha_cliente()
    {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(1);
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("site.pedido-ficha-cliente", $dados);
    }

    public function ficha_admin()
    {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(1);
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("site.pedido-ficha-admin", $dados);
    }

    static public function pagseguro_get_session($email = "suporte@lojamodelo.com.br",
                                                 $token = "57BE455F4EC148E5A54D9BB91C5AC12C",
                                                 $__ENV = 'SANDBOX')
    {

        $credenciais = "email=$email&token=$token";
        $env = self::pagseguro_get_env($__ENV);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $env->url_ssid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $credenciais);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) die('Error:' . curl_error($ch));
        curl_close($ch);
        $result = @simplexml_load_string($result);
        if ($result) {
            $result = $result->id;
        }
        return (object)['url_ssid' => $result, 'url_js' => $env->url_js, 'trans_url' => $env->trans_url];

    }

    static public function pagseguro_get_env($env)
    {
        if ($env == 'SANDBOX') {
            $URL_SESSION = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';
            $URL_JS = 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js';
            $TRANS_URL = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";
        } else {
            $URL_SESSION = 'https://ws.pagseguro.uol.com.br/v2/sessions';
            $URL_JS = 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js';
            $TRANS_URL = "https://ws.pagseguro.uol.com.br/v2/transactions";
        }
        return (object)['url_ssid' => $URL_SESSION, 'url_js' => $URL_JS, 'trans_url' => $TRANS_URL];

    }

    public function confirmar_pagseguro()
    {
        if (Carrinho::isfull()) {
            $config = (new configModel)->get_config();
            $cart = Carrinho::get_all();
            $cliente = ClienteSessao::get_obj();
            $p = new stdClass;
            $p->pedido_cliente = $cliente->cliente_id;
            $p->pedido_data = date('Y-m-d H:i:s');
            $local = Post::get('pedido_local', 'int');
            $bairro = Post::get_and_drop('pedido_bairro');
            if ($local == 0) {
                $local = 0;
                $entrega_valor = 0;
            } else {
                $entrega_valor = self::get_preco_entrega($bairro);
            }
            $p->pedido_local = $local;
            $p->pedido_entrega = Currency::moedaUS($entrega_valor);
            $p->pedido_total = Currency::moedaUS(Post::get('total_amount') + $p->pedido_entrega);
            $p->pedido_entrega_prazo = Post::get('pedido_entrega_prazo');
            $p->pedido_obs_pagto = 'Pagamento Online';
            if (isset($_SESSION['__CUPOM__']) && !empty($_SESSION['__CUPOM__'])) {
                $p->pedido_obs = Filter::antiSQL(Post::get('pedido_obs'), true) . '<strong class="text-center"><br><br><br>Cupom ' . $_SESSION['__CUPOM__']->cupom_nome . ' utilizado nesta compra</strong>';
            } else {
                $p->pedido_obs = Filter::antiSQL(Post::get('pedido_obs'), true);
            }
            $p->pedido_id = (new pedidoModel)->incluir($p, $cart);
            // pagseguro
            if ($p->pedido_id > 0) {
                $p->cliente_telefone = preg_replace("/[^0-9]/", "", $cliente->cliente_fone2);
                $p->cliente_ddd = substr($cliente->cliente_fone2, 1, 2);
                $p->cliente_telefone = preg_replace("/[^0-9]/", "", trim(substr($cliente->cliente_fone2, 4, -1)));
                $nascimento = $_POST['cliente_nascimento'];
                $p->cliente_nascimento = "$nascimento";
                $itens_p = array();
                $j = 0;
                foreach ($cart as $i) { //terminar loop com cart
                    $j++;
                    $lista_preco = preg_replace('/\,/', '', $i->item_preco);
                    $preco_extra = preg_replace('/\,/', '', $i->extra_preco);
                    $total_preco =  floatval($lista_preco) + floatval($preco_extra);
                    $itens_p["itemId$j"] = $i->item_id;
                    $itens_p["itemDescription$j"] = "$i->item_nome";
                    $itens_p["itemAmount$j"] = number_format($total_preco, 2, '.', '');
                    $itens_p["itemQuantity$j"] = $i->qtde;
                }
            }
            $cliente->cliente_email = "null@phpstaff.com.br";
            $cliente->cliente_cpf = "00110589866";
            $cliente_doc = $cliente->cliente_cpf;
            if (isset($_POST['cartao_nome']) && !empty($_POST['cartao_nome'])) {
                $cliente_nome = $_POST['cartao_nome'];
            } else {
                $cliente_nome = $cliente->cliente_nome;
            }
            $cliente_doc = Filter::antiSQL(Post::get('cartao_cpf'));
            $pagamento = (new pagamentoModel)->get_all();
            $env = self::pagseguro_get_env($pagamento->pagamento_gw);
            if ($pagamento->pagamento_gw == 'SANDBOX') {
                $pagamento->pagamento_usuario = 'joao-comprador@sandbox.pagseguro.com.br';
            }
            $cliente_doc = preg_replace(['/\,/', '/\./', '/\//', '/\-/'], ['', '', ''], $cliente_doc);
            $sender = [
                //CLIENTE LOGADO
                'reference' => "$p->pedido_id",
                'senderName' => trim("$cliente_nome"),
                "senderCPF" => trim("$cliente_doc"),
                'senderAreaCode' => $p->cliente_ddd,
                'senderPhone' => $p->cliente_telefone,
                'senderEmail' => $cliente->cliente_email
            ];
            $endereco_entrega = (new enderecoModel)->get_by_cliente($p->pedido_cliente);
            $endereco_entrega = $endereco_entrega[0];
            if (empty($endereco_entrega->endereco_endereco)) {
                $endereco_entrega->endereco_endereco = 'AV Paulista';
            }
            if (empty($endereco_entrega->endereco_endereco)) {
                $endereco_entrega->endereco_endereco = '1578';
            }
            if (empty($endereco_entrega->endereco_bairro)) {
                $endereco_entrega->endereco_bairro = 'Bela Vista';
            }
            if (empty($endereco_entrega->endereco_cep)) {
                $endereco_entrega->endereco_cep = '01310-200';
            }
            if (empty($endereco_entrega->endereco_cidade)) {
                $endereco_entrega->endereco_cidade = 'São Paulo';
            }
            if (empty($endereco_entrega->endereco_uf)) {
                $endereco_entrega->endereco_uf = 'SP';
            }
            $shipping = [
                'shippingAddressStreet' => $endereco_entrega->endereco_endereco,
                'shippingAddressNumber' => $endereco_entrega->endereco_numero,
                'shippingAddressDistrict' => $endereco_entrega->endereco_bairro,
                'shippingAddressPostalCode' => $endereco_entrega->endereco_cep,
                'shippingAddressCity' => $endereco_entrega->endereco_cidade,
                'shippingAddressState' => $endereco_entrega->endereco_uf,
                'shippingAddressCountry' => 'BRA',
                'shippingType' => '1',
                'shippingCost' => number_format($p->pedido_entrega, 2, '.', '.')
            ];
            $bill = [
                'billingAddressStreet' => $endereco_entrega->endereco_endereco,
                'billingAddressNumber' => $endereco_entrega->endereco_numero,
                'billingAddressDistrict' => $endereco_entrega->endereco_bairro,
                'billingAddressPostalCode' => $endereco_entrega->endereco_cep,
                'billingAddressCity' => $endereco_entrega->endereco_cidade,
                'billingAddressState' => $endereco_entrega->endereco_uf,
                'billingAddressCountry' => 'BRA',
            ];
            $final = array_merge($bill, $shipping);
            $final = array_merge($final, $itens_p);
            $final = array_merge($final, $sender);
            $metodo = 'cartao';
            if ($metodo == 'cartao') {
                $cartao_nome = $_POST['cartao_nome'];
                $card_token = $_POST['card_token'];
                $sender_hash = $_POST['sender_hash'];
                $cartao_cpf = $_POST['cartao_cpf'];
                $parcelas = intval($_POST['card_parcela']);
                $total_amount = $_POST['total_amount'];
                //$total_amount = floatval(number_format($_POST['total_amount'], 2, '.', ''));
                $cartao_cpf = preg_replace(['/\,/', '/\./', '/\-/'], ['', '', ''], $cartao_cpf);
                $installmentValue = number_format($total_amount + $p->pedido_entrega, 2, '.', '');
                $card =
                    [
                        //'noInterestInstallmentQuantity'=> 2,//parcelas sem juros
                        'installmentQuantity' => $parcelas,
                        'installmentValue' => $installmentValue,
                        //DADOS DO TITULAR CARTAO
                        'creditCardHolderName' => "$cartao_nome",
                        'creditCardHolderCPF' => "$cartao_cpf",
                        'creditCardHolderBirthDate' => $_POST['cliente_nascimento'],
                        'creditCardHolderAreaCode' => $p->cliente_ddd,
                        'creditCardHolderPhone' => $p->cliente_telefone,
                    ];
                if ($pagamento->pagamento_gw == 'SANDBOX') {
                    $pagamento->pagamento_usuario = 'suporte@lojamodelo.com.br';
                    $pagamento->pagamento_senha = '57BE455F4EC148E5A54D9BB91C5AC12C';
                }
                $creds = [
                    'email' => "$pagamento->pagamento_usuario",
                    'token' => "$pagamento->pagamento_senha",
                    'creditCardToken' => "$card_token",
                    'senderHash' => "$sender_hash",
                    'receiverEmail' => "$pagamento->pagamento_usuario",
                    'notificationURL' => Http::base() . "/notificacao/pagseguro",
                    'paymentMode' => 'default',
                    'paymentMethod' => 'creditCard',
                    'currency' => 'BRL'
                ];
                $final = array_merge($final, $card);
                $final = array_merge($final, $creds);
            }
            $headers = ['Content-Type' => 'application/json; charset=UTF-8;'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $env->trans_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($final, '', '&'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if ($result != 'Unauthorized') {
                $result = simplexml_load_string($result);
            } else {
                $result = 'Unauthorized';
            }
            if ($result == 'Unauthorized') {
                $query = "pedido_status = 5, pedido_pagseguro = 7, pedido_obs = 'Pedido não autorizado pelo PagSeguro!'";
                (new pedidoModel)->incluir_pagseguro($query, $p->pedido_id);
                Carrinho::clear();
                curl_close($ch);
                self::notificarPedido($p);
                Http::redirect_to("/detalhes-do-pedido/$p->pedido_id/?recusado");
                exit;
            } else {
                if (isset($result->code) && !empty($result->code)) {
                    $url_code = $result->code;
                    $pedidoURL = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code=$url_code";
                    $query = "pedido_url_code = '$url_code', pedido_pedidourl = '$pedidoURL'";
                    (new pedidoModel)->incluir_pagseguro($query, $p->pedido_id);
                    (new pedidoModel)->status_pagseguro($result->status, $p->pedido_id);
                    Carrinho::clear();
                    curl_close($ch);
                    self::notificarPedido($p);
                    Http::redirect_to("/detalhes-do-pedido/$p->pedido_id/?new&aprovado");
                    exit;
                } else {
                    $query = "pedido_status = 5, pedido_pagseguro = 7, pedido_obs = 'Pedido não autorizado pelo PagSeguro!'";
                    (new pedidoModel)->incluir_pagseguro($query, $p->pedido_id);
                    Carrinho::clear();
                    curl_close($ch);
                    self::notificarPedido($p);
                    Http::redirect_to("/detalhes-do-pedido/$p->pedido_id/?recusado");
                    exit;
                }
            }
            @curl_close($ch);
        }
    }

    public function checkPedido()
    {
        if (isset($_SESSION['__LAST__PEDIDO__']) && !empty($_SESSION['__LAST__PEDIDO__'])) {
            $id = intval($_SESSION['__LAST__PEDIDO__']['ID']);
            $status = intval($_SESSION['__LAST__PEDIDO__']['STATUS']);
            if ($status < 4) {
                $pedido = (new pedidoModel)->get_by_id($id);
                if (isset($pedido->pedido_status) && $pedido->pedido_status != $status) {
                    $new = Status::check($pedido->pedido_status);
                    $text = "#$id  " . strtolower($new->text);
                    $ped = ['id' => $id, 'text' => $text, 'color' => $new->color];
                    echo json_encode($ped);
                    if ($pedido->pedido_status >= 4) {
                        unset($_SESSION['__LAST__PEDIDO__']);
                    }
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }

    }

    public static function status_get($cod)
    {
        $status = [
            1 => 'Aguardando pagamento',
            2 => 'Em análise',
            3 => 'Pago',
            4 => 'Disponível',
            5 => 'Em disputa',
            6 => 'Devolvida',
            7 => 'Cancelada',
            8 => 'Debitado',
            9 => 'Retenção temporária'
        ];
        return (isset($status[$cod])) ? $status[$cod] : 0;
    }
}