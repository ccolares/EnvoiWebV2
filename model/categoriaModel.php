<?php

Class categoriaModel extends appModel
{

    public function __construct()
    {
        $this->initApp();
    }

    public function get_all_admin($order = 'categoria_nome ASC')
    {
        $this->db->query = "SELECT * FROM categoria ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_all($order = 'categoria_nome ASC')
    {
        $this->db->query = "SELECT * FROM categoria WHERE  categoria_ativa = 1 ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_by_id($id)
    {
        $this->db->query = "SELECT * FROM categoria WHERE categoria_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_by_item($id)
    {
        $this->db->query = "SELECT * FROM item INNER JOIN categoria ON (categoria_id = item_categoria) WHERE categoria_id = $id;";
        $data = $this->db->fetch();
        return (isset($data)) ? $data : null;
    }

    public function duplicar($id)
    {
        $this->db->query = "SELECT * FROM categoria WHERE categoria_id = $id;";
        $data = $this->db->fetch()[0];
        $data->categoria_ordem = intval($data->categoria_ordem);
        $data->categoria_nome = $data->categoria_nome. " (1)";
        unset($data->categoria_id);
        $data = (array)$data;
        $_POST = $data;
        return self::gravar();
    }


    public function gravar($id = null)
    {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE categoria SET $post->sql_update WHERE categoria_id = $id;");
            return $id;
        } else {//cadastra
            $this->db->query("INSERT INTO categoria $post->sql_insert;");
            return $this->db->lastId();
        }
    }

    public function altera_status($id, $status)
    {
        $status = ($status == 1) ? 0 : 1;
        $this->db->query("UPDATE categoria SET categoria_ativa = '$status' WHERE categoria_id = $id;");
    }

    public function altera_pos($id, $pos)
    {
        $this->db->query("UPDATE categoria SET categoria_pos = '$pos' WHERE categoria_id = $id;");
    }

    public function remove($id)
    {
        $this->db->query("DELETE FROM categoria WHERE categoria_id = $id;");
    }

    public function add_grupo($cat, $grp)
    {
        $this->db->query("INSERT INTO relprod (relprod_grupo, relprod_categoria) VALUES ($grp,$cat);");
    }

    public function rem_grupo($cat, $grp)
    {
        $this->db->query("DELETE FROM relprod WHERE relprod_categoria = $cat AND relprod_grupo = $grp;");
    }

    public function __destruct()
    {
        //
    }
}
