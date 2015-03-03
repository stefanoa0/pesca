<?php

/**
 * Controller de Comunidades
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
require_once "../library/fpdf/fpdf.php";
class ComunidadeController extends Zend_Controller_Action
{
    private $modelComunidade;
private $usuario;
    public function init()
    {
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



        $this->modelComunidade = new Application_Model_Comunidade();
    }

    /*
     * Lista todas as artes de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelComunidade->select( NULL, 'tcom_nome', NULL );

        $this->view->assign("dados", $dados);
    }
    
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
    }

    /*
     * Cadastra uma Arte de Pesca
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelComunidade->insert($this->_getAllParams());

        $this->_redirect('comunidade/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $comunidade = $this->modelComunidade->find($this->_getParam('id'));
        $this->naoexiste($comunidade);
        
        
        $this->view->assign("comunidade", $comunidade);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelComunidade->update($this->_getAllParams());

        $this->_redirect('comunidade/index');
    }

    /*
     *
     */
    public function excluirAction()
    {   
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelComunidade->delete($this->_getParam('id'));
        }
        $this->_redirect('comunidade/index');
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelComunidade = new Application_Model_Comunidade();
		$localComunidade= $localModelComunidade->select(NULL, array('tcom_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Comunidade');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Comunidade');

		foreach ($localComunidade as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tcom_id']);
			$modeloRelatorio->setValue(80, $localData['tcom_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_comunidade.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}
