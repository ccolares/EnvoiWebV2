<?php

@session_start();
/* Cliente Controller */
/* Author: Rafael <falecom@phpstaff.com.br> */

Class Entrega {

    public function __construct() {
        Sessao::checar();
    }

    public function bairro() {
        Tpl::view("admin.entrega-bairro", (new entregaModel)->get_bairros());
    }

    public function bairro_add() {
        Post::change('bairro_preco', preg_replace('/\,/', '.', Post::get('bairro_preco')));
        if (Post::get('bairro_id', 'int') > 0) {
            $id = Post::get('bairro_id', 'int');
            (new entregaModel)->bairro_add($id);
        } else {
            if(isset($_POST['bairro_id'])){
                unset($_POST['bairro_id']);
            }
            (new entregaModel)->bairro_add();
        }
        Http::redirect_to('/entrega/bairro/?success');
    }

    public function bairro_remove() {
        if (Http::get_param(2, 'int') > 0) {
            $id = Http::get_param(2, 'int');
            (new entregaModel)->bairro_remove($id);
        }
        Http::redirect_to('/entrega/bairro/?success');
    }



    public function indexAction() {
        Tpl::view("admin.entrega-lista", (new entregaModel)->get_all());
    }



    public function gravar() {
        Post::change('entrega_inicio', preg_replace('/\-/', '', Post::get('entrega_inicio')));
        Post::change('entrega_fim', preg_replace('/\-/', '', Post::get('entrega_fim')));
        Post::change('entrega_taxa', preg_replace('/\,/', '.', Post::get('entrega_taxa')));
        if (Post::get('entrega_id', 'int') > 0) {
            $id = Post::get('entrega_id', 'int');
            (new entregaModel)->gravar($id);
        } else {
            if(isset($_POST['entrega_id'])){
                unset($_POST['entrega_id']);
            }
            (new entregaModel)->gravar();
        }
        Http::redirect_to('/entrega/?success');
    }

    public function remove() {
        if (Http::get_param(2, 'int') > 0) {
            $id = Http::get_param(2, 'int');
            (new entregaModel)->remove($id);
        }
        Http::redirect_to('/entrega/?success');
    }

}