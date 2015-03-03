<?php

class RendaController extends Zend_Controller_Action
{
      private $modelRenda;
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


        $this->modelRenda = new Application_Model_Renda();
    }
    
    public function indexAction()
    {
        $renda = $this->modelRenda->select(null, 'ren_id', null);

        $this->view->assign("rendas", $renda);
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
        $this->modelRenda->insert($this->_getAllParams());

        $this->_redirect('renda/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $renda = $this->modelRenda->find($this->_getParam('id'));
        $this->naoexiste($renda);
        
        
        $this->view->assign("rendas", $renda);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelRenda->update($this->_getAllParams());

        $this->_redirect('renda/index');
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
        $this->modelRenda->delete($this->_getParam('id'));

        $this->_redirect('renda/index');
        }
    }

	public function relatorioAction() {
	 $this->_helper->layout->disableLayout();
	 $this->_helper->viewRenderer->setNoRender(true);

	 $localModelRenda = new Application_Model_Renda();
	 $localRenda= $localModelRenda->select(NULL, array('ren_renda'), NULL);

	 require_once "../library/ModeloRelatorio.php";
	 $modeloRelatorio = new ModeloRelatorio();
	 $modeloRelatorio->setTitulo('Relatório de Renda');
	 $modeloRelatorio->setLegenda(30, 'Código');
	 $modeloRelatorio->setLegenda(80, 'Renda');

	 foreach ($localRenda as $key => $localData) {
		$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ren_id']);
		$modeloRelatorio->setValue(80, $localData['ren_renda']);
		$modeloRelatorio->setNewLine();
	}
	 $modeloRelatorio->setNewLine();
	 $pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_renda.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

	public function relatoriofatorAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelRenda = new Application_Model_Renda();
		$localRenda= $localModelRenda->select(NULL, array('ren_renda'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Renda');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Renda');
		$modeloRelatorio->setLegenda(320, 'Fator Mínimo');
		$modeloRelatorio->setLegenda(400, 'Fator Máximo');

		foreach ($localRenda as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ren_id']);
			$modeloRelatorio->setValue(80, $localData['ren_renda']);
			$modeloRelatorio->setValueAlinhadoDireita(320, 70, number_format($localData['ren_fatormin'], 2, ',', ' '));
			$modeloRelatorio->setValueAlinhadoDireita(400, 70, number_format($localData['ren_fatormax'], 2, ',', ' '));
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_renda_fator.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}


