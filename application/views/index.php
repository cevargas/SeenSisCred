<!DOCTYPE html>
<html>
    <head>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>public/materialize/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>public/app.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                    <li class="<?php if($url == 'funcionarios') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>funcionarios">Funcionários</a>
                    </li>
                    <li class="<?php if($url == 'vendas') { echo 'active'; }?>">
                        <a href="<?php echo base_url()?>vendas">Vendas</a>
                    </li>                    
                    <li>
                        <a class="dropdown-button" href="#!" data-activates="dropdown1">Usuário<i class="material-icons right">arrow_drop_down</i></a>
                    </li>
                </ul>
            </div>
        </nav>

        <main>
            <div class="container">
                 <?php $this->load->view($view);?>    
            </div>
        </main>
                
        <footer class="indigo accent-2 page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">SisCred</h5>
                        <p class="grey-text text-lighten-4">Sistema de Crediário</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Menu</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#!">Inicio</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Clientes</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Funcionários</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Vendas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2016 Copyright 
                </div>
            </div>
        </footer>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/materialize/js/materialize.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>public/app.js"></script>
        <script>
            $(document).ready(function(){
                APP.dropdown();
            });
        </script>

    </body>
</html>