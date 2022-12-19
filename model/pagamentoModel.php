<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 29/09/17
 * Time: 09:18
 */

class pagamentoModel extends appModel
{
    public function __construct() {
        $this->initApp();
    }

    public function get_all() {
        $this->db->query = "SELECT * FROM pagamento";
       $data = $this->db->fetch();
       return $data[0];
    }

    public function gravar($id) {
        $post = Req::query_builder();
        $this->db->query("UPDATE pagamento SET $post->sql_update WHERE pagamento_id = $id;");
    }

}