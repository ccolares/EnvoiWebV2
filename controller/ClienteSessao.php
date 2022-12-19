<?php

@session_start();

class ClienteSessao {

    static public function checar() {
        if (!isset($_SESSION['__CLIENTE__LOGADO__'])) {
            Http::redirect_to("/cliente-login/");
        }
    }

    static public function get_id() {
        if (isset($_SESSION['__CLIENTE__ID__'])) {
            return $_SESSION['__CLIENTE__ID__'];
        }
    }

    static public function get_nivel() {
        if (isset($_SESSION['__CLIENTE__NIVEL__'])) {
            return $_SESSION['__CLIENTE__NIVEL__'];
        }
    }

    static public function get_nome() {
        if (isset($_SESSION['__CLIENTE__NOME__'])) {
            return $_SESSION['__CLIENTE__NOME__'];
        }
    }

    static public function get_nome_first() {
        if (isset($_SESSION['__CLIENTE__NOME__'])) {
            return explode(' ', $_SESSION['__CLIENTE__NOME__'])[0];
        }
    }

    static public function get_obj() {
        if (isset($_SESSION['__CLIENTE__OBJ__'])) {
            return $_SESSION['__CLIENTE__OBJ__'];
        }
    }

}
