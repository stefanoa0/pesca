<?php

class ConsultaPadraoController extends Zend_Controller_Action
{

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
    }

    public function indexAction()
    {

        //print_r($selectConsulta);
    }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
        
        $consultaPadrao = new Application_Model_VConsultaPadrao();
        
	$selectConsulta = $consultaPadrao->select(); 
        $selectMonitoramentos = $consultaPadrao->selectMonitoramentos(); 
        $selectFichas = $consultaPadrao->selectFichas();
        $selectSubamostras = $consultaPadrao->selectSubamostras();
        $totalEntrevistas = $consultaPadrao->selectTotalEntrevistas();
        $diasByPorto = $consultaPadrao->selectDiasByPorto();
        $dias = $consultaPadrao->selectDias();

	require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório Consulta Padrão');
        
        $modeloRelatorio->setLegValue(30, 'Artes de Pesca');
        $modeloRelatorio->setLegValue(120, 'Quantidade');
        $modeloRelatorio->setLegValue(180, 'Porto');
        $modeloRelatorio->setNewLine();
	
        foreach ( $selectConsulta as $key => $consulta ) {
		$modeloRelatorio->setLegValue(30, '', $consulta['consulta']);
                $modeloRelatorio->setLegValue(120, '', $consulta['quantidade']);
                $modeloRelatorio->setLegValue(180, '', $consulta['pto_nome']);
		$modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        
        $modeloRelatorio->setLegValue(30, 'Total de Entrevistas');
        $modeloRelatorio->setNewLine();
        foreach ( $totalEntrevistas as $key => $consulta ){
            $modeloRelatorio->setLegValue(30, '', $consulta['sum']);
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setNewLine();
        
        $modeloRelatorio->setLegValue(30, 'Dias por Portos');
        $modeloRelatorio->setLegValue(120, 'Portos');
        $modeloRelatorio->setNewLine();
        foreach ( $diasByPorto as $key => $consulta ){
            $modeloRelatorio->setLegValue(30, '', $consulta['count']);
            $modeloRelatorio->setLegValue(120, '', $consulta['pto_nome']);
            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setNewLine();
        
        $modeloRelatorio->setLegValue(30, 'Total de Dias monitorados');
        $modeloRelatorio->setNewLine();
        foreach ( $dias as $key => $consulta ){
            $modeloRelatorio->setLegValue(30, '', $consulta['count']);
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setLegValue(30, 'Monitoramentos');
        $modeloRelatorio->setLegValue(120, 'Quantidade');
        $modeloRelatorio->setNewLine();
        foreach ( $selectMonitoramentos as $key => $consulta ) {
		$modeloRelatorio->setLegValue(30, '', $consulta['consulta']);
                $modeloRelatorio->setLegValue(120, '', $consulta['quantidade']);
		$modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        
        $modeloRelatorio->setLegValue(30, 'Porto');
        $modeloRelatorio->setLegValue(120, 'Quantidade de Fichas');
        $modeloRelatorio->setNewLine();
        foreach ( $selectFichas as $key => $consulta ) {
		$modeloRelatorio->setLegValue(30, '', $consulta['pto_nome']);
                $modeloRelatorio->setLegValue(120, '', $consulta['quantidade']);
		$modeloRelatorio->setNewLine();
        }
        
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setNewLine();
        
        $modeloRelatorio->setLegValue(30, 'Subamostras');
        $modeloRelatorio->setLegValue(120, 'Quantidade');
        $modeloRelatorio->setNewLine();
        foreach ( $selectSubamostras as $key => $consulta ) {
		$modeloRelatorio->setLegValue(30, '', $consulta['consulta']);
                $modeloRelatorio->setLegValue(120, '', $consulta['quantidade']);
		$modeloRelatorio->setNewLine();
        }
	$pdf = $modeloRelatorio->getRelatorio();

	ob_end_clean();
        
        header('Content-Disposition: attachment;filename="rel_consulta.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
    
    public function relatorioxlsAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $consultaPadrao = new Application_Model_VConsultaPadrao();
        
	$selectConsulta = $consultaPadrao->select(); 
        $selectMonitoramentos = $consultaPadrao->selectMonitoramentos(); 
        $selectFichas = $consultaPadrao->selectFichas();
        $selectSubamostras = $consultaPadrao->selectSubamostras();
        $totalEntrevistas = $consultaPadrao->selectTotalEntrevistas();
        $diasByPorto = $consultaPadrao->selectDiasByPorto();
        $dias = $consultaPadrao->selectDias();
        
        $selectPortosByData = $consultaPadrao->selectPortosByData();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, 'Entrevistas por porto e por Arte');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Artes de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'Quantidade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'Porto');

        $linha = 4;
        foreach ($selectConsulta as $key => $consulta):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha,  $consulta['quantidade']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $consulta['pto_nome']);
            $linha++;
        endforeach;
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Total de Entrevistas');
            $linha++;
        
        foreach($totalEntrevistas as $key => $consultaEntrevistas):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consultaEntrevistas['sum']);
            $linha++;
        endforeach;
        
        
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Dias por Portos');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, 'Portos');
            $linha++;
        
            
        foreach ( $diasByPorto as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['count']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['pto_nome']);
            $linha++;
        endforeach;
            
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Total de Dias');
            $linha++;
         
            
        foreach ($dias as $key => $consulta):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['count']);
            $linha++;
        endforeach;
        
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Monitoramentos');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, 'Quantidade');
            $linha++;
            
        foreach ( $selectMonitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Portos');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, 'Quantidade de Fichas');
            $linha++;
            
        foreach ( $selectFichas as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        
            $linha++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Subamostras');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, 'Quantidade');
            $linha++;
            
        foreach ( $selectSubamostras as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        
        $linha++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Entrevistas por Arte, porto e Data');
        $linha++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, 'Artes de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, 'Quantidade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, 'Mês');

        $linha++;
        foreach ($selectPortosByData as $key => $consulta):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha,  $consulta['quantidade']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $consulta['data_ficha']);
            $linha++;
        endforeach;
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="teste.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriomensalxlsAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelConsulta = new Application_Model_VConsultaPadrao();
        
        $relatorioMensal = $modelConsulta->selectRelatorioMensal();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 0, 'Relatorio Mensal');
        $linha = 2;
        foreach ( $relatorioMensal as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioMensal.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function entrevistapesqueiroAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelConsulta = new Application_Model_VConsultaPadrao();
        
        $relatorioMensal = $modelConsulta->selectEntrevistaPesqueiro();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Arte de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Pesqueiro');
        $linha = 2;
        foreach ( $relatorioMensal as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $consulta['paf_pesqueiro']);
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="consultaPesqueiroEntrevistas.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    public function entrevistasbyhoraAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelConsulta = new Application_Model_VConsultaPadrao();
        
        $relatorioMensal = $modelConsulta->selectEntrevistasByHora();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Arte de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Quantidade de Entrevistas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Horário');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Mês/Ano');
        $linha = 2;
        foreach ( $relatorioMensal as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $consulta['consulta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $consulta['quantidade']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $consulta['hora_chegada']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $consulta['mes']);
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="entrevistasPorHora.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
     public function filogeniaAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelConsulta = new Application_Model_VConsultaPadrao();
        
        $relatorioMensal = $modelConsulta->selectFilogenia();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'ID');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Espécie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Descrição');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Nome Comum');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Gênero');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Família');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Tipo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Característica');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Ordem');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Característica da Ordem');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Grupo');
        $coluna = 0;
        $linha = 2;
        foreach ( $relatorioMensal as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['esp_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['esp_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['gen_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fam_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fam_tipo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fam_caracteristica']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['ord_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['ord_caracteristicas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['gen_nome']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="filogenia.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function avistamentosAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        

        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++,   $linha, 'Arte de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Avistamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Data');
        
        $avistamentosArrasto = new Application_Model_ArrastoFundo();
        $relatorioArrasto = $avistamentosArrasto->selectArrastoHasAvistamento();
        $coluna = 0;
        $linha++;
        foreach ( $relatorioArrasto as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Arrasto de Fundo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['af_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosCalao = new Application_Model_Calao();
        $relatorioCalao = $avistamentosCalao->selectCalaoHasAvistamento();
        foreach ( $relatorioCalao as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Calao');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['cal_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosColetaManual = new Application_Model_ColetaManual();
        $relatorioColetaManual = $avistamentosColetaManual->selectColetaManualHasAvistamento();
        foreach ( $relatorioColetaManual as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'ColetaManual');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['cml_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosEmalhe = new Application_Model_Emalhe();
        $relatorioEmalhe = $avistamentosEmalhe->selectEmalheHasAvistamento();
        foreach ( $relatorioEmalhe as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Emalhe');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['em_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosGrosseira = new Application_Model_Grosseira();
        $relatorioGrosseira = $avistamentosGrosseira->selectGrosseiraHasAvistamento();
        foreach ( $relatorioGrosseira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Grosseira');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['grs_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosJerere = new Application_Model_Jerere();
        $relatorioJerere = $avistamentosJerere->selectJerereHasAvistamento();
        foreach ( $relatorioJerere as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Jerere');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['jre_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosMergulho = new Application_Model_Mergulho();
        $relatorioMergulho = $avistamentosMergulho->selectMergulhoHasAvistamento();
        foreach ( $relatorioMergulho as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Mergulho');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['mer_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosRatoeira = new Application_Model_Ratoeira();
        $relatorioRatoeira = $avistamentosRatoeira->selectRatoeiraHasAvistamento();
        foreach ( $relatorioRatoeira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Ratoeira');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['rat_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosSiripoia = new Application_Model_Siripoia();
        $relatorioSiripoia = $avistamentosSiripoia->selectSiripoiaHasAvistamento();
        foreach ( $relatorioSiripoia as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Siripoia');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['sir_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosTarrafa = new Application_Model_Tarrafa();
        $relatorioTarrafa = $avistamentosTarrafa->selectTarrafaHasAvistamento();
        foreach ( $relatorioTarrafa as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Tarrafa');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['tar_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['tar_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $avistamentosVaraPesca = new Application_Model_VaraPesca();
        $relatorioVaraPesca = $avistamentosVaraPesca->selectVaraPescaHasAvistamento();
        foreach ( $relatorioVaraPesca as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'VaraPesca');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['vp_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['avs_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['fd_data']);
            $coluna = 0;
            $linha++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioAvistamentos.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
}

