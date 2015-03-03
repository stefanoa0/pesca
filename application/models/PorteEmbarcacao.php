<?php

class Application_Model_PorteEmbarcacao
{
    private $dbTablePorteEmbarcacao;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTablePorteEmbarcacao = new Application_Model_DbTable_PorteEmbarcacao();
        
        $select = $this->dbTablePorteEmbarcacao->select()->from($this->dbTablePorteEmbarcacao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTablePorteEmbarcacao->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTablePorteEmbarcacao = new Application_Model_DbTable_PorteEmbarcacao();
        $arr = $this->dbTablePorteEmbarcacao->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTablePorteEmbarcacao = new Application_Model_DbTable_PorteEmbarcacao();
        
        $dadosPorteEmbarcacao = array(
            'tpe_porte' => $request['porteEmb']
        );
        
        $this->dbTablePorteEmbarcacao->insert($dadosPorteEmbarcacao);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTablePorteEmbarcacao = new Application_Model_DbTable_PorteEmbarcacao();
        
        $dadosPorteEmbarcacao = array(
            'tpe_porte' => $request['porteEmb']
        );
        
        $whereAreaPesca= $this->dbTablePorteEmbarcacao->getAdapter()
                ->quoteInto('"tpe_id" = ?', $request['idPorteEmb']);
        
        $this->dbTablePorteEmbarcacao->update($dadosPorteEmbarcacao, $whereAreaPesca);
    }
    
    public function delete($idPorteEmbarcacao)
    {
        $this->dbTablePorteEmbarcacao = new Application_Model_DbTable_PorteEmbarcacao();       
                
        $whereAreaPesca= $this->dbTablePorteEmbarcacao->getAdapter()
                ->quoteInto('"tpe_id" = ?', $idPorteEmbarcacao);
        
        $this->dbTablePorteEmbarcacao->delete($whereAreaPesca);
    }
}

