<?php

@session_start();

Class Dados {

    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {

        $config = (new configModel)->get_config();
        $categoria = (new categoriaModel)->get_all('categoria_pos ASC');
        $cat_item = array();
        $categorias = (new categoriaModel)->get_all('categoria_pos ASC');
        $k = 0;
        foreach ($categorias as $cat) {
            $itens = (new itemModel)->get_by_categoria_com_opcao($cat->categoria_id);
            $cat_item[$k]['categoria'] = $cat->categoria_nome;
            $cat_item[$k]['categoria_id'] = $cat->categoria_id;
            $cat_item[$k]['item'] = $itens;
            $k++;
        }

        $dados = array(
            'config' => $config,
            'categoria' => $categoria,
            'lista' => (object) $cat_item
        );
        Tpl::view("site.index", $dados);
    }

}
