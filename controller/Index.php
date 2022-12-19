<?php

@session_start();

class Index
{
    public function indexAction()
    {
        $_SESSION['busca'] = false;
        $config = (new configModel)->get_config();
        $categoria = (new Factory('categoria'))
            ->where('categoria_ativa = 1')
            ->order('categoria_pos ASC')->get();
        $produtos = $this->lista($categoria, $config->config_home_qtde);
        $produtos_busca = $this->lista($categoria);
        $banner = (new Factory('banner'))->order('banner_pos ASC')->get();
        $dados = [
            'config' => $config,
            'banner' => $banner,
            'categoria' => $categoria,
            'lista_combo' => $produtos_busca,
            'lista' => $produtos,
        ];
        Tpl::view("site.index", $dados);
    }

    public function promocoes()
    {
        $config = (new configModel)->get_config();
        $categoria = (new Factory('categoria'))
            ->where('categoria_ativa = 1')
            ->order('categoria_pos ASC')->get();
        $produtos = $this->lista_promo($categoria);
        $produtos_busca = $this->lista($categoria, 1000);
        $dados = [
            'config' => $config,
            'categoria' => $categoria,
            'lista_combo' => $produtos_busca,
            'lista' => $produtos,
        ];
        Tpl::view("site.index", $dados);
    }

    public function busca()
    {
        $config = (new configModel)->get_config();
        $categoria = (new categoriaModel)->get_all('categoria_pos ASC');
        $produtos_busca = $this->lista($categoria);
        $dados = [
            'config' => $config,
            'categoria' => $categoria,
            'lista_combo' => $produtos_busca,
            'lista' => $this->lista_busca($categoria),
        ];
        $_SESSION['busca'] = true;
        Tpl::view("site.index", $dados);
    }

    public function busca_live()
    {
        $b = addslashes($_REQUEST['busca']);
        $item = (new Factory('item'))
            ->select('item_id as id,item_nome as text')
            ->join('categoria', 'categoria_id = item_categoria')
            ->where("(item_nome like '%$b%' OR categoria_nome like '%$b%') AND item_ativo = 1")
            ->limit(500)
            ->get();
        echo json_encode(['itens' => $item] );

    }
    public function lista_promo($categoria)
    {
        $cat_item = [];
        $k = 0;
        foreach ($categoria as $cat) {
            $itensAll = (new itemModel)->get_by_categoria($cat->categoria_id);
            $itens = (new itemModel)->get_by_categoria_promo($cat->categoria_id);
            $opcoes = (new opcaoModel)->get_by_categoria($cat->categoria_id);
            if (isset($itens[0]->item_id)) {
                $cat_item[$k]['categoria'] = $cat->categoria_nome;
                $cat_item[$k]['categoria_id'] = $cat->categoria_id;
                $cat_item[$k]['categoria_meia'] = $cat->categoria_meia;
                $cat_item[$k]['categoria_img'] = $cat->categoria_img;
                $cat_item[$k]['item'] = $itens;
                $cat_item[$k]['itemAll'] = $itensAll;
                $cat_item[$k]['opcoes'] = $opcoes;
                $k++;
            }
        }
        return $cat_item;
    }

    public function lista($categoria, $limit = 1000)
    {
        $cat_item = [];
        $k = 0;
        foreach ($categoria as $cat) {
            $itensAll = (new itemModel)->get_by_categoria($cat->categoria_id);
            $itens = (new itemModel)->get_by_categoria($cat->categoria_id, $limit);
            $opcoes = (new opcaoModel)->get_by_categoria($cat->categoria_id);
            if (isset($itens[0]->item_id)) {
                $cat_item[$k]['categoria'] = $cat->categoria_nome;
                $cat_item[$k]['categoria_id'] = $cat->categoria_id;
                $cat_item[$k]['categoria_meia'] = $cat->categoria_meia;
                $cat_item[$k]['categoria_img'] = $cat->categoria_img;
                $cat_item[$k]['item'] = $itens;
                $cat_item[$k]['itemAll'] = $itensAll;
                $cat_item[$k]['opcoes'] = $opcoes;
                $k++;
            }
        }
        return $cat_item;
    }

    public function lista_busca($categoria)
    {
        $this->nome = Req::post('ipt-nome');
        $this->cod = Req::post('ipt-cod');
        $this->desc = Req::post('ipt-desc');
        $this->obs = Req::post('ipt-obs');
        $cat_item = array();
        $k = 0;
        foreach ($categoria as $cat) {
            $itens = (new itemModel)->get_by_busca($cat->categoria_id, $this->nome, $this->cod, $this->desc, $this->obs);
            $opcoes = (new opcaoModel)->get_by_categoria($cat->categoria_id);
            $itensAll = (new itemModel)->get_by_categoria($cat->categoria_id);
            if (isset($itens[0])) {
                $cat_item[$k]['categoria'] = $cat->categoria_nome;
                $cat_item[$k]['categoria_id'] = $cat->categoria_id;
                $cat_item[$k]['categoria_meia'] = $cat->categoria_meia;
                $cat_item[$k]['categoria_img'] = $cat->categoria_img;
                $cat_item[$k]['item'] = $itens;
                $cat_item[$k]['itemAll'] = $itensAll;
                $cat_item[$k]['opcoes'] = $opcoes;
                $k++;
            }
        }
        return $cat_item;
    }

    public function sobre()
    {
        $config = (new configModel)->get_config();
        $dados = ['config' => $config];
        Tpl::view("site.sobre", $dados);
    }
}
