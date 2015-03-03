<?php
require_once "../library/fpdf/fpdf.php";
class TempoController extends Zend_Controller_Action
{
    private $modelTempo;

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



        $this->modelTempo = new Application_Model_Tempo();
    }

    public function indexAction()
    {
        $dados = $this->modelTempo->select();

        $this->view->assign("dados", $dados);
    }

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
        $this->modelTempo->insert($this->_getAllParams());

        $this->_redirect('tempo/index');
    }

    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tempo = $this->modelTempo->find($this->_getParam('id'));

        $this->view->assign("tempo", $tempo);
    }

    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelTempo->update($this->_getAllParams());

        $this->_redirect('tempo/index');
    }

    public function excluirAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelTempo->delete($this->_getParam('id'));

        $this->_redirect('tempo/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelTempo = new Application_Model_Tempo();
		$localTempo = $localModelTempo->select(NULL, array('tmp_estado'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Tempo');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Tempo');

		foreach ($localTempo as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tmp_id']);
			$modeloRelatorio->setValue(80, $localData['tmp_estado']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_tempo.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}
