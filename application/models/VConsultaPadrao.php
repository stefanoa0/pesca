<?php

class Application_Model_VConsultaPadrao
{
    var $totalEntrevistas;
    var $totalDias;
    
    public function select($where = null, $limit = null)
    {
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $select = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao)->order('consulta')->order('pto_nome')->limit($limit)->where("consulta <> 'Quantidade de Fichas' AND consulta <> 'Monitoradas' AND consulta <> 'Não monitorados' AND consulta <> 'Subamostras'");
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbVConsultaPadrao->fetchAll($select)->toArray();
    }
    public function selectTotalEntrevistas($where = null, $limit = null)
    {
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $select = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao, 'Sum(quantidade)')->limit($limit)->where("consulta <> 'Quantidade de Fichas' AND consulta <> 'Monitoradas' AND consulta <> 'Não monitorados' AND consulta <> 'Subamostras'");
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbVConsultaPadrao->fetchAll($select)->toArray();
    }
    public function selectTotalEntrevistasByPorto($where = null, $limit = null)
    {
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $select = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao, 'Sum(quantidade)')->limit($limit)->where("consulta <> 'Quantidade de Fichas' AND consulta <> 'Monitoradas' AND consulta <> 'Não monitorados' AND consulta <> 'Subamostras'");
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbVConsultaPadrao->fetchAll($select)->toArray();
    }
    public function selectMonitoramentos()
    {
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $select = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao)->order('consulta')->order('pto_nome')->where("consulta = 'Monitoradas' OR consulta = 'Não monitorados'");
        

        return $this->dbVConsultaPadrao->fetchAll($select)->toArray();
    }
    public function selectSubamostras()
    {
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $select = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao)->order('consulta')->order('pto_nome')->where("consulta = 'Subamostras'");
        

        return $this->dbVConsultaPadrao->fetchAll($select)->toArray();
    }
    public function selectDiasByPorto(){
        $this->dbVFicha = new Application_Model_DbTable_VFichaDiaria();
        $selectFicha = $this->dbVFicha->select()->from($this->dbVFicha, 'count(distinct fd_data), pto_nome')->order('pto_nome')->group('pto_nome');
        
        
        return $this->dbVConsultaPadrao->fetchAll($selectFicha)->toArray();
    }
    public function selectDias(){
        $this->dbVFicha = new Application_Model_DbTable_VFichaDiaria();
        $selectFicha = $this->dbVFicha->select()->from($this->dbVFicha, 'count(distinct fd_data)');
        
        
        return $this->dbVConsultaPadrao->fetchAll($selectFicha)->toArray();
    }
    
    public function selectFichas(){
        $this->dbVConsultaPadrao = new Application_Model_DbTable_VConsultaPadrao();
        $selectFicha = $this->dbVConsultaPadrao->select()->from($this->dbVConsultaPadrao)->where("consulta = 'Quantidade de Fichas'")->order('pto_nome');
        
        
        return $this->dbVConsultaPadrao->fetchAll($selectFicha)->toArray();
    }
    
    public function selectPortosByData(){
        $this->dbVConsultaPortos = new Application_Model_DbTable_VConsultaPortosbyData();
        
        $selectPortosData = $this->dbVConsultaPortos->select();
        
        return $this->dbVConsultaPortos->fetchAll($selectPortosData)->toArray();
    }
    
    public function selectRelatorioMensal(){
        $this->dbRelatorioMensal = new Application_Model_DbTable_VRelatorioMensal();
        
        $selectRelatorio = $this->dbRelatorioMensal->select();
        
        return $this->dbRelatorioMensal->fetchAll($selectRelatorio)->toArray();
    }
    
    public function selectEntrevistaPesqueiro(){
        $this->dbEntrevistaPortoPesqueiro = new Application_Model_DbTable_VEntrevistaPortoPesqueiro();
        
        $selectRelatorio = $this->dbEntrevistaPortoPesqueiro->select();
        
        return $this->dbEntrevistaPortoPesqueiro->fetchAll($selectRelatorio)->toArray();
    }
    public function selectEntrevistasByHora(){
        $this->dbEntrevistaHora = new Application_Model_DbTable_VEntrevistasByHora();
        
        $selectRelatorio = $this->dbEntrevistaHora->select();
        
        return $this->dbEntrevistaHora->fetchAll($selectRelatorio)->toArray();
    }
    public function selectFilogenia(){
        $this->dbFilogenia = new Application_Model_DbTable_VFilogenia();
        
        $selectRelatorio = $this->dbFilogenia->select();
        
        return $this->dbFilogenia->fetchAll($selectRelatorio)->toArray();
    }

}

