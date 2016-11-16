<div class="row align-top">
    <div class="col s8"><h5>Cadastro de Vendas</h5></div>
</div>

<div class="row">
    <?php
    echo form_open(base_url('vendas/salvar'), array('id' => 'form-vendas', 'method' => 'post',
        'class' => 'form-horizontal', 'role' => 'form',
        'autocomplete' => 'off'));
    ?>

    <?php
    if (strlen(validation_errors()) > 0):
        ?>
        <div class="red-text">	
            <?php echo validation_errors(); ?>
        </div>
        <?php
    endif;
    ?>

    <div class="row">
        <div class="col s12">
            <div class="input-field col s8">
                <select id="clientes">
                    <?php
                    foreach ($clientes as $cliente) :
                        ?>
                        <option value="<?php echo $cliente['id'] ?>"><?php echo $cliente['nome'] . ' ' . $cliente['sobrenome'] ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <label>Clientes</label>
            </div>
            <div class="input-field col s4">
                <input type="date" name="data_compra" class="datepicker" value="<?php echo set_value('data_compra'); ?>">
                <label for="data_compra">Data Compra</label>     
            </div>
        </div>

        <div data-linha="1" class="col s12 linhaadd">
            <div class="input-field col s4">
                <select name="produtos[]" id="produtos1" class="produtos">
                    <option value="">Selecione</option>
                    <?php
                    foreach ($produtos as $produto) :
                        ?>
                        <option value="<?php echo $produto['id'] ?>"><?php echo $produto['nome'] ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <label>Produtos</label>
            </div>
            <div class="input-field col s2">
                <input class="qtdchange" id="quantidade1" name="quantidade[]" type="text" value="">
                <label for="quantidade1">Quantidade</label>
            </div>
            <div class="input-field col s2">
                <input id="valor1" name="valor[]" type="text" value="" readonly="" >
                <label for="valor1">Valor</label>
            </div>
            <div class="input-field col s2">
                <input id="total1" class="totalitem" name="total[]" type="text" value="" readonly="" >
                <label for="total1">Total</label>
            </div>
            <div class="input-field col s2">
                <a href="javascript:;" class="addLinha"><i class="material-icons">add</i></a>
                
                <label for=""></label>
            </div>
        </div>

        <div class="col s12 card-panel blue-grey lighten-5">
            <div class="col s8 text-darken-2 blue-text right-align padding-valor-total">
                <h5>Total Geral</h5>
            </div>
            <div class="input-field col s4">
                <input id="totalgeral" name="totalgeral" type="text" value="" readonly="" >
                <label for="totalgeral">Total Geral</label>
            </div>
        </div>   

        <div class="col s12 ">  
            <div class="input-field col s6">                
                Forma Pagamento<br>
                <input name="formapagto" type="radio" id="formpagto1" value="1" checked="" />
                <label for="formpagto1">À Vista</label>
                <input name="formapagto" type="radio" id="formpagto2" value="2" />                
                <label for="formpagto2">À Prazo</label>
            </div>
            <div class="input-field col s2">
                <input id="prestacoes" name="prestacoes" type="text" value="" disabled>
                <label for="prestacoes">Prestações</label>
            </div>
            <div class="input-field col s2">
                <input id="diapagto" name="diapagto" type="text" value="" disabled>
                <label for="diapagto">Dia pagamento</label>
            </div>
            <div class="input-field col s2">
                <a href="javascript:;" id="btnCalcula" class=" purple accent-2 waves-effect waves-light btn" disabled>Calcular</a>
            </div>     
        </div> 

        <div class="col s12 hide">  
            <table class="highlight responsive-table">
                <thead>
                    <tr>
                        <th data-field="data">Data Pagamento</th>
                        <th data-field="valor">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>                    
                </tbody>
            </table>
        </div>

        <input id="id" name="id" type="hidden" value="<?php echo (isset($venda)) ? $venda['id'] : null; ?>">
    </div>

    <div class="row">
        <div class="col s2 right-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Salvar
                <i class="material-icons right">send</i>
            </button>
        </div>
        <div class="col s2 right-align">
            <a href="<?php echo base_url() ?>clientes" class="red lighten-1 waves-effect waves-light btn">Cancelar</a>
        </div>
    </div>

    <?php
    echo form_close();
    ?> 

</div> 