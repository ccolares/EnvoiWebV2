<?php

@session_start();

class Ficha {

    public function __construct() {
        
    }

    public function cliente() {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(1);
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("site.pedido-ficha-cliente", $dados);
    }

    public function admin() {
        $config = (new configModel)->get_config();
        $pedido_id = Http::get_param(1);
        $pedido = (new pedidoModel)->get_by_id($pedido_id);
        $lista = (new pedidoModel)->get_lista_by_pedido($pedido_id);
        $endereco = (new enderecoModel)->get_by_id($pedido->pedido_local);
        $dados = array(
            'lista' => $lista,
            'pedido' => $pedido,
            'endereco' => $endereco,
            'config' => $config,
        );
        Tpl::view("site.pedido-ficha-admin", $dados);
    }

}
