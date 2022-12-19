<?php

@session_start();
/* Smtp Controller */
/* Author: Rafael Clares <falecom@phpstaff.com.br> */

Class Smtp {

    public function __construct() {
        Sessao::checar();
    }

    public function indexAction() {
        $dados = array(
            'smtp' => (new smtpModel)->get()
        );
        if (!is_null($dados)) {
            Tpl::view("admin.config-email", $dados);
        } else {
            Http::redirect_to('/configuracao-email/?registro-invalido');
        }
    }

    public function gravar() {
        (new smtpModel)->gravar(1);
        Http::redirect_to('/configuracao-email/?success');
    }

}
