
<?php
//$this->view->headScript()->appendFile('/js/filename.js');
//$this->headScript()->appendFile('/js/funcoes.js');

class TipoTelefoneController extends Zend_Controller_Action
{
      private $modeloTipoTelefone;
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



        $this->modeloTipoTelefone = new Application_Model_TipoTelefone();
    }

    public function indexAction()
    {
        $tipoTelefone = $this->modeloTipoTelefone->select(NULL, 'ttel_desc', NULL);

        $this->view->assign("assignTipoTelefone", $tipoTelefone);
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
        $this->modeloTipoTelefone->insert($this->_getAllParams());

        $this->_redirect('tipo-telefone/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tipoTelefone = $this->modeloTipoTelefone->find($this->_getParam('id'));
        $this->naoexiste($tipoTelefone);
        
        $this->view->assign("assignTipoTelefone", $tipoTelefone);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modeloTipoTelefone->update($this->_getAllParams());

        $this->_redirect('tipo-telefone/index');
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
        $this->modeloTipoTelefone->delete($this->_getParam('id'));

        $this->_redirect('tipo-telefone/index');
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

		Zend_Locale::setDefault('pt_BR');

		$localModelTT = new Application_Model_TipoTelefone();
		$localTT = $localModelTT->select(NULL, array('ttel_desc'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Tipo de Telefones');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Tipo de Telefones');

		foreach ($localTT as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ttel_id']);
			$modeloRelatorio->setValue(80, $localData['ttel_desc']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_tipo_telefone.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

}





