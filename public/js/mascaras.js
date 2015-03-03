$(document).ready(function($){
    $(".telefone").mask("(99) 9999-9999");
    $("#cep").mask("99999-999");
    $("#cpf").mask("999.999.999-99");
    $('input[id*=data_]').mask("99/99/9999");
    $('input[id*=hora_]').mask("99:99");
    
    $("#Submit input").click(function() {
        $(".telefone").mask("9999999999");
        $("#cep").mask("99999999");
        $("#cpf").mask("99999999999");
        return true;
    });
});
