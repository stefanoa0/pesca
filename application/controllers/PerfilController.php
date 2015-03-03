<?php

class PerfilController extends Zend_Controller_Action {

    private $ModeloPerfil;
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


        $this->ModeloPerfil = new Application_Model_Perfil();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosPerfil = $this->ModeloPerfil->select(NULL, 'tp_perfil', NULL);

        $this->view->assign("assignPerfil", $dadosPerfil);
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

        $this->ModeloPerfil->delete($this->_getParam('tp_id'));

        $this->_redirect('perfil/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tp_perfil' => $this->_getParam("tp_perfil"));

        $this->ModeloPerfil->insert($setupDados);

        $this->_redirect("/perfil/index");

        return;
    }

    public function updateAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tp_id' => $this->_getParam("tp_id"),
            'tp_perfil' => $this->_getParam("tp_perfil")
        );

        $this->ModeloPerfil->update($setupDados);

        $this->_redirect("/perfil/index");

        return;
    }

    public function relatorioAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPerfil = new Application_Model_Perfil();
		$localPerfil = $localModelPerfil->select(NULL, array('tp_perfil'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Perfil');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Perfil');

		foreach ($localPerfil as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tp_id']);
			$modeloRelatorio->setValue(80, $localData['tp_perfil']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_perfil_usuarios.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

}
