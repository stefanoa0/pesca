$(document).ready(function() {
    //funções para menu-lateral
    if ($("fieldset").attr('id') === "Social") {
        $("#Social").show();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Dsbq").hide();
        $("#Filo").hide();
        $("#Entrevista").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "dadosSocial") {
        $("#Social").show();
        $("#dadosSocial").show();
        $("#dadosDesembarque").hide();
        $("#Filo").hide();
        $("#Dsbq").hide();
        $("#Entrevista").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "Desembarque") {
        $("#Dsbq").show();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#Entrevista").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "dadosDesembarque") {
        $("#Dsbq").show();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").show();
        $("#Filo").hide();
        $("#Social").hide();
        $("#Entrevista").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "Filogenia") {
        $("#Dsbq").show();
        $("#Filo").show();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Social").hide();
        $("#Entrevista").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "Entrevista"){
        $("#Dsbq").show();
        $("#Entrevista").show();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "Relatorio"){
        $("#Relatorio").show();
        $("#Dsbq").hide();
        $("#Entrevista").hide();
        $("#Filo").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Social").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "RelListas"){
        $("#Relatorio").show();
        $("#RelListas").show();
        $("#Dsbq").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Entrevista").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if ($("fieldset").attr('id') === "RelConsolidados"){
        $("#Dsbq").hide();
        $("#Entrevista").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Relatorio").show();
        $("#RelListas").hide();
        $("#RelConsolidados").show();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }
    else if($("fieldset").attr('id') === "Amostras"){
        $("#Entrevista").hide();
        $("#Dsbq").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").show();
        $("#Especialista").hide();
    }
    else if($("fieldset").attr('id') === "Especialista"){
        $("#Entrevista").hide();
        $("#Dsbq").hide();
        $("#Filo").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Social").show();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").show();
        $("#dadosEmbarcacao").hide();
    }
    else if($("fieldset").attr('id') === "dadosEmbarcacao"){
        $("#Entrevista").hide();
        $("#Dsbq").show();
        $("#Filo").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Social").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").show();
    }
    else {
        $("#Entrevista").hide();
        $("#dadosSocial").hide();
        $("#dadosDesembarque").hide();
        $("#Dsbq").hide();
        $("#Filo").hide();
        $("#Social").hide();
        $("#Relatorio").hide();
        $("#RelListas").hide();
        $("#RelConsolidados").hide();
        $("#RelPescador").hide();
        $("#RelPerfilSocial").hide();
        $("#RelDesembarque").hide();
        $("#Amostras").hide();
        $("#Especialista").hide();
        $("#dadosEmbarcacao").hide();
    }

    $("#for-Social").click(function() {
        $("#Social").slideToggle();
    });
    $("#for-dadosSocial").click(function() {
        $("#dadosSocial").slideToggle();
    });
    $("#for-dadosDesembarque").click(function() {
        $("#dadosDesembarque").slideToggle();
    });
    $("#for-Dsbq").click(function() {
        $("#Dsbq").slideToggle();
    });
    $("#for-Filo").click(function() {
        $("#Filo").slideToggle();
    });
    $("#for-Entrevista").click(function(){
        $("#Entrevista").slideToggle();
    });
    $("#for-Relatorio").click(function(){
        $("#Relatorio").slideToggle();
    });
    $("#for-RelListas").click(function(){
        $("#RelListas").slideToggle();
    });
    $("#for-RelConsolidados").click(function(){
        $("#RelConsolidados").slideToggle();
    });
    $("#for-RelPescador").click(function(){
        $("#RelPescador").slideToggle();
    });
    $("#for-RelPerfilSocial").click(function(){
        $("#RelPerfilSocial").slideToggle();
    });
    $("#for-RelDesembarque").click(function(){
        $("#RelDesembarque").slideToggle();
    });
    $("#for-Amostra").click(function(){
        $("#Amostras").slideToggle();
    });
    $("#for-Especialista").click(function(){
        $("#Especialista").slideToggle();
    });
    $("#for-dadosEmbarcacao").click(function(){
        $("#dadosEmbarcacao").slideToggle();
    });
    //funcoes para menu

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54122257-1', 'auto');
  ga('send', 'pageview');


});

function jsEditarEntrevistas(nomeArtePesca,idEntrevista) {
            var Entrevista;
            if (nomeArtePesca.toLowerCase() === "Arrasto-Fundo".toLowerCase()) {
                Entrevista = "arrasto-fundo";
            }
            else if (nomeArtePesca.toLowerCase() === "Calão".toLowerCase()) {
                Entrevista = 'calao';
            }
            else if (nomeArtePesca.toLowerCase() === "Groseira".toLowerCase()) {
                Entrevista = 'grosseira';
            }
            else if (nomeArtePesca.toLowerCase() === "Linha".toLowerCase()) {
                Entrevista = 'linha';
            }
            else if (nomeArtePesca.toLowerCase() === "Emalhe".toLowerCase()) {
                Entrevista = 'emalhe';
            }
            else if (nomeArtePesca.toLowerCase() === "Tarrafa".toLowerCase()) {
                Entrevista = 'tarrafa';
            }
            else if (nomeArtePesca.toLowerCase() === "Vara de Pesca".toLowerCase()) {
                Entrevista = 'vara-pesca';
            }
            else if (nomeArtePesca.toLowerCase() === "Jereré".toLowerCase()) {
                Entrevista = 'jerere';
            }
            else if (nomeArtePesca.toLowerCase() === "Manzuá".toLowerCase()) {
                Entrevista = 'manzua';
            }
            else if (nomeArtePesca.toLowerCase() === "Ratoeira".toLowerCase()) {
                Entrevista = 'ratoeira';
            }
            else if (nomeArtePesca.toLowerCase() === "Coleta Manual".toLowerCase()) {
                Entrevista = 'coleta-manual';
            }
            else if (nomeArtePesca.toLowerCase() === "Mergulho".toLowerCase()) {
                Entrevista = 'mergulho';
            }
            else if (nomeArtePesca.toLowerCase() === "Linha de Fundo".toLowerCase()) {
                Entrevista = 'linha-fundo';
            }
            else if (nomeArtePesca.toLowerCase() === "Siripóia".toLowerCase()) {
                Entrevista = 'siripoia';
            }
            else
                Entrevista = 'error';
            var pag = (Entrevista + '/editar');
            var tmpUpdate = (pag + '/id/' + idEntrevista);
            window.open(tmpUpdate, "_blank");
}




///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Dependentes /_/_/_/_/_/_/_/_/_/_/_/_/_/


function scrollTo(hash) {
    location.hash = "#" + hash;
    location.hash = '';
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Endereço /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorEndereco( frm, pag )
{
    var TmpUrl = ('#top');

    var tmpUpdate = (pag +
            '/tp_nome/' + frm.nome.value +
            '/tp_sexo/' + frm.sexo.value +
            '/tp_rg/' + frm.rg.value +
            '/tp_cpf/' + frm.cpf.value +
            '/tp_apelido/' + frm.apelido.value +
            '/tp_matricula/' + frm.matricula.value +
            '/tp_filiacaopai/' + frm.filiacaoPai.value +
            '/tp_filiacaomae/' + frm.filiacaoMae.value +
            '/tp_ctps/' + frm.ctps.value +
            '/tp_pis/' + frm.pis.value +
            '/tp_inss/' + frm.inss.value +
            '/tp_nit_cei/' + frm.nit_cei.value +
            '/tp_cma/' + frm.cma.value +
            '/tp_rgb_maa_ibama/' + frm.rgb_maa_ibama.value +
            '/tp_cir_cap_porto/' + frm.cir_cap_porto.value +
            '/tp_datanasc/' + frm.dataNasc.value +
            '/tmun_id_natural/' + frm.municipioNat.value +
            '/esc_id/' + frm.selectEscolaridadeId.value +
            '/tp_resp_lan/' + frm.respLancamento.value +
            '/tp_resp_cad/' + frm.respCadastro.value +
            '/tp_obs/' + frm.obs.value +
            '/tpr_id/' + frm.selectProjeto.value +
            '/te_logradouro/' + frm.logradouro.value +
            '/te_numero/' + frm.numero.value +
            '/te_bairro/' + frm.bairro.value +
            '/te_cep/' + frm.cep.value +
            '/te_comp/' + frm.complemento.value +
            '/tmun_id/' + frm.municipio.value +
 
            '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Endereço /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsAtualizarPescadorEndereco( frm, pag )
{
    var TmpUrl = ('#top');

    var tmpUpdate = (pag +
            '/tp_id/' + frm.idPescador.value +
            '/tp_nome/' + frm.nome.value +
            '/tp_sexo/' + frm.sexo.value +
            '/tp_rg/' + frm.rg.value +
            '/tp_cpf/' + frm.cpf.value +
            '/tp_apelido/' + frm.apelido.value +
            '/tp_matricula/' + frm.matricula.value +
            '/tp_filiacaopai/' + frm.filiacaoPai.value +
            '/tp_filiacaomae/' + frm.filiacaoMae.value +
            '/tp_ctps/' + frm.ctps.value +
            '/tp_pis/' + frm.pis.value +
            '/tp_inss/' + frm.inss.value +
            '/tp_nit_cei/' + frm.nit_cei.value +
            '/tp_cma/' + frm.cma.value +
            '/tp_rgb_maa_ibama/' + frm.rgb_maa_ibama.value +
            '/tp_cir_cap_porto/' + frm.cir_cap_porto.value +
            '/tp_datanasc/' + frm.dataNasc.value +
            '/tmun_id_natural/' + frm.municipioNat.value +
            '/esc_id/' + frm.selectEscolaridadeId.value +
            '/tp_resp_lan/' + frm.respLancamento.value +
            '/tp_resp_cad/' + frm.respCadastro.value +
            '/tp_obs/' + frm.obs.value +
 
            '/te_id/' + frm.idEndereco.value +
            '/te_logradouro/' + frm.logradouro.value +
            '/te_numero/' + frm.numero.value +
            '/te_bairro/' + frm.bairro.value +
            '/te_cep/' + frm.cep.value +
            '/te_comp/' + frm.complemento.value +
            '/tmun_id/' + frm.municipio.value +
 
            '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Perfil /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPerfil( frm, pag )
{
    if (frm.inputTP_ID.value) {

        var tmpUpdate = ( '/perfil/update' + '/tp_id/' + frm.inputTP_ID.value + '/tp_perfil/' + frm.inputTP_Perfil.value);

        location.replace(tmpUpdate);
        
        return;
    }
    if (frm.inputTP_Perfil.value) {

        var tmpUpdate = (pag + '/tp_perfil/' + frm.inputTP_Perfil.value);

        location.replace(tmpUpdate);
    }
}

function jsDeletePerfil( idPerfil, pag )
{
    if (confirm("Realmente deseja excluir este item?")) {
        
        var tmpUpdate = (pag + '/tp_id/' + idPerfil);
        
        location.replace(tmpUpdate);
    }
}

function jsUpdatePerfil( tp_id, tp_perfil, frm )
{
    if ( confirm("Realmente deseja EDITAR este item?") ) {
        frm.inputTP_Perfil.value = tp_perfil;
        frm.inputTP_ID.value = tp_id;
    }
}

function jsReloadPerfil( frm ){
    if ( frm.inputTP_ID.value || frm.inputTP_Perfil.value) {
        location.replace('/perfil');
    }
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ DestinoPescado /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertDestinoPescado( frm, pag )
{
    if (frm.inputdp_id.value) {

        var tmpUpdate = ( '/destino-pescado/update' + '/dp_id/' + frm.inputdp_id.value + '/dp_destino/' + frm.inputdp_destino.value);

        location.replace(tmpUpdate);
        
        return;
    }
    if (frm.inputdp_destino.value) {

        var tmpUpdate = (pag + '/dp_destino/' + frm.inputdp_destino.value);

        location.replace(tmpUpdate);
    }
}

function jsDeleteDestinoPescado( idDestino, pag )
{
    if (confirm("Realmente deseja excluir este item?")) {
        
        var tmpUpdate = (pag + '/dp_id/' + idDestino);
        
        location.replace(tmpUpdate);
    }
}

function jsUpdateDestinoPescado( dp_id, dp_destino, frm )
{
    if ( confirm("Realmente deseja EDITAR este item?") ) {
        frm.inputdp_destino.value = dp_destino;
        frm.inputdp_id.value = dp_id;
    }
}

function jsReloadDestinoPescado( frm ){
    if ( frm.inputdp_id.value || frm.inputdp_destino.value) {
        location.replace('/destino-pescado');
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Dependentes /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasDependente( frm, pag )
{
    if (frm.inputQuantidadeDependente.value) {
        var TmpUrl = (+frm.idPescador.value + '#ancora_dependentes');

        var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idDependente/' + frm.SelectDependente.value + '/quant/' + frm.inputQuantidadeDependente.value + '/back_url/' + TmpUrl);
 
        location.replace( tmpUpdate );
    }
}

function jsDeletePescadorHasDependente(idDep, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_dependentes');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idDependente/' + idDep+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Renda /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasRenda( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_rendas');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idTipoRenda/' + frm.SelectTipoRenda.value + '/idRenda/' + frm.SelectRenda.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasRenda(idTipoRenda, idRenda, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_rendas');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idTipoRenda/'+idTipoRenda+'/idRenda/'+ idRenda+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Comunidade /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasComunidade( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_comunidade');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idComunidade/' + frm.selectComunidade.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasComunidade( idComunidade, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_comunidade');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idComunidade/'+idComunidade+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Porto /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasPorto( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_porto');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idPorto/' + frm.selectPorto.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasPorto( idPorto, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_porto');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idPorto/'+idPorto+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_ProgramaSocial /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasProgramaSocial( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_programasocial');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idProgramaSocial/' + frm.selectProgramaSocial.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasProgramaSocial( idProgramaSocial, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_programasocial');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idProgramaSocial/'+idProgramaSocial+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Telefone /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasTelefone( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_telefones');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idTelenone/' + frm.selectTipoTelefone.value + '/nTelefone/' + frm.inputTelefone.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasTelefone(idTeleone, frm, pag)
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_telefones');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idTelenone/'+idTeleone+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Colonia /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasColonia( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_colonias');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idColonia/' + frm.SelectColonia.value + '/dtaColonia/' + frm.inputDataInscricaoColonia.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasColonia( idColonia, frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_colonias');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idColonia/'+idColonia+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Area /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasArea( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_areas');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idArea/' + frm.selectAreaPesca.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasArea( idArea, frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_areas');

    var tmpUpdate = (pag + '/id/'+frm.idPescador.value+'/idArea/'+idArea+'/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Arte /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasArteTipo( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_arte');

   var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idArte/' + frm.SelectArtePesca.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasArteTipo( idArte, frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_arte');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idArte/' + idArte +  '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Tipo /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasTipoCapturada( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_tipos');

   var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idTipo/' + frm.selectTipoCapturada.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasTipoCapturada( idTipo, frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_tipos');

    var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idTipo/' + idTipo +  '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Embarcações /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsInsertPescadorHasEmbarcacoes( frm, pag )
{
    var TmpUrl = (+frm.idPescador.value + '#ancora_embarcacoes');

   var tmpUpdate = (pag + '/id/' + frm.idPescador.value + '/idDono/' + frm.selectDonoEmbarcacao.value + '/idEmbarcacao/' + frm.selectTipoEmbarcacao.value + '/idPorte/' + frm.selectPorteEmbarcacao.value + '/isMotor/' + frm.selectMotorEmbarcacao.value + '/back_url/' + TmpUrl);

    location.replace(tmpUpdate);
}

function jsDeletePescadorHasEmbarcacoes(idPescador,idEmbarcacao, frm, pag )
{
    var TmpUrl = (+idPescador + '#ancora_embarcacoes');

    var tmpUpdate = (pag +'/idPescador/' +idPescador + '/idPescadorEmbarcacao/' + idEmbarcacao + '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}


///_/_/_/_/_/_/_/_/_/_/_/_/_/ MENSAGEM DE CONFIRMAÇÃO /_/_/_/_/_/_/_/_/_/_/_/_/_/
function beforeDelete(id)
{
    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(id);
    }
}


///_/_/_/_/_/_/_/_/_/_/_/_/_/ Entrevista_has_Pesqueiro /_/_/_/_/_/_/_/_/_/_/_/_/_/
function jsDeletePesqueiro(fichaId,pag, idEntHasPesqueiro) {
    var TmpUrl = (+fichaId + '#base');
    
    var tmpUpdate = (pag + '/id/' + idEntHasPesqueiro + '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}
function jsInsertPesqueiro(frm, pag, entrevista) {

        var TmpUrl = (entrevista + '#base');
        if(frm.nomePesqueiro.value === ""){
            alert("Selecione um pesqueiro!");
        }
        else{
            var tmpUpdate = (pag + '/nomePesqueiro/' + frm.nomePesqueiro.value + '/tempoPesqueiro/' + frm.tempoPesqueiro.value + '/id_entrevista/' + entrevista + '/back_url/' + TmpUrl);

            location.replace(tmpUpdate);
        }
}

function jsInsertPesqueiroWithoutTime(frm, pag, entrevista) {

        var TmpUrl = (entrevista + '#base');
        if(frm.nomePesqueiro.value === ""){
            alert("Selecione um pesqueiro!");
        }
        else{
            var tmpUpdate = (pag + '/nomePesqueiro/' + frm.nomePesqueiro.value + '/id_entrevista/' + entrevista + '/back_url/' + TmpUrl);

            location.replace(tmpUpdate);
        }
}


function jsInsertPesqueiroWithTime(frm, pag, entrevista) {

        var TmpUrl = (entrevista + '#base');
        if(frm.nomePesqueiro.value === ""){
            alert("Selecione um pesqueiro!");
        }
        else{
            var tmpUpdate = (pag + '/nomePesqueiro/' + frm.nomePesqueiro.value + '/tempoAPesqueiro/' + frm.tempoAPesqueiro.value +'/id_entrevista/' + entrevista + '/back_url/' + TmpUrl);

            location.replace(tmpUpdate);
        }
}

function jsInsertPesqueiroWithTimeAndRange(frm, pag, entrevista) {

        var TmpUrl = (entrevista + '#base');
        if(frm.nomePesqueiro.value === ""){
            alert("Selecione um pesqueiro!");
        }
        else{
            var tmpUpdate = (pag + '/nomePesqueiro/' + frm.nomePesqueiro.value + '/tempoAPesqueiro/' + frm.tempoAPesqueiro.value +'/distAPesqueiro/'+ frm.distAPesqueiro.value + '/id_entrevista/' + entrevista + '/back_url/' + TmpUrl);

            location.replace(tmpUpdate);
        }
}

function jsInsertEspecieCapturadaTipoVenda(frm, pag, entrevista){
    
    var TmpUrl  = (entrevista+ '#base');
    if(frm.SelectEspecie.value === ""){
        alert("Selecione uma espécie!");
    }
    else if(frm.quantidade.value === "" && frm.peso.value === ""){
        alert("A Quantidade e o Peso não podem ser vazios, por favor insira um deles!");
    }
    else{
        var tmpUpdate = (pag + '/selectEspecie/' + frm.SelectEspecie.value + '/quantidade/' + frm.quantidade.value + '/peso/' + frm.peso.value + '/precokg/' + frm.precokg.value + '/id_entrevista/' + entrevista + '/id_tipovenda/'+frm.tipoVenda.value+'/back_url/' + TmpUrl);
        
        location.replace(tmpUpdate);
    }
}
function jsInsertEspecieCapturada(frm, pag, entrevista){
    
    var TmpUrl  = (entrevista+ '#base');
    if(frm.SelectEspecie.value === ""){
        alert("Selecione uma espécie!");
    }
    else if(frm.quantidade.value === "" && frm.peso.value === ""){
        alert("A Quantidade e o Peso não podem ser vazios, por favor insira um deles!");
    }
    else{
        var tmpUpdate = (pag + '/selectEspecie/' + frm.SelectEspecie.value + '/quantidade/' + frm.quantidade.value + '/peso/' + frm.peso.value + '/precokg/' + frm.precokg.value + '/id_entrevista/' + entrevista +'/back_url/' + TmpUrl);

        location.replace(tmpUpdate);
    }
}


function jsDeleteEspecieCapturada(fichaId, pag, idEntHasEspecie) {
    var TmpUrl = (+fichaId + '#base');

    var tmpUpdate = (pag + '/id/' + idEntHasEspecie + '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}
function jsInsertAvistamento(frm, pag, entrevista){
    
    var TmpUrl  = (entrevista+ '#base');
    if(frm.SelectAvistamento.value === ""){
        alert("Selecione um avistamento!");
    }
    else{
        var tmpUpdate = (pag + '/SelectAvistamento/' + frm.SelectAvistamento.value +'/id_entrevista/' + entrevista + '/back_url/' + TmpUrl);

        location.replace(tmpUpdate);
    }
    
}
function jsDeleteAvistamento(fichaId, pag, idAvistamento) {
    var TmpUrl = (+fichaId + '#base');

    var tmpUpdate = (pag + '/id_entrevista/' + fichaId + '/id_avistamento/'+idAvistamento+ '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

function jsEntrevista(nomeArtePesca, idMonitoramento, idFichaDiaria) {
            var Entrevista;
            if (nomeArtePesca.toLowerCase() === "Arrasto de Fundo".toLowerCase()) {
                Entrevista = "arrasto-fundo";
            }
            else if (nomeArtePesca.toLowerCase() === "Calão".toLowerCase()) {
                Entrevista = 'calao';
            }
            else if (nomeArtePesca.toLowerCase() === "Espinhel/Groseira".toLowerCase()) {
                Entrevista = 'grosseira';
            }
            else if (nomeArtePesca.toLowerCase() === "Pesca de Linha".toLowerCase()) {
                Entrevista = 'linha';
            }
            else if (nomeArtePesca.toLowerCase() === "Rede de Emalhar".toLowerCase()) {
                Entrevista = 'emalhe';
            }
            else if (nomeArtePesca.toLowerCase() === "Tarrafa".toLowerCase()) {
                Entrevista = 'tarrafa';
            }
            else if (nomeArtePesca.toLowerCase() === "Vara de Pesca".toLowerCase()) {
                Entrevista = 'vara-pesca';
            }
            else if (nomeArtePesca.toLowerCase() === "Jereré".toLowerCase()) {
                Entrevista = 'jerere';
            }
            else if (nomeArtePesca.toLowerCase() === "Manzuá".toLowerCase()) {
                Entrevista = 'manzua';
            }
            else if (nomeArtePesca.toLowerCase() === "Ratoeira".toLowerCase()) {
                Entrevista = 'ratoeira';
            }
            else if (nomeArtePesca.toLowerCase() === "Coleta Manual".toLowerCase()) {
                Entrevista = 'coleta-manual';
            }
            else if (nomeArtePesca.toLowerCase() === "Mergulho".toLowerCase()) {
                Entrevista = 'mergulho';
            }
            else if (nomeArtePesca.toLowerCase() === "Linha de Fundo".toLowerCase()) {
                Entrevista = 'linha-fundo';
            }
            else if (nomeArtePesca.toLowerCase() === "Siripóia".toLowerCase()) {
                Entrevista = 'siripoia';
            }
            else
                Entrevista = 'error';
            var pag = (Entrevista + '/index');
            var tmpUpdate = (pag + '/id/' + idFichaDiaria + '/idMonitoramento/' + idMonitoramento);
            location.replace(tmpUpdate);
        }
function jsDeleteMonitoramento(idMnt, frm, pag, fichaId) {
      var TmpUrl = (+fichaId + '#base');

      var tmpUpdate = (pag + '/id/' + idMnt + '/back_url/' + TmpUrl);

      if (confirm("Realmente deseja excluir este item?")) {
                location.replace(tmpUpdate);
            }
}

        function jsInsertMonitoramento(frm, pag)
        {
            if (frm.QuantidadeEmbarcacoes.value) {
                var TmpUrl = (+frm.id_fichaDiaria.value + '#base');

                var tmpUpdate = (pag + '/SelectArtePesca/' + frm.SelectArtePesca.value + '/SelectMonitorada/' + frm.SelectMonitorada.value + '/QuantidadeEmbarcacoes/' + frm.QuantidadeEmbarcacoes.value + '/id_fichaDiaria/' + frm.id_fichaDiaria.value + '/back_url/' + TmpUrl);

                window.location.replace(tmpUpdate);
            }
        }

function jsInsertIsca( frm, pag )
{
    if (frm.inputIsc_id.value) {

        var tmpUpdate = (pag + '/isc_id/' + frm.inputIsc_id.value);

        location.replace(tmpUpdate);
        
        return;
    }
    if (frm.inputIsc_tipo.value) {

        var tmpUpdate = (pag + '/isc_tipo/' + frm.inputIsc_tipo.value);

        location.replace(tmpUpdate);
    }
}

function jsDeleteIsca( idIsca, pag )
{
    if (confirm("Realmente deseja excluir este item?")) {
        
        var tmpUpdate = (pag + '/isc_id/' + idIsca);
        
        location.replace(tmpUpdate);
    }
}

function jsUpdateIsca( isc_id, isc_tipo, frm )
{
    if ( confirm("Realmente deseja EDITAR este item?") ) {
        frm.inputIsc_tipo.value = isc_tipo;
        frm.inputIsc_id.value = isc_id;
    }
}

function jsReloadIsca( frm ){
    if ( frm.inputIsc_id.value || frm.inputIsc_tipo.value) {
        location.replace('/perfil');
    }
}

function relatorioIndividualPescador(id_pescador){
    
    location.reload('pescador/relpdfpescador/id_pescador/'.id_pescador);
}

function jsInsertAmostraCamarao(frm, pag, idEntrevista){
    
    var TmpUrl  = (idEntrevista+ '#base_camarao');
    if(frm.comprimentoCabeca.value===""){
        alert("Digite o Comprimento da Cabeça");
    }
    else if(frm.pesoCamarao.value === ""){
        alert("Digite o Peso do Camarão");
    }
    else{
        var tmpUpdate = (pag + '/id/' +idEntrevista+ '/SelectEspecie/'+ frm.SelectEspecieCamarao.value +
        '/SelectSexo/' + frm.SelectSexoCamarao.value +'/SelectMaturidade/' + frm.SelectMaturidade.value + 
        '/comprimentoCabeca/'+ frm.comprimentoCabeca.value + '/peso/'+frm.pesoCamarao.value+'/back_url/' + TmpUrl);

        location.replace(tmpUpdate);
    }
}

function jsDeleteUnidade( pag, idEntrevista ,idUnidade, retorno) {
    var TmpUrl = (+idEntrevista + retorno);

    var tmpUpdate = (pag + '/id/'+idUnidade+ '/back_url/' + TmpUrl);

    if (confirm("Realmente deseja excluir este item?")) {
        location.replace(tmpUpdate);
    }
}

function jsInsertAmostraPeixe(frm, pag, idEntrevista){
    
    var TmpUrl  = (idEntrevista+ '#base_peixe');
    if(frm.comprimentoPeixe.value===""){
        alert("Digite o Comprimento do Peixe");
    }
    else if(frm.pesoPeixe.value === ""){
        alert("Digite o Peso do Camarão");
    }
    else{
        var tmpUpdate = (pag + '/id/'+idEntrevista+'/SelectSexo/' + frm.SelectSexoPeixe.value +
        '/SelectEspecie/' + frm.SelectEspeciePeixe.value + '/comprimento/'+ frm.comprimentoPeixe.value + 
        '/peso/'+frm.pesoPeixe.value+'/back_url/' + TmpUrl);

        location.replace(tmpUpdate);
    }
}
//Insert para views dinâmicas
function jsInsertDynamic(frm, pag, pag_update)
{
    if (frm.input_id.value) {

        var tmpUpdate = (pag_update + '/id/' + frm.input_id.value + '/valor/'+frm.input_valor.value);

        location.replace(tmpUpdate);
        
        return;
    }
    if (frm.input_valor.value) {

        var tmpUpdate = (pag + '/valor/' + frm.input_valor.value);

        location.replace(tmpUpdate);
    }
}
//Delete for inputs dinamicos
function jsDeleteDynamic( id, pag )
{
    if (confirm("Realmente deseja excluir este item?")) {
        
        var tmpUpdate = (pag + '/id/' + id);
        
        location.replace(tmpUpdate);
    }
}

function jsUpdateDynamic( id, valor, frm)
{
    if ( confirm("Realmente deseja EDITAR este item?") ) {
        frm.input_valor.value = valor;
        frm.input_id.value = id;
    }
}

function jsReloadDynamic( frm , pag){
    if ( frm.input_valor.value || frm.input_id.value) {
        location.replace(pag);
    }
}

function jsAtualizaPescadorEspecialista( frm, pag, idEspecialista, redirect)
{
    var TmpUrl = (idEspecialista +redirect);

    var tmpUpdate = (pag +
            '/tps_id/' + idEspecialista +
            '/pto_id/'+ frm.selectPortoEspecialista.value +
            '/tps_data_nasc/'+ frm.tp_dataNasc.value +
            '/tps_idade/'+ frm.tp_idade.value +
            '/tec_id/'+ frm.selectEstadoCivil.value +
            '/tps_filhos/'+ frm.tp_numFilhos.value +
            '/tps_tempo_residencia/'+ frm.tp_tempoResidencia.value +
            '/to_id/'+  frm.selectOrigem.value +
            '/tre_id/'+ frm.selectResidencia.value +
            '/tps_pessoas_na_casa/'+ frm.tp_quantPessoas.value +
            '/tps_tempo_sustento/'+ frm.tp_tempoSemPesca.value +
            '/tps_renda_menor_ano/'+ frm.tp_menorRenda.value +
            '/tea_id_menor/'+ frm.selectMenorEstacaoAno.value +
            '/tps_renda_maior_ano/'+ frm.tp_maiorRenda.value +
            '/tea_id_maior/'+ frm.selectMaiorEstacaoAno.value +
            '/tps_renda_no_defeso/'+ frm.tp_valorRendaDefeso.value +
            '/tps_tempo_de_pesca/'+ frm.tp_tempoPesca.value +
            '/ttd_id_tutor_pesca/'+ frm.selectTutorPesca.value +
            '/ttr_id_antes_pesca/'+ frm.selectAntesPesca.value +
            '/tps_mora_onde_pesca/'+ frm.selectMoraOndePesca.value +
            '/tps_embarcado/' + frm.selectEmbarcado.value +
            '/tps_num_familiar_pescador/' + frm.tp_numPescadorFamilia.value +
            '/tfp_id/' + frm.selectFrequenciaPesca.value +
            '/tps_num_dias_pescando/'+ frm.tp_diasPescando.value +
            '/tps_hora_pescando/'+ frm.tp_horasPescando.value +
            '/tup_id/'+ frm.selectUltimaPesca.value +     
            '/tfp_id_consumo/'+ frm.selectFrequenciaConsumo.value +
            '/tsp_id/' + frm.selectSobraPesca.value +
            '/tlt_id/' + frm.selectLocalTratamento.value +
            '/tps_unidade_beneficiamento/'+ frm.tp_unidadeBeneficiamento.value +
            '/tps_curso_beneficiamento/'+ frm.tp_cursoBeneficiamento.value +
            '/tasp_id/'+ frm.selectAssociacaoPesca.value +
            '/tc_id/' + frm.selectColoniaEspecialista.value +
            '/tps_tempo_em_colonia/'+ frm.tp_tempoColonizado.value +
            '/tps_motivo_falta_pagamento/'+ frm.tp_dificuldadeColonia.value +
            '/tps_beneficio_colonia/'+ frm.tp_beneficiosColonia.value +
            '/trgp_id/' + frm.selectOrgaoRgp.value +
            '/ttr_id_alternativa_renda/' + frm.selectAlternativaRenda.value +
            '/ttr_id_outra_profissao/' + frm.selectOutraProfissao.value +
            '/tps_filho_seguir_profissao/'+ frm.tp_filhoPescador.value +
            '/tps_grau_dependencia_pesca/' + frm.tp_dependenciaPesca.value +
            '/tu_id_entrevistador/' + frm.selectEntrevistador.value +
            '/tps_data/'+ frm.tp_data.value +
            '/tps_obs/' + frm.tps_obs.value +
            '/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
    window.alert("Dados do Especialista adicionado com sucesso");
    
}

function jsInsertPescadorEspecialista(pag,idPescador, respCadastro){
    var TmpUrl = (idPescador +'#pescador_especialista');
    
    var tmpUpdate = (pag +
        '/tp_id/'+ idPescador + '/tp_resp_cad/'+respCadastro+'/back_url/' + TmpUrl
    );
    if (confirm("Deseja adicionar o pescador especialista?")) {
            $("#tabs-1").hide();
            location.replace(tmpUpdate);
    }
}
// -9 -------------------------------------------------------//
function jsInsertEstruturaResidencial(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectValor.value +'/back_url/' + TmpUrl); 

    location.replace(tmpUpdate);
    
}

// -11 -------------------------------------------------------//
function jsInsertProgramaSocial(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectProgramaSocial.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}

// -13 -------------------------------------------------------//
function jsInsertSeguroDefeso(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+ retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectSeguroDefeso.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -13.1 -------------------------------------------------------//
function jsInsertRendaDefeso(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+ retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectRendaDefeso.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -16 -------------------------------------------------------//
function jsInsertMotivoPesca(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectMotivoPesca.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -19 -------------------------------------------------------//
function jsInsertTransporte(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectTransporte.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -20 -------------------------------------------------------//
function jsInsertAcompanhado(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectAcompanhado.value +'/quantidade/'+frm.tp_qtdCompanhia.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}

// -20.1 -------------------------------------------------------//
function jsInsertCompanhia(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectCompanhia.value +'/quantidade/'+frm.tp_quantParente.value  +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}

// -22.1 -------------------------------------------------------//
function jsInsertFamiliaPescador(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectFamiliaPescador.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -24 -------------------------------------------------------//
function jsInsertHorarioPesca(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectHorarioPesca.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -28 -------------------------------------------------------//
function jsInsertInsumoPesca(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectInsumo.value+ '/preco/' +frm.tp_valorInsumo.value+'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -28.2 -------------------------------------------------------//
function jsInsertFornecedorInsumo(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectFornecedorInsumo.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -28.3 -------------------------------------------------------//
function jsInsertRecursos(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectRecursos.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}

// -29 -------------------------------------------------------//
function jsInsertDestinoPescadoEspecialista(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectDestinoPescado.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -29.2 -------------------------------------------------------//
function jsInsertCompradorPescado(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectCompradorPescado.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -36 -------------------------------------------------------//
function jsInsertDificuldadePesca(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectDificuldadePesca.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -37   -------------------------------------------------------//
function jsInsertHabilidades(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectHabilidades.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}
// -44   -------------------------------------------------------//
function jsInsertEmbarcacoes(frm, pag, idPescador, idEspecialista, retorno){
    
    var TmpUrl  = (idPescador+retorno);
    
    var tmpUpdate = (pag + '/id/'+idEspecialista+'/valor/' + frm.selectEmbarcacao.value +'/back_url/' + TmpUrl);
    
    location.replace(tmpUpdate);
    
}


function jsRedirectEspecialista(url, hash){
    var especialista = url+hash;
    
    location.replace(especialista);
}

function jsDeleteDynamicEspecialista( id, idPescador, pag, idBack,back)
{
        var back_url = idBack+back;
    if (confirm("Realmente deseja excluir este item?")) {
        
        var tmpUpdate = (pag + '/id/' + id + '/tps_id/' + idPescador + '/back_url/' +back_url);
        
        location.replace(tmpUpdate);
    }
}


function jsBuscaPescador(form, pag){
    var busca;
    if(form.tipoBusca.value === '1'){
        busca = (pag+'/index/tp_nome/'+form.buscaPescador.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '2'){
        busca = (pag+'/index/tp_id/'+form.buscaPescador.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '3'){
        busca = (pag+'/index/tp_apelido/'+form.buscaPescador.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '4'){
        busca = (pag+'/index/tp_all/'+"all");
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '5'){
        busca = (pag+'/index/tp_especialidade/especialista');
        location.replace(busca);
    }
}
function jsBuscaFichaDiaria(form, pag){
    var busca;
    if(form.tipoBusca.value === '1'){
        busca = (pag+'/index/fd_id/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '2'){
        busca = (pag+'/index/fd_data/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '3'){
        busca = (pag+'/index/fd_turno/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '4'){
        busca = (pag+'/index/pto_id/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '5'){
        busca = (pag+'/index/fd_estagiario/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '6'){
        busca = (pag+'/index/fd_monitor/'+form.buscaFicha.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '7'){
        busca = (pag+'/index/fd_all/'+"all");
        location.replace(busca);
    }
    
}

function jsBuscaEntrevistas(form, pag){
    var busca;
    
    if(form.tipoBusca.value === '1'){
        busca = (pag+'/ent_id/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    if(form.tipoBusca.value === '2'){
        busca = (pag+'/tp_nome/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '3'){
        busca = (pag+'/bar_nome/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '4'){
        busca = (pag+'/tp_apelido/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '5'){
        busca = (pag+'/porto/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '6'){
        busca = (pag+'/ent_all/'+"all");
        location.replace(busca);
    }
    
}
function jsBuscaTodasEntrevistas(form, pag){
    var busca;
    if(form.tipoBusca.value === '1'){
        busca = (pag+'/index/data/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    if(form.tipoBusca.value === '2'){
        busca = (pag+'/index/tp_nome/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '3'){
        busca = (pag+'/index/bar_nome/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '4'){
        busca = (pag+'/index/tp_apelido/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '5'){
        busca = (pag+'/index/porto/'+form.buscaEntrevistas.value);
        location.replace(busca);
    }
    else if(form.tipoBusca.value === '6'){
        busca = (pag+'/index/ent_all/'+"all");
        location.replace(busca);
    }
    
}

function jsClearBusca( pag ){
        location.hash = '';
        location.replace( pag );
}

