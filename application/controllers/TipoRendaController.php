<?php


class TipoRendaController extends Zend_Controller_Action
{
      private $ModeloTipoRenda;
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



        $this->ModeloTipoRenda = new Application_Model_TipoRenda();
    }

    public function indexAction()
    {
        $tipoRenda = $this->ModeloTipoRenda->select( NULL, 'ttr_descricao', NULL );

        $this->view->assign("assignTipoRenda", $tipoRenda);
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
        $this->ModeloTipoRenda->insert($this->_getAllParams());

        $this->_redirect('tipo-renda/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tipoRenda = $this->ModeloTipoRenda->find($this->_getParam('id'));
        $this->naoexiste($tipoRenda);
        
        
        $this->view->assign("assignTipoRenda", $tipoRenda);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->ModeloTipoRenda->update($this->_getAllParams());

        $this->_redirect('tipo-renda/index');
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
        $this->ModeloTipoRenda->delete($this->_getParam('id'));

        $this->_redirect('tipo-renda/index');
        }
    }

    public function beforeExcluirAction()
    {

    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
	 $this->_helper->layout->disableLayout();
	 $this->_helper->viewRenderer->setNoRender(true);

	 $localModelTRenda = new Application_Model_TipoRenda();
	 $localTRenda= $localModelTRenda->select(NULL, array('ttr_descricao'), NULL);

	 require_once "../library/ModeloRelatorio.php";
	 $modeloRelatorio = new ModeloRelatorio();
	 $modeloRelatorio->setTitulo('Relatório Tipo de Renda');
	 $modeloRelatorio->setLegenda(30, 'Código');
	 $modeloRelatorio->setLegenda(80, 'Tipo de Renda');

	 foreach ($localTRenda as $key => $localData) {
		$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ttr_id']);
		$modeloRelatorio->setValue(80, $localData['ttr_descricao']);
		$modeloRelatorio->setNewLine();
	}
	 $modeloRelatorio->setNewLine();
	 $pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_tipo_renda.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}





