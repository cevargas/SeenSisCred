<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Model responsavel pela persistencia de Vendas
 */

class Vendas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Retorna lista de Clientes
     */
    public function findAll() {
        $this->db->select("*, DATE_FORMAT(data_compra,'%d/%m/%Y') AS data_compra");
        $this->db->from('venda');
        $this->db->join('cliente', 'cliente.id = venda.id_cliente');
        $this->db->join('funcionario', 'funcionario.id = venda.id_funcionario');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

}