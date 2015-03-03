/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function verificaData(){
    var dataSaida = document.forms["entrevista"]["dataSaida"].value;
    var horaSaida = document.forms["entrevista"]["horaSaida"].value;
    
    var dataVolta = document.forms["entrevista"]["dataVolta"].value;
    var horaVolta = document.forms["entrevista"]["horaVolta"].value;
    
    var resultado;
    
    if(dataSaida > dataVolta){
        alert("A data de Saída não pode ser maior que a data de Volta!!");
        resultado = false;
    }
    else if(dataSaida === dataVolta){
        if(horaSaida >= horaVolta){
            alert("A hora de Saída não pode ser maior que a hora de Volta!!");
            resultado = false;
        }
    }
    else{
        resultado = true;
    }
    return resultado;
    
    
}

function verificaDataEmalhe(){
    var dataSaida = document.forms["entrevista"]["dataLancamento"].value;
    var horaSaida = document.forms["entrevista"]["horaLancamento"].value;
    
    var dataVolta = document.forms["entrevista"]["dataRecolhimento"].value;
    var horaVolta = document.forms["entrevista"]["horaRecolhimento"].value;
    
    var resultado;
    
    if(dataSaida > dataVolta){
        alert("A data de Saída não pode ser maior que a data de Volta!!");
        resultado = false;
    }
    else if(dataSaida === dataVolta){
        if(horaSaida >= horaVolta){
            alert("A hora de Saída não pode ser maior que a hora de Volta!!");
            resultado = false;
        }
    }
    else{
        resultado = true;
    }
    return resultado;
    
    
}