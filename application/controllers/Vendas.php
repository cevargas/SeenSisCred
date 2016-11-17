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
                if ($data['forma_pagamento'] === '2') {
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
        $venda = $this->Vendas_model->getVenda($id);

        if ($venda) {
          $pagamentos = $this->Vendas_model->getVendaPagamentos($id);
          $itens = $this->Vendas_model->getItensVenda($id);

          $html = '<html>
                    <head>
                        <style>
                            body {font-family: sans-serif;
                                  font-size: 10pt;
                            }
                            p {	margin: 0pt; }
                            table.items {
                                border: 0.1mm solid #000000;
                            }
                            td { vertical-align: top; }
                            .items td {
                                border-left: 0.1mm solid #000000;
                                border-right: 0.1mm solid #000000;
                            }
                            table thead td { background-color: #EEEEEE;
                                             text-align: center;
                                             border: 0.1mm solid #000000;
                                             font-variant: small-caps;
                            }
                            .items td.blanktotal {
                                background-color: #EEEEEE;
                                border: 0.1mm solid #000000;
                                background-color: #FFFFFF;
                                border: 0mm none #000000;
                                border-top: 0.1mm solid #000000;
                                border-right: 0.1mm solid #000000;
                            }
                            .items td.totals {
                                text-align: right;
                                border: 0.1mm solid #000000;
                            }
                            .items td.cost {
                                text-align: "." center;
                            }
                        </style>
                    </head>
                    <body>
                        <div style="text-align: right">'.date('d/m/Y').'</div>
                        <table width="100%" style="font-family: serif;" cellpadding="10">
                          <tr>
                                <td width="45%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">Cliente:</span><br /><br />'.$venda['nome_cliente'].' '.$venda['sobrenome_cliente'].'</td>
                                <td width="10%">&nbsp;</td>
                                <td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">Venda:</span><br /><br />Data: '.$venda['data_compra'].'<br />Valor Total (R$): '.number_format($venda['valor_total'], 2, ',', '.').'</td>
                            </tr>
                        </table>
                        <br />
                        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
                          <thead>
                              <tr>
                                  <td width="35%">Produto</td>
                                  <td width="15%">Quantidade</td>
                                  <td width="25%">Valor</td>
                                  <td width="25%">Total</td>
                              </tr>
                          </thead>
                          <tbody>';

                          foreach ($itens as $key => $item) {
                            $html .= '<tr>
                                        <td align="center">'.$item['produto_nome'].'</td>
                                        <td align="center">'.$item['quantidade'].'</td>
                                        <td align="center">'.number_format($item['valor'], 2, ',', '.').'</td>
                                        <td align="center">'.number_format(($item['quantidade'] * $item['valor']), 2, ',', '.').'</td>
                                      </tr>';
                            }
                            $html .= '</tbody></table>';

                            if($pagamentos) {
                                $html .= '<br />
                                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
                                    <thead>
                                        <tr>
                                            <td width="50%">Data Vencimento</td>
                                            <td width="50%">Valor Prestacao</td>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                  foreach ($pagamentos as $key => $pagamento) {
                                    $html .= '<tr>
                                                <td align="center">'.$pagamento['data_pagamento'].'</td>
                                                <td align="center">'.number_format($pagamento['valor'], 2, ',', '.').'</td>
                                              </tr>';
                                    }
                              }
                              $html .= '</tbody></table>';

            $html .= '
                    </body>
                </html>';

          $pdfFilePath = "RelatorioVendas_".$id."_".hash('ripemd160', time()).".pdf";

          $this->m_pdf->pdf->SetHeader('SisCred|Relatorio de Vendas|{PAGENO}');
          $this->m_pdf->pdf->SetProtection(array('print'));
          $this->m_pdf->pdf->SetTitle("SisCred");
          $this->m_pdf->pdf->SetAuthor("Carlos Vargas");
          $this->m_pdf->pdf->SetDisplayMode('fullpage');
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($pdfFilePath, "D");

      } else {
          $this->session->set_flashdata('success_msg', "Falha ao Gerar Relatorio de Vendas.");
          redirect('clientes', 'location', 303);
      }
    }

    function getHtml(){

    }
}
