<?php

Class usuarioModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all($order = 'ASC') {
        $this->db->query = "SELECT * FROM usuario ORDER BY usuario_nome $order";
        return $this->db->fetch();
    }

    public function get_by_id($id) {
        $this->db->query = "SELECT * FROM usuario WHERE usuario_id  = $id;";
        return $this->db->fetch()[0];
    }

    public function gravar($id = null) {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE usuario SET $post->sql_update WHERE usuario_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO usuario $post->sql_insert;");
        }
    }

    public function remove($id) {
        $this->db->query("DELETE FROM usuario WHERE usuario_id = $id;");
    }

    public function __destruct() {
        //
    }

}
