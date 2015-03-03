<?php
/** 
 * Model Especies Capturadas
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_EspecieCapturada
{
    private $dbTableEspecieCapturada;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableEspecieCapturada = new Application_Model_DbTable_Especie();
        $select = $this->dbTableEspecieCapturada->select()
                ->from($this->dbTableEspecieCapturada)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEspecie->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableEspecie = new Application_Model_DbTable_Especie();
        $arr = $this->dbTableEspecie->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableEspecie = new Application_Model_DbTable_Especie();
        $this->dbTableGenero = new Application_Model_DbTable_Genero();
        
        $dadosEspecie = array(
            'esp_nome'			=> $request['nome_especie'],
            'esp_descritor'		=> $request['descritor_especie'],
            'esp_nome_comum'	=> $request['nome_comum'], 
            'gen_id'			=> $request['select_genero_especie']
        );
        
        $this->dbTableEspecie->insert($dadosEspecie);
        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableEspecie = new Application_Model_DbTable_Especie();
        
        $dadosEspecie = array(
            'esp_nome'			=> $request['nome_especie'],
            'esp_descritor'		=> $request['descritor_especie'],
            'esp_nome_comum'	=> $request['nome_comum'], 
            'gen_id'			=> $request['select_genero_especie']
        );
 
        
        $whereEspecie= $this->dbTableEspecie->getAdapter()->quoteInto('"esp_id" = ?', $request['id_especie']);
        
        
        $this->dbTableEspecie->update($dadosEspecie, $whereEspecie);
    }
    
    public function delete($idEspecie)
    {
        $this->dbTableEspecie = new Application_Model_DbTable_Especie();       
                
        $whereEspecie= $this->dbTableEspecie->getAdapter() ->quoteInto('"esp_id" = ?', $idEspecie);
        
        $this->dbTableEspecie->delete($whereEspecie);
    }


}

