<?php

Class configModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all($order = 'config_nome DESC') {
        $this->db->query = "SELECT * FROM config ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_config() {
        $this->db->query = "SELECT * FROM config";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_valor_min() {
        $this->db->query = "SELECT config_pedmin FROM config WHERE config_id = 1";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0]->config_pedmin : null;
    }

    public function get_by_id()
    {
        $this->db->query = "SELECT * FROM config LIMIT 0,1;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function gravar($id = null) {
        Post::drop('redir');
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            //echo $post->sql_update;
            $this->db->query("UPDATE config SET $post->sql_update WHERE config_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO config $post->sql_insert;");
        }
    }

    public function remove($id) {
        $this->db->query("DELETE FROM config WHERE config_id = $id;");
    }
}
