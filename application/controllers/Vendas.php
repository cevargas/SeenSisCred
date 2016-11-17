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

        //busca todos as vendas 
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

    /**
     * Recebe post para salvar os dados no banco de dados.
     * @return type
     */
    public function salvar() {
        
        $id = trim($this->input->post('id', TRUE));

        $this->form_validation->set_rules('clientes', 'Clientes', 'trim|required');
        $this->form_validation->set_rules('data_compra', 'Data Compra', 'trim|required');
        $this->form_validation->set_rules('produtos[]', 'Produto', 'trim|required');
        $this->form_validation->set_rules('quantidade[]', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('valor[]', 'Valor', 'trim|required');

        if ($this->form_validation->run() === TRUE) {

            $data = array();
            $data['id_funcionario'] = 1; //seria o id do funcionario da sessao.
            $data['id_cliente'] = $this->input->post('clientes');
            $data['data_compra'] = $this->input->post('data_compra_submit');
            $data['forma_pagamento'] = $this->input->post('formapagto');

            $prestacoes = $this->input->post('prestacoes');
            $diapagto = $this->input->post('diapagto');

            $data['prestacoes'] = $prestacoes;
            $data['diapagto'] = $diapagto;

            $map = array_map(null, $this->input->post('produtos'), $this->input->post('quantidade'));

            $total = 0;
            foreach ($map as $m) {
                if (count($m) > 0) {
                    $produto = $this->Produtos_model->getProduto($m[0]);
                    $total += ($produto['valor'] * $m[1]);
                }
            }
            $data['valor_total'] = $total;
            
            //inserindo novo registro
            if(!$id) {
                    
                //salva vendas
                $novoId = $this->Vendas_model->save($data);

                $prodmap = array_map(null, array(), $this->input->post('produtos'), $this->input->post('quantidade'));

                //salva itens da compra
                $this->saveItens($prodmap, $novoId);

                //parcelamento = a prazo
                if ($data['forma_pagamento'] === 2) {
                    $this->savePagamento($total, $prestacoes, $diapagto, $novoId);
                }

                $this->session->set_flashdata('success_msg', "Dados salvos com sucesso");
                redirect('vendas', 'location', 303);
            }
            else {
                //update
                $data['id'] = $id; //id da venda
                $this->Vendas_model->save($data);
                
                $prodmap = array_map(null, $this->input->post('id_itens'), $this->input->post('produtos'), $this->input->post('quantidade'));

                //salva itens da compra
                $this->saveItens($prodmap, $data['id']);

                //parcelamento = a prazo
                if ($data['forma_pagamento'] === '2') {                 
                    $this->savePagamento($total, $prestacoes, $diapagto, $data['id']);
                }
    
                $this->session->set_flashdata('success_msg', "Dados atualizados com sucesso");
                redirect('vendas', 'location', 303);
                
            }
        } else {
            $this->novo();
            return;
        }
    }

    /**
     * Recupera dados para edicao de vendas
     * @param type $id
     */
    public function edit($id) {
        $data = array();
        if (trim((int) $id)) {

            $venda = $this->Vendas_model->getVenda($id);

            if ($venda) {
                $data['acao'] = 'Editar Vendas';
                $data['url'] = 'vendas';
                $data['view'] = 'app/vendas/form';
                $data['clientes'] = $this->Clientes_model->findAll();
                $data['produtos'] = $this->Produtos_model->findAll();
                $data['pagamentos'] = $this->Vendas_model->getVendaPagamentos($id);
                $data['itens'] = $this->Vendas_model->getItensVenda($id);
                $data['venda'] = $venda;

                $this->load->view('index', $data);
            } else {
                $this->session->set_flashdata('success_msg', "Falha ao acessar os dados da Venda.");
                redirect('clientes', 'location', 303);
            }
        }
    }
    
    /**
     * Salva itens da venda
     * @param type $prodmap
     * @param type $novoId
     */
    public function saveItens($prodmap, $novoId) {
        foreach ($prodmap as $pm) {
            if (count($pm) > 0) {
                $dataItens = array();
                $dataItens['id'] = $pm[0];
                $produto = $this->Produtos_model->getProduto($pm[1]);
                $dataItens['id_venda'] = $novoId;
                $dataItens['id_produto'] = $produto['id'];
                $dataItens['valor'] = $produto['valor'];
                $dataItens['quantidade'] = $pm[2];

                //salva itens da venda
                $this->Vendas_model->saveItens($dataItens);
            }
        }
    }    
    
    /**
     * Salva dados de pagamento a prazo
     * @param type $mapitens
     * @param type $total
     * @param type $prestacoes
     * @param type $diapagto
     * @param type $idVenda
     */
    public function savePagamento($total, $prestacoes, $diapagto, $idVenda){
        
        //vai deletar os registro de pagamento se ja existirem
        $this->Vendas_model->deletePagamento($idVenda);
        
        if ($total && $prestacoes && $diapagto) {

            $valorpres = ($total / $prestacoes);

            for ($i = 1; $i <= $prestacoes; $i++) {
                $datapagto = array();

                $dt = new DateTime();
                $dt->add(new DateInterval('P' . $i . 'M'));
                $strDate = $dt->format('Y-m-d H:i:s');
                $date = $strDate;
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $nDate = new DateTime();
                $nDate->setDate($year, $month, $diapagto);
                $strNDate = $nDate->format('Y-m-d H:i:s');
                $datapagto['id_venda'] = $idVenda;
                $datapagto['valor'] = $valorpres;
                $datapagto['data_pagamento'] = $strNDate;
                $datapagto['status'] = 1;
    
                //salva dados de pagamento a prazo
                $this->Vendas_model->savePagamento($datapagto);
            }
        }
    }
    
    public function relatorio($id) {
   
        $data = [];
        
        //$id busca os dados do ID
        
        $html = '';
        
        $pdfFilePath = "output_pdf_name.pdf";
 
        
        //$this->load->library('m_pdf');
 
       
        $this->m_pdf->pdf->WriteHTML($html);
 
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
}