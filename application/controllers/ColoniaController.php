<?php

/**
 * Controller de Colonias
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class ColoniaController extends Zend_Controller_Action {

    private $modelColonia;
    private $usuario;

    public function init() {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $identity2 = get_object_vars($identity);

        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);



        $this->modelColonia = new Application_Model_Colonia();
        $this->modelComunidade = new Application_Model_Comunidade();
        $this->modelEndereco = new Application_Model_DbTable_Endereco();
        $this->modelMunicipio = new Application_Model_Municipio();
    }

    /*
     * Lista todas as artes de pesca
     */
    public function indexAction() {

        $dados = $this->modelColonia->select( NULL, 'tc_nome', NULL );
        print_r(time());


        $this->view->assign("dados", $dados);
    }

    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    
    public function visualizarAction() {
        $colonia = $this->modelColonia->find($this->_getParam('id'));

        $this->view->assign("colonia", $colonia);
    }

    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $this->view->estados = array("AC", "AL", "AM", "AP",  "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");

        $modelMunicipio = new Application_Model_Municipio();
        $municipios = $modelMunicipio->select();

        $modelComunidade = new Application_Model_Comunidade();
        $comunidades = $modelComunidade->select();

        $this->view->assign("municipios", $municipios);
        $this->view->assign("comunidades", $comunidades);
    }

    /*
     * Cadastra uma Arte de Pesca
     */
    public function criarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelColonia->insert($this->_getAllParams());

        $this->_redirect('colonia/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $colonia = $this->modelColonia->find($this->_getParam('id'));
        $this->naoexiste($colonia);
        
        $municipios = $this->modelMunicipio->select(null, 'tmun_municipio');
        $endereco = $this->modelEndereco->select();
        $comunidades = $this->modelComunidade->select(null, 'tcom_nome');

        $this->view->assign("enderecos", $endereco);
        $this->view->assign("municipios", $municipios);
        $this->view->assign("comunidades", $comunidades);
        $this->view->assign("colonia", $colonia);
        $this->view->estados = array("AC", "AL", "AM", "AP",  "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelColonia->update($this->_getAllParams());

        $this->_redirect('colonia/index');
    }

    /*
     *
     */
    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelColonia->delete($this->_getParam('id'));

        $this->_redirect('colonia/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelColonia = new Application_Model_Colonia();
		$localColonia = $localModelColonia->select(NULL, array('tc_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Colônia');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Colônia');

		foreach ($localColonia as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tc_id']);
			$modeloRelatorio->setValue(80, $localData['tc_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_colonia.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}
