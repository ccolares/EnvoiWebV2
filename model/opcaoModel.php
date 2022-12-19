<?php

Class opcaoModel extends appModel {

    public function __construct() {
        $this->initApp();
    }

    public function get_all($order = 'opcao_nome DESC') {
        $this->db->query = "SELECT * FROM opcao 
                            INNER JOIN grupo ON (grupo_id = opcao_item) 
                            ORDER BY $order";
        return $this->db->fetch();
    }

    public function get_by_grupo($grp) {
        $this->db->query = "SELECT * FROM opcao 
                            INNER JOIN grupo ON (grupo_id = opcao_grupo) 
                            WHERE opcao_grupo = $grp
                            ORDER BY opcao_nome ASC";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    } 


    public function get_grupos() {
        $this->db->query = "SELECT * FROM grupo ORDER BY grupo_nome ASC";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data : null;
    }        

    public function get_grupo_categoria($id) {
        $this->db->query = "SELECT grupo_nome, grupo_tipo, grupo_id, grupo_desc,relprod_grupo,
                            categoria_id,relprod_id, relprod_status,relprod_categoria, relprod_pos
                            FROM grupo 
                            INNER JOIN relprod ON (grupo_id = relprod_grupo) 
                            INNER JOIN categoria ON (categoria_id = relprod_categoria) 
                            WHERE relprod_categoria = $id                            
                            GROUP BY grupo_id
                            ORDER BY relprod_pos ASC";
        return $this->db->fetch();
    }       

    public function get_by_id($id) {
        $this->db->query = "SELECT * FROM opcao 
                            JOIN grupo ON (grupo_id = opcao_grupo) 
                            WHERE opcao_id = $id;";
        $data = $this->db->fetch();
        return (isset($data[0])) ? $data[0] : null;
    }

    public function get_by_categoria($id) {
        $this->db->query = "SELECT grupo_id FROM grupo  
                            JOIN relprod ON (grupo_id = relprod_grupo) 
                            WHERE relprod_categoria = $id 
                            GROUP BY relprod_grupo ORDER BY relprod_pos ASC;
                            ";                            
        $grupo = $this->db->fetch();
        $opcoes = [];
        if(isset($grupo[0])){
            foreach($grupo as $k => $v){
                $this->db->query = "SELECT opcao_id,opcao_nome,opcao_preco,grupo_tipo,grupo_id,grupo_nome, grupo_limite
                                    FROM opcao  
                                    JOIN grupo ON (grupo_id = opcao_grupo) 
                                    WHERE opcao_grupo = $v->grupo_id 
                                    AND  opcao_status = 1
                                    ORDER BY opcao_preco ASC
                ";                  
                $data = $this->db->fetch();        
                if(isset($data[0])){
                    $opcoes[] = $data;
                }
            }
        }
        return (isset($opcoes)) ? $opcoes : null;
    }    

    public function gravar($id = null) {
        $post = Req::query_builder();
        if ($id != null) {//atualiza
            $this->db->query("UPDATE opcao SET $post->sql_update WHERE opcao_id = $id;");
        } else {//cadastra
            $this->db->query("INSERT INTO opcao $post->sql_insert;");
        }
    }

    public function remove($id) {
        $this->db->query("DELETE FROM opcao WHERE opcao_id = $id;");
    }

    public function update_rel_pos($id) {
        $post = Req::query_builder();
        $this->db->query("UPDATE relprod SET $post->sql_update WHERE relprod_id = $id;");
    }

}
