<?php

class DestinoPescadoController extends Zend_Controller_Action {

    private $ModeloDestinoPescado;
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


        $this->ModeloDestinoPescado = new Application_Model_DestinoPescado();
    }

    public function indexAction() {
         if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosDestinoPescado = $this->ModeloDestinoPescado->select(NULL, 'dp_destino', NULL);

        $this->view->assign("assignDestinoPescado", $dadosDestinoPescado);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
         if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->ModeloDestinoPescado->delete($this->_getParam('dp_id'));

        $this->_redirect('destino-pescado/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('dp_destino' => $this->_getParam("dp_destino"));

        $this->ModeloDestinoPescado->insert($setupDados);

        $this->_redirect("/destino-pescado/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'dp_id' => $this->_getParam("dp_id"),
            'dp_destino' => $this->_getParam("dp_destino")
        );

        $this->ModeloDestinoPescado->update($setupDados);

        $this->_redirect("/destino-pescado/index");

        return;
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelDP = new Application_Model_DestinoPescado();
		$localDP = $localModelDP->select(NULL, array('dp_destino'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Destino do Pescado');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Destino do Pescado');

		foreach ($localDP as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['dp_id']);
			$modeloRelatorio->setValue(80, $localData['dp_destino']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_destino_pescado.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
	}
}
