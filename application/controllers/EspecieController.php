<?php

/**
 * Controller de Especies
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
require_once "../library/fpdf/fpdf.php";
class EspecieController extends Zend_Controller_Action
{
    private $modelEspecie;
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


        $this->modelEspecie = new Application_Model_Especie();
        $this->modelGenero = new Application_Model_Genero();
    }

    /*
     * Lista todas as artes de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelEspecie->select();

        $this->view->assign("dados", $dados);
    }

    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {   

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dados = $this->modelGenero->select();

        $this->view->assign("dados", $dados);
    }

    /*
     * Cadastra uma Arte de Pesca
     */
    public function criarAction()
    {   
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelEspecie->insert($this->_getAllParams());

        $this->_redirect('especie/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dados = $this->modelGenero->select();

        $this->view->assign("dados", $dados);

        $especie = $this->modelEspecie->find($this->_getParam('id'));

        $this->view->assign("especie", $especie);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelEspecie->update($this->_getAllParams());

        $this->_redirect('especie/index');
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
        $this->modelEspecie->delete($this->_getParam('id'));

        $this->_redirect('especie/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelEspecie = new Application_Model_Especie();
		$localModelGenero = new Application_Model_Genero();
		$localModelFamilia = new Application_Model_Familia();
		$localModelOrdem = new Application_Model_Ordem();
		$localModelGrupo = new Application_Model_Grupo();

		$localGrupo = $localModelGrupo->select(NULL, array('grp_nome'), NULL);
		$localOrdem = $localModelOrdem->select(NULL, array('ord_nome'), NULL);
		$localFamilia = $localModelFamilia->select(NULL, array('fam_nome'), NULL);
		$localGenero = $localModelGenero->select(NULL, array('gen_nome'), NULL);
		$localEspecie = $localModelEspecie->select(NULL, array('esp_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Filogenia de Espécie');
		$modeloRelatorio->setLegendaOff();

		foreach ($localGrupo as $key => $localData) {
			$modeloRelatorio->setLegValue(30, 'Grupo: ', $localData['grp_nome']);
			$modeloRelatorio->setNewLine();

			foreach ($localOrdem as $key_o => $localDataOrdem) {
				if ( $localDataOrdem['grp_id'] ==  $localData['grp_id'] ) {
					$modeloRelatorio->setLegValue(50,'Ordem: ', $localDataOrdem['ord_nome']);
					$modeloRelatorio->setNewLine();

					foreach ($localFamilia as $key_f => $localDataFamilia) {
						if ( $localDataFamilia['ord_id'] ==  $localDataOrdem['ord_id'] ) {
							$modeloRelatorio->setLegValue(70,'Família: ', $localDataFamilia['fam_nome']);
							$modeloRelatorio->setNewLine();

							foreach ($localGenero as $key_f => $localDataGenero ) {
								if ( $localDataGenero['fam_id'] ==  $localDataFamilia['fam_id'] ) {
									$modeloRelatorio->setLegValue(90,'Gênero: ',$localDataGenero['gen_nome']);
									$modeloRelatorio->setNewLine();

									$isPrinted = FALSE;
									foreach ($localEspecie as $key_f => $localDataEspecie ) {
										if ( $localDataGenero['gen_id'] ==  $localDataEspecie['gen_id'] ) {
											if ( $isPrinted == FALSE ) {
												$modeloRelatorio->setLegValue(110, 'Código', '');
												$modeloRelatorio->setLegValue(150, 'Espécie', '');
												$modeloRelatorio->setLegValue(300, 'Nome Comum', '');
												$modeloRelatorio->setLegValue(450, 'Descritor', '');
												$modeloRelatorio->setNewLine();

												$isPrinted = TRUE;
											}
											$modeloRelatorio->setValueAlinhadoDireita(100, 40, $localDataEspecie['esp_id']);
											$modeloRelatorio->setValue(150, $localDataEspecie['esp_nome']);
											$modeloRelatorio->setValue(300, $localDataEspecie['esp_nome_comum']);
											$modeloRelatorio->setValue(450, $localDataEspecie['esp_descritor']);
											$modeloRelatorio->setNewLine();
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_especie.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }

   	public function relatoriolistaAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelEspecie = new Application_Model_Especie();

		$localEspecie = $localModelEspecie->select(NULL, array('esp_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Espécies');

		$modeloRelatorio->setLegenda(30, 'Código', '');
		$modeloRelatorio->setLegenda(80, 'Espécie', '');
		$modeloRelatorio->setLegenda(300, 'Nome Comum', '');
		$modeloRelatorio->setLegenda(450, 'Descritor', '');

		foreach ($localEspecie as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['esp_id']);
			$modeloRelatorio->setValue(80, $localData['esp_nome']);
			$modeloRelatorio->setValue(300, $localData['esp_nome_comum']);
			$modeloRelatorio->setValue(450, $localData['esp_descritor']);
			$modeloRelatorio->setNewLine();
		}

		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_filogenia_especie_lista.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }

}
