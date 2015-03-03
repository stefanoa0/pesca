<?php

/** 
 * Model TipoEmbarcacao
 * 
 * @package Pesca
 * @subpackage Models
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_TipoEmbarcacao
{
    private $dbTableTipoEmbarcacao;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTipoEmbarcacao = new Application_Model_DbTable_TipoEmbarcacao();
        $select = $this->dbTableTipoEmbarcacao->select()
                ->from($this->dbTableTipoEmbarcacao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTipoEmbarcacao->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableTipoEmbarcacao = new Application_Model_DbTable_TipoEmbarcacao();
        $arr = $this->dbTableTipoEmbarcacao->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableTipoEmbarcacao = new Application_Model_DbTable_TipoEmbarcacao();
        
        $dadosTipoEmbarcacao = array(
            'tte_tipoembarcacao' => $request['tipoEmbarcacao']
        );
        
        $this->dbTableTipoEmbarcacao->insert($dadosTipoEmbarcacao);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableTipoEmbarcacao = new Application_Model_DbTable_TipoEmbarcacao();
        
        $dadosTipoEmbarcacao = array(
            'tte_tipoembarcacao' => $request['tipoEmbarcacao']
        );
        
        $whereTipoEmbarcacao= $this->dbTableTipoEmbarcacao->getAdapter()
                ->quoteInto('"tte_id" = ?', $request['idtipoembarcacao']);
        
        $this->dbTableTipoEmbarcacao->update($dadosTipoEmbarcacao, $whereTipoEmbarcacao);
    }
    
    public function delete($idTipoEmbarcacao)
    {
        $this->dbTableTipoEmbarcacao = new Application_Model_DbTable_TipoEmbarcacao();       
                
        $whereTipoEmbarcacao= $this->dbTableTipoEmbarcacao->getAdapter()
                ->quoteInto('"tte_id" = ?', $idTipoEmbarcacao);
        
        $this->dbTableTipoEmbarcacao->delete($whereTipoEmbarcacao);
    }
    
}