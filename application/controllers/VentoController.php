<?php
require_once "../library/fpdf/fpdf.php";
class VentoController extends Zend_Controller_Action
{
    private $modelVento;
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



        $this->modelVento = new Application_Model_Vento();
    }

    public function indexAction()
    {
        
        $dados = $this->modelVento->select();

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
        $this->modelVento->insert($this->_getAllParams());

        $this->_redirect('vento/index');
    }

    public function editarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $vento = $this->modelVento->find($this->_getParam('id'));

        $this->view->assign("vento", $vento);
    }

    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelVento->update($this->_getAllParams());

        $this->_redirect('vento/index');
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
        $this->modelVento->delete($this->_getParam('id'));

        $this->_redirect('vento/index');
        }
    }


	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelVento = new Application_Model_Vento();
		$localVento = $localModelVento->select(NULL, array('vnt_forca'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Intensidade do Vento');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Intensidade do Vento');

		foreach ($localVento as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['vnt_id']);
			$modeloRelatorio->setValue(80, $localData['vnt_forca']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_vento.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}
