<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para Produtos
 */
class Produtos extends CI_Controller {
    
     public function __construct() {
        parent::__construct();

        $this->load->model('Produtos_model');
    }
    
    
    /**
     * Busca id do Produto
     */
    public function getProduto() {        
        $id = $this->input->post('id', TRUE);        
        $produto = $this->Produtos_model->getProduto($id);
        echo json_encode($produto);        
    } 
}
