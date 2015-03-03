<?php

class Application_Model_Monitoramento
{
    private $dbTableMonitoramento;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableMonitoramento = new Application_Model_DbTable_VMonitoramentobyFicha();
        $select = $this->dbTableMonitoramento->select()
                ->from($this->dbTableMonitoramento)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMonitoramento->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableMonitoramento = new Application_Model_DbTable_Monitoramento();
        $arr = $this->dbTableMonitoramento->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert($idFicha, $idArtePesca, $mnt_quantidade, $Monitorada)
    {
        $this->dbTableMonitoramento = new Application_Model_DbTable_Monitoramento();
        
        
        $dadosMonitoramento = array(
            'mnt_monitorado' => $Monitorada,
            'mnt_arte' => $idArtePesca,
            'mnt_quantidade' => $mnt_quantidade,
            'fd_id' => $idFicha
        );
        
        $this->dbTableMonitoramento->insert($dadosMonitoramento);
        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableMonitoramento = new Application_Model_DbTable_Monitoramento();
        
        $dadosMonitoramento = array(
            'mnt_monitorado' => $request['monitorado'],
            'mnt_arte' => $request['artePesca'],
            'mnt_quantidade' => $request['quantidade']
        );
 
        
        $whereMonitoramento = $this->dbTableMonitoramento->getAdapter()
                ->quoteInto('"mnt_id" = ?', $request['id_mnt']);
        
        
        $this->dbTableMonitoramento->update($dadosMonitoramento, $whereMonitoramento);
    }
    
    public function delete($idMonitoramento)
    {
        $this->dbTableMonitoramento = new Application_Model_DbTable_Monitoramento();       
                
        $whereMonitoramento= $this->dbTableMonitoramento->getAdapter()
                ->quoteInto('"mnt_id" = ?', $idMonitoramento);
        
        $this->dbTableMonitoramento->delete($whereMonitoramento);
    }

}

