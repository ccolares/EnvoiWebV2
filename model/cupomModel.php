<?php

Class CupomModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all($order = 'cupom_nome DESC') {
        $this->db->query = "SELECT * FROM cupom ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_cupom() {
        $this->db->query = "SELECT cupom_id as id, cupom_nome as nome,
                            DATE_FORMAT(cupom_validade, '%d/%m/%Y') as validade,
                            CASE cupom_tipo
                            WHEN 1 THEN CONCAT('R$ ', FORMAT(cupom_valor, 2, 'de_DE') )
                            ELSE CONCAT(cupom_percent, '%')
                            END AS valor 
                            FROM cupom;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_by_id($id) {
        $this->db->query = "SELECT * FROM cupom LIMIT 0,1;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_by_nome($cupom) {
        $this->db->query = "SELECT cupom_nome, cupom_tipo, cupom_percent, cupom_valor, cupom_id FROM cupom WHERE cupom_nome = '$cupom'  AND cupom_validade >= CURRENT_DATE();";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function gravar($id = null) {
        $post = Req::query_builder();
        $this->db->query("INSERT INTO cupom $post->sql_insert;");
        return 1;
    }

    public function remove($id) {
        $this->db->query("DELETE FROM cupom WHERE cupom_id = $id;");
    }

    public function __destruct() {
        //
    }

}
