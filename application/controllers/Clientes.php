<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para Clientes
 */
class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Clientes_model');
    }
    
    /**
     * Busca clientes para carregar na view
     */
    public function index() {
        $data = array();

        //busca todos os clientes 
        $clientes = $this->Clientes_model->findAll();

        $data['view'] = 'app/clientes/list';
        $data['url'] = 'clientes';
        $data['clientes'] = $clientes;
        $this->load->view('index', $data);
    }

    /**
     * Carrega formulario para adicao de novo cliente
     */
    public function novo() {
        $data = array();
        $data['view'] = 'app/clientes/form';
        $data['url'] = 'clientes';
        $this->load->view('index', $data);
    }

    /**
     * Recebe post para salvar os dados no banco de dados.
     * @return type
     */
    public function salvar() {

        $id = trim($this->input->post('id', TRUE));

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('sobrenome', 'Sobrenome', 'trim|required');
        $this->form_validation->set_rules('cpf', 'Nome', 'trim|required');
        $this->form_validation->set_rules('datanascimento', 'Data Nascimento', 'trim|required');
        $this->form_validation->set_rules('endereco', 'Endereço', 'trim|required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'trim|required');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $data = array(
                'nome' => $this->input->post('nome', TRUE),
                'email' => $this->input->post('email', TRUE),
                'sobrenome' => $this->input->post('sobrenome', TRUE),
                'cpf' => $this->input->post('cpf', TRUE),
                'data_nascimento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('datanascimento', TRUE)))),
                'endereco' => $this->input->post('endereco', TRUE),
                'telefone' => $this->input->post('telefone', TRUE),
                'estado' => $this->input->post('estado', TRUE),
                'cidade' => $this->input->post('cidade', TRUE)
            );

            //inserindo novo registro
            if(!$id) {

                $novoId = $this->Clientes_model->save($data);

                $map = array_map(null, array(), $this->input->post('nomeref'), $this->input->post('sobrenomeref'), $this->input->post('telefoneref'), $this->input->post('tiporeferencia'));    
                $this->saveRefs($novoId, $map);

                $mapo = array_map(null, array(), $this->input->post('nomeout'), $this->input->post('sobrenomeout'), $this->input->post('telefoneout'), $this->input->post('limiteout'));
                $this->saveOutros($novoId, $mapo);
    
                $this->session->set_flashdata('success_msg', "Dados salvos com sucesso");
                redirect('clientes', 'location', 303);
            }
            else {
                //update
                $data['id'] = $id; //id do cliente
                $this->Clientes_model->save($data);
                
                $map = array_map(null, $this->input->post('idref'), $this->input->post('nomeref'), $this->input->post('sobrenomeref'), $this->input->post('telefoneref'), $this->input->post('tiporeferencia'));    
                $this->saveRefs($id, $map);

                $mapo = array_map(null, $this->input->post('idout'), $this->input->post('nomeout'), $this->input->post('sobrenomeout'), $this->input->post('telefoneout'), $this->input->post('limiteout'));    
                $this->saveOutros($id, $mapo);
                
                $this->session->set_flashdata('success_msg', "Dados atualizados com sucesso");
                redirect('clientes', 'location', 303);
            }
            
        } else {
            $this->novo();
            return;
        }
    }
    
    /**
     * Recupera dados para edicao de cliente
     * @param type $id
     */
    public function edit($id){
        $data = array();
        if(trim((int)$id)) {
            
            $cliente = $this->Clientes_model->getCliente($id);
            
            if($cliente) {      
                $data['acao'] = 'Editar Cliente';
                $data['url'] = 'clientes';
                $data['view'] = 'app/clientes/form'; 
                $data['cliente'] = $cliente;
                $data['cliente_ref'] = $this->Clientes_model->getClienteRefencias($id);    
                $data['cliente_out'] = $this->Clientes_model->getClienteOutros($id);
                $this->load->view('index', $data);
            }
            else {            
                $this->session->set_flashdata('success_msg', "Falha ao acessar os dados do Cliente.");
                redirect('clientes', 'location', 303);
            }
        }
    }
    
    /**
     * Delete do cliente
     * @param type $id
     */
    public function delete($id) {
        if(trim((int)$id)) {
            $this->Clientes_model->delete($id);
            $this->session->set_flashdata('success_msg', "Registro excluído.");
            redirect('clientes', 'location', 303);
        }
    }
    
    /**
     * Salva outras pessoas relacionadas ao cliente
     * @param type $id
     * @param type $map
     */
    public function saveOutros($id, $map) {
        
        foreach ($map as $m) {
            if (count($m) > 0) {
                $dataout = array(
                    'id' => $m[0],
                    'id_cliente' => $id,
                    'nome' => $m[1],
                    'sobrenome' => $m[2],
                    'telefone' => $m[3],
                    'limite_credito' => $this->clearMaskMoney($m[4])
                );

                $this->Clientes_model->saveOutros($dataout);
            } 
        }
    }

    /**
     * Salva referencias do cliente
     * @param type $id
     * @param type $map
     */
    public function saveRefs($id, $map) {

        foreach ($map as $m) {
            if (count($m) > 0) {
                $dataref = array(
                    'id' => $m[0],
                    'id_cliente' => $id,
                    'nome' => $m[1],
                    'sobrenome' => $m[2],
                    'telefone' => $m[3],
                    'tipo_referencia' => $m[4]
                );
                $this->Clientes_model->saveReferencias($dataref);
            }
        }
    }

    /**
     * Limpa mascara de moeda
     * @param type $valor
     * @return type
     */
    public function clearMaskMoney($valor){   
        $result = str_replace(',', '.', str_replace('.', '', str_replace('R$', '', $valor)));
        return $result;
    }
}