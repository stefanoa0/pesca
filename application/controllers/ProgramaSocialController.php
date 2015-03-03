<?php

class ProgramaSocialController extends Zend_Controller_Action
{
      private $modelProgramaSocial;
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



        $this->modelProgramaSocial = new Application_Model_ProgramaSocial();
    }

    public function indexAction()
    {
        $programaSocial = $this->modelProgramaSocial->select( NULL, 'prs_programa', NULL );

        $this->view->assign("programasSocial", $programaSocial);
    }

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
        $this->modelProgramaSocial->insert($this->_getAllParams());

        $this->_redirect('programa-social/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $programaSocial = $this->modelProgramaSocial->find($this->_getParam('id'));
        $this->naoexiste($programaSocial);
        
        $this->view->assign("programasSocial", $programaSocial);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelProgramaSocial->update($this->_getAllParams());

        $this->_redirect('programa-social/index');
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
        $this->modelProgramaSocial->delete($this->_getParam('id'));

        $this->_redirect('programa-social/index');
        }
    }

	public function relatorioAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPS = new Application_Model_ProgramaSocial();
		$localPS= $localModelPS->select(NULL, array('prs_programa'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Programa Social');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Programa Social');

		foreach ($localPS as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['prs_id']);
			$modeloRelatorio->setValue(80, $localData['prs_programa']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_programa_social.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

}


