<?php

/**
 * Model Usuario
 *
 * @package Pesca
 * @subpackage Models
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
class Application_Model_Usuario {

    public function select($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_Usuario();
        $select = $dao->select()->from($dao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }

    public function selectView($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_VUsuario();
        $select = $dao->select()->from($dao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }

    public function find($id) {
        $dao = new Application_Model_DbTable_VUsuario();
        $arr = $dao->find($id)->toArray();
        return $arr[0];
    }
    public function selectLogin($loginId){
        $usuario = new Application_Model_DbTable_VUsuario();
        $zendObj = $usuario->select()->from($usuario)->where("tl_id= ".$loginId);

        $array = $usuario->fetchAll($zendObj)->toArray();
        return $array[0];
    }
    public function selectNomeLogin($login){
        $selectLogin = new Application_Model_DbTable_Login();
        $zendObj = $selectLogin->select()->where("tl_login ='".$login."'");
        
        $array = $selectLogin->fetchAll($zendObj)->toArray();
        return $array[0];
        
    }
    public function selectSenha($loginId){
        $usuario = new Application_Model_DbTable_Login();
        $zendObj = $usuario->select()->from($usuario)->where("tl_id= ".$loginId);

        $array = $usuario->fetchAll($zendObj)->toArray();
        return $array[0];
    }

    public function insert(array $request) {

        $dbTableEndereco = new Application_Model_DbTable_Endereco();

        $dataCEP = $request['cep'];
        $dataCEP = trim($dataCEP, "_-");

        if (!$dataCEP)
            $dataCEP = NULL;

        $dadosEndereco = array(
            'te_logradouro' => $request['logradouro'],
            'te_numero' => $request['numero'],
            'te_bairro' => $request['bairro'],
            'te_cep' => $dataCEP,
            'te_comp' => $request['complemento'],
            'tmun_id' => $request['municipio']
        );

        $idEndereco = $dbTableEndereco->insert($dadosEndereco);

        $dbTableLogin = new Application_Model_DbTable_Login();
        $dadosLogin = array(
            'tl_login' => $request['login'],
            'tl_hashsenha' => sha1($request['login'])
        );

        $idLogin = $dbTableLogin->insert($dadosLogin);

        $dbTableUsuario = new Application_Model_DbTable_Usuario();

        $dadosUsuario = array(
            'tp_id' => $request['perfil'],
            'te_id' => $idEndereco,
            'tl_id' => $idLogin,
            'tu_nome' => $request['nome'],
            'tu_sexo' => $request['sexo'],
            'tu_rg' => $request['rg'],
            'tu_cpf' => $request['cpf'],
            'tu_email' => $request['email'],
            'tu_telres' => $request['telefoneResidencial'],
            'tu_telcel' => $request['telefoneCelular']
        );

        $dbTableUsuario->insert($dadosUsuario);

        return;
    }

    public function update(array $request) {
        $dbTableUsuario = new Application_Model_DbTable_Usuario();
        $dbTableEndereco = new Application_Model_DbTable_Endereco();

        $dadosEndereco = array(
            'te_logradouro' => $request['logradouro'],
            'te_numero' => $request['numero'],
            'te_bairro' => $request['bairro'],
            'te_cep' => $request['cep'],
            'te_comp' => $request['complemento'],
            'tmun_id' => $request['municipio']
        );

        $dadosUsuario = array(
            'tp_id' => $request['perfil'],
            'tu_nome' => $request['nome'],
            'tu_sexo' => $request['sexo'],
            'tu_rg' => $request['rg'],
            'tu_cpf' => $request['cpf'],
            'tu_email' => $request['email'],
            'tu_telres' => $request['telefoneResidencial'],
            'tu_telcel' => $request['telefoneCelular']
        );

        $whereUsuario = $dbTableUsuario->getAdapter()->quoteInto('"tu_id" = ?', $request['idUsuario']);
        $whereEndereco = $dbTableEndereco->getAdapter()->quoteInto('"te_id" = ?', $request['idEndereco']);

        $dbTableUsuario->update($dadosUsuario, $whereUsuario);
        $dbTableEndereco->update($dadosEndereco, $whereEndereco);
    }

    public function delete($idUsuario) {
        $dbTableUsuario = new Application_Model_DbTable_Usuario();

        $dadosUsuario = array(
            'tu_usuariodeletado' => TRUE
        );

        $whereUsuario = $dbTableUsuario->getAdapter()->quoteInto('"tu_id" = ?', $idUsuario);

        $dbTableUsuario->update($dadosUsuario, $whereUsuario);
    }
    
    public function insertLogin($idUsuario){
        date_default_timezone_set('America/Bahia');
        $dbTableLogin = new Application_Model_DbTable_HistoricoLogin();
        
        $datahoraLogin = date('d-m-Y').' '.date('H:i:s');
        $dadosLogin = array (
            'tu_id' => $idUsuario,
            'thl_dhlogin' => $datahoraLogin
            
        );
         $idHistorico = $dbTableLogin->insert($dadosLogin);
         return $idHistorico;
    }
    public function updateLogin($lastLogin,$idUsuario){
        date_default_timezone_set('America/Bahia');
        $dbTableLogin = new Application_Model_DbTable_HistoricoLogin();
        
        $datahoraLogin = date('d-m-Y').' '.date('H:i:s');
        $dadosLogin = array (
            'thl_dhlogoff' => $datahoraLogin
        );
         $where[] = "tu_id = ".$idUsuario;
         $where[] = "thl_id = ".$lastLogin;
         
        $dbTableLogin->update($dadosLogin, $where);
    }

    
}
