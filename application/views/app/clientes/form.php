<div class="row align-top">
    <div class="col s8"><h5>Cadastro de Clientes</h5></div>
</div>

<div class="row">
    <?php
    echo form_open(base_url('clientes/salvar'), array('id' => 'form-clientes', 'method' => 'post',
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
            <ul class="tabs blue lighten-1">
                <li class="tab col s2"><a class="active white-text" href="#clientes">Clientes</a></li>
                <li class="tab col s2"><a class="white-text" href="#referencias">Referências</a></li>
                <li class="tab col s2"><a class="white-text" href="#outros">Outros</a></li>
            </ul>
        </div>
 
        <div id="clientes" class="col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input id="nome" name="nome" type="text" value="<?php echo (isset($cliente)) ? $cliente['nome'] : set_value('nome');?>">
                    <label for="nome">Nome</label>
                </div>
                <div class="input-field col s6">
                    <input id="sobrenome" name="sobrenome" type="text" value="<?php echo (isset($cliente)) ? $cliente['sobrenome'] : set_value('sobrenome');?>">
                    <label for="sobrenome">Sobrenome</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="cpf" name="cpf" type="text" maxlength="11" value="<?php echo (isset($cliente)) ? $cliente['cpf'] : set_value('cpf');?>">
                    <label for="cpf">CPF</label>
                </div>
                <div class="input-field col s6">
                    <input type="date" name="datanascimento" class="datepicker" value="<?php echo (isset($cliente)) ? $cliente['data_nascimento'] : set_value('datanascimento');?>">
                    <label for="datanascimento">Data Nascimento</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="endereco" name="endereco" type="text" value="<?php echo (isset($cliente)) ? $cliente['endereco'] : set_value('endereco');?>">
                    <label for="endereco">Endereco</label>
                </div>

                <div class="input-field col s6">
                    <input class="telefone" id="telefone" name="telefone" type="text" value="<?php echo (isset($cliente)) ? $cliente['telefone'] : set_value('telefone');?>">
                    <label for="telefone">Telefone</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="cidade" name="cidade" type="text" value="<?php echo (isset($cliente)) ? $cliente['cidade'] : set_value('cidade');?>">
                    <label for="cidade">Cidade</label>
                </div>

                <div class="input-field col s6">      
                    <select name="estado">
                        <option value="1" <?php if(isset($cliente) && $cliente['estado'] == 1) { echo 'selected'; }?>>RS</option>
                        <option value="2" <?php if(isset($cliente) && $cliente['estado'] == 2) { echo 'selected'; }?>>SC</option>
                        <option value="3" <?php if(isset($cliente) && $cliente['estado'] == 3) { echo 'selected'; }?>>PR</option>
                    </select>
                    <label>Estado</label>          
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" value="<?php echo (isset($cliente)) ? $cliente['email'] : set_value('email');?>">
                    <label for="email">Email</label>
                </div>
            </div>
            
            <div class="col s2 right-align">
                <a href="#" class="nexttab light-blue darken-1 waves-effect waves-light btn">Próximo</a>
            </div>
        </div>

        <div id="referencias" class="col s12">
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeref1" name="nomeref[]" type="text" value="<?php echo (isset($cliente_ref[0])) ? $cliente_ref[0]['nome'] : '';?>">
                    <label for="nomeref1">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeref1" name="sobrenomeref[]" type="text" value="<?php echo (isset($cliente_ref[0])) ? $cliente_ref[0]['sobrenome'] : '';?>">
                    <label for="sobrenomeref1">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneref1" name="telefoneref[]" type="text" value="<?php echo (isset($cliente_ref[0])) ? $cliente_ref[0]['telefone'] : '';?>">
                    <label for="telefoneref1">Telefone</label>
                </div>
                <div class="input-field col s3">                     
                    <input name="tiporeferencia[1]" type="radio" id="ref1banc" value="1"
                        <?php echo (isset($cliente_ref[0])) ? ($cliente_ref[0]['tipo_referencia'] == 1) ? 'checked' : '' : 'checked';?> />
                    <label for="ref1banc">Bancária</label>
                    <input name="tiporeferencia[1]" type="radio" id="ref1com" value="2"  
                        <?php echo (isset($cliente_ref[0])) ? ($cliente_ref[0]['tipo_referencia'] == 2) ? 'checked' : '' : '';?> />
                    <label for="ref1com">Comercial</label>                     
                </div>     
                <input id="idref1" name="idref[]" type="hidden" value="<?php echo (isset($cliente_ref[0])) ? $cliente_ref[0]['id'] : null;?>">
            </div>
            
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeref2" name="nomeref[]" type="text" value="<?php echo (isset($cliente_ref[1])) ? $cliente_ref[1]['nome'] : '';?>">
                    <label for="nomeref2">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeref2" name="sobrenomeref[]" type="text" value="<?php echo (isset($cliente_ref[1])) ? $cliente_ref[1]['sobrenome'] : '';?>">
                    <label for="sobrenomeref2">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneref2" name="telefoneref[]" type="text" value="<?php echo (isset($cliente_ref[1])) ? $cliente_ref[1]['telefone'] : '';?>">
                    <label for="telefoneref2">Telefone</label>
                </div>
                <div class="input-field col s3">                     
                    <input name="tiporeferencia[2]" type="radio" id="ref2banc" value="1"
                        <?php echo (isset($cliente_ref[1])) ? ($cliente_ref[1]['tipo_referencia'] == 1) ? 'checked' : '' : 'checked';?> />
                    <label for="ref2banc">Bancária</label>
                    <input name="tiporeferencia[2]" type="radio" id="ref2com" value="2"  
                        <?php echo (isset($cliente_ref[1])) ? ($cliente_ref[1]['tipo_referencia'] == 2) ? 'checked' : '' : '';?> />
                    <label for="ref2com">Comercial</label>                     
                </div>     
                <input id="idref2" name="idref[]" type="hidden" value="<?php echo (isset($cliente_ref[1])) ? $cliente_ref[1]['id'] : null;?>">
            </div>
            
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeref3" name="nomeref[]" type="text" value="<?php echo (isset($cliente_ref[2])) ? $cliente_ref[2]['nome'] : '';?>">
                    <label for="nomeref3">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeref3" name="sobrenomeref[]" type="text" value="<?php echo (isset($cliente_ref[2])) ? $cliente_ref[2]['sobrenome'] : '';?>">
                    <label for="sobrenomeref3">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneref3" name="telefoneref[]" type="text" value="<?php echo (isset($cliente_ref[2])) ? $cliente_ref[2]['telefone'] : '';?>">
                    <label for="telefoneref3">Telefone</label>
                </div>
                <div class="input-field col s3">                     
                    <input name="tiporeferencia[3]" type="radio" id="ref3banc" value="1"
                        <?php echo (isset($cliente_ref[2])) ? ($cliente_ref[2]['tipo_referencia'] == 1) ? 'checked' : '' : 'checked';?> />
                    <label for="ref3banc">Bancária</label>
                    <input name="tiporeferencia[3]" type="radio" id="ref3com" value="2"  
                        <?php echo (isset($cliente_ref[2])) ? ($cliente_ref[2]['tipo_referencia'] == 2) ? 'checked' : '' : '';?> />
                    <label for="ref3com">Comercial</label>                     
                </div>     
                <input id="idref3" name="idref[]" type="hidden" value="<?php echo (isset($cliente_ref[2])) ? $cliente_ref[2]['id'] : null;?>">
            </div>
            
            <div class="col s2 right-align">
                <a href="#" class="nexttab light-blue darken-1 waves-effect waves-light btn">Próximo</a>
            </div>
        </div>
        
        <div id="outros" class="col s12">
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeout1" name="nomeout[]" type="text" value="<?php echo (isset($cliente_out[0])) ? $cliente_out[0]['nome'] : '';?>">
                    <label for="nomeout1">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeout1" name="sobrenomeout[]" type="text" value="<?php echo (isset($cliente_out[0])) ? $cliente_out[0]['sobrenome'] : '';?>">
                    <label for="sobrenomeout1">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneout1" name="telefoneout[]" type="text" value="<?php echo (isset($cliente_out[0])) ? $cliente_out[0]['telefone'] : '';?>">
                    <label for="telefoneout1">Telefone</label>
                </div>
                <div class="input-field col s3">
                    <input data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," class="money" id="limiteout1" name="limiteout[]" type="text" value="<?php echo (isset($cliente_out[0])) ? $cliente_out[0]['limite_credito'] : '';?>">
                    <label for="limiteout1">Limite (R$)</label>
                </div>
                <input id="idoutf1" name="idout[]" type="hidden" value="<?php echo (isset($cliente_out[0])) ? $cliente_out[0]['id'] : null;?>">
            </div>
            
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeout2" name="nomeout[]" type="text" value="<?php echo (isset($cliente_out[1])) ? $cliente_out[1]['nome'] : '';?>">
                    <label for="nomeout2">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeout2" name="sobrenomeout[]" type="text" value="<?php echo (isset($cliente_out[1])) ? $cliente_out[1]['sobrenome'] : '';?>">
                    <label for="sobrenomeout2">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneout2" name="telefoneout[]" type="text" value="<?php echo (isset($cliente_out[1])) ? $cliente_out[1]['telefone'] : '';?>">
                    <label for="telefoneout2">Telefone</label>
                </div>
                <div class="input-field col s3">
                    <input class="money" id="limiteout2" name="limiteout[]" type="text" value="<?php echo (isset($cliente_out[1])) ? $cliente_out[1]['limite_credito'] : '';?>">
                    <label for="limiteout2">Limite (R$)</label>
                </div>
                <input id="idoutf2" name="idout[]" type="hidden" value="<?php echo (isset($cliente_out[1])) ? $cliente_out[1]['id'] : null;?>">
            </div>
            
            <div class="row">
                <div class="input-field col s3">
                    <input id="nomeout3" name="nomeout[]" type="text" value="<?php echo (isset($cliente_out[2])) ? $cliente_out[2]['nome'] : '';?>">
                    <label for="nomeout3">Nome</label>
                </div>
                <div class="input-field col s3">
                    <input id="sobrenomeout3" name="sobrenomeout[]" type="text" value="<?php echo (isset($cliente_out[2])) ? $cliente_out[2]['sobrenome'] : '';?>">
                    <label for="sobrenomeout3">Sobrenome</label>
                </div>
                <div class="input-field col s3">
                    <input class="telefone" id="telefoneout3" name="telefoneout[]" type="text" value="<?php echo (isset($cliente_out[2])) ? $cliente_out[2]['telefone'] : '';?>">
                    <label for="telefoneout3">Telefone</label>
                </div>
                <div class="input-field col s3">
                    <input class="money" id="limiteout3" name="limiteout[]" type="text" value="<?php echo (isset($cliente_out[2])) ? $cliente_out[2]['limite_credito'] : '';?>">
                    <label for="limiteout3">Limite (R$)</label>
                </div>
                <input id="idoutf3" name="idout[]" type="hidden" value="<?php echo (isset($cliente_out[2])) ? $cliente_out[2]['id'] : null;?>">
            </div>
            
            <div class="col s2 right-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">Salvar
                    <i class="material-icons right">send</i>
                </button>
            </div>
            <div class="col s2 right-align">
                <a href="<?php echo base_url() ?>clientes" class="red lighten-1 waves-effect waves-light btn">Cancelar</a>
            </div>
        </div>
  
    </div>

    <input id="id" name="id" type="hidden" value="<?php echo (isset($cliente)) ? $cliente['id'] : null;?>">
    <?php
        echo form_close();
    ?> 
</div> 