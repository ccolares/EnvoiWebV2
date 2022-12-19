<?php

Class itemModel extends appModel
{

    public function __construct()
    {
        $this->initApp();
    }

    public function get_all($order = 'item_nome ASC, categoria_pos ASC')
    {
        $this->db->query = "SELECT * FROM item "
            . "INNER JOIN categoria ON (categoria_id = item_categoria) "
            . "WHERE item_id > 1 "
            . "ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_by_id($id)
    {
        $this->db->query = "SELECT * FROM item "
            . "INNER JOIN categoria ON (categoria_id = item_categoria) "
            . "WHERE item.item_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_foto($id)
    {
        $this->db->query = "SELECT item_foto FROM item WHERE item_id = $id";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0]->item_foto : false;
    }

    public function get_by_categoria($id, $limit = 100000)
    {
        $this->db->query = "SELECT item_id,item_categoria,item_nome,item_obs,item_foto,item_preco,
                            item_desc,item_codigo,categoria_nome,categoria_id,categoria_meia, item_estoque 
                            FROM item 
                            INNER JOIN categoria ON (categoria_id = item_categoria) 
                            WHERE item_id > 1 AND item_ativo = 1  AND item.item_categoria = $id
                            ORDER BY item_nome ASC LIMIT 0,$limit;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_by_categoria_promo($id)
    {
        $this->db->query = "SELECT item_id,item_categoria,item_estoque,item_nome,item_obs,item_foto,item_preco,item_promo,
                            item_desc,item_codigo,categoria_nome,categoria_id,categoria_meia 
                            FROM item 
                            INNER JOIN categoria ON (categoria_id = item_categoria) 
                            WHERE  item_ativo = 1 AND item_promo = 1 AND item.item_categoria = $id
                            ORDER BY item_id DESC;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_by_busca($id, $nome, $cod, $desc, $obs)
    {
        $this->db->query = "SELECT * FROM item "
            . "INNER JOIN categoria ON (categoria_id = item_categoria) WHERE  "
            . "categoria_id = $id AND ( "
            . "item_nome LIKE'%$nome%' ";
        if ($cod != "") {
            $this->db->query .= " OR  item_codigo LIKE'%$cod%' ";
        }
        if ($desc != "") {
            $this->db->query .= " OR item_desc LIKE'%$desc%' ";
        }
        if ($obs != "") {
            //$this->db->query .= " OR item_obs LIKE'%$obs%' ";
        }
        $this->db->query .= " ); ";

        $data = $this->db->fetch();

        if (isset($data[0])) {
            foreach ($data as $k => $v) {
                //$opc = (new opcaoModel)->get_by_item($data[$k]->item_id);
                //$data[$k]->opcao = $opc;
            }
        }
        return (isset($data[0])) ? $data : null;
    }

    public function get_estoque()
    {
        $this->db->query = "SELECT item_nome, item_id, item_estoque, categoria_nome 
                            FROM item INNER JOIN categoria ON item_categoria = categoria_id 
                            WHERE item_estoque <= 20 ORDER BY item_estoque ASC";
        return $this->db->fetch();
    }


    public function duplicar($id)
    {
        $this->db->query = "SELECT * FROM item WHERE item.item_id = $id;";
        $data = $this->db->fetch()[0];
        unset($data->item_id);
        unset($data->item_foto);
        $data->item_nome = $data->item_nome . " (1)";
        $data->item_codigo = $data->item_codigo . " (1)";
        $data = (array)$data;
        $_POST = $data;
        return self::gravar();
    }


    public function gravar($id = null)
    {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE item SET $post->sql_update WHERE item_id = $id;");
            return $id;
        } else {//cadastra
            $this->db->query("INSERT INTO item $post->sql_insert;");
            return $this->db->lastId();
        }
    }

    public function remove($id)
    {
        $this->db->query("DELETE FROM item WHERE item_id = $id;");
    }

    public function altera_status($id, $status)
    {
        $status = ($status == 1) ? 0 : 1;
        $this->db->query("UPDATE item SET item_ativo = '$status' WHERE item_id = $id;");
    }

    public function altera_promo($id, $promo)
    {
        $promo = ($promo == 1) ? 0 : 1;
        $this->db->query("UPDATE item SET item_promo = '$promo' WHERE item_id = $id;");
    }

    public function __destruct()
    {
        //
    }

}
