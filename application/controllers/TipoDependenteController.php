<?php
//$this->view->headScript()->appendFile('/js/filename.js');
//$this->headScript()->appendFile('/js/funcoes.js');

class TipoDependenteController extends Zend_Controller_Action
{
      private $modeloTipoDependente;
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



        $this->modeloTipoDependente = new Application_Model_TipoDependente();
    }

    public function indexAction()
    {
        $tipoDependente = $this->modeloTipoDependente->select(NULL,'ttd_tipodependente',NULL);

        $this->view->assign("assignTipoDependente", $tipoDependente);
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
        $this->modeloTipoDependente->insert($this->_getAllParams());

        $this->_redirect('tipo-dependente/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tipoDependente = $this->modeloTipoDependente->find($this->_getParam('id'));
        $this->naoexiste($tipoDependente);
        
        $this->view->assign("assignTipoDependente", $tipoDependente);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modeloTipoDependente->update($this->_getAllParams());

        $this->_redirect('tipo-dependente/index');
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
        $this->modeloTipoDependente->delete($this->_getParam('id'));

        $this->_redirect('tipo-dependente/index');
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

		$localModelTD = new Application_Model_TipoDependente();
		$localTD = $localModelTD->select(NULL, array('ttd_tipodependente'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Tipo de Dependente');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Tipo de Dependente');

		foreach ($localTD as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ttd_id']);
			$modeloRelatorio->setValue(80, $localData['ttd_tipodependente']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_tipo_dependente.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}





