/*
 * Modulo js da aplicacao
 * Inicializa componentes do Materialize
 */
var APP = function () {

    var dropdown = function () {
        $(".dropdown").dropdown();
    };

    var sideNav = function () {
        $('.button-collapse').sideNav({
            menuWidth: 300,
            edge: 'left',
            closeOnClick: true,
            draggable: true
        });
    };

    var select = function () {
        $('select').material_select();
    };

    var datepicker = function () {
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            format: 'dd/mm/yyyy',
            monthsFull: ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'],
            monthsShort: ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'],
            weekdaysFull: ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'],
            weekdaysShort: ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'],
            today: 'hoje',
            clear: 'limpar',
            close: 'fechar',
            formatSubmit: 'yyyy-mm-dd'
        });
    };

    var tabs = function () {
        $('ul.tabs').tabs('select_tab', 'tab_id');
    };

    var defaultValidator = function() {
        
        $.validator.setDefaults({
            debug: false, 
            errorElement: 'div',
            errorClass: 'error',
            focusInvalid: false,
            ignore: "",
            errorPlacement: function (error, element) {
                error.insertAfter(element).css({
                    position: 'relative',
                    top: '-1rem',
                    left: '0rem',
                    "font-size": '0.8rem',
                    color: '#FF4081',
                    "-webkit-transform": 'translateY(0%)',
                    "-ms-transform": 'translateY(0%)',
                    "-o-transform": 'translateY(0%)',
                    "transform": 'translateY(0%)'
                });
            }
        });
    };

    var formValidateClientes = function () {
        $("#form-clientes").validate({         
            rules: {
                nome: {
                    required: true,
                    minlength: 5
                },
                sobrenome: {
                    required: true,
                    minlength: 5                    
                },
                email: {
                    required: true,
                    minlength: 5,
                    email: true
                },
                cpf: {
                    required: true,
                    minlength: 11,
                    maxlength: 11,
                    number: true
                },
                datanascimento: {
                    required: true
                },
                endereco: {
                    required: true
                },
                telefone: {
                    required: true
                },
                cidade: {
                    required: true
                }                
            },
            messages: {
                nome: {
                    required: "Campo obrigatório",
                    minlength: "Deve ter no mínimo 5 caracteres"
                },
                sobrenome: {
                    required: "Campo obrigatório",
                    minlength: "Deve ter no mínimo 5 caracteres"               
                },
                email: {
                    required: "Campo obrigatório",
                    minlength: "Deve ter no mínimo 5 caracteres",
                    email: "Informe um email válido"
                },
                cpf: {
                    required: "Campo obrigatório",
                    minlength: "Deve ter no mínimo 11 caracteres",
                    maxlength: "Deve ter no máximo 11 caracteres",
                    number: "Apenas números"
                },
                datanascimento: {
                    required: "Campo obrigatório",
                },
                endereco: {
                    required: "Campo obrigatório",
                },
                telefone: {
                    required: "Campo obrigatório",
                },
                cidade: {
                    required: "Campo obrigatório"
                }  
            }     
        });
    };
    
    var formatter = function() {
        $('.telefone').formatter({
            'pattern': '({{99}}) {{9999}}-{{9999}}',
            'persistent': false
        });
        
        $('.money').maskMoney();
    };
    
    var processTab = function(){      
        $(".nexttab").on("click", function(){
            var href = $(".tabs").children('li').find("a.active").removeClass('active').parent('li').next().children('a').attr('href');
            var text = href.replace("#", "");        
            $('ul.tabs').tabs('select_tab', text);
        });
    };

    return {
        dropdown: dropdown,
        sideNav: sideNav,
        select: select,
        datepicker: datepicker,
        tabs: tabs,
        defaultValidator: defaultValidator,
        formValidateClientes: formValidateClientes,
        formatter: formatter,
        processTab: processTab
    };
}($);