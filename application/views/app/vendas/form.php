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
                <select id="clientes" name="clientes">
                    <?php
                    foreach ($clientes as $cliente) :
					
						$selected = '';
						if(isset($venda)) {
							if($venda['id_cliente'] == $cliente['id']) {
								$selected = 'selected';
							}
						}					
                        ?>
                        <option value="<?php echo $cliente['id'] ?>" <?php echo $selected;?>><?php echo $cliente['nome'] . ' ' . $cliente['sobrenome']?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <label>Clientes</label>
            </div>
            <div class="input-field col s4">
                <input type="date" name="data_compra" class="datepicker" value="<?php if(isset($venda)) echo $venda['data_compra']; else echo date('d/m/Y');?>">
                <label for="data_compra">Data Compra</label>     
            </div>
        </div>
        
        <?php		
			//editando	
			if(isset($itens)) : 
		
				$total = 0;
				foreach($itens as $k => $item) :
					$k = $k + 1;					
					$total += ($item['valor'] * $item['quantidade']);
				?> 
                	<div data-linha="<?php echo $k;?>" class="col s12 linhaadd">
                    
                        <div class="input-field col s4">
                            <select name="produtos[]" id="produtos<?php echo $k;?>" class="produtos">
                                <option value="">Selecione</option>
                                <?php
                                foreach ($produtos as $produto) :							
                                    $selected = '';
                                    if(isset($item)) {
                                        if($item['id_produto'] == $produto['id']) {
                                            $selected = 'selected';
                                        }
                                    }							
                                    ?>
                                    <option value="<?php echo $produto['id']?>" <?php echo $selected;?>><?php echo $produto['nome'] ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <label>Produtos</label>
                        </div> 
                        
                        <div class="input-field col s2">
                            <input class="qtdchange" id="quantidade<?php echo $k;?>" name="quantidade[]" type="text" value="<?php echo $item['quantidade']?>">
                            <label for="quantidade<?php echo $k;?>">Quantidade</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="valor<?php echo $k;?>" name="valor[]" type="text" value="<?php echo $item['valor']?>" readonly="" >
                            <label for="valor<?php echo $k;?>">Valor</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="total<?php echo $k;?>" class="totalitem" name="total[]" type="text" value="<?php echo ($item['valor'] * $item['quantidade']);?>" readonly="" >
                            <label for="total<?php echo $k;?>">Total</label>
                        </div>
                        <div class="input-field col s2">
                            <a href="javascript:;" class="addLinha"><i class="material-icons">add</i></a>       
                            
                            <?php 
								if($k > 1) :								
									echo '<a href="javascript:;" class="removeLinha"><i class="material-icons">delete</i></a>';
								endif;
							?>
                                     
                            <label for=""></label>
                        </div>            
                    </div>	
                   	
                <?php
				endforeach;	
				?>				 
                    <div class="col s12 card-panel blue-grey lighten-5">
                        <div class="col s8 text-darken-2 blue-text right-align padding-valor-total">
                            <h5>Total Geral</h5>
                        </div>
                        <div class="input-field col s4">
                            <input id="totalgeral" name="totalgeral" type="text" value="<?php echo $total;?>" readonly="" >
                            <label for="totalgeral">Total Geral</label>
                        </div>
                    </div>   	
				<?		
			endif;			
		?>
        
        <?php	
			//novo registro		
			if(!isset($itens)) : 
		?>
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
        <?php endif;?>


        <div class="col s12 ">  
            <div class="input-field col s6">                
                Forma Pagamento<br>
                <input name="formapagto" type="radio" id="formpagto1" value="1" <?php if(isset($venda) && $venda['forma_pagamento'] == 1) echo 'checked'; if(!isset($venda)) echo 'checked';?>/>
                <label for="formpagto1">À Vista</label>
                <input name="formapagto" type="radio" id="formpagto2" value="2" <?php if(isset($venda) && $venda['forma_pagamento'] == 2) echo 'checked';?> />                
                <label for="formpagto2">À Prazo</label>
            </div>
            <div class="input-field col s2">
                <input id="prestacoes" name="prestacoes" type="text" value="<?php if(isset($venda)) echo $venda['prestacoes'];?>" <?php if(!isset($venda)) echo 'disabled'?>>
                <label for="prestacoes">Prestações</label>
            </div>
            <div class="input-field col s2">
                <input id="diapagto" name="diapagto" type="text" value="<?php if(isset($venda)) echo $venda['diapagto'];?>" <?php if(!isset($venda)) echo 'disabled'?>>
                <label for="diapagto">Dia pagamento</label>
            </div>
            <div class="input-field col s2">
                <a href="javascript:;" id="btnCalcula" class=" purple accent-2 waves-effect waves-light btn" <?php if(!isset($itens)) echo 'disabled';?>>Calcular</a>
            </div>     
        </div> 

        <div id="table-prestacoes" class="col s12 <?php if(!isset($pagamentos)) echo 'hide';?>">  
            <table class="highlight responsive-table">
                <thead>
                    <tr>
                        <th data-field="data">Data Pagamento</th>
                        <th data-field="valor">Valor</th>
                    </tr>
                </thead>
                <tbody id="tbody-prestacoes">
                
                	<?php
						if(isset($pagamentos)) :
							foreach($pagamentos as $pagamento) :
								echo '<tr>';
								echo '<td>' . $pagamento['data_pagamento'] . '</td>';
								echo '<td>' . $pagamento['valor'] . '</td>';
								echo '</tr>';
							endforeach;						
						endif;
					?>       
                </tbody>
            </table>
        </div>

        <input id="id" name="id" type="hidden" value="<?php echo (isset($venda)) ? $venda['id_venda'] : null; ?>">
    </div>

    <div class="row">
        <div class="col s2 right-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Salvar
                <i class="material-icons right">send</i>
            </button>
        </div>
        <div class="col s2 right-align">
            <a href="<?php echo base_url() ?>vendas" class="red lighten-1 waves-effect waves-light btn">Cancelar</a>
        </div>
    </div>

    <?php
    	echo form_close();
    ?> 
</div> 