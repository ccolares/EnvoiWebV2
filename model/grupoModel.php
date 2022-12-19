<?php

Class grupoModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all_admin($order = 'grupo_nome ASC') {
        $this->db->query = "SELECT * FROM grupo ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_all($order = 'grupo_nome ASC') {
        $this->db->query = "SELECT * FROM grupo WHERE  grupo_ativa = 1 ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_by_id($id) {
        $this->db->query = "SELECT * FROM grupo WHERE grupo_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_by_item($id) {
        $this->db->query = "SELECT * FROM item INNER JOIN grupo ON (grupo_id = item_grupo) WHERE grupo_id = $id;";
        $data = $this->db->fetch();
        return (isset($data)) ? $data : null;
    }

    public function gravar($id = null) {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE grupo SET $post->sql_update WHERE grupo_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO grupo $post->sql_insert;");
        }
    }

    public function altera_status($id, $status) {
        $status = ($status == 1) ? 0 : 1;
        $this->db->query("UPDATE grupo SET grupo_ativa = '$status' WHERE grupo_id = $id;");
    }

    public function altera_pos($id, $pos) {
        $this->db->query("UPDATE grupo SET grupo_pos = '$pos' WHERE grupo_id = $id;");
    }

    public function remove($id) {
        $this->db->query("DELETE FROM grupo WHERE grupo_id = $id;");
        $this->db->query("DELETE FROM relprod WHERE relprod_grupo = $id;");
        $this->db->query("DELETE FROM opcao WHERE opcao_grupo = $id;");
    }

    public function rem_grupo($id) {
        $this->db->query("DELETE FROM relprod WHERE relprod_grupo = $id;");
    }

    public function __destruct() {
        //
    }
}
