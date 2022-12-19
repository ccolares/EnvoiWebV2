<?php

@session_start();

/* Usuario Controller */

/* Author: Rafael Clares <falecom@phpstaff.com.br> */

class Usuario
{

    public function __construct()
    {
        Sessao::checar();
        if(Sessao::get_nivel() == 2){
            Http::redirect_to('/admin');
        }
    }

    public function indexAction()
    {
        $dados = array('usuario' => (new usuarioModel)->get_all());
        Tpl::view("admin.usuario-lista", $dados);
    }

    public function novo()
    {
        Tpl::view("admin.usuario-novo");
    }

    public function editar()
    {
        $id = Http::get_param(2,'int');
        $dados = ['user' => (new Factory('usuario'))->find($id)];
        Tpl::view("admin.usuario-editar", $dados);
    }

    public function me()
    {
        $me = Sessao::get_id();
        $dados = array('usuario' => (new usuarioModel)->get_all(), 'me' => $me);
        Tpl::view("admin.usuario-lista", $dados);
    }

    public function gravar()
    {
        Post::drop('___');
        if (Req::post('usuario_senha') == "") {
            Post::drop('usuario_senha');
        } else {
            Post::crypt('usuario_senha');
        }
        if (Req::post('usuario_avatar') != "" && Req::post('usuario_id', null, 'int') == Sessao::get_id()) {
            $_SESSION['__USUARIO__AVATAR__'] = Req::post('usuario_avatar');
        }
        if (Req::post('usuario_id', null, 'int') > 0) {
            $id = Req::post('usuario_id');
            (new usuarioModel)->gravar($id);
        } else {
            (new usuarioModel)->gravar();
        }
        Http::redirect_to('/usuario/?success');
    }

    public function remove()
    {
        if (Req::post('usuario_id', null, 'int') > 0) {
            $id = Req::post('usuario_id', null, 'int');
            (new usuarioModel)->remove($id);
        }
    }

}
