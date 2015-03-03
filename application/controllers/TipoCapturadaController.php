<?php

class TipoCapturadaController extends Zend_Controller_Action
{
  private $modelTipoCapturada;
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



        $this->modelTipoCapturada = new Application_Model_TipoCapturadaModel();
    }

    public function indexAction()
    {
        $tipoCapturada = $this->modelTipoCapturada->select( NULL, 'itc_tipo', NULL );

        $this->view->assign("tipoCapturada", $tipoCapturada);
    }
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
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
        $this->modelTipoCapturada->insert($this->_getAllParams());

        $this->_redirect('tipo-capturada/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tipoCapturada = $this->modelTipoCapturada->find($this->_getParam('id'));
        $this->naoexiste($tipoCapturada);
        
        $this->view->assign("tipoCapturada", $tipoCapturada);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelTipoCapturada->update($this->_getAllParams());

        $this->_redirect('tipo-capturada/index');
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
        $this->modelTipoCapturada->delete($this->_getParam('id'));

        $this->_redirect('tipo-capturada/index');
        }
    }
	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelTipoCapturada = new Application_Model_TipoCapturadaModel();
		$localTipoCapturada = $localModelTipoCapturada->select(NULL, array('itc_tipo'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Tipo Capturada');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Tipo Capturada');

		foreach ($localTipoCapturada as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['itc_id']);
			$modeloRelatorio->setValue(80, $localData['itc_tipo']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_tipo_capturada.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}

