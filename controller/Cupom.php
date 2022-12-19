<?php
@session_start();
Class Cupom {

    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {
        $dados = array(
            'cupom' => (new cupomModel)->get_cupom()
        );
        Tpl::view("admin.cupom", $dados);
    }

    public function gravar() {
        Post::change('cupom_validade', date('Y-m-d', strtotime(str_replace('/', '-', Post::get('cupom_validade')))));

        if(isset($_POST['cupom_valor']) && empty($_POST['cupom_valor'])){
            unset($_POST['cupom_valor']);
        }else{
            Post::change('cupom_valor',  str_replace(',', '.', Post::get('cupom_valor'))  );
        }
        if(isset($_POST['cupom_percent']) && empty($_POST['cupom_percent'])){
            unset($_POST['cupom_percent']);
        }
        (new cupomModel)->gravar(1);
        Http::redirect_to('/cupom/?success');
    }

    public function remove() {
        $id = intval($_POST['cupom_id']);
        if ($id > 0) {
            (new cupomModel)->remove($id);
            Http::redirect_to('/cupom/?success');
        }
    }

}
