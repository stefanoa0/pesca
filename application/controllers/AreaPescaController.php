<?php

/**
 * Controller de Áreas de pesca
 * teste
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
require_once "../library/fpdf/fpdf.php";
class AreaPescaController extends Zend_Controller_Action
{
    private $modelAreaPesca;
private $usuario;
    public function init()
    {
        $this->modelUsuario = new Application_Model_Usuario();
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $ArrayIdentity = get_object_vars($identity);

        }


        $this->usuario = $this->modelUsuario->selectLogin($ArrayIdentity['tl_id']);
        $this->view->assign("usuario",$this->usuario);



        $this->modelAreaPesca = new Application_Model_AreaPesca();
    }

    /*
     * Lista todas as areas de pesca
     */
    public function indexAction()
    {
        $areapesca = $this->modelAreaPesca->select( NULL, 'tareap_areapesca', NULL );

        $this->view->assign("area_pesca", $areapesca);
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
    
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    /*
     * Cadastra uma Area de Pesca
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelAreaPesca->insert($this->_getAllParams());

        $this->_redirect('area-pesca/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $areaPesca = $this->modelAreaPesca->find($this->_getParam('id'));
        $this->naoexiste($areaPesca);
        $this->view->assign("areaPesca", $areaPesca);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelAreaPesca->update($this->_getAllParams());

        $this->_redirect('area-pesca/index');
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
        $this->modelAreaPesca->delete($this->_getParam('id'));

        $this->_redirect('area-pesca/index');

        }
   }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelAreaPesca = new Application_Model_AreaPesca();
		$localAreaPesca = $localModelAreaPesca->select(NULL, array('tareap_areapesca'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Area de Pesca');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Area de Pesca');

		foreach ($localAreaPesca as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tareap_id']);
			$modeloRelatorio->setValue(80, $localData['tareap_areapesca']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_area_pesca.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

}
