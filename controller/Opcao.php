<?php

@session_start();
/* Categoria Controller */
/* Author: Rafael Clares <falecom@phpstaff.com.br> */

Class Opcao {
    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {
        $opcao = (new opcaoModel)->get_all();
        $dados = [
            'opcao' => $opcao
        ];
        Tpl::view("admin.opcao-lista", $dados);        
    }

    public function novo() {
        $id = Http::get_param(2, 'int');
        $grupo = (new Factory('grupo'))->find($id);
        $dados = [
            'grupo' => $grupo
        ];          
        Tpl::view("admin.opcao-novo", $dados);
    }

    public function editar() {
        $id = Http::get_param(2, 'int');
        $dados = [
            'opcao' => (new opcaoModel)->get_by_id($id)
        ];
        Tpl::view("admin.opcao-editar", $dados);
    }

    public function gravar() {
        $grupo = Req::post('opcao_grupo', null, 'int');
        Post::set_moeda('opcao_preco');
        $desc = Req::post('opcao_desc', null, 'text');
        Post::change('opcao_desc', $desc);
        if (Req::post('opcao_id', null, 'int') > 0) {
            $id = Req::post('opcao_id', null, 'int');
            (new opcaoModel)->gravar($id);
        } else {
            (new opcaoModel)->gravar();
        }
        Http::redirect_to("/grupo/opcao/$grupo/?success");
    }


    public function remove() {
        if (Req::post('opcao_id', null,'int') > 0) {
            $id = Req::post('opcao_id',null,'int');
            (new opcaoModel)->remove($id);
        }
    }

}
