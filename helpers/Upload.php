<?php

class Upload
{
    static public function Enviar($file, $pasta = '')
    {
        $midia = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . $pasta;
        $arquivo = $midia . basename($file['name']);
        //verifica se o arquivo enviado é uma imagem
        $check = getimagesize($file["tmp_name"]);
        if ($check == false) {
            $data = ['mensagem' => "Erro ao fazer upload - O arquivo deve ser uma imagem!"];
            Tpl::View('adm/erro/upload', $data);
            exit;
        }
        if (move_uploaded_file($file['tmp_name'], $arquivo)) {
            return $file['name'];
        } else {
            $data = ['mensagem' => "Erro ao fazer upload "];
            Tpl::View('erro.upload', $data);
            exit;
        }
    }

    static public function remove($file)
    {
        $file = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . "item" . DIRECTORY_SEPARATOR . $file;
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    static public function Slide($file)
    {
        $midia = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . "item" . DIRECTORY_SEPARATOR;
        $extensao = Upload::get_extensao($file['name']);
        $arquivo_extensao = time() . ".$extensao";
        $destino = $midia . time() . ".$extensao";
        //verifica se o arquivo enviado é uma imagem
        $check = getimagesize($file["tmp_name"]);
        if ($check == false) {
            $data = ['mensagem' => "Erro ao fazer upload - O arquivo deve ser uma imagem!"];
            Tpl::View('erro.upload', $data);
            exit;
        }
        if (move_uploaded_file($file['tmp_name'], $destino)) {
            return $arquivo_extensao;
        } else {
            $data = ['mensagem' => "Erro ao fazer upload!"];
            Tpl::view('erro.upload',$data);
            exit;
        }
    }

    static public function Logo($file)
    {
        $midia = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . "logo".DIRECTORY_SEPARATOR;
        $extensao = Upload::get_extensao($file['name']);
        $arquivo_extensao = time() . ".$extensao";
        $destino = $midia . time() . ".$extensao";
        //verifica se o arquivo enviado é uma imagem
        $check = getimagesize($file["tmp_name"]);
        if ($check == false) {
            $data = ['mensagem' => "Erro ao fazer upload - O arquivo deve ser uma imagem!"];
            Tpl::View('erro.upload', $data);
            exit;
        }
        if (move_uploaded_file($file['tmp_name'], $destino)) {
            return $arquivo_extensao;
        } else {
            $data = ['mensagem' => "Erro ao fazer upload!"];
            Tpl::View('erro.upload', $data);
            exit;
        }
    }

    static public function Banner($file)
    {
        $midia = Path::base() . DIRECTORY_SEPARATOR . "midias" . DIRECTORY_SEPARATOR . "banner". DIRECTORY_SEPARATOR;
        $extensao = Upload::get_extensao($file['name']);
        $arquivo_extensao = time() . ".$extensao";
        $destino = $midia . time() . ".$extensao";
        //verifica se o arquivo enviado é uma imagem
        $check = getimagesize($file["tmp_name"]);
        if ($check == false) {
            $data = ['mensagem' => "Erro ao fazer upload - O arquivo deve ser uma imagem!"];
            Tpl::View('erro.upload', $data);
            exit;
        }
        if (move_uploaded_file($file['tmp_name'], $destino)) {
            return $arquivo_extensao;
        } else {
            $data = ['mensagem' => "Erro ao fazer upload!"];
            Tpl::View('erro.upload', $data);
            exit;
        }
    }

    static public function get_extensao($file)
    {
        $ext = explode(".", $file);
        return $ext[count($ext) - 1];
    }

}
