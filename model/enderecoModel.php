<?php

Class enderecoModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all($order = 'endereco_cidade DESC') {
        $this->db->query = "SELECT * FROM endereco ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_by_id($id) {
        $this->db->query = "SELECT * FROM endereco JOIN cliente ON (cliente_id = endereco_cliente) WHERE endereco_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_by_cliente($id) {
        $this->db->query = "SELECT * FROM endereco 
                            LEFT JOIN bairro ON (bairro_id = endereco_bairro_id)
                            INNER JOIN cliente ON (cliente_id = endereco_cliente) 
                            WHERE endereco_cliente = $id ORDER BY endereco_id DESC;";
        $data = $this->db->fetch();
        return (isset($data)) ? $data : null;
    }


    public function gravar($id = null) {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE endereco SET $post->sql_update WHERE endereco_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO endereco $post->sql_insert;");
            return $this->db->lastId();
        }
    }

    public function remove($id) {
        $this->db->query("DELETE FROM endereco WHERE endereco_id = $id;");
    }

    public function remove_by_cliente($id, $cliente) {
        $this->db->query("DELETE FROM endereco WHERE endereco_id = $id AND endereco_cliente = $cliente;");
    }

    public function __destruct() {
        //
    }

}
