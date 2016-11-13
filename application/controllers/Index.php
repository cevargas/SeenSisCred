<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador inicial
 */
class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();
        $data['view'] = 'app/home';
        $data['url'] = 'home';
        $this->load->view('index', $data);
    }

}
