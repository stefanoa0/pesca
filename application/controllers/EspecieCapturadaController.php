<?php

class EspecieCapturadaController extends Zend_Controller_Action
{
    private $modelEspecieCapturada;
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
        $this->modelEpecieCapturada = new Application_Model_EspecieCapturada();
    }

    /*
     * Lista todas as artes de pesca
     */
    public function indexAction()
    {        
        $dados = $this->modelEspecieCapturada->select();
      
        $this->view->assign("dados", $dados);
    }
    
    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {
        $dados = $this->modelEspecie->select();
      
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
        $this->modelEspecie->delete($this->_getParam('id'));

        $this->_redirect('especie/index');
    }
    
}

class PDF Extends FPDF{
       
    function Header(){
        
        
        $view = "Pescador";
        $width = 30;
        $height = 7;
        $same_line = 0;
        $next_line = 1;
        $border_false = 0;
        $y = 0;

        date_default_timezone_set('America/Bahia');
        //Cabecalho
        $this->SetY($y);
        $this->SetFont("Arial", "B",14);
        $this->Image("img/Cabecalho1.jpg", null, null, 180, 30);
        $this->SetTextColor(78, 22, 35);
        $this->Cell($width, $height, "Relatorio ->", $border_false, $same_line);
        $this->Cell($width+70, $height, $view, $border_false, $same_line);
        $this->Cell($width, $height, date("d/m/Y - H:i:s"), $border_false, $next_line);
        $this->Cell($width, $height, "___________________________________________________________________", $border_false, $next_line);
        $this->Cell($width, $height, "Dados:", $border_false, $next_line);
        $this->Cell($width, $height, "", $border_false, $next_line);
            
    } 
    
    
   function Footer(){
       
       $y = 255;
       $width = 0;
       $height = 5;
       $center = 100;
       
       $this->SetY($y);
       $this->Cell(0, 5, "_____________________________________________________________________________________________", 0, 1);
       $this->SetFont('Arial','I',8);
       $this->MultiCell($width, $height, $this->page, 0, "C");
       $this->SetX($center-6);
       $this->Image("img/isus.jpg",10, null, 20, 10);
       $this->Image("img/bamin.jpg", 175, 265, 20, 10);
       
    }    
  
    
}
