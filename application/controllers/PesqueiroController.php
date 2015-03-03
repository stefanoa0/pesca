<?php

class PesqueiroController extends Zend_Controller_Action
{
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


        $this->modelPesqueiro = new Application_Model_Pesqueiro();

    }

    public function indexAction()
    {
        $fromPesqueiro = $this->modelPesqueiro->select();

        $this->view->assign('dadosPesqueiros', $fromPesqueiro);
    }
    public function novoAction(){
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
    }

    public function criarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPesqueiro->insert($this->_getAllParams());

        $this->_redirect('pesqueiro/index');
    }

    public function editarAction(){
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $idPesqueiro = $this->_getParam('id');
        $fromPesqueiro = $this->modelPesqueiro->find($idPesqueiro);

        $this->view->assign('dadosPesqueiros', $fromPesqueiro);
    }
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPesqueiro->update($this->_getAllParams());

        $this->_redirect('pesqueiro/index');
    }


    public function excluirAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }else{
        $idPesqueiro = $this->_getParam('id');

        $this->modelPesqueiro->delete($idPesqueiro);

        $this->_redirect('pesqueiro/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPesqueiro = new Application_Model_Pesqueiro();
		$localPesqueiro = $localModelPesqueiro->select(NULL, array('paf_pesqueiro'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Pesqueiros');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Pesqueiro');

		foreach ($localPesqueiro as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['paf_id']);
			$modeloRelatorio->setValue(80, $localData['paf_pesqueiro']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_pesqueiros.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}

