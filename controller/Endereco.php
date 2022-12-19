<?php

@session_start();
/* Cliente Controller */
/* Author: Rafael Clares <falecom@phpstaff.com.br> */

Class Endereco {

    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {
        $config = (new configModel)->get_config();
        $cliente_id = Http::get_param(2, 'int');
        $dados = array(
            'endereco' => (new enderecoModel)->get_all(),
            'cliente' => (new clienteModel)->get_by_id($cliente_id),
             'config' => $config
        );
        Tpl::view("admin.endereco-lista", $dados);
    }

    public function lista() {
        $config = (new configModel)->get_config();
        $cliente_id = Http::get_param(2, 'int');
        $dados = array(
            'cliente' => (new clienteModel)->get_by_id($cliente_id),
            'endereco' => (new enderecoModel)->get_by_cliente($cliente_id),
            'config' => $config
        );
        Tpl::view("admin.endereco-lista", $dados);
    }

    public function novo() {
        $config = (new configModel)->get_config();
        $cliente_id = Http::get_param(2, 'int');
        $dados = array(
            'cliente' => (new clienteModel)->get_by_id($cliente_id),
             'config' => $config
        );
        Tpl::view("admin.endereco-novo", $dados);
    }

    public function editar() {
        $id = Http::get_param(2, 'int');
        $config = (new configModel)->get_config();
        $dados = array(
            'endereco' => (new enderecoModel)->get_by_id($id),
            'config' => $config
        );
        Tpl::view("admin.endereco-editar", $dados);
    }

    public function gravar() {
        $endereco_cliente = Req::post('endereco_cliente',null, 'int');
        if (Req::post('endereco_id', null,'int') > 0) {
            $id = Req::post('endereco_id',null,'int');
            (new enderecoModel)->gravar($id);
        } else {
            (new enderecoModel)->gravar();
        }
        Http::redirect_to("/endereco/lista/$endereco_cliente/?success");
    }

    public function remove() {
        $id = Http::get_param(2, 'int');
        $endereco_cliente = Req::post('endereco_cliente',null, 'int');
        if (Req::post('endereco_id',null, 'int') > 0) {
            $id = Req::post('endereco_id');
            (new enderecoModel)->remove($id);
        }
        Http::redirect_to("/endereco/lista/$endereco_cliente/?success");
    }

}
