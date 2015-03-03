<?php
/** 
 * Model Fichas Diarias
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_FichaDiaria
{
    private $dbTableFichaDiaria;
    private $dbTableFichaDiariaView;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();
        $select = $this->dbTableFichaDiaria->select()
                ->from($this->dbTableFichaDiaria)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableFichaDiaria->fetchAll($select)->toArray();
    }
    
    public function selectView($where = null, $order = null, $limit = null)
    {
        $this->dbTableFichaDiariaView = new Application_Model_DbTable_VFichaDiaria();
        $select = $this->dbTableFichaDiariaView->select()
                ->from($this->dbTableFichaDiariaView)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableFichaDiariaView->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();
        $arr = $this->dbTableFichaDiaria->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();
        $this->dbTablePorto = new Application_Model_DbTable_Porto();
        $this->dbTableEstagiario = new Application_Model_Usuario();
        $this->dbTableMonitor = new Application_Model_Usuario();
        
        
        $dadosFichaDiaria = array(
            
            't_estagiario_tu_id' => $request['select_nome_estagiario'],
            't_monitor_tu_id1' => $request['select_nome_monitor'],
            'fd_data' => $request['data_ficha'], 
            'fd_turno' => $request['select_turno'],
            'obs' => $request['obs'],
            'pto_id' => $request['select_nome_porto'],
            'tmp_id' => $request['select_tempo'],
            'vnt_id' => $request['select_vento']
        );
        
        $idFicha = $this->dbTableFichaDiaria->insert($dadosFichaDiaria);
        return $idFicha;
    }
    
    public function update(array $request)
    {
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();
        
        $dadosFichaDiaria = array(
            
            't_estagiario_tu_id' => $request['select_nome_estagiario'],
            't_monitor_tu_id1' => $request['select_nome_monitor'],
            'fd_data' => $request['data_ficha'], 
            'fd_turno' => $request['select_turno'],
            'obs' => $request['obs'],
            'pto_id' => $request['select_nome_porto'],
            'tmp_id' => $request['select_tempo'],
            'vnt_id' => $request['select_vento']
        );
 
        
        $whereFichaDiaria= $this->dbTableFichaDiaria->getAdapter()
                ->quoteInto('"fd_id" = ?', $request['id_fichaDiaria']);
        
        
        $this->dbTableFichaDiaria->update($dadosFichaDiaria, $whereFichaDiaria);
    }
    
    public function delete($idFichaDiaria)
    {
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();       
                
        $whereFichaDiaria= $this->dbTableFichaDiaria->getAdapter()
                ->quoteInto('"fd_id" = ?', $idFichaDiaria);
        
        $this->dbTableFichaDiaria->delete($whereFichaDiaria);
    }
    public function selectId(){
        $this->dbTableFichaDiaria = new Application_Model_DbTable_FichaDiaria();
        
        $select = $this->dbTableFichaDiaria->select()
                ->from($this->dbTableFichaDiaria, 'fd_id')->order('fd_id DESC')->limit('1');
        
        return $this->dbTableFichaDiaria->fetchAll($select)->toArray();
    }
    
}

