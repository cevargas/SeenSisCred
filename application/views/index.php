<!DOCTYPE html>
<html>
    <head>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>public/materialize/css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>public/app.css" media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>SisCred</title>
    </head>
    <body>

        <ul id="dropdown1" class="dropdown-content">
            <li><a href="#!">Editar Perfil</a></li>
            <li><a href="#!">Sair</a></li>           
        </ul>
        <nav class=" indigo darken-1"> 
            <div class="nav-wrapper ">
                <a href="#!" class="brand-logo">SisCred</a>
                <ul class=" lighten-3 right hide-on-med-and-down">
                    <li class="<?php if($url == 'home' or !isset($url)) { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>">Inicio</a>
                    </li>
                    <li class="<?php if($url == 'clientes') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>clientes">Clientes</a>
                    </li>
                    <li class="<?php if($url == 'vendas') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>vendas">Vendas</a>
                    </li>                    
                    <li>
                        <a class="dropdown-button" href="#!" data-activates="dropdown1">Usuário<i class="material-icons right">arrow_drop_down</i></a>
                    </li>
                </ul>

                <ul id="slide-out" class="side-nav">
                    <li>
                        <div class="userView">
                            <div class="background">
                                <img src="<?php echo base_url() ?>public/images/office.jpg">
                            </div>
                            <a href="#!user"><img class="circle" src="<?php echo base_url() ?>public/images/carlos.jpg"></a>
                            <a href="#!name"><span class="white-text name">Carlos Eduardo</span></a>
                            <a href="#!email"><span class="white-text email">kduvargas@gmail.com</span></a>
                        </div>
                    </li>
                    <li class="<?php if($url == 'home' or !isset($url)) { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>">Inicio</a>
                    </li>
                    <li class="<?php if($url == 'clientes') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>clientes">Clientes</a>
                    </li>
                    <li class="<?php if($url == 'vendas') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>vendas">Vendas</a>
                    </li>                 
                </ul>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>    

        <main>
            <div class="container">
                 <?php $this->load->view($view);?>
            </div>
        </main>
                
        <footer class="indigo accent-2 page-footer">           
            <div class="footer-copyright">
                <div class="container">
                    SisCred © 2016 Copyright 
                </div>
            </div>
        </footer>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/formatter/jquery.formatter.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>public/app.js"></script>
        <script>
            $(document).ready(function(){
                APP.dropdown();
                APP.sideNav();
                APP.select();
                APP.datepicker();
                APP.tabs();
                APP.defaultValidator();
                APP.formValidateClientes();
                APP.formatter();
                APP.processTab();
                
                <?php 
                    if($this->session->flashdata('success_msg') != NULL) :
                ?>
                    Materialize.toast('<?php echo $this->session->flashdata('success_msg');?>', 4000);		
                <?php 
                    endif; 
                    $this->session->set_flashdata('success_msg', NULL);
                ?>
                        
                $('.money').maskMoney('mask');
            }); 
        </script>
        
        
    </body>
</html>