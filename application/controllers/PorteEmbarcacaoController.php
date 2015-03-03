<?php

class PorteEmbarcacaoController extends Zend_Controller_Action
{
      private $modelPorteEmbarcacao;
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



        $this->modelPorteEmbarcacao = new Application_Model_PorteEmbarcacao();
    }

    public function indexAction()
    {
        $dados = $this->modelPorteEmbarcacao->select();

        $this->view->assign("dados", $dados);
    }
    
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }

    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
    }

    /*
     * Cadastra uma Area de Pesca
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorteEmbarcacao->insert($this->_getAllParams());
        
        $this->_redirect('porte-embarcacao/index');
    }
    
    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $porteEmb = $this->modelPorteEmbarcacao->find($this->_getParam('id'));
        $this->naoexiste($porteEmb);
        
        $this->view->assign("porteEmbarcacao", $porteEmb);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorteEmbarcacao->update($this->_getAllParams());

        $this->_redirect('porte-embarcacao/index');
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
        $this->modelPorteEmbarcacao->delete($this->_getParam('id'));

        $this->_redirect('porte-embarcacao/index');

        }
    }

	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPorteEmbarcacao = new Application_Model_PorteEmbarcacao();
		$localPorteEmbarcacao = $localModelPorteEmbarcacao->select(NULL, array('tpe_porte'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Porte da Embarcação');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Porte da Embarcação');

		foreach ($localPorteEmbarcacao as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tpe_id']);
			$modeloRelatorio->setValue(80, $localData['tpe_porte']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_porte_embarcacoes.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}

