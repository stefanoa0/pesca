<?php

class Application_Model_Administrador
{
    public function deletePescadorHasDependente($idPescador) {
        $dbTable_PescadorHasDependente = new Application_Model_DbTable_PescadorHasDependente();

        $dadosPescadorHasDependente = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasDependente->delete($dadosPescadorHasDependente);

        return;
    }
    
    public function deletePescadorHasRenda($idPescador) {
        $dbTable_PescadorHasRenda = new Application_Model_DbTable_PescadorHasRenda();

        $dadosPescadorHasRenda = array(
            'tp_id = ?' => $idPescador,

        );
        $dbTable_PescadorHasRenda->delete($dadosPescadorHasRenda);

        return;
    }
    
    public function deletePescadorHasComunidade($idPescador) {
        $dbTable_PescadorHasComunidade = new Application_Model_DbTable_PescadorHasComunidade();

        $dadosPescadorHasComunidade = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasComunidade->delete($dadosPescadorHasComunidade);

        return;
    }
    public function deletePescadorHasPorto($idPescador) {
        $dbTable_PescadorHasPorto = new Application_Model_DbTable_PescadorHasPorto();

        $dadosPescadorHasPorto = array(
            'tp_id = ?' => $idPescador,
        );
        $dbTable_PescadorHasPorto->delete($dadosPescadorHasPorto);

        return;
    }
    public function deletePescadorHasProgramaSocial($idPescador) {
        $dbTable_PescadorHasProgramaSocial = new Application_Model_DbTable_PescadorHasProgramaSocial();

        $dadosPescadorHasProgramaSocial = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasProgramaSocial->delete($dadosPescadorHasProgramaSocial);

        return;
    }
    public function deletePescadorHasTelefone($idPescador) {
        $dbTable_PescadorHasTelefone = new Application_Model_DbTable_PescadorHasTelefone();

        $dadosPescadorHasTelefone = array(
            'tpt_tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasTelefone->delete($dadosPescadorHasTelefone);

        return;
    }
    public function deletePescadorHasColonia($idPescador) {
        $dbTable_PescadorHasColonia = new Application_Model_DbTable_PescadorHasColonia();

        $dadosPescadorHasColonia = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasColonia->delete($dadosPescadorHasColonia);

        return;
    }
    public function deletePescadorHasArea($idPescador) {
        $dbTable_PescadorHasArea = new Application_Model_DbTable_PescadorHasAreaPesca();

        $dadosPescadorHasArea = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasArea->delete($dadosPescadorHasArea);

        return;
    }
    public function deletePescadorHasArteTipo($idPescador) {
        $dbTable_PescadorHasArteTipo = new Application_Model_DbTable_PescadorHasArtePesca();

        $dadosPescadorHasArteTipo = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasArteTipo->delete($dadosPescadorHasArteTipo);

        return;
    }
    public function deletePescadorHasTipo($idPescador) {
        $dbTable_PescadorHasTipo = new Application_Model_DbTable_PescadorHasEspecieCapturada();

        $dadosPescadorHasTipo = array(
            'tp_id = ?' => $idPescador
        );
        $dbTable_PescadorHasTipo->delete($dadosPescadorHasTipo);

        return;
    }
    public function deletePescadorHasEmbarcacoes($idPescadorEmbarcacao) {
        $dbTable_PescadorHasEmbarcacoes = new Application_Model_DbTable_PescadorHasEmbarcacao();

        
        $wherePescadorHasEmbarcacao= $dbTable_PescadorHasEmbarcacoes->getAdapter()
                ->quoteInto('"tp_id" = ?', $idPescadorEmbarcacao);
        
        $dbTable_PescadorHasEmbarcacoes->delete($wherePescadorHasEmbarcacao);

        return;
    }
    
    public function deletePescador($idPescador){
        $dbTablePescador = new Application_Model_DbTable_Pescador();
        
        $wherePescador = $dbTablePescador->getAdapter()
                ->quoteInto('"tp_id" = ?', $idPescador);
        
        $dbTablePescador->delete($wherePescador);
    }


}

