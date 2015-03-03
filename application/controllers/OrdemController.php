<?php

require_once "../library/fpdf/fpdf.php";
class OrdemController extends Zend_Controller_Action
{
    private $modelOrdem;
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



        $this->modelOrdem = new Application_Model_Ordem();
        $this->modelGrupo = new Application_Model_Grupo();
    }

    public function indexAction()
    {
        $dados = $this->modelOrdem->select();

        $this->view->assign("dados", $dados);
    }

    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }

        $dados = $this->modelGrupo->select();

        $this->view->assign("dados", $dados);
    }

    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelOrdem->insert($this->_getAllParams());

        $this->_redirect('ordem/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $grupos = $this->modelGrupo->select();

        $this->view->assign("grupos", $grupos);

        $ordem = $this->modelOrdem->find($this->_getParam('id'));

        $this->view->assign("ordem", $ordem);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelOrdem->update($this->_getAllParams());

        $this->_redirect('ordem/index');
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
        $this->modelOrdem->delete($this->_getParam('id'));

        $this->_redirect('ordem/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelOrdem = new Application_Model_Ordem();
		$localModelGrupo = new Application_Model_Grupo();

		$localGrupo = $localModelGrupo->select(NULL, array('grp_nome'), NULL);
		$localOrdem = $localModelOrdem->select(NULL, array('ord_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Filogenia de Ordem');
		$modeloRelatorio->setLegendaOff();

		foreach ($localGrupo as $key => $localData) {
			$modeloRelatorio->setLegValue(30, 'Grupo: ', $localData['grp_nome']);
			$modeloRelatorio->setNewLine();

			$isPrinted = FALSE;

			foreach ($localOrdem as $key => $localDataOrdem) {
				if ( $localDataOrdem['grp_id'] ==  $localData['grp_id'] ) {
					if ( $isPrinted == FALSE ) {
						$modeloRelatorio->setLegValue(60, 'Código', '');
						$modeloRelatorio->setLegValue(100, 'Ordem', '');
						$modeloRelatorio->setLegValue(250, 'Característica', '');
						$modeloRelatorio->setNewLine();

						$isPrinted = TRUE;
					}

					$modeloRelatorio->setValueAlinhadoDireita(50, 40, $localDataOrdem['ord_id']);
					$modeloRelatorio->setValue(100, $localDataOrdem['ord_nome']);
					$modeloRelatorio->setValue(250, $localDataOrdem['ord_caracteristica']);
					$modeloRelatorio->setNewLine();
				}
			}

		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_ordem.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
	}

   	public function relatoriolistaAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelOrdem = new Application_Model_Ordem();

		$localOrdem = $localModelOrdem->select(NULL, array('ord_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Ordem');

		$modeloRelatorio->setLegenda(30, 'Código', '');
		$modeloRelatorio->setLegenda(80, 'Ordem', '');
		$modeloRelatorio->setLegenda(200, 'Característica', '');

		foreach ($localOrdem as $key_f => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['ord_id']);
			$modeloRelatorio->setValue(80, $localData['ord_nome']);
			$modeloRelatorio->setValue(200, $localData['ord_caracteristica']);
			$modeloRelatorio->setNewLine();
		}

		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_ordem_lista.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
	}

}
