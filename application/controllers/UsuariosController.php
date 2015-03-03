<?php

/**
 * Controller de Usuários
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class UsuariosController extends Zend_Controller_Action {

    private $modelUsuario;
    private $usuario;

    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();

        if ( $auth->hasIdentity() ) {
			$identity = $auth->getIdentity();
			$identity2 = get_object_vars($identity);
		}

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);

        $this->modelUsuario = new Application_Model_Usuario();
    }

    /*
     * Lista todos os usuários ativos
     */
    public function indexAction()
    {
        $whereUsuario= '"tu_usuariodeletado" IS FALSE';

        $dados = $this->modelUsuario->select($whereUsuario);

        $this->view->assign("dados", $dados);
    }

    /*
     * Consulta um usuário
     */
    public function visualizarAction()
    {

        $idUsuario = $this->_getParam('id');

        $usuario = $this->modelUsuario->find($idUsuario);

        $modelTelefone = new Application_Model_Telefone();
        $telefoneResidencial = $modelTelefone->getTelefone($idUsuario, 'Residencial');
        $telefoneCelular = $modelTelefone->getTelefone($idUsuario, 'Celular');

        $this->view->assign("usuario", $usuario);
        $this->view->assign("telefoneResidencial", $telefoneResidencial);
        $this->view->assign("telefoneCelular", $telefoneCelular);
    }

    /*
     * Exibe formulário para cadastro de um usuário
     */
    public function novoAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelPerfil = new Application_Model_Perfil();
        $perfis = $modelPerfil->select();

        $modelMunicipio = new Application_Model_Municipio();
        $municipios = $modelMunicipio->select();

        $this->view->assign("perfis", $perfis);
        $this->view->assign("municipios", $municipios);
        $this->view->estados = array("AC", "AL", "AM", "AP",  "BA", "CE", "DF", "ES", "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");

    }

    /*
     * Cadastra um usuário
     */
    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelUsuario->insert($this->_getAllParams());

        $this->_redirect('usuarios/index');
    }

    /*
     * Preenche um formulario com as informações de um usuário
     */
    public function editarAction()
    {
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelPerfil = new Application_Model_Perfil();
        $perfis = $modelPerfil->select();

        $modelMunicipios = new Application_Model_Municipio();
        $municipios = $modelMunicipios->select();

        $modelUf = new Application_Model_UfMapper();
        $ufs = $modelUf->select();

        $usuario = $this->modelUsuario->find($this->_getParam('id'));

        $this->view->assign("perfis", $perfis);
        $this->view->assign("municipios", $municipios);
        $this->view->assign("ufs", $ufs);
        $this->view->assign("usuario", $usuario);
    }

    /*
     * Atualiza os dados do usuário
     */
    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelUsuario->update($this->_getAllParams());

        $this->_redirect('usuarios/index');
    }

    /*
     *
     */
    public function excluirAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelUsuario->delete($this->_getParam('id'));

        $this->_redirect('usuarios/index');
        }
    }

    public function senhaAction(){



    }
    public function alterasenhaAction(){
        $dadosLogin = new Application_Model_Login();
        $usuarioForm = $this->_getAllParams();

        $idlogin = $usuarioForm['login'];
        $senhaAntiga = $usuarioForm['SenhaAntiga'];
        $senhaNova = $usuarioForm['novaSenha'];

        $login = $this->modelUsuario->selectSenha($idlogin);
        print_r($login);

        $senhasha1 = sha1($senhaAntiga);

        if($senhasha1 == $login['tl_hashsenha']){
            $senhaNova = sha1($senhaNova);
            $dadosLogin->update($senhaNova, $idlogin);
            $this->_redirect('usuarios/index');
        }
        else {
            print_r("Senha inválida, tente novamente!");

        }
    }

    public function relatorioAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelUsuario = new Application_Model_Usuario();
		$localUsuario = $localModelUsuario->selectView(NULL, array('tp_perfil', 'tu_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Usuários');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'Usuário');
		$modeloRelatorio->setLegenda(250, 'Login');
		$modeloRelatorio->setLegenda(500, 'Perfil');

		foreach ($localUsuario as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tu_id']);
			$modeloRelatorio->setValue(80, $localData['tu_nome']);
			$modeloRelatorio->setValue(250, $localData['tl_login']);
			$modeloRelatorio->setValue(400, $localData['tp_perfil']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_usuarios_lista.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

    public function relatoriocompletoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelUsuario = new Application_Model_Usuario();
		$localUsuario = $localModelUsuario->selectView(NULL, array('tp_perfil', 'tu_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();

		$modeloRelatorio->setTitulo('Relatório Usuários');
		$modeloRelatorio->setLegendaOff();

		foreach ($localUsuario as $key => $localData) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Código: ',  $localData['tu_id']);
			$modeloRelatorio->setLegValue(90, 'Nome: ', $localData['tu_nome']);
			$modeloRelatorio->setLegValue(340, 'Sexo: ', $localData['tu_sexo']);
			$modeloRelatorio->setLegValue(380, 'Perfil: ',  $localData['tp_perfil']);
			$modeloRelatorio->setNewLine();


			$modeloRelatorio->setLegValue(60, 'CPF: ', $localData['tu_cpf']);
			$modeloRelatorio->setLegValue(180, 'RG: ', $localData['tu_rg']);
			$modeloRelatorio->setLegValue(300, 'E-Mail: ', $localData['tu_email']);
			$modeloRelatorio->setNewLine();

			$modeloRelatorio->setLegValue(60, 'Tel.Res.: ', $localData['tu_telres']);
			$modeloRelatorio->setLegValue(180, 'Tel.Cel.: ', $localData['tu_telcel']);
			$modeloRelatorio->setLegValue(300, 'Login: ', $localData['tl_login']);
			$modeloRelatorio->setNewLine();

			$tmpEnd = $localData['te_logradouro'];
			if ( strlen($localData['te_logradouro']) > 0 && strlen($localData['te_numero']) > 0 ) {
				$tmpEnd = $localData['te_logradouro'] . ', ' . $localData['te_numero'] ;
			}
			$modeloRelatorio->setLegValue(60, 'Logradouro: ',  $tmpEnd );
			$modeloRelatorio->setLegValue(300, 'Complemento: ', $localData['te_comp']);
			$modeloRelatorio->setNewLine();

			$modeloRelatorio->setLegValue(60, 'Bairro: ', $localData['te_bairro']);
			$modeloRelatorio->setLegValue(260, 'Município: ', $localData['tmun_municipio']);
			$modeloRelatorio->setLegValue(460, 'UF: ', $localData['tuf_sigla']);
			$tmpCEP = $this->mascara_string( '#####-###',  $localData['te_cep'] );
			$modeloRelatorio->setLegValue(500, 'CEP: ', $tmpCEP );
			$modeloRelatorio->setNewLine();
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_usuarios.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }

	private function mascara_string($mascara,$string) {
		if ( strlen($string) > 0 ) {
			$string = str_replace(" ","",$string);
			for($i=0;$i<strlen($string);$i++)
			{
				$mascara[strpos($mascara,"#")] = $string[$i];
			}
		} else {
			$mascara = $string;
		}
		return $mascara;
	}
}