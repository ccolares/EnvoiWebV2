<?php

class pedidoModel extends appModel
{

    public function __construct()
    {
        $this->initApp();
    }

    public function get_all()
    {
        $this->db->query = "SELECT * FROM pedido "
            . "INNER JOIN pedido_lista ON (lista_pedido = pedido_id) "
            . "INNER JOIN cliente ON (cliente_id = pedido_cliente) "
            . "GROUP BY pedido_id ORDER BY pedido.pedido_id DESC";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_dash()
    {
        $this->db->query = "SELECT * FROM pedido "
            . "INNER JOIN pedido_lista ON (lista_pedido = pedido_id) "
            . "INNER JOIN cliente ON (cliente_id = pedido_cliente) "
            . "WHERE (pedido_status = 1) "
            . "GROUP BY pedido_id ORDER BY pedido_id DESC, pedido_status ASC LIMIT 0,20";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_by_id($id)
    {
        $this->db->query = "SELECT * FROM pedido "
            . "INNER JOIN cliente ON (pedido_cliente = cliente_id ) "
            . "LEFT JOIN endereco ON (pedido_local = endereco_id ) "
            . "WHERE pedido_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_lista_by_pedido($id)
    {
        $this->db->query = "SELECT * FROM pedido_lista 
                            INNER JOIN item ON (lista_item = item_id) 
                            INNER JOIN categoria ON (item_categoria = categoria_id) 
                            WHERE lista_pedido = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }

    public function get_last_id_pedido()
    {
        $this->db->query = "SELECT * FROM pedido WHERE pedido_status = 1 ORDER BY pedido_id DESC";
        $data = $this->db->fetch();
        return (isset($data[0]->pedido_id)) ? $data[0]->pedido_id : 0;
    }

    public function pendente_by_cliente()
    {
        if (ClienteSessao::get_id() > 0) {
            $cliente = ClienteSessao::get_id();
            $this->db->query = "SELECT pedido_id, pedido_cliente FROM pedido WHERE pedido_cliente = $cliente AND pedido_status < 4 ORDER BY pedido_id DESC LIMIT 1";
            $data = $this->db->fetch();
            if (isset($data[0])) {
                foreach ($data as $k => $v) {
                    $data[$k]->lista = $this->get_lista_by_pedido($data[$k]->pedido_id);
                }
            }
            return (isset($data[0])) ? json_encode($data[0]) : null;
        } else {
            return null;
        }
    }


    public function get_by_cliente($id)
    {
        $this->db->query = "SELECT * FROM pedido  WHERE pedido_cliente = $id ORDER BY pedido_id DESC";
        $data = $this->db->fetch();
        if (isset($data[0])) {
            foreach ($data as $k => $v) {
                $data[$k]->lista = $this->get_lista_by_pedido($data[$k]->pedido_id);
            }
        }
        return (isset($data[0])) ? $data : null;
    }

    public function gravar($id = null)
    {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE pedido SET $post->sql_update WHERE pedido_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO pedido $post->sql_insert;");
        }
    }

    public function incluir($p, $cart)
    {
        /* SQL PEDIDO */
        $sql_pedido = "INSERT INTO pedido (pedido_data,pedido_cliente,pedido_local,pedido_total,pedido_entrega,pedido_entrega_prazo,pedido_obs,pedido_obs_pagto) ";
        $sql_pedido .= " VALUES ";
        $sql_pedido .= " ('$p->pedido_data','$p->pedido_cliente','$p->pedido_local',$p->pedido_total,'$p->pedido_entrega','$p->pedido_entrega_prazo','$p->pedido_obs','$p->pedido_obs_pagto'); ";
        $this->db->query("$sql_pedido") or die($sql_pedido);
        $p->pedido_id = $this->db->lastId();
        //$p->pedido_id = 1;
        if ($p->pedido_id > 0) {
            /* SQL LISTA DE ITENS DO PEDIDO */
            $sql_pedido_lista = "INSERT INTO pedido_lista (lista_pedido,lista_item,lista_item_obs,lista_item_desc,lista_item_nome,lista_opcao_nome,lista_opcao_preco,lista_qtde,lista_item_codigo) ";
            $sql_pedido_lista .= "VALUES ";
            foreach ($cart as $c) {
                $c->item_nome = addslashes($c->item_nome);
                $c->item_desc = addslashes($c->item_desc);
                //$c->item_obs = '';
                $c->item_desc = substr($c->extra, 0, -2);
                $sql_pedido_lista .= "('$p->pedido_id','$c->item_id','$c->item_obs','$c->item_desc','$c->item_nome','$c->item_nome','$c->total','$c->qtde','$c->item_codigo'),";
            }
            $sql_pedido_lista = substr($sql_pedido_lista, 0, -1) . ";";
            $this->db->query("$sql_pedido_lista");
        }
        return $p->pedido_id;
    }

    public function incluir_pagseguro($query, $id)
    {
        $this->db->query("UPDATE pedido SET $query WHERE pedido_id =  $id;");
    }

    public function status_pagseguro($status, $id)
    {
        if($status == 7){
            $this->db->query("UPDATE pedido SET pedido_status = 5 WHERE pedido_id =  $id;");    
        }
        $this->db->query("UPDATE pedido SET pedido_pagseguro = $status WHERE pedido_id =  $id;");
    }

    public function remove($id)
    {
        $this->db->query("DELETE FROM pedido WHERE pedido_id = $id;");
        $this->db->query("DELETE FROM pedido_lista WHERE lista_pedido = $id;");
    }

    public function remove_by_cliente($id, $cliente)
    {
        $this->db->query("DELETE FROM pedido WHERE pedido_id = $id AND pedido_cliente = $cliente;");
    }
}
