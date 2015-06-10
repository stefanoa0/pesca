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
        
        $this->modelPorto = new Application_Model_Porto();
        $this->modelArrasto = new Application_Model_ArrastoFundo();
        $this->modelCalao= new Application_Model_Calao();
        $this->modelColeta= new Application_Model_ColetaManual();
        $this->modelEmalhe= new Application_Model_Emalhe();
        $this->modelGrosseira= new Application_Model_Grosseira();
        $this->modelJerere= new Application_Model_Jerere();
        $this->modelLinha= new Application_Model_Linha();
        $this->modelLinhaFundo= new Application_Model_LinhaFundo();
        $this->modelManzua= new Application_Model_Manzua();
        $this->modelMergulho= new Application_Model_Mergulho();
        $this->modelRatoeira= new Application_Model_Ratoeira();
        $this->modelSiripoia= new Application_Model_Siripoia();
        $this->modelTarrafa= new Application_Model_Tarrafa();
        $this->modelVaraPesca =  new Application_Model_VaraPesca();
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
    
    public function indexrelatorioAction() {
        $especie = $this->modelEspecie->select(null, 'esp_nome_comum');
        
        $esp_id = $this->_getParam('esp_id');
        if(empty($esp_id)){
            $esp_id = 0;
        }
        $arrayEspCaptArrasto = $this->modelArrasto->selectArrastoHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptCalao = $this->modelCalao->selectCalaoHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptColeta = $this->modelColeta->selectColetaManualHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptEmalhe = $this->modelEmalhe->selectEmalheHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptGrosseira = $this->modelGrosseira->selectGrosseiraHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptJerere = $this->modelJerere->selectJerereHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptLinha = $this->modelLinha->selectLinhaHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptLinhaFundo = $this->modelLinhaFundo->selectLinhaFundoHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptManzua = $this->modelManzua->selectManzuaHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptMergulho = $this->modelMergulho->selectMergulhoHasEspCapturadas('esp_id = '. $esp_id); 
        $arrayEspCaptRatoeira = $this->modelRatoeira->selectRatoeiraHasEspCapturadas('esp_id = '. $esp_id); 
        $arrayEspCaptSiripoia = $this->modelSiripoia->selectSiripoiaHasEspCapturadas('esp_id = '. $esp_id);
        $arrayEspCaptTarrafa = $this->modelTarrafa->selectTarrafaHasEspCapturadas('esp_id = '. $esp_id); 
        $arrayEspCaptVaraPesca = $this->modelVaraPesca ->selectVaraPescaHasEspCapturadas('esp_id = '. $esp_id);  
        
       
        $this->view->assign("arrayEspArrasto", $arrayEspCaptArrasto);
        $this->view->assign("arrayEspCalao",$arrayEspCaptCalao);
        $this->view->assign("arrayEspColeta",$arrayEspCaptColeta); 
        $this->view->assign("arrayEspEmalhe",$arrayEspCaptEmalhe);
        $this->view->assign("arrayEspGrosseira",$arrayEspCaptGrosseira);
        $this->view->assign("arrayEspJerere",$arrayEspCaptJerere);
        $this->view->assign("arrayEspLinha",$arrayEspCaptLinha);
        $this->view->assign("arrayEspLinhaFundo",$arrayEspCaptLinhaFundo);
        $this->view->assign("arrayEspManzua",$arrayEspCaptManzua);
        $this->view->assign("arrayEspMergulho",$arrayEspCaptMergulho );
        $this->view->assign("arrayEspRatoeira",$arrayEspCaptRatoeira );
        $this->view->assign("arrayEspSiripoia",$arrayEspCaptSiripoia );
        $this->view->assign("arrayEspTarrafa",$arrayEspCaptTarrafa );
        $this->view->assign("arrayEspVaraPesca",$arrayEspCaptVaraPesca);
        $this->view->assign("especie", $especie);
        
    }
    
    public function selectespeciesAction(){
        $esp_id = $this->_getParam('esp_id');

        $this->_redirect('especie/tableespc/esp_id/'.$esp_id);
    }
    public function addKey($array, $id, $arte){
        
        for($i=0; $i<sizeof($array); $i++){
            $array[$i]['entr'] = $array[$i][$id];
            $array[$i]['arte'] = $arte[$i][$id];
        }
        
        return $array;
        
    }
    public function tableespcAction(){
        $this->_helper->layout->disableLayout();
        
        
        $this->indexrelatorioAction();        
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
