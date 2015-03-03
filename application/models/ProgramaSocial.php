<?php

class Application_Model_ProgramaSocial
{
    private $dbTableProgramaSocial;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableProgramaSocial = new Application_Model_DbTable_ProgramaSocialDbtable();
        
        $select = $this->dbTableProgramaSocial->select()->from($this->dbTableProgramaSocial)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableProgramaSocial->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableProgramaSocial = new Application_Model_DbTable_ProgramaSocialDbtable();
        $arr = $this->dbTableProgramaSocial->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableProgramaSocial = new Application_Model_DbTable_ProgramaSocialDbtable();
        
        $dadosProgramaSocial = array( 'prs_programa' => $request['nomeProgramaSocial' ] );
        
        $this->dbTableProgramaSocial->insert($dadosProgramaSocial);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableProgramaSocial = new Application_Model_DbTable_ProgramaSocialDbtable();
        
        $dadosProgramaSocial = array( 'prs_programa' => $request['nomeProgramaSocial' ] );
        
        $whereProgrmaSocial= $this->dbTableProgramaSocial->getAdapter() ->quoteInto('"prs_id" = ?', $request['idProgramaSocial']);
        
        $this->dbTableProgramaSocial->update($dadosProgramaSocial, $whereProgrmaSocial);
    }
    
    public function delete($idProgramaSocial)
    {
        $this->dbTableProgramaSocial = new Application_Model_DbTable_ProgramaSocialDbtable();       
                
        $whereProgrmaSocial= $this->dbTableProgramaSocial->getAdapter()->quoteInto('"prs_id" = ?', $idProgramaSocial);
        
        $this->dbTableProgramaSocial->delete($whereProgrmaSocial);
    }
}

