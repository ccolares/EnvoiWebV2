<?php

@session_start();
/* Categoria Controller */

/* Author: Rafael Clares <falecom@phpstaff.com.br> */

class Configuracao
{

    public function __construct()
    {
        Sessao::checar();
        if(Sessao::get_nivel() == 2){
            Http::redirect_to('/admin');
        }
    }

    public function indexAction()
    {
        $dados = array(
            'config' => (new configModel)->get_config()
        );
        if (!is_null($dados)) {
            Tpl::view("admin.config-editar", $dados);
        } else {
            Http::redirect_to('/configuracao/?registro-invalido');
        }
    }

    public function novo()
    {
        Tpl::view("admin.config-novo");
    }

    public function tema()
    {
        $dados = ['config' => (new configModel)->get_config()];
        if (!is_null($dados)) {
            Tpl::view("admin.config-tema", $dados);
        } else {
            Http::redirect_to('/configuracao/tema/?registro-invalido');
        }
    }

    public function tema_update()
    {
        $config = (new configModel)->get_config();
        $br = $config->config_foto_round;
        $bd = addslashes( (isset($_POST['config_color_bd']) ? $_POST['config_color_bd'] : ''));
        $bh = addslashes( (isset($_POST['config_color_bh']) ? $_POST['config_color_bh'] : ''));
        $cd = addslashes($_POST['config_color_cd']);
        $ch = addslashes($_POST['config_color_ch']);
        $bt = addslashes($_POST['config_color_top']);
        $config_colors = str_replace('#', '', "bd=$bd&bh=$bh&cd=$cd&ch=$ch&bt=$bt&br=$br");
        Post::add('config_colors', $config_colors);
        if (isset($_FILES['config_foto']) && !empty($_FILES['config_foto']['name'])) {
            $this->config_foto = Upload::Logo($_FILES['config_foto'], "logo/");
            Post::add('config_foto', $this->config_foto);
        }
        if (isset($_FILES['config_alert']) && !empty($_FILES['config_alert']['name'])) {
            //  Upload::Alerta($_FILES['config_alert'], "alerta/");
        }
        if (Req::post('redir') == false) {
            $redirect = true;
        }
        (new configModel)->gravar(1);
        if (isset($redirect)) {
            Http::redirect_to('/configuracao/tema/?success');
        }
    }


    public function update_foto_round()
    {
        $config = (new configModel)->get_config();
        $bd = $config->config_color_bd;
        $bh = $config->config_color_bh;
        $cd = $config->config_color_cd;
        $ch = $config->config_color_ch;
        $bt = $config->config_color_top;
        $br = Req::post('config_foto_round');
        $config_colors = str_replace('#', '', "bd=$bd&bh=$bh&cd=$cd&ch=$ch&bt=$bt&br=$br");
        Post::add('config_colors', $config_colors);
        (new configModel)->gravar(1);
        echo $config_colors;
    }

    public function gravar()
    {
        if(isset($_POST['config_chat']) || isset($_POST['config_pedmin'])) {
            $_POST['config_chat'] = @strip_tags($_POST['config_chat']);
            $_POST['config_site_ga'] = @strip_tags($_POST['config_site_ga']);
            $_POST['config_pedmin'] = @Filter::moeda($_POST['config_pedmin'], 'US');
        }
        if (Req::post('redir') == false) {
            $redirect = true;
        }
        (new configModel)->gravar(1);
        if (isset($redirect)) {
            Http::redirect_to('/configuracao/?success');
        }
    }
}
