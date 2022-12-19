<?php

@session_start();

Class Login extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function indexAction() {
        Tpl::View("admin.login");
    }

    public function entrar() {
        $this->usuario_login = Post:: get('usuario_login', 'string', 1);
        $this->usuario_senha = Post:: crypt('usuario_senha');
        $this->db->query = "SELECT * FROM usuario WHERE usuario_login = '$this->usuario_login' AND usuario_senha = '$this->usuario_senha';";
        $dados = $this->db->fetch();
        if (isset($dados[0])) {
            $_SESSION['__USUARIO__LOGADO__'] = TRUE;
            $_SESSION['__USUARIO__ID__'] = $dados[0]->usuario_id;
            $_SESSION['__USUARIO__NOME__'] = $dados[0]->usuario_nome;
            $_SESSION['__USUARIO__NIVEL__'] = $dados[0]->usuario_nivel;
            $_SESSION['__USUARIO__LAST_PEDIDO__'] = (new pedidoModel)->get_last_id_pedido();
            $_SESSION['__USUARIO__VISUALIZOU__'] = 'TRUE';

            if ($dados[0]->usuario_avatar == '0' || $dados[0]->usuario_avatar == '') {
                $_SESSION['__USUARIO__AVATAR__'] = "images/avatar.png";
            } else {
                $_SESSION['__USUARIO__AVATAR__'] = $dados[0]->usuario_avatar;
            }
            Http::redirect_to("/admin/");
        } else {
            Http::redirect_to("/login/?incorreto=true");
        }
    }

    public function logout() {
        if (isset($_SESSION['__USUARIO__LOGADO__'])) {
            unset($_SESSION['__USUARIO__LOGADO__']);
            @session_destroy();
        }
        Http::redirect_to("/admin/");
    }

}
