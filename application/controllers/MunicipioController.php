<?php

/**
 * Controller de Municipios
 * teste
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
require_once "../library/fpdf/fpdf.php";
class MunicipioController extends Zend_Controller_Action
{
    private $modelMunicipio;
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



        $this->modelMunicipio = new Application_Model_Municipio();
    }

    /*
     * Lista todas as areas de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelMunicipio->select( NULL, array('tuf_sigla','tmun_municipio'), NULL );

        $this->view->assign("dados", $dados);
    }
    
    
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $this->view->estados = array("AC", "AL", "AM", "AP",  "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");
    }

    /*
     * Cadastra uma Area de Pesca
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelMunicipio->insert($this->_getAllParams());

        $this->_redirect('municipio/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $municipio = $this->modelMunicipio->find($this->_getParam('id'));
        $this->naoexiste($municipio);
        
        $this->view->estados = array("AC", "AL", "AM", "AP",  "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");
        $this->view->assign("municipio", $municipio);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelMunicipio->update($this->_getAllParams());

        $this->_redirect('municipio/index');
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
        $this->modelMunicipio->delete($this->_getParam('id'));

        $this->_redirect('municipio/index');
        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
	 $this->_helper->layout->disableLayout();
	 $this->_helper->viewRenderer->setNoRender(true);

	 $localModelMunicipio = new Application_Model_Municipio();
	 $localMunicipio = $localModelMunicipio->select(NULL, array('tuf_sigla', 'tmun_municipio'), NULL);

	 require_once "../library/ModeloRelatorio.php";
	 $modeloRelatorio = new ModeloRelatorio();
	 $modeloRelatorio->setTitulo('Relatório de Município');
	 $modeloRelatorio->setLegenda(30, 'Código');
	 $modeloRelatorio->setLegenda(80, 'UF');
	 $modeloRelatorio->setLegenda(110, 'Município');

	 foreach ($localMunicipio as $key => $localData) {
	  $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tmun_id']);
	  $modeloRelatorio->setValue(80, $localData['tuf_sigla']);
	  $modeloRelatorio->setValue(110, $localData['tmun_municipio']);
	  $modeloRelatorio->setNewLine();
	}
	 $modeloRelatorio->setNewLine();
	 $pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_municipios.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }


}

