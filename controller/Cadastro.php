<?php

@session_start();

/* Author: <falecom@phpstaff.com.br> */

class Cadastro
{
    public function indexAction()
    {
        $config = (new configModel)->get_config();
        $dados = ['config' => $config];
        Tpl::view("site.cliente-cadastro", $dados);
    }

    public function editar()
    {
        $cliente = ClienteSessao::get_obj();
        $id = $cliente->cliente_id;
        $cliente = (new clienteModel)->get_by_id($id);
        $config = (new configModel)->get_config();
        $dados = [
            'config' => $config,
            'cliente' => $cliente,
        ];
        if (!is_null($cliente)) {
            Tpl::view("site.cliente-dados", $dados);
        } else {
            Http::redirect_to('/?registro-invalido');
        }
    }

    public function exists()
    {
        $fone = Req::post('fone', null, 'string');
        echo ((new clienteModel)->get_by_fone($fone)) ? 1 : 0;
    }

    public function me(){
            Filter::pre($_SESSION['__CLIENTE__OBJ__']);
    }

    public function gravar()
    {
        if (Req::post('cliente_senha') == "") {
            Req::drop('cliente_senha');
        } else {
            Req::crypt('cliente_senha');
        }
        if (Req::post('cliente_id', null, 'int') > 0) {
            $id = Req::post('cliente_id');
            (new clienteModel)->gravar($id);
            $dados =  (new Factory('cliente'))->find($id);
            $_SESSION['__CLIENTE__OBJ__'] = $dados;
            if (Carrinho::isfull()) {
                Http::redirect_to('/pedido/');
            } else {
                Http::redirect_to('/meus-dados/?success');
            }
        } else {
            (new clienteModel)->gravar();
            (new LoginCliente)->autenticar(false);
            Http::redirect_to('/novo-endereco/?return=pedido');
        }
    }

}
