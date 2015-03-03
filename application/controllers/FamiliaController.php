<?php



class FamiliaController extends Zend_Controller_Action
{
    private $modelFamilia;
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


        $this->modelFamilia = new Application_Model_Familia();
        $this->modelOrdem = new Application_Model_Ordem();
    }

    public function indexAction()
    {
        
        $dados = $this->modelFamilia->select();

        $this->view->assign("dados", $dados);
    }

    public function novoAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dados = $this->modelOrdem->select();

        $this->view->assign("dados", $dados);

    }

    public function criarAction()
    {

        $this->modelFamilia->insert($this->_getAllParams());

        $this->_redirect('familia/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dados = $this->modelOrdem->select();

        $this->view->assign("dados", $dados);

        $familia = $this->modelFamilia->find($this->_getParam('id'));

        $this->view->assign("familia", $familia);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelFamilia->update($this->_getAllParams());

        $this->_redirect('familia/index');
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
        $this->modelFamilia->delete($this->_getParam('id'));

        $this->_redirect('familia/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelFamilia = new Application_Model_Familia();
		$localModelOrdem = new Application_Model_Ordem();
		$localModelGrupo = new Application_Model_Grupo();
		$localGrupo = $localModelGrupo->select(NULL, array('grp_nome'), NULL);
		$localOrdem = $localModelOrdem->select(NULL, array('ord_nome'), NULL);
		$localFamilia = $localModelFamilia->select(NULL, array('fam_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Filogenia de Família');
		$modeloRelatorio->setLegendaOff();

		foreach ($localGrupo as $key => $localData) {
			$modeloRelatorio->setLegValue(30, 'Grupo: ', $localData['grp_nome']);
			$modeloRelatorio->setNewLine();

			foreach ($localOrdem as $key_o => $localDataOrdem) {
				if ( $localDataOrdem['grp_id'] ==  $localData['grp_id'] ) {
					$modeloRelatorio->setLegValue(50,'Ordem: ', $localDataOrdem['ord_nome']);
					$modeloRelatorio->setNewLine();

					$isPrinted = FALSE;
					foreach ($localFamilia as $key_f => $localDataFamilia) {
						if ( $localDataFamilia['ord_id'] ==  $localDataOrdem['ord_id'] ) {
							if ( $isPrinted == FALSE ) {
								$modeloRelatorio->setLegValue(80, 'Código', '');
								$modeloRelatorio->setLegValue(120, 'Família', '');
								$modeloRelatorio->setLegValue(250, 'Tipo', '');
								$modeloRelatorio->setNewLine();

								$isPrinted = TRUE;
							}

							$modeloRelatorio->setValueAlinhadoDireita(70, 40, $localDataFamilia['fam_id']);
							$modeloRelatorio->setValue(120, $localDataFamilia['fam_nome']);
							$modeloRelatorio->setValue(250, $localDataFamilia['fam_tipo']);
							$tmpCaracteristica = $localDataFamilia['fam_caracteristica'];
							if ( sizeof($tmpCaracteristica) > 0 ) {
								$modeloRelatorio->setNewLine();
								if (strlen($tmpCaracteristica) > 100 ) {
									$tmp1 = substr($tmpCaracteristica, 0, 100);
									$tmp2 = substr($tmpCaracteristica, 101, strlen($tmpCaracteristica)+1);
									$modeloRelatorio->setLegValue(120,'Caract.: ', $tmp1);
									$modeloRelatorio->setNewLine();
									$modeloRelatorio->setLegValue(120,'', $tmp2);

								} else {
									$modeloRelatorio->setLegValue(120,'Caract.: ', $tmpCaracteristica);
								}
							}
							$modeloRelatorio->setNewLine();
						}
					}
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_familia.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }

   	public function relatoriolistaAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelFamilia = new Application_Model_Familia();

		$localFamilia = $localModelFamilia->select(NULL, array('fam_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Famílias');

		$modeloRelatorio->setLegenda(30, 'Código', '');
		$modeloRelatorio->setLegenda(80, 'Família', '');
		$modeloRelatorio->setLegenda(300, 'Tipo', '');

		foreach ($localFamilia as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fam_id']);
			$modeloRelatorio->setValue(80, $localData['fam_nome']);
			$modeloRelatorio->setValue(300, $localData['fam_tipo']);
			$tmpCaracteristica = $localData['fam_caracteristica'];
			if ( sizeof($tmpCaracteristica) > 0 ) {
				$modeloRelatorio->setNewLine();
				if (strlen($tmpCaracteristica) > 100 ) {
					$tmp1 = substr($tmpCaracteristica, 0, 100);
					$tmp2 = substr($tmpCaracteristica, 101, strlen($tmpCaracteristica)+1);
					$modeloRelatorio->setLegValue(80,'Caract.: ', $tmp1);
					$modeloRelatorio->setNewLine();
					$modeloRelatorio->setLegValue(80,'', $tmp2);
				} else {
					$modeloRelatorio->setLegValue(80,'Caract.: ', $tmpCaracteristica);
				}
			}
			$modeloRelatorio->setNewLine();
		}

		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_familia_lista.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}
