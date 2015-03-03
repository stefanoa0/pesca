<?php

class MareController extends Zend_Controller_Action
{
    private $modelMare;
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



        $this->modelMare = new Application_Model_Mare();
    }

    /*
     * Lista todas as areas de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelMare->select( NULL, 'mre_id', NULL );

        $this->view->assign("dados", $dados);
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
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelMare->insert($this->_getAllParams());

        $this->_redirect('mare/index');
    }
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $mares = $this->modelMare->find($this->_getParam('id'));

        $this->view->assign("mare", $mares);
    }

    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelMare->update($this->_getAllParams());

        $this->_redirect('mare/index');
    }
    /*
     * Cadastra uma Area de Pesca
     */


	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
	 $this->_helper->layout->disableLayout();
	 $this->_helper->viewRenderer->setNoRender(true);

	 $localModelMare = new Application_Model_Mare();
	 $localMare = $localModelMare->select(NULL, array('mre_tipo'), NULL);

	 require_once "../library/ModeloRelatorio.php";
	 $modeloRelatorio = new ModeloRelatorio();
	 $modeloRelatorio->setTitulo('Relatório Tipo de Maré');
	 $modeloRelatorio->setLegenda(30, 'Código');
	 $modeloRelatorio->setLegenda(80, 'Tipo de Maré');

	 foreach ($localMare as $key => $localData) {
	  $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['mre_id']);
	  $modeloRelatorio->setValue(80, $localData['mre_tipo']);
	  $modeloRelatorio->setNewLine();
	}
	 $modeloRelatorio->setNewLine();
	 $pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_mare.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}