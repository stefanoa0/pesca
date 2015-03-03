<?php

class AdministradorController extends Zend_Controller_Action
{

    public function init()
    {
        $this->modelUsuario = new Application_Model_Usuario();
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $ArrayIdentity = get_object_vars($identity);

        }


        $this->usuario = $this->modelUsuario->selectLogin($ArrayIdentity['tl_id']);
        $this->view->assign("usuario",$this->usuario);
        
        $this->modelPescador = new Application_Model_Pescador();
    }

    public function indexAction()
    {
       if($this->usuario['tp_id']!=1){
            $this->_redirect('index');
        }
        else{
            $pescadorDeletado = $this->modelPescador->selectDeletado();
            
            
            $this->view->assign("pescadorDeletado", $pescadorDeletado);
        }
    }
    
    public function deleteAction(){
        $idPescador = $this->getParam('id');
        
        $idMantido = $this->getParam('idMantido');
        
        $modelAdministrador = new Application_Model_Administrador();
        
        $modelArrasto= new Application_Model_ArrastoFundo;
        $modelCalao= new Application_Model_Calao;
        $modelColetaManual= new Application_Model_ColetaManual;
        $modelEmalhe= new Application_Model_Emalhe;
        $modelGrosseira= new Application_Model_Grosseira;
        $modelJerere= new Application_Model_Jerere;
        $modelLinha= new Application_Model_Linha;
        $modelLinhaFundo= new Application_Model_LinhaFundo;
        $modelManzua= new Application_Model_Manzua;
        $modelMergulho= new Application_Model_Mergulho;
        $modelRatoeira= new Application_Model_Ratoeira;
        $modelSiripoia= new Application_Model_Siripoia;
        $modelTarrafa= new Application_Model_Tarrafa;
        $modelVaraPesca= new Application_Model_VaraPesca;
        
        
        $modelArrasto->updatePescador($idPescador, $idMantido);
        $modelCalao->updatePescador($idPescador, $idMantido);
        $modelColetaManual->updatePescador($idPescador, $idMantido);
        $modelEmalhe->updatePescador($idPescador, $idMantido);
        $modelGrosseira->updatePescador($idPescador, $idMantido);
        $modelJerere->updatePescador($idPescador, $idMantido);
        $modelLinha->updatePescador($idPescador, $idMantido); 
        $modelLinhaFundo->updatePescador($idPescador, $idMantido);
        $modelManzua->updatePescador($idPescador, $idMantido);
        $modelMergulho->updatePescador($idPescador, $idMantido);
        $modelRatoeira->updatePescador($idPescador, $idMantido);
        $modelSiripoia->updatePescador($idPescador, $idMantido);
        $modelTarrafa->updatePescador($idPescador, $idMantido);
        $modelVaraPesca->updatePescador($idPescador, $idMantido);

        $modelAdministrador->deletePescadorHasArea($idPescador);
        $modelAdministrador->deletePescadorHasArteTipo($idPescador);
        $modelAdministrador->deletePescadorHasColonia($idPescador);
        $modelAdministrador->deletePescadorHasComunidade($idPescador);
        $modelAdministrador->deletePescadorHasDependente($idPescador);
        $modelAdministrador->deletePescadorHasEmbarcacoes($idPescador);
        $modelAdministrador->deletePescadorHasPorto($idPescador);
        $modelAdministrador->deletePescadorHasProgramaSocial($idPescador);
        $modelAdministrador->deletePescadorHasRenda($idPescador);
        $modelAdministrador->deletePescadorHasTelefone($idPescador);
        $modelAdministrador->deletePescadorHasTipo($idPescador);
        $modelAdministrador->deletePescador($idPescador);
        
        $this->redirect('administrador/index');
    }


}

