<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para Clientes
 */
class Clientes extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data = array();
        $data['view'] = 'app/clientes/list';
        $data['url'] = 'clientes';
        $this->load->view('index', $data);
    }
}
