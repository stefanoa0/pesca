<?php

class IscaController extends Zend_Controller_Action
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

        $this->modelIsca = new Application_Model_Isca();
    }

    public function indexAction()
    {

        $dadosIsca = $this->modelIsca->select(NULL, 'isc_tipo', NULL);

        $this->view->assign("dadosIscas", $dadosIsca);
    }

    public function insertAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id'] == 5){
            
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('isc_tipo' => $this->_getParam("isc_tipo"));

        $this->modelIsca->insert($setupDados);

        $this->_redirect("/isca/index");

        return;
    }
    public function deleteAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id'] == 5){
           
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->modelIsca->delete($this->_getParam('isc_id'));

        $this->_redirect('isca/index');
        }
    }
   	public function relatoriolistaAction() {
            if($this->usuario['tp_id'] == 5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelIsca = new Application_Model_Isca();

		$localIsca = $localModelIsca->select(NULL, array('isc_tipo'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Iscas');

		$modeloRelatorio->setLegenda(30, 'Código', '');
		$modeloRelatorio->setLegenda(80, 'Isca', '');

		foreach ( $localIsca as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['isc_id']);
			$modeloRelatorio->setValue(80, $localData['isc_tipo']);

			$modeloRelatorio->setNewLine();
		}

		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_iscas.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}

