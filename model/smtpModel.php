<?php

Class smtpModel extends appModel {
    private $host;
    private $port;
    private $email;
    private $pass;
    private $nome;
    
    public function __construct() {
        $this->initApp();
        $this->db->query = "SELECT * FROM smtp WHERE smtp_id = 1";
        $smtp = $this->db->fetch()[0];       
        $this->host = $smtp->smtp_host;
        $this->port = $smtp->smtp_port;
        $this->email = $smtp->smtp_email;
        $this->pass = $smtp->smtp_pass;
        $this->nome = $smtp->smtp_nome;
        $this->bcc = $smtp->smtp_bcc;
    }

    public function __get($key) {
        return $this->$key;
    }

    public function get() {
        return $this->db->fetch()[0];
    }

    public function gravar($id = null) {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE smtp SET $post->sql_update WHERE smtp_id = $id;");
        }
    }

    public function __destruct() {
        //
    }

}
