<?php

@session_start();
/* Cliente Controller */

/* Author: Rafael <falecom@phpstaff.com.br> */

class Cliente
{

    public function __construct()
    {
        Sessao::checar();
    }

    public function indexAction()
    {
        Tpl::view("admin.cliente-lista", (new clienteModel)->get_all());
    }

    public function novo()
    {
        Tpl::view("admin.cliente-novo");
    }

    public function editar()
    {
        $id = Http::get_param(2, 'int');
        $config = (new configModel)->get_config();
        $cliente = (new clienteModel)->get_by_id($id);
        $dados = array(
            'cliente' => $cliente,
            'config' => $config,
        );
        if (!is_null($cliente)) {
            Tpl::view("admin.cliente-editar", $dados);
        } else {
            Http::redirect_to('/cliente/?registro-invalido');
        }
    }

    public function gravar()
    {
        if (Req::post('cliente_senha') == "") {
            Req::drop('cliente_senha');
        } else {
            Req::crypt('cliente_senha');
        }
        Req::drop_blank();
        if (Req::post('cliente_id', null, 'int') > 0) {
            $id = Req::post('cliente_id', null, 'int');
            (new clienteModel)->gravar($id);
        } else {
            (new clienteModel)->gravar();
        }
        Http::redirect_to('/cliente/?success');
    }

    public function remove()
    {
        if (Req::post('cliente_id', null, 'int') > 0) {
            $id = Req::post('cliente_id');
            (new clienteModel)->remove($id);
        }
    }

}
