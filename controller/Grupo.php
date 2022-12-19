<?php
@session_start();
/* Categoria Controller */
/* Author: Rafael Clares <falecom@phpstaff.com.br> */

Class Grupo {

    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {
        $grupos = (new Factory('grupo'))->order('grupo_pos ASC')->get();
        $dados = [
            'grupos' => $grupos
        ];
        Tpl::view("admin.grupo-lista", $dados);
    }


    public function opcao() {
        $id = Http::get_param(2, 'int');
        $opcoes = (new opcaoModel)->get_by_grupo($id);
        $grupo = (new grupoModel)->get_by_id($id);
        $dados = ['opcao' => $opcoes, 'grupo' => $grupo];
        Tpl::view("admin.opcao-lista", $dados);
    }    

    public function novo() {
        $id = Http::get_param(2, 'int');
        $categoria = (new Factory('categoria'))->find($id);
        $dados = [
            'categoria' => $categoria
        ];        
        Tpl::view("admin.grupo-novo", $dados);
    }

    public function editar() {
        $id = Http::get_param(2, 'int');
        $grupo = (new Factory('grupo'))->find($id);
        $dados = [
            'grupo' => $grupo
        ];
        Tpl::view("admin.grupo-editar", $dados);
    }

    public function gravar() {
        if (Req::post('grupo_id',null, 'int') > 0) {
            $id = Req::post('grupo_id',null, 'int');
            (new grupoModel)->gravar($id);
            Http::redirect_to("/grupo/editar/$id/?success");            
        } else {
            (new grupoModel)->gravar();
            Http::redirect_to('/grupo/?success');
        }
    }

    public function remove() {
        if (Req::post('grupo_id', null,'int') > 0) {
            $id = Req::post('grupo_id', null,'int');
            (new grupoModel)->remove($id);
        }
    }


    public function update_pos() {
        if (Req::post('relprod_id', null, 'int') > 0) {
            $id = Req::post('relprod_id', null, 'int');
            (new opcaoModel)->update_rel_pos($id);
        }
    }

}
