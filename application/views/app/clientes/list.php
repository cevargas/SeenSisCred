<div class="row align-top">
    <div class="col s6"><h5>Cadastro de Clientes</h5></div>
    <div class="col s6 right-align"><a href="<?php echo base_url()?>clientes/novo" class="waves-effect waves-light btn">Novo</a></div>
</div>

<div class="row">
    <div class="col s12">
        <table class="highlight responsive-table">
            <thead>
                <tr>
                    <th data-field="nome">Nome</th>
                    <th data-field="telefone">Telefone</th>
                    <th data-field="email">Email</th>
                    <th data-field="opcoes">Opções</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if (isset($clientes)) :                    
                  
                    foreach ($clientes as $cliente) :
                        ?>
                        <tr>
                            <td><?php echo $cliente['nome'] . ' ' . $cliente['sobrenome']; ?></td>
                            <td><?php echo $cliente['telefone']; ?></td>
                            <td><?php echo $cliente['email']; ?></td>
                            <td>
                                <a href="<?php echo base_url()?>clientes/edit/<?php echo $cliente['id']?>">Editar</a> |
                                <a href="<?php echo base_url()?>clientes/delete/<?php echo $cliente['id']?>">Excluir</a>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                <?php endif ?>

                <?php
                if (count($clientes) == 0):
                ?>                 
                    <tr>
                        <td colspan="4">Nenhuma informação para exibir.</td>
                    </tr>      
                <?php endif; ?>                

            </tbody>
        </table>
    </div>
</div>