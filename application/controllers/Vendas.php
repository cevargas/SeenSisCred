<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para Vendas
 */
class Vendas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->model('Vendas_model');
        $this->load->model('Clientes_model');
        $this->load->model('Produtos_model');
    }
    
     /**
     * Busca vendas para carregar na view
     */
    public function index() {
        $data = array();

        //busca todos os clientes 
        $vendas = $this->Vendas_model->findAll();

        $data['view'] = 'app/vendas/list';
        $data['url'] = 'vendas';
        $data['vendas'] = $vendas;
        $this->load->view('index', $data);
    }
    
    /**
     * Carrega formulario para adicao de nova venda
     */
    public function novo() {
        $data = array();
        $data['view'] = 'app/vendas/form';
        $data['url'] = 'vendas';
        $data['clientes'] = $this->Clientes_model->findAll();
        $data['produtos'] = $this->Produtos_model->findAll();
        $this->load->view('index', $data);
    }
}