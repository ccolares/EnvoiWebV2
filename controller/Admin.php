<?php

@session_start();

class Admin
{

    public function __construct()
    {
        Sessao::checar();
        if (!isset($_SESSION['__USUARIO__LAST_PEDIDO__']) ||
            (isset($_SESSION['__USUARIO__LAST_PEDIDO__'])) && !is_array($_SESSION['__USUARIO__LAST_PEDIDO__'])) {
            $_SESSION['__USUARIO__LAST_PEDIDO__'] = array();
        }
    }

    public function indexAction()
    {
        $config = (new configModel)->get_config();
        $pedido = (new pedidoModel)->get_dash();
        $cliente = (new clienteModel)->get_dash();
        $estoque = (new itemModel)->get_estoque();
        $dados = array(
            'config' => $config,
            'pedido' => $pedido,
            'cliente' => $cliente,
            'estoque' => $estoque
        );
        Tpl::view("admin.dashboard", $dados);
    }

    public function pedidos()
    {
        $config = (new configModel)->get_config();
        $pedido = (new pedidoModel)->get_all();
        $dados = array(
            'config' => $config,
            'pedido' => $pedido
        );
        Tpl::view("admin.pedidos", $dados);
    }

    public function pedido()
    {
        $config = (new configModel)->get_config();
        $pedido_id = intval(Http::get_param(2));
        $_SESSION['__USUARIO__LAST_PEDIDO__'][$pedido_id] = TRUE;
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        if (isset($pedido->pedido_local) && !empty($pedido->pedido_local)) {
            $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        } else {
            $endereco = (object)[
                'endereco_nome' => 'Retirar no Local',
                'endereco_numero' => '',
                'endereco_complemento' => '',
                'endereco_cidade' => '',
                'endereco_uf' => '',
                'endereco_endereco' => '',
            ];
        }
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("admin.pedido-exibir", $dados);
    }

    public function imprimir()
    {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(2);
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        $_SESSION['__USUARIO__LAST_PEDIDO__'][$pedido_id] = TRUE;
        Tpl::view("admin.pedido-imprimir", $dados);
    }

    public function pedido_remove()
    {
        $pedido_id = Req::post('pedido_id', null, 'int');
        if ($pedido_id > 0) {
            (new pedidoModel)->remove($pedido_id);
        }
        $_SESSION['__USUARIO__LAST_PEDIDO__'][$pedido_id] = TRUE;
    }

    public function atualiza_status()
    {
        $config = (new configModel)->get_config();
        $id = Post::get_and_drop('pedido_id');
        $cliente_id = Post::get_and_drop('cliente');
        $pstatus = Req::post('pedido_status');
        (new pedidoModel())->gravar($id);

        $pat = array('/1/', '/2/', '/3/', '/4/', '/5/');
        $rep = array('<i class="fa fa-hourglass-o"></i> Pendente', '<i class="fa fa-hourglass-2"></i> Em andamento', '<i class="fa fa-motorcycle"></i>  Em rota de entrega', '<i class="fa fa-check-circle-o"></i> Pedido Entregue', '<i class="fa fa-remove"></i> Cancelado');
        $status = preg_replace($pat, $rep, $pstatus);

        $pats = array('/1/', '/2/', '/3/', '/4/', '/5/');
        $reps = array('warning', 'info', 'info', 'success', 'danger');
        $status_msg = preg_replace($pats, $reps, $pstatus);

        echo json_encode(array('text' => $status, 'class' => $status_msg));

        /*
        $cliente = (new clienteModel())->get_by_id($cliente_id);
        $url = Http::base() . '/pedido-ficha-cliente/' . $id . '/';
        //$body = Request::open_curl($url, $cliente);
        $body = "";
        $body .= "Olá <br>";
        $body .= "O status do seu pedido mudou! <br>";
        $body .= "Confira o status do seu pedido em: $url <br>";
        $data = array(
            'destinatario' => "$cliente->cliente_email",
            //'bcc' => array('outro@email.com.br'),
            'assunto' => "$config->config_nome - Novo status do seu Pedido Nº $id",
            'mensagem' => $body,
        );
        Sender::mail($data);
        */
    }

    public function checkPedido()
    {
        $config = (new configModel)->get_config();
        if ($config->config_bell == 1) {
            $id = (new pedidoModel)->get_last_id_pedido();
            if ($id > 0) {
                echo json_encode(['id' => intval($id)]);
            } else {
                echo json_encode(['id' => intval(0)]);
            }
        } else {
            echo json_encode(['id' => intval(0)]);
        }
    }

    public function newPedido()
    {
        //$config = (new configModel)->get_config();
        //if ($config->config_bell == 1) {
            $id = (new pedidoModel)->get_last_id_pedido();
            if ($id > 0) {
                echo json_encode(['id' => intval($id)]);
            } else {
                echo json_encode(['id' => intval(0)]);
            }
//        } else {
//            echo json_encode(['id' => intval(0)]);
//        }
    }
}

