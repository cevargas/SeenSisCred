<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Model responsavel pela persistencia de Clientes
 */

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Retorna lista de Clientes
     */

    public function findAll() {
        $this->db->select('*');
        $this->db->from('cliente');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    /*
     * Salva cliente
     */
    public function save($data) {

        try {
            
            if(isset($data['id'])) {                
                $this->db->where('id', $data['id']);
                $this->db->update('cliente', $data); 
            }
            else {
                $this->db->insert('cliente', $data);
                return $this->db->insert_id();
            }
            
            return true;
            
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }
    
    /*
     * Salva referencias do cliente
     */
    public function saveReferencias($data) {        

        try {
            
            if($data['id'] && $data['id_cliente']) {    
                $this->db->where('id', $data['id']);
                $this->db->update('cliente_referencia', $data); 
            }
            else {
                if(empty($data['id']) && $data['nome']) {
                    $this->db->insert('cliente_referencia', $data);
                }
            }

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }
    
    /*
     * Salva outras pessoas autorizadas a comprar 
     */
    public function saveOutros($data) {

        try {
            if($data['id'] && $data['id_cliente']) {    
                $this->db->where('id', $data['id']);
                $this->db->update('cliente_outro', $data); 
            }
            else {
                if(empty($data['id']) && $data['nome']) {
                    $this->db->insert('cliente_outro', $data);
                }
            }

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }
    
    /*
     * Recupera dados de um clinete
     */
    public function getCliente($id) {
        
        //$this->output->enable_profiler(TRUE);
        $this->db->select("cliente.*, DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento");
        $this->db->from('cliente');
        $this->db->where('cliente.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        
        return $result;
    }
    
     /*
     * Recupera dados de referencia de um clinete
     */
    public function getClienteRefencias($idCliente) {
        $this->db->select('*');
        $this->db->from('cliente_referencia');
        $this->db->where('id_cliente', $idCliente);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
    }
    
    /*
     * Recupera dados de outras pessoas de um clinete
     */
    public function getClienteOutros($idCliente) {
        $this->db->select('*');
        $this->db->from('cliente_outro');
        $this->db->where('id_cliente', $idCliente);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
    }
    
    /**
     * Delete Cliente
     * @param type $id
     * @return type
     */
    public function delete($id) {

        try {

            $this->db->where('id_cliente', $id);
            $this->db->delete('cliente_outro'); 
     
            $this->db->where('id_cliente', $id);
            $this->db->delete('cliente_referencia'); 
            
            $this->db->where('id', $id);
            $this->db->delete('cliente');

            return true;
            
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return;
        }
    }
}