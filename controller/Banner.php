<?php

@session_start();

class Banner
{
    public function __construct()
    {
        Sessao::checar();
    }

    public function indexAction()
    {
        $config = (new configModel())->get_config();
        $banners = (new Factory('banner'))->order('banner_pos ASC')->get();
        $dados = ['config' => $config, 'banner' => $banners];
        Tpl::view("admin.banner", $dados);
    }

    public function upload()
    {
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = 'midias' . $ds . 'banner';
        $dir = Path::base() . $ds;
        if (!empty($_FILES)) {
            $tempFile = $_FILES['banner_url']['tmp_name'];
            $ext = strtolower(
                pathinfo($_FILES['banner_url']['name'], PATHINFO_EXTENSION)
            );
            $filename =
            Filter::slug($_FILES['banner_url']['name']) . "." . $ext;
            $exts = ['png', 'jpg', 'jpeg', 'gif'];
            if (!in_array($ext, $exts)) {
                Http::redirect_to('/banner/?error');
                exit();
            }
            $targetPath = $dir . $storeFolder . $ds;
            $targetFile = $targetPath . $filename;
            if (move_uploaded_file($tempFile, $targetFile)) {
                $data = ['banner_url' => $filename];
                (new Factory('banner'))->with($data)->save();
            } else {
                Http::redirect_to('/banner/?error');
                exit();
            }
        }
        Http::redirect_to('/banner/?success');
    }

    public function remove()
    {
        $id = Req::post('banner_id', null, 'int');
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = 'midias' . $ds . 'banner';
        $dir = Path::base() . $ds . $storeFolder . $ds;
        $banner = (new Factory('banner'))->find($id);
        $file = $dir . $banner->banner_url;
        if (file_exists($file)) {
            @unlink($file);
        }
        (new Factory('banner'))->drop($id);
    }

    public function posicao()
    {
        $id = Req::post('banner_id', null, 'int');
        $pos = Req::post('banner_pos', null, 'int');
        $data = ['banner_id' => $id, 'banner_pos' => $pos];
        (new Factory('banner'))->with($data)->save();
    }
}
