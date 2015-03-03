<?php

/**
 * Controller de Tipo de Embarcação
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
require_once "../library/fpdf/fpdf.php";
class TipoEmbarcacaoController extends Zend_Controller_Action
{
    private $modelTipoEmbarcacao;
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



        $this->modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
    }

    /*
     * Lista todas as artes de pesca
     */
    public function indexAction()
    {
        $dados = $this->modelTipoEmbarcacao->select( NULL, 'tte_tipoembarcacao', NULL );

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
    }

    /*
     * Cadastra uma Arte de Pesca
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelTipoEmbarcacao->insert($this->_getAllParams());

        $this->_redirect('tipo-embarcacao/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $tipoEmbarcacao = $this->modelTipoEmbarcacao->find($this->_getParam('id'));
        $this->naoexiste($tipoEmbarcacao);
        
        $this->view->assign("tipoEmbarcacao", $tipoEmbarcacao);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelTipoEmbarcacao->update($this->_getAllParams());

        $this->_redirect('tipo-embarcacao/index');
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
        $this->modelTipoEmbarcacao->delete($this->_getParam('id'));

        $this->_redirect('tipo-embarcacao/index');
        }
    }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
		$localTipoEmbarcacao = $localModelTipoEmbarcacao->select(NULL, array('tte_tipoembarcacao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Tipo de Embarcação');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Tipo de Embarcação');

		foreach ($localTipoEmbarcacao as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tte_id']);
			$modeloRelatorio->setValue(80, $localData['tte_tipoembarcacao']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_tipo_embarcacoes.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

}
