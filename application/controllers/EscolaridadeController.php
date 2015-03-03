<?php

class EscolaridadeController extends Zend_Controller_Action
{
      private $modelEscolaridade;
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



        $this->modelEscolaridade = new Application_Model_Escolaridade();
    }

    public function indexAction()
    {
        $escolaridade = $this->modelEscolaridade->select( NULL, 'esc_nivel', NULL );

        $this->view->assign("escolaridades", $escolaridade);
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
        $this->modelEscolaridade->insert($this->_getAllParams());

        $this->_redirect('escolaridade/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $escolaridade = $this->modelEscolaridade->find($this->_getParam('id'));
        $this->naoexiste($escolaridade);
        
        $this->view->assign("escolaridades", $escolaridade);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelEscolaridade->update($this->_getAllParams());

        $this->_redirect('escolaridade/index');
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
        $this->modelEscolaridade->delete($this->_getParam('id'));

        $this->_redirect('escolaridade/index');
        }

   }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelEscolaridade = new Application_Model_Escolaridade();
		$localEscolaridade = $localModelEscolaridade->select(NULL, array('esc_nivel'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Escolaridade');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Escolaridade');

		foreach ($localEscolaridade as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['esc_id']);
			$modeloRelatorio->setValue(80, $localData['esc_nivel']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_escolaridade.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

}




