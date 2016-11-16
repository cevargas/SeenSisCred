<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Model responsavel pela persistencia de Produtos
 */

class Produtos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Retorna lista de Produtos
     */
    public function findAll() {
        $this->db->select("*");
        $this->db->from('produto');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }
    
     /*
     * Recupera dados de um produto
     */
    public function getProduto($id) {
        
        $this->db->select("*");
        $this->db->from('produto');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        
        return $result;
    }

}