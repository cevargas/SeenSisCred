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

        //$this->output->enable_profiler(TRUE);

        $this->db->select("venda.id AS id_venda, 
                            venda.forma_pagamento AS forma_pagamento, 
                            venda.valor_total AS valor_total, 
                            DATE_FORMAT(data_compra,'%d/%m/%Y') AS data_compra,
                            cliente.id AS id_cliente, 
                            cliente.nome AS nome_cliente, 
                            cliente.sobrenome AS sobrenome_cliente, 
                            funcionario.id AS id_funcionario,
                            funcionario.nome AS nome_funcionario,
                            funcionario.sobrenome AS sobrenome_funcionario");
        $this->db->from('venda');
        $this->db->join('cliente', 'cliente.id = venda.id_cliente');
        $this->db->join('funcionario', 'funcionario.id = venda.id_funcionario');
        $this->db->order_by("venda.id", "desc");
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    /**
     * Salva venda
     */
    public function save($data) {

        try {

            if(isset($data['id'])) {                
                $this->db->where('id', $data['id']);
                $this->db->update('venda', $data); 
            }
            else {
                $this->db->insert('venda', $data);
                return $this->db->insert_id();
            }  
            
            return true;
            
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }

    /**
     * Salva itens da venda
     */
    public function saveItens($data) {

        try {
            
            if(isset($data['id'])) {                
                $this->db->where('id', $data['id']);
                $this->db->update('itens_venda', $data); 
            }
            else {
                $this->db->insert('itens_venda', $data);                
            }
            
            return true;
            
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }
    
    /**
     * Deleta os registros de pagamento
     * @param type $idVenda
     */
    public function deletePagamento($idVenda) {
        //delete            
       $this->db->where('id_venda', $idVenda);
       $this->db->delete('pagamento'); 
    }

    /**
     * Salva pagamentos a prazo
     */
    public function savePagamento($data) {

        try { 
            
            $this->db->insert('pagamento', $data);    
            return true;
            
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }

    /*
     * Recupera dados de uma venda
     */
    public function getVenda($id) {

        $this->db->select("venda.id AS id_venda, 
                            venda.forma_pagamento AS forma_pagamento, 
                            venda.valor_total AS valor_total, 
                            venda.prestacoes AS prestacoes, 
                            venda.diapagto AS diapagto, 
                            DATE_FORMAT(data_compra,'%d/%m/%Y') AS data_compra,
                            cliente.id AS id_cliente, 
                            cliente.nome AS nome_cliente, 
                            cliente.sobrenome AS sobrenome_cliente, 
                            funcionario.id AS id_funcionario,
                            funcionario.nome AS nome_funcionario,
                            funcionario.sobrenome AS sobrenome_funcionario");
        $this->db->from('venda');
        $this->db->join('cliente', 'cliente.id = venda.id_cliente');
        $this->db->join('funcionario', 'funcionario.id = venda.id_funcionario');
        $this->db->where('venda.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    /*
     * Recupera dados de pagamentos
     */
    public function getVendaPagamentos($id) {

        $this->db->select("pagamento.*, DATE_FORMAT(data_pagamento,'%d/%m/%Y') AS data_pagamento");
        $this->db->from('pagamento');
        $this->db->join('venda', 'venda.id = pagamento.id_venda');
        $this->db->where('pagamento.id_venda', $id);
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    /*
     * Recupera itens da venda
     */
    public function getItensVenda($id) {

        $this->db->select("itens_venda.*");
        $this->db->from('itens_venda');
        $this->db->join('venda', 'itens_venda.id_venda = venda.id');
        $this->db->join('produto', 'itens_venda.id_produto = produto.id');
        $this->db->where('itens_venda.id_venda', $id);
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
}
