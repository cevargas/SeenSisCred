<div class="row align-top">
    <div class="col s6"><h5>Cadastro de Vendas</h5></div>
    <div class="col s6 right-align"><a href="<?php echo base_url()?>vendas/novo" class="waves-effect waves-light btn">Novo</a></div>
</div>

<div class="row">
    <div class="col s12">
        <table class="highlight responsive-table">
            <thead>
                <tr>
                    <th data-field="cliente">Cliente</th>
                    <th data-field="data">Data Compra</th>
                    <th data-field="total">Total</th>
                    <th data-field="opcoes">Opções</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if (isset($vendas)) :                    
                  
                    foreach ($vendas as $venda) :
                        ?>
                        <tr>
                            <td><?php echo $venda['nome_cliente'].' '.$venda['sobrenome_cliente']; ?></td>
                            <td><?php echo $venda['data_compra']; ?></td>
                            <td align="right">R$ <?php echo number_format($venda['valor_total'], 2, ',', '.'); ?></td>
                            <td>
                                <a href="<?php echo base_url()?>vendas/edit/<?php echo $venda['id_venda']?>">Editar</a> |
                                <a href="<?php echo base_url()?>vendas/relatorio/<?php echo $venda['id_venda']?>">Relatório</a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                <?php endif ?>

                <?php
                if (count($vendas) == 0):
                ?>                 
                    <tr>
                        <td colspan="4">Nenhuma informação para exibir.</td>
                    </tr>      
                <?php endif; ?>                

            </tbody>
        </table>
    </div>
</div>