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

    var defaultValidator = function () {

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

    var formatter = function () {
        $('.telefone').formatter({
            'pattern': '({{99}}) {{9999}}-{{9999}}',
            'persistent': false
        });

        $('.money').maskMoney();
    };

    var processTab = function () {
        $(".nexttab").on("click", function () {
            var href = $(".tabs").children('li').find("a.active").removeClass('active').parent('li').next().children('a').attr('href');
            var text = href.replace("#", "");
            $('ul.tabs').tabs('select_tab', text);
        });
    };

    var processVendas = function () {

        $(document.body).off('change', ".produtos").on('change', ".produtos", function(){

            var idLinha = $(this).closest('div').parent('div').parent('div').data('linha');   
            
            $("#valor"+idLinha).val('');
            $("#quantidade"+idLinha).val('');
            $("#total"+idLinha).val('');
            //$("#totalgeral").val('');
            
            if($(this).val()) {             
                var id = $(this).val();  
                $.ajax({
                    type: "POST",
                    url: '../produtos/getProduto',
                    data: {id: id},
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        $("#valor"+idLinha).val(data.valor);
                        Materialize.updateTextFields();         
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        Materialize.toast('Ocorreu um problema :S', 4000);		
                    }
                });
            }
        });

        $(document.body).off('change', ".qtdchange").on('change', ".qtdchange", function(){
      
            var idLinha = $(this).closest('div').parent('div').data('linha'); 
            
            if($(this).val()) {                      
                var totalLinha = Number($(this).val());
                var valorLinha = Number($("#valor"+idLinha).val());
                var calc = parseFloat(totalLinha * valorLinha);
         
                $("#total"+idLinha).val(calc.toFixed(2));

                var elementsLinha = $(document.body).find("[data-linha]");
                var totalGeral = 0;
                $(elementsLinha).find(".totalitem").each(function(){
                    totalGeral += parseFloat($(this).val());
                });

                $("#totalgeral").val(totalGeral.toFixed(2));
            }
            else {
                $("#total"+idLinha).val('');
                $("#totalgeral").val('');
            }
 
            Materialize.updateTextFields();            
        });
    };
    
    var addLinhaProduto = function(){
        
        $(document.body).off('click', ".addLinha").on('click', ".addLinha", function(){
            
            var idLinha = $(this).closest('div').parent('div').data('linha'); 
            var btnRemove = null;
            if(idLinha === 1) {
                btnRemove = '<a href="javascript:;" class="removeLinha"><i class="material-icons">delete</i></a>';
            }            
            
            //destroi o select do material
            $('select').material_select('destroy');
            
            var element = $(this).closest('div').parent('div').last();            
            //var totalLinha = $(document.body).find("div.linhaadd").length;            
            var elementsLinha = $(document.body).find("[data-linha]").last();
            
            var elementsLinhaCount = $(document.body).find("[data-linha]");            
            var totalLinha = 0;
            $(elementsLinhaCount).each(function(k, v){
                k = k + 1;
                totalLinha = k;
            });
     
            $(element).clone().insertAfter(elementsLinha);
            var newElement = $(document.body).find("[data-linha]").last();
            var nextId = parseInt(totalLinha + 1);  

            $(newElement).attr('data-linha', nextId);
            $(newElement).find('.produtos').attr('id', 'produtos'+nextId);            
            $(newElement).find('#quantidade'+totalLinha).attr('id', 'quantidade'+nextId).val('');
            $(newElement).find('#valor'+totalLinha).attr('id', 'valor'+nextId).val('');
            $(newElement).find('#total'+totalLinha).attr('id', 'total'+nextId).val('');
            $(newElement).find('label[for="quantidade'+ totalLinha +'"]').attr('for', 'quantidade'+nextId);
            $(newElement).find('label[for="valor'+ totalLinha +'"]').attr('for', 'valor'+nextId);
            $(newElement).find('label[for="total'+ totalLinha +'"]').attr('for', 'total'+nextId);
            
            if(btnRemove) {
                $(newElement).find('.addLinha').after(btnRemove);       
            }

            //recria o select do material  
            $('select').material_select();
        });
    };
    
    var removeLinhaProduto = function(){
        $(document.body).off('click', ".removeLinha").on('click', ".removeLinha", function(){

            //remove linha 
            $(this).closest('div').parent('div').remove();
            
            //reset os ids
            var elementsLinha = $(document.body).find("[data-linha]");
            var totalGeral = 0;
            $(elementsLinha).each(function(k, v){  

                k = k + 1;//inicializa as linhas em 1   
                $(this).attr('data-linha', k);
                $(this).find('.produtos').attr('id', 'produtos'+k);

                $(this).find('input[name="quantidade[]"]').attr('id', 'quantidade'+k);
                $(this).find('input[name="valor[]"]').attr('id', 'valor'+k);
                $(this).find('input[name="total[]"]').attr('id', 'total'+k);

                $(this).find('input[name="quantidade[]"]').next().attr('for', 'quantidade'+k);
                $(this).find('input[name="valor[]"]').next().attr('for', 'valor'+k);
                $(this).find('input[name="total[]"]').next().attr('for', 'total'+k);
            });

            //recalcula total geral
            $(elementsLinha).find(".totalitem").each(function(){
                if($(this).val()) {
                    totalGeral += parseFloat($(this).val());
                }
            });      

            if(totalGeral) {
                //set total            
                $("#totalgeral").val(totalGeral.toFixed(2));
            } 
            
            Materialize.updateTextFields();
        });               
    };
    
    var vendaPrazo = function(){
        $("input[name='formapagto']").on("click", function(){            
            if($(this).val() === '2') {
                $("#btnCalcula").removeAttr('disabled');
                $("#prestacoes").removeAttr('disabled');
                $("#diapagto").removeAttr('disabled');
            }
            else {
                $("#btnCalcula").attr('disabled', true).val('');
                $("#prestacoes").attr('disabled', true).val('');
                $("#diapagto").attr('disabled', true).val('');
            }            
        });
    };
    
    var calcularPrestacoes = function(){
        $("#btnCalcula").on("click", function(){
            
            var totalGeral = $("#totalgeral").val();
            var prestacoes = $("#prestacoes").val();
            var diapagto = $("#diapagto").val();
                
            //se tiver valor total
            if(totalGeral && prestacoes && diapagto) {
                //aqui tem que calcular e gerar prestacoes na tabela
            }
            else {
                Materialize.toast('Nada para calcular', 4000);
            }            
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
        processTab: processTab,
        processVendas: processVendas,
        addLinhaProduto: addLinhaProduto,
        removeLinhaProduto: removeLinhaProduto,
        vendaPrazo: vendaPrazo,
        calcularPrestacoes: calcularPrestacoes
    };
}($);