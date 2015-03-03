<?php

/**
 * Controller de Artes de Pesca
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class ArtePescaController extends Zend_Controller_Action
{
    private $modelArtePesca;
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
          //Converte do objeto para um array (tem que ser feito)
          $identity2 = get_object_vars($identity);

        }

        $this->modelUsuario = new Application_Model_Usuario();
        //Busca o usuário no banco pelo id do login
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);

        $this->modelArtePesca = new Application_Model_ArtePesca();
    }
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    /*
     * Lista todas as artes de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelArtePesca->select( NULL, 'tap_artepesca', NULL );

        $this->view->assign("dados", $dados);

    }

    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {
        //Verificar se o usuário logado é estagiário
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
        $this->modelArtePesca->insert($this->_getAllParams());

        $this->_redirect('arte-pesca/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        //Verificar se o usuário logado é estagiário
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $artePesca = $this->modelArtePesca->find($this->_getParam('id'));
        $this->naoexiste($artePesca);
        $this->view->assign("artePesca", $artePesca);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelArtePesca->update($this->_getAllParams());

        $this->_redirect('arte-pesca/index');
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
        $this->modelArtePesca->delete($this->_getParam('id'));
        }
        $this->_redirect('arte-pesca/index');
    }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelArtePesca = new Application_Model_ArtePesca();
		$localArtePesca = $localModelArtePesca->select(NULL, array('tap_artepesca'), NULL);

		require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Arte de Pesca');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Arte de Pesca');

		foreach ($localArtePesca as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tap_id']);
			$modeloRelatorio->setValue(80, $localData['tap_artepesca']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_arte_pesca.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

}
