<?php

@session_start();

class LoginCliente extends appModel
{

    public function __construct()
    {
        $this->initApp();
    }

    public function indexAction()
    {
        $config = (new configModel)->get_config();
        $cliente = (new clienteModel)->get_all();
        $dados = array(
            'config' => $config,
            'cliente' => $cliente
        );
        if (isset($_GET['carrinho'])) {
            $dados['carrinho'] = $_GET['carrinho'];
        }
        Tpl::View("site.login", $dados);
    }

    public function entrar()
    {
        $this->cliente_fone2 = Post:: get('cliente_fone2', 'string', 1);
        $this->cliente_senha = Post:: crypt('cliente_senha');
        $this->db->query = "SELECT * FROM cliente WHERE cliente_fone2 = '$this->cliente_fone2' AND cliente_senha = '$this->cliente_senha';";
        $dados = $this->db->fetch();
        if (isset($dados[0])) {
            $_SESSION['__CLIENTE__LOGADO__'] = TRUE;
            $_SESSION['__CLIENTE__ID__'] = $dados[0]->cliente_id;
            $_SESSION['__CLIENTE__NOME__'] = $dados[0]->cliente_nome;
            $dados[0]->cliente_senha = '';
            $_SESSION['__CLIENTE__OBJ__'] = $dados[0];
            if (isset($_GET['carrinho'])) {
                Http::redirect_to("/pedido/");
            } else {
                Http::redirect_to("/");
            }
        } else {
            Http::redirect_to("/entrar/?incorreto=true");
            //@session_destroy();
        }
    }

    public function autenticar($redir = true)
    {
        $this->cliente_fone2 = Post:: get('cliente_fone2', 'string', 1);
        $this->cliente_senha = Post:: get('cliente_senha');
        $this->db->query = "SELECT * FROM cliente WHERE cliente_fone2 = '$this->cliente_fone2' AND cliente_senha = '$this->cliente_senha';";
        $dados = $this->db->fetch();
        if (isset($dados[0])) {
            $_SESSION['__CLIENTE__LOGADO__'] = TRUE;
            $_SESSION['__CLIENTE__ID__'] = $dados[0]->cliente_id;
            $_SESSION['__CLIENTE__NOME__'] = $dados[0]->cliente_nome;
            $dados[0]->cliente_senha = '';
            $_SESSION['__CLIENTE__OBJ__'] = $dados[0];
            if ($redir == true) {
                Http::redirect_to('/meus-enderecos/?success');
            }
        } else {
            if ($redir == true) {
                Http::redirect_to('/');
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['__CLIENTE__ID__']) || isset($_SESSION['__CLIENTE__LOGADO__'])) {
            unset($_SESSION['__CLIENTE__LOGADO__']);
            unset($_SESSION['__CLIENTE__ID__']);
            unset($_SESSION['__CLIENTE__NOME__']);
            unset($_SESSION['__CLIENTE__OBJ__']);
            //@session_destroy();
        }
        Http::redirect_to("/");
    }


    public function recupera_senha()
    {
        $config = (new configModel)->get_config();
        $data = ['config' => $config];
        Tpl::view('site.recupera-senha', $data);
    }

    public function recuperar()
    {
        $config = (new configModel)->get_config();
        $email = Req::post('cliente_email');
        $token = Md5(Time());
        $cliente = (new clienteModel)->gera_token($email, $token);
        if ($cliente) {
            $msg = '';
            $msg .= utf8_encode('Mensagem: A recuperação de senha foi solicitada.<br> acesse: ' . Http::base() . '/nova-senha/' . $token . '<br>');
            $msg .= 'Data: ' . date('d/m/Y H:s') . '<br>';
            $data = array(
                'destinatario' => $cliente->cliente_email,
                'assunto' => utf8_encode('Recuperação de senha, Site: ' . $config->config_nome),
                'mensagem' => $msg,
            );
            if (Sender::mail($data)) {
                Http::redirect_to('/entrar/?envio=true');
            } else {
                Http::redirect_to('/entrar/?envio=true');
            }
        } else {
            Http::redirect_to('/recupera-senha/?incorreto=true');
        }
    }

    public function nova_senha()
    {
        $token = Http::get_param(1);
        $cliente = (new clienteModel)->get_by_token($token);
        if ($cliente) {
            $config = (new configModel)->get_config();
            $data = [
                'config' => $config,
                'cliente' => $cliente
            ];
            Tpl::view('site.nova-senha', $data);
        } else {
            Http::redirect_to('/entrar/');
        }
    }

    public function muda_senha()
    {
        $id = Req::post('cliente_id', null, 'int');
        Post::drop_blank();
        Post::add('cliente_token', md5(Time()));
        if (Req::post('cliente_senha') !== "null" || Req::post('cliente_senha')) {
            Req::post('cliente_senha', md5(Req::post('cliente_senha')));
        }
        if ((new clienteModel)->gravar($id)) {
            Http::redirect_to("/entrar/?muda-senha=true");
        } else {
            Http::redirect_to("/entrar/?muda-senha=false");
        }
    }


}
