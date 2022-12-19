<?php
@session_start();

class Pagamento
{
    public function __construct() {
        Sessao::checar();
        if(Sessao::get_nivel() == 2){
            Http::redirect_to('/admin');
        }
    }

    public function indexAction() {
        $pagamento = (new pagamentoModel)->get_all();
        $dados = array(
            'pagamento' => $pagamento
        );
        Tpl::view("admin.pagamento", $dados);
    }

    public function gravar(){
        $id = intval($_POST['pagamento_id']);
        (new pagamentoModel)->gravar($id);
        Http::redirect_to('/pagamento/?success');

    }

}