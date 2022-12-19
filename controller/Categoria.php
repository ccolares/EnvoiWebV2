<?php

@session_start();
/* Categoria Controller */

/* Author: PHP STAFF <falecom@phpstaff.com.br> */

class Categoria
{

    public function __construct()
    {
        Sessao::checar();
    }

    public function indexAction()
    {
        $dados = [
            'categoria' => (new categoriaModel)->get_all_admin()
        ];
        Tpl::view("admin.categoria-lista", $dados);
    }

    public function item()
    {
        $id = Http::get_param(2, 'int');
        $item = (new Factory('item'))
            ->join('categoria', 'categoria_id = item_categoria')
            ->where("item_categoria = $id")
            ->get();
        $cat = (new Factory('categoria'))->find($id);
        $dados = [
            'item' => $item,
            'categoria' => $cat->categoria_nome
        ];
        Tpl::view("admin.item-lista", $dados);
    }

    public function opcao()
    {
        $id = Http::get_param(2, 'int');
        $dados = [
            'item' => (new opcaoModel)->get_by_categoria($id)
        ];
        Tpl::view("admin.item-lista-opcao", $dados);
    }

    public function novo()
    {
        Tpl::view("admin.categoria-novo");
    }

    public function editar()
    {
        $id = Http::get_param(2, 'int');
        $dados = [
            'categoria' => (new categoriaModel)->get_by_id($id),
        ];
        if (!is_null($dados)) {
            Tpl::view("admin.categoria-editar", $dados);
        } else {
            Http::redirect_to('/categoria/?registro-invalido');
        }
    }

    public function duplicar()
    {
        $id = Http::get_param(2, 'int');
        if ($id > 0) {
            $id = (new categoriaModel)->duplicar($id);
            Http::redirect_to("/categoria/editar/$id/");
        } else {
            Http::redirect_to('/categoria/?registro-invalido');
        }
    }


    public function gravar()
    {
        Req::changeWith('categoria_id', 'Filter', 'parse_int');
        Req::changeWith('categoria_nome', 'Filter', 'addslashes');
        Req::changeWith('categoria_ref', 'Filter', 'intval');
        $id = Req::post('categoria_id');
        $id = (new categoriaModel)->gravar($id);
        if (self::upload($id)) {
            Http::redirect_to('/categoria/?success');
        } else {
            Http::redirect_to('/categoria/?error');
        }
    }

    public function altera_status()
    {
        $id = Req::post('item_id', null, 'int');
        if ($id > 0) {
            $status = Req::post('status');
            (new categoriaModel)->altera_status($id, $status);
        }
    }


    static public function upload($id = null)
    {
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = 'midias' . $ds . 'categoria';
        @mkdir("$storeFolder");
        @chmod("$storeFolder", 0777);
        $dir = Path::base() . $ds;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['categoria_img']['tmp_name'];
            $ext = strtolower(pathinfo($_FILES['categoria_img']['name'], PATHINFO_EXTENSION));
            $filename = Filter::slug($_FILES['categoria_img']['name']) . "." . $ext;
            $exts = ['png', 'jpg', 'jpeg', 'gif'];
            if (!in_array($ext, $exts)) {
                return false;
                exit();
            }
            $targetPath = $dir . $storeFolder . $ds;
            @mkdir("$targetPath");
            @chmod("$targetPath", 0777);
            $targetFile = $targetPath . $filename;
            if (move_uploaded_file($tempFile, $targetFile)) {
                $data = ['categoria_img' => $filename, 'categoria_id' => $id];
                (new Factory('categoria'))->with($data)->save();
            } else {
                echo 'error';
                return false;
                exit();
            }
        }
    }

    static public function img_remove()
    {
        $id = Req::post('id', null, 'int');
        $cat = (new Factory('categoria'))->find($id);
        $img = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . "categoria" . DIRECTORY_SEPARATOR . $cat->categoria_img;
         if (file_exists($img)) {
            @unlink($img);
        }
        $data = ['categoria_img' => '', 'categoria_id' => $id];
        (new Factory('categoria'))->with($data)->save();
    }

    public function grupo()
    {
        $id = Http::get_param(2, 'int');
        $grupo = (new opcaoModel)->get_grupo_categoria($id);
        $grupos = (new Factory('grupo'))->order('grupo_nome ASC')->get();
        $categoria = (new Factory('categoria'))->find($id);
        $dados = [
            'grupo' => $grupo,
            'grupos' => $grupos,
            'categoria' => $categoria
        ];
        Tpl::view("admin.item-lista-opcao", $dados);
    }

    public function grupo_add()
    {
        $cat = Req::post('categoria_id', null, 'int');
        $grp = Req::post('grupo_id', null, 'int');
        (new categoriaModel)->add_grupo($cat, $grp);
        Http::redirect_to("/categoria/grupo/$cat/?success");
    }

    public function grupo_rem()
    {
        $cat = Req::post('categoria_id', null, 'int');
        $grp = Req::post('grupo_id', null, 'int');
        (new categoriaModel)->rem_grupo($cat, $grp);
        echo Http::base() . "/categoria/grupo/$cat/?success";
    }

    public function altera_pos()
    {
        $id = Req::post('categoria_id');
        $pos = Req::post('categoria_pos');
        (new categoriaModel)->altera_pos($id, $pos);
    }

    public function remove()
    {
        if (Req::post('categoria_id', null, 'int') > 0) {
            $id = Req::post('categoria_id');
            (new categoriaModel)->remove($id);
        }
    }

}
