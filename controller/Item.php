<?php

@session_start();
/* Categoria Controller */

/* Author: Rafael Clares <falecom@phpstaff.com.br> */

class Item
{

    public function __construct()
    {
        Sessao::checar();
    }

    public function indexAction()
    {
        $item = (new Factory('item'))
             ->select('categoria_nome,item_nome,item_preco,item_codigo,item_id,item_estoque,item_ativo,item_foto,item_promo')
             ->join('categoria', 'categoria_id = item_categoria')
             ->get();
        $dados = ['item' => $item];
        Tpl::view("admin.item-lista", $dados);
    }

    public function busca()
    {
        $busca = Req::get('busca');
        $item = (new Factory('item'))
            ->select('categoria_nome,item_nome,item_preco,item_codigo,item_id,item_ativo,item_foto,item_promo')
            ->join('categoria', 'categoria_id = item_categoria')
            ->where("item_nome like '%$busca%'  OR categoria_nome like '%$busca%'")
            ->get_all();
        $dados = ['item' => $item['data'], 'pages' => $item['page_all'] , 'page' => $item['page'] , 'total' =>  $item['total'] ];
        Tpl::view("admin.item-lista", $dados);
    }    

    public function novo()
    {
        $dados = [
            'categoria' => (new Factory('categoria'))->order('categoria_nome ASC')->get()
        ];
        Tpl::view("admin.item-novo", $dados);
    }

    public function editar()
    {
        $id = Http::get_param(2, 'int');
        $categoria = (new Factory('categoria'))->get();
        $item = (new Factory('item'))->format(['item_preco' => 'money'])->find($id);
        $item = [
            'categoria' => $categoria,
            'item' => $item
        ];
        if (!is_null($item)) {
            Tpl::view("admin.item-editar", $item);
        } else {
            Http::redirect_to('/item/?registro-invalido');
        }
    }

    public function gravar()
    {
        $id = Req::post('item_id', null, 'int');
        if (isset($_FILES['item_foto']) && !empty($_FILES['item_foto']['name'])) {
            $item_foto = Upload::Slide($_FILES['item_foto'], "item/");
            Req::post('item_foto', $item_foto);
            if ($id > 0) {
                $foto_old = (new itemModel)->get_foto($id);
                if ($foto_old) {
                    Upload::remove($foto_old);
                }
            }
        }
        Req::changeWith('item_preco', 'Math', 'money2Decimal');
        (new itemModel)->gravar($id);
        Http::redirect_to("/item/?success");
    }

    public function duplicar()
    {
        $id = Http::get_param(2, 'int');
        if ($id > 0) {
            $id = (new itemModel)->duplicar($id);
            Http::redirect_to("/item/editar/$id/");
        } else {
            Http::redirect_to('/item/?registro-invalido');
        }
    }

    public function remove()
    {
        if (Req::post('item_id', null, 'int') > 0) {
            $id = Req::post('item_id');
            (new itemModel)->remove($id);
        }
    }

    public function promo_update()
    {
        $id = Req::post('item_id', null, 'int');
        if ($id > 0) {
            $promo = Req::post('item_promo', null, 'int');
            (new itemModel)->altera_promo($id, $promo);
        }
    }

    public function altera_status()
    {
        $id = Req::post('item_id', null, 'int');
        if ($id > 0) {
            $status = Req::post('status', null, 'int');
            (new itemModel)->altera_status($id, $status);
        }
    }

}
