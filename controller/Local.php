<?php

@session_start();

Class Local
{
    public function indexAction()
    {

    }
    public function lista()
    {
        if (ClienteSessao::get_id() > 0) {
            $cliente_id = ClienteSessao::get_id();
            $dados = [
                'cliente' => (new clienteModel)->get_by_id($cliente_id),
                'endereco' => (new enderecoModel)->get_by_cliente($cliente_id),
                'config' => (new configModel)->get_config()
            ];
            Tpl::view("site.cliente-endereco-lista", $dados);
        } else {
            Http::redirect_to("/");
        }
    }
    public function novo()
    {
        if (ClienteSessao::get_id() > 0) {
            $cliente_id = ClienteSessao::get_id();
            $return = (isset($_GET['return'])) ? $_GET['return'] : '';
            $config = (new configModel)->get_config();
            $bairro = (new entregaModel)->get_bairros();
            $dados = [
                'cliente' => (new clienteModel)->get_by_id($cliente_id),
                'bairro' => $bairro,
                'config' => $config,
                'return' => $return
            ];
            Tpl::view("site.cliente-endereco-novo", $dados);
        }
    }

    public function editar()
    {
        if (ClienteSessao::get_id() > 0) {
            $cliente_id = ClienteSessao::get_id();
            $id = Http::get_param(1, 'int');
            $bairro = (new entregaModel)->get_bairros();
            $dados = [
                'cliente' => (new clienteModel)->get_by_id($cliente_id),
                'endereco' => (new enderecoModel)->get_by_id($id),
                'bairro' => $bairro,
                'config' => (new configModel)->get_config()
            ];
            Tpl::view("site.cliente-endereco-editar", $dados);
        }
    }

    public function get_preco_entrega(){
        $bairro = Req::post('bairro');
        $preco = (new Factory('bairro'))->find($bairro);
        echo Currency::moedaUS($preco->bairro_preco);
    }


    public function get_bairro_by_name(){
        $bairro = Req::post('bairro');
        $bairro_low = strtolower($bairro);
        $rs = (new Factory('bairro'))->where("bairro_nome like'%$bairro%' OR LOWER(bairro_nome) like '%$bairro_low%'")->get();
        if(isset($rs[0]->bairro_id)){
            echo 1;
        }else{
            echo '-1';
        }
    }

    public function getfaixa()
    {
        $intervalos = (new entregaModel)->get_faixas();
        $cep = Req::post('cep');
        $v = (int)preg_replace("/\D+/", "", $cep);
        $rs = '-1';
        foreach ($intervalos as $faixa) {
            $range = [$faixa->entrega_inicio, $faixa->entrega_fim];
            list($min, $max) = $range;
            if ($v >= $min && $v <= $max) {
                $rs = "$faixa->entrega_taxa";
            }
        }
        echo $rs;
    }

    public function gravar()
    {
        $endereco_cliente = Req::post('endereco_cliente', null, 'int');
        $return = (isset($_GET['return'])) ? $_GET['return'] : '';
        if (Req::post('endereco_id', null, 'int') > 0) {
            $id = Req::post('endereco_id', null, 'int');
            (new enderecoModel)->gravar($id);
        } else {
            $id = (new enderecoModel)->gravar();
            if ($return == "pedido") {
                $_SESSION['__LOCAL__'] = intval($id);
                Http::redirect_to("/pedido/");
            } else {
                Http::redirect_to("/meus-enderecos/");
            }
        }
        Http::redirect_to("/meus-enderecos/?success");
    }

    public function remove()
    {
        if (Req::post('endereco_id', null, 'int') > 0) {
            $id = Req::post('endereco_id', null, 'int');
            echo $id;
            (new enderecoModel)->remove($id);
        }
    }

}
