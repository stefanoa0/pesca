<?php

class RelatoriosController extends Zend_Controller_Action
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
        
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
    }

    public function indexAction(){
        
        $modelPorto = new Application_Model_Porto();
        
        $porto = $modelPorto->select(null, 'pto_nome');
        
        $this->view->assign("portos", $porto);

    }
    public function graficosAction(){
        
    }
    
    public function pescadoresportoAction(){
        $this->modelRelatorios = new Application_Model_Relatorios();
        $pescadoresPorto = $this->modelRelatorios->selectPescadores('pto_nome');
        
        foreach($pescadoresPorto as $key => $porto):
            $array_porto[] = $porto['pto_nome'];
            $array_quantidade[] = $porto['count'];
        endforeach;
        
        $js_porto = json_encode($array_porto);
        $js_quantidade = json_encode($array_quantidade);

        $this->view->assign("array_porto",$js_porto);
        $this->view->assign("array_quantidade",$js_quantidade);
    }
    public function pescadoresportoxlsAction(){
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $this->modelRelatorios = new Application_Model_Relatorios();
        $pescadoresPorto = $this->modelRelatorios->selectPescadores('pto_nome');
        
        $coluna=0;
        $linha=1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, 'Quantidade de Pescadores');
        
        $linha++;
        $coluna=0;
        foreach($pescadoresPorto as $consulta){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $consulta['count']);
            $linha++;
            $coluna=0;
        }
        
        
        $values = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$18');

        $categories = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$18');
        
        $series = new PHPExcel_Chart_DataSeries(
          PHPExcel_Chart_DataSeries::TYPE_BARCHART,
          PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  
          array(0),                                       
          array(),                                        
          array($categories), 
          array($values)  
        );
        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
        
        $layout = new PHPExcel_Chart_Layout();
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
        
        $chart = new PHPExcel_Chart('exemplo', null, null, $plotarea);
        

        $title = new PHPExcel_Chart_Title(null, $layout);
        $title->setCaption(utf8_encode('Gráfico PHPExcel Chart Class'));

        $chart->setTopLeftPosition('D1');
        $chart->setBottomRightPosition('K15');
        $chart->setTitle($title);
        
        $sheet->addChart($chart);
        
        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $writer->setIncludeCharts(TRUE);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="grafico_phpexcel_chart_class.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');
        
    }
    public function pescadorescoloniaAction(){
        $this->modelRelatorios = new Application_Model_Relatorios();
        $pescadoresColonias = $this->modelRelatorios->selectPescadores('tc_nome');
        
        foreach($pescadoresColonias as $key => $colonia):
            $array_colonia[] = $colonia['tc_nome'];
            $array_quantidade[] = $colonia['count'];
        endforeach;
        
        $js_colonia = json_encode($array_colonia);
        $js_quantidade = json_encode($array_quantidade);
        
        $this->view->assign("array_quantidade", $js_quantidade);
        $this->view->assign("array_colonia",$js_colonia);
    }
    public function pescadoresescolaridadeAction(){
        $this->modelRelatorios = new Application_Model_Relatorios();
        $pescadoresEscolaridade = $this->modelRelatorios->selectPescadores('esc_nivel');
        
        $this->view->assign("escolaridades",$pescadoresEscolaridade);
    }
    
    public function monitoramentosAction(){
        $consultaPadrao = new Application_Model_VConsultaPadrao();
        $selectMonitoramentos = $consultaPadrao->selectMonitoramentos();
        
        $this->view->assign("monitoramentos",$selectMonitoramentos);
    }
    public function gerarAction(){
        
        $valueRelatorio = $this->_getAllParams();

        $rel = $valueRelatorio['tipoRelatorio'];
        $rel = 'id/'.$rel;
        
        $dia = $valueRelatorio['dia_ini'];
        $mes = $valueRelatorio['mes_ini'];
        $ano = $valueRelatorio['ano_ini'];
        $data = $ano.'-'.$mes.'-'.$dia;
        $data = '/data/'.$data;
        
        $diafim = $valueRelatorio['dia_fim'];
        $mesfim = $valueRelatorio['mes_fim'];
        $anofim = $valueRelatorio['ano_fim'];
        $datafim = $anofim.'-'.$mesfim.'-'.$diafim;
        
        $datafim = '/datafim/'.$datafim;
        
        
        $porto = $valueRelatorio['porto'];
        
        $porto = '/porto/'.$porto;
        
        switch($valueRelatorio['artePesca']){
            
            case 1: $this->_redirect("/relatorios/relatoriocompletoarrasto/".$rel.$data.$datafim.$porto);break;
            case 2:$this->_redirect("/relatorios/relatoriocompletocalao/".$rel.$data.$datafim.$porto);break;
            case 3:$this->_redirect("/relatorios/relatoriocompletocoletamanual/".$rel.$data.$datafim.$porto);break;
            case 4:$this->_redirect("/relatorios/relatoriocompletoemalhe/".$rel.$data.$datafim.$porto);break;
            case 5:$this->_redirect("/relatorios/relatoriocompletogroseira/".$rel.$data.$datafim.$porto);break;
            case 6:$this->_redirect("/relatorios/relatoriocompletojerere/".$rel.$data.$datafim.$porto);break;
            case 7:$this->_redirect("/relatorios/relatoriocompletolinha/".$rel.$data.$datafim.$porto);break;
            case 8:$this->_redirect("/relatorios/relatoriocompletolinhafundo/".$rel.$data.$datafim.$porto);break;
            case 9:$this->_redirect("/relatorios/relatoriocompletomanzua/".$rel.$data.$datafim.$porto);break;
            case 10:$this->_redirect("/relatorios/relatoriocompletomergulho/".$rel.$data.$datafim.$porto);break;
            case 11:$this->_redirect("/relatorios/relatoriocompletoratoeira/".$rel.$data.$datafim.$porto);break;
            case 12:$this->_redirect("/relatorios/relatoriocompletosiripoia/".$rel.$data.$datafim.$porto);break;
            case 13:$this->_redirect("/relatorios/relatoriocompletotarrafa/".$rel.$data.$datafim.$porto);break;
            case 14:$this->_redirect("/relatorios/relatoriocompletovarapesca/".$rel.$data.$datafim.$porto);break;
            case 15:$this->_redirect("/relatorios/relatoriocompleto/".$rel.$data.$datafim.$porto);break;
            case 16:$this->_redirect("/relatorios/biometriascamarao".$data.$datafim.$porto);break;
            case 17:$this->_redirect("/relatorios/biometriaspeixe".$data.$datafim.$porto);break;

        }
    }
    
    public function verificaRelatorio($var){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($var === '1' || $var === '0'){
            $tipoRel = 'spc_peso_kg';
        }
        if($var === '2'){
            $tipoRel = 'spc_quantidade';
        }
        if($var === '3'){
            $tipoRel = 'spc_preco';
        }
        return $tipoRel;
    }
    public function motor($var){
        
        if($var == false){
            $var = "Não";
        }
        else{
            $var = "Sim";
        }
        return $var;
    }
    public function mare($mare){
        
        if($mare == false){
            $mare = "Morta";
        }
        else{
            $mare = "Viva";
        }
        return $mare;
    }
    public function dataFinal($data){
        
        if($data=='--'){
            $data = date('Y-m-j');
        }

        return $data;
    }
    public function dataInicial($data){
        if($data == '--'){
            $data = '2013-01-01';
        }
        return $data;
    }
    public function relatoriocompletoarrastoAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();

        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant= 21;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        
        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspecies();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosArrasto();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;
        

        foreach ( $relatorioArrasto as $key => $consulta ):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_quantpescadores']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_diesel']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_oleo']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_alimento']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_gelo']);
                $consulta['af_motor'] = $this->motor($consulta['af_motor']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_motor']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_obs']);

                $Pesqueiros = $this->modelRelatorios->selectArrastoHasPesqueiro('af_id = '.$consulta['af_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempopesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectArrastoHasEspCapturadas('af_id = '.$consulta['af_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                   foreach($Relesp as $key => $esp):
                        if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                        }
                   endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;     
                $coluna=0;
                $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioArrasto.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    
    
    public function relatoriocompletocoletamanualAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        
        $quant = 19;
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesColetamanual();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosColetaManual();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioColetaManual = $this->modelRelatorios->selectColetaManual("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioColetaManual = $this->modelRelatorios->selectColetaManual("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioColetaManual as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['cml_mreviva'] = $this->mare($consulta['cml_mreviva']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_mreviva']);
            $consulta['cml_motor'] = $this->motor($consulta['cml_motor']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectColetaManualHasPesqueiro('cml_id = '.$consulta['cml_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas('cml_id = '.$consulta['cml_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                 if($coluna < $lastcolumn-1){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;     
            
            $coluna=0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioColetaManual_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    public function relatoriocompletocalaoAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 21;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data do Calão');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Num panos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tamanhos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Altura');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha3');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Calão');

        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesCalao();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosCalao();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        $linha = 2;
        $coluna= 0;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."'");
        }

        foreach ( $relatorioCalao as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_npanos']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_tamanho']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha1']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha2']);
            $consulta['cal_motor'] = $this->motor($consulta['cal_motor']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tcat_tipo']);
            
            $Pesqueiros = $this->modelRelatorios->selectCalaoHasPesqueiro('cal_id = '.$consulta['cal_id']);
                
            $coluna++;
            foreach($Pesqueiros as $key => $nome):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            
            $coluna = $maxPesqueiros[0]['count']*2+$quant;
            $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas('cal_id = '.$consulta['cal_id']);
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach; 
            
            
            $coluna=0;
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioCalao_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletoemalheAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 25;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Lançamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Lançamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Recolhimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Recolhimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tamanho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Altura');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Panos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesEmalhe();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosEmalhe();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;

        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioEmalhe as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dlancamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hlancamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hrecolhimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_tamanho']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_numpanos']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_malha']);
            
            $consulta['em_motor'] = $this->motor($consulta['em_motor']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_obs']);

            $Pesqueiros = $this->modelRelatorios->selectEmalheHasPesqueiro('em_id = '.$consulta['em_id']);
             $coluna++;
            foreach($Pesqueiros as $key => $nome):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            
            
            $coluna = $maxPesqueiros[0]['count']*2+$quant;
            $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas('em_id = '.$consulta['em_id']);
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach; 
            
            
            $coluna=0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioEmalhe_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletogroseiraAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
       
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant= 24;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Linhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Anzóis por Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Isca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesGrosseira();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosGrosseira();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;

        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioGrosseira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            
            $consulta['grs_motor'] = $this->motor($consulta['grs_motor']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_obs']);

            $Pesqueiros = $this->modelRelatorios->selectGrosseiraHasPesqueiro('grs_id = '.$consulta['grs_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas('grs_id = '.$consulta['grs_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                   if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;  
            
            $coluna=0;
            $linha++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioGrosseira_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletojerereAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Armadilhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustível');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesJerere();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosJerere();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."'");
        }
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioJerere as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['jre_mreviva'] = $this->mare($consulta['jre_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_combustivel']);
            $consulta['jre_motor'] = $this->motor($consulta['jre_motor']);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectJerereHasPesqueiro('jre_id = '.$consulta['jre_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas('jre_id = '.$consulta['jre_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;  

            $coluna=0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioJereré_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
   public function relatoriocompletolinhaAction() {
       
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 24;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Linhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Anzóis por Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Isca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesLinha();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosLinha();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."'");
        }
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioLinha as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['lin_motor'] = $this->motor($consulta['lin_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_obs']);

            $Pesqueiros = $this->modelRelatorios->selectLinhaHasPesqueiro('lin_id = '.$consulta['lin_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas('lin_id = '.$consulta['lin_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;  

            $coluna=0;
            $linha++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioLinha'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletolinhafundoAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 25;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Linhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Anzóis por Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Isca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesLinhaFundo();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosLinhaFundo();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
       
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioLinhaFundo as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['lf_motor'] = $this->motor($consulta['lf_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectLinhaFundoHasPesqueiro('lf_id = '.$consulta['lf_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas('lf_id = '.$consulta['lf_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioLinhaFundo_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
     public function relatoriocompletomanzuaAction() {
         set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
    
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustível');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Armadilhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesManzua();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosManzua();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."'");
        }
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioManzua as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['man_mreviva'] = $this->mare($consulta['man_mreviva']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_mreviva']);
            
            $consulta['man_motor'] = $this->motor($consulta['man_motor']);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectManzuaHasPesqueiro('man_id = '.$consulta['man_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas('man_id = '.$consulta['man_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioManzua'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletomergulhoAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 19;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Chegada');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesMergulho();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosMergulho();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."'");
        }
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioMergulho as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['mer_mreviva'] = $this->mare($consulta['mer_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_mreviva']);
            $consulta['mer_motor'] = $this->motor($consulta['mer_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_obs']);
            
           $Pesqueiros = $this->modelRelatorios->selectMergulhoHasPesqueiro('mer_id = '.$consulta['mer_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas('mer_id = '.$consulta['mer_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioMergulho_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    public function relatoriocompletoratoeiraAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Armadilhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustível');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesRatoeira();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosRatoeira();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."'");
        }
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioRatoeira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['rat_mreviva'] = $this->mare($consulta['rat_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_combustivel']);
            $consulta['rat_motor'] = $this->motor($consulta['rat_motor']);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectRatoeiraHasPesqueiro('rat_id = '.$consulta['rat_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas('rat_id = '.$consulta['rat_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                   if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
            
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioRatoeira_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletosiripoiaAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Armadilhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustível');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesSiripoia();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosSiripoia();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioSiripoia as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['sir_mreviva'] = $this->mare($consulta['sir_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_combustivel']);
            $consulta['sir_motor'] = $this->motor($consulta['sir_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectSiripoiaHasPesqueiro('sir_id = '.$consulta['sir_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas('sir_id = '.$consulta['sir_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
            
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioSiripoia_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletotarrafaAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";
        
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 18;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data da Tarrafa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Roda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Altura');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Lances');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesTarrafa();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosTarrafa();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioTarrafa as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_roda']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_malha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_numlances']);
            $consulta['tar_motor'] = $this->motor($consulta['tar_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectTarrafaHasPesqueiro('tar_id = '.$consulta['tar_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas('tar_id = '.$consulta['tar_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn-1){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            $coluna=0;
            $linha++;
        endforeach;
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioTarrafa_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletovarapescaAction() {
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 28;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saída');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Diesel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Óleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimentos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Linhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Anzois Por linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Isca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');

        
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspeciesVaraPesca();
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosVaraPesca();
        $coluna = $maxPesqueiros[0]['count']*2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto = $this->verifporto($porto);
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
        }
        else{
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioVaraPesca as $key => $consulta ):
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['vp_mreviva'] = $this->mare($consulta['vp_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_mreviva']);
            $consulta['vp_motor'] = $this->motor($consulta['vp_motor']);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_obs']);
            
            $Pesqueiros = $this->modelRelatorios->selectVaraPescaHasPesqueiro('vp_id = '.$consulta['vp_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $maxPesqueiros[0]['count']+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas('vp_id = '.$consulta['vp_id']);
                
                $coluna= $maxPesqueiros[0]['count']*2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
            
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioVaraPesca_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletoAction() {
        $inicio1 = microtime(true);
        set_time_limit(800);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        ini_set('memory_limit', '-1');
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $var =  $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        $this->modelRelatorios = new Application_Model_Relatorios();

        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 37;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saida');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Saida');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Hora Volta');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo Gasto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustivel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Oleo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gelo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Lances');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de panos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Roda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tamanhos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Altura');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Malha3');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Linhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Anzóis Por Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Armadilhas');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Isca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motor?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Maré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Calão');

        
        
        $relatorioEspecies = $this->modelRelatorios->selectEspecies();
        
        $coluna = 2+$quant;
        foreach($relatorioEspecies as $key => $especie):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha,$especie['esp_nome_comum']);
        endforeach;
        $lastcolumn = $coluna;
        
        $porto = $this->_getParam('porto');
        if($porto != '999'){
            $porto2 = $this->verifporto($porto);
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
        }
        else{
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."'");
        }
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioCalao as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '1');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_npanos']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_tamanho']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha1']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_malha2']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $consulta['cal_motor'] = $this->motor($consulta['cal_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tcat_tipo']);
            
            $Pesqueiros = $this->modelRelatorios->selectCalaoHasPesqueiro('cal_id = '.$consulta['cal_id']);
                
            $coluna++;
            foreach($Pesqueiros as $key => $nome):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            
            $coluna = 2+$quant;
            $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas('cal_id = '.$consulta['cal_id']);
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach; 
            $coluna=0;
            $linha++;
        endforeach;

        if($porto != '999'){
            $porto2 = $this->verifporto($porto);
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
        }
        else{
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("fd_data between '". $data."'"." and '".$datafim."'");
        }
        foreach ( $relatorioColeta as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            if($consulta['dias'] == '0'){
                $consulta['dias']= '1';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['cml_mreviva'] = $this->mare($consulta['cml_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_mreviva']);
            $consulta['cml_motor'] = $this->motor($consulta['cml_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_obs']);
            
            
            $Pesqueiros = $this->modelRelatorios->selectColetaManualHasPesqueiro('cml_id = '.$consulta['cml_id']);
                
            $coluna++;
            foreach($Pesqueiros as $key => $nome):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            
            $coluna = 2+$quant;
            $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas('cml_id = '.$consulta['cml_id']);
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach; 

            $coluna=0;
            $linha++;
        endforeach;
        

//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach($relatorioEmalhe as $key=> $consulta):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dlancamento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hlancamento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hrecolhimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_diesel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_oleo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_alimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_gelo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');            
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_numpanos']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_tamanho']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_altura']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_malha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['em_motor'] = $this->motor($consulta['em_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//
//            $Pesqueiros = $this->modelRelatorios->selectEmalheHasPesqueiro('em_id = '.$consulta['em_id']);
//             $coluna++;
//            foreach($Pesqueiros as $key => $nome):
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//            endforeach;
//            
//            
//            $coluna = 2+$quant;
//            $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas('em_id = '.$consulta['em_id']);
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach; 
//            
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//
//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioGrosseira as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_diesel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_oleo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_alimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_gelo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numlinhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numanzoisplinha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numanzoisplinha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_id']);
//            $consulta['grs_motor'] = $this->motor($consulta['grs_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $Pesqueiros = $this->modelRelatorios->selectGrosseiraHasPesqueiro('grs_id = '.$consulta['grs_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= 2+$quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas('grs_id = '.$consulta['grs_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                   if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;  
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//
//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioJerere as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_combustivel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_numarmadilhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_numarmadilhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['jre_motor'] = $this->motor($consulta['jre_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
//            $consulta['jre_mreviva'] = $this->mare($consulta['jre_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $Pesqueiros = $this->modelRelatorios->selectJerereHasPesqueiro('jre_id = '.$consulta['jre_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= 2+$quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas('jre_id = '.$consulta['jre_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;  
//
//            $coluna=0;
//            $linha++;
//        endforeach;
        

//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioLinha as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//	    
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_diesel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_oleo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_alimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_gelo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numlinhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numanzoisplinha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
//            
//            $consulta['lin_motor'] = $this->motor($consulta['lin_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//	
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//
//            $Pesqueiros = $this->modelRelatorios->selectLinhaHasPesqueiro('lin_id = '.$consulta['lin_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas('lin_id = '.$consulta['lin_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;  
//
//            $coluna=0;
//            $linha++;
//        endforeach;
        

//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioLinhaFundo as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_diesel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_oleo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_alimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_gelo']);
//	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');            
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numlinhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numanzoisplinha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
//            
//            $consulta['lf_motor'] = $this->motor($consulta['lf_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            
//            $Pesqueiros = $this->modelRelatorios->selectLinhaFundoHasPesqueiro('lf_id = '.$consulta['lf_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas('lf_id = '.$consulta['lf_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        

        if($porto != '999'){
            $porto2 = $this->verifporto($porto);
            $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
        }
        else{
            $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."'");
        }
        foreach ( $relatorioManzua as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $consulta['man_motor'] = $this->motor($consulta['man_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['man_mreviva'] = $this->mare($consulta['man_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_mreviva']);  
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectManzuaHasPesqueiro('man_id = '.$consulta['man_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= +$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas('man_id = '.$consulta['man_id']);
                
                $coluna= 2+$quant;
            foreach($relatorioEspecies as $key => $especie):
                 foreach($Relesp as $key => $esp):
                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
                     }
                 endforeach;
                    if($coluna < $lastcolumn){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
                 }
                 else{
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
                 }
            endforeach;
            
            $coluna=0;
            $linha++;
        endforeach;
        

//        if($porto != '999'){
//            $porto2 = $this->verifporto($porto);
//            $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto2."'");
//        }
//        else{
//            $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioMergulho as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['mer_motor'] = $this->motor($consulta['mer_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
//            $consulta['mer_mreviva'] = $this->mare($consulta['mer_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_mreviva']);      
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            
//            $Pesqueiros = $this->modelRelatorios->selectMergulhoHasPesqueiro('mer_id = '.$consulta['mer_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas('mer_id = '.$consulta['mer_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//        $porto = $this->_getParam('porto');
//        if($porto != '999'){
//            $porto = $this->verifporto($porto);
//            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
//        }
//        else{
//            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioRatoeira as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_combustivel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_numarmadilhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['rat_motor'] = $this->motor($consulta['rat_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
//            $consulta['rat_mreviva'] = $this->mare($consulta['rat_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $Pesqueiros = $this->modelRelatorios->selectRatoeiraHasPesqueiro('rat_id = '.$consulta['rat_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas('rat_id = '.$consulta['rat_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                   if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//        $porto = $this->_getParam('porto');
//        if($porto != '999'){
//            $porto = $this->verifporto($porto);
//            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
//        }
//        else{
//            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioSiripoia as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_combustivel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_numarmadilhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['sir_motor'] = $this->motor($consulta['sir_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
//            $consulta['sir_mreviva'] = $this->mare($consulta['sir_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            
//            $Pesqueiros = $this->modelRelatorios->selectSiripoiaHasPesqueiro('sir_id = '.$consulta['sir_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas('sir_id = '.$consulta['sir_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//        $porto = $this->_getParam('porto');
//        if($porto != '999'){
//            $porto = $this->verifporto($porto);
//            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
//        }
//        else{
//            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioTarrafa as $key => $consulta ):
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['1']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_numlances']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_roda']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_altura']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_malha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $consulta['tar_motor'] = $this->motor($consulta['tar_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $Pesqueiros = $this->modelRelatorios->selectTarrafaHasPesqueiro('tar_id = '.$consulta['tar_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas('tar_id = '.$consulta['tar_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            $coluna=0;
//            $linha++;
//        endforeach;
//        
//        $porto = $this->_getParam('porto');
//        if($porto != '999'){
//            $porto = $this->verifporto($porto);
//            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."' AND pto_nome = '".$porto."'");
//        }
//        else{
//            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."'");
//        }
//        foreach ( $relatorioVaraPesca as $key => $consulta ):
//            
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hsaida']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hvolta']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_tempogasto']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_id']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_quantpescadores']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_diesel']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_oleo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_alimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_gelo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numlinhas']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numanzoisplinha']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
//            $consulta['vp_motor'] = $this->motor($consulta['vp_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_motor']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
//            $consulta['vp_mreviva'] = $this->mare($consulta['vp_mreviva']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_mreviva']);
//            
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_obs']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//            
//            $Pesqueiros = $this->modelRelatorios->selectVaraPescaHasPesqueiro('vp_id = '.$consulta['vp_id']);
//                
//                $coluna++;
//                foreach($Pesqueiros as $key => $nome):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
//                endforeach;
//                $coluna= $quant;
//                foreach($Pesqueiros as $key => $tempo):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
//                endforeach;
//                
//                $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas('vp_id = '.$consulta['vp_id']);
//                
//                $coluna= 2+$quant;
//            foreach($relatorioEspecies as $key => $especie):
//                 foreach($Relesp as $key => $esp):
//                     if($esp['esp_nome_comum'] === $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getFormattedValue()){
//                         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp[$tipoRel]);
//                     }
//                 endforeach;
//                    if($coluna < $lastcolumn){
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '0');
//                 }
//                 else{
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, '');
//                 }
//            endforeach;
//            
//            $coluna=0;
//            $linha++;
//        endforeach;
        
        $fim1 = microtime(true);
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $fim1-$inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioCompleto_'.$tipoRel.'.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    public function relatoriocompletomonitoramentosAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $monitoramentos = $this->modelRelatorios->selectMonitoramentos();
        
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mês');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Não Monitorados');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Contagem de Entrevistas Monitoradas');
        
        $coluna= 0;
        $linha++;
        foreach ( $monitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tap_artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mes']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ano']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['naomonitorados']);
            if($consulta['monitorados'] == ''){
                $consulta['monitorados'] = 0;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['monitorados']);
            $coluna=0;
            $linha++;
        endforeach;    
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="monitoramentos.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletoespeciesAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $monitoramentos = $this->modelRelatorios->selectEspeciesCapturadas();
        
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Espécie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Nome Comum');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Peso Total');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Quantidade Total');
        
        $coluna= 0;
        $linha++;
        foreach ( $monitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['arte']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['quantidade']);
            $coluna=0;
            $linha++;
        endforeach;    
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Espécies Capturadas.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    public function relatoriocompletoespeciesmesAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $monitoramentos = $this->modelRelatorios->selectEspeciesCapturadasMes();
        
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mês/Ano');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Nome Comum');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Peso Total');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Quantidade Total');
        
        $coluna= 0;
        $linha++;
        foreach ( $monitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['arte']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mes'].'/'.$consulta['ano']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['quantidade']);
            $coluna=0;
            $linha++;
        endforeach;    
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Espécies Capturadas Por Mês.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function relatoriocompletopescadoresAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $pescadores = $this->modelRelatorios->selectPescadorByProjeto();
        
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Porto de Desembarque');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pescador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Projeto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Monitoramentos em Arrasto de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Calão');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Coleta Manual');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Emalhe');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Grosseira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Jereré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Linha de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Manzuá');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mergulho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ratoeira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Siripoia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tarrafa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Vara de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Total de Monitoramentos');
        
        $coluna= 0;
        $linha++;
        foreach ( $pescadores as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tpr_descricao']);
            $coluna=0;
            $linha++;
        endforeach;
        
        $arrasto = $this->modelRelatorios->selectPescadorByArrasto();
        $linha = 2;
        $coluna+=3;
        foreach ( $arrasto as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $calao = $this->modelRelatorios->selectPescadorByCalao();
        foreach ( $calao as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $coleta = $this->modelRelatorios->selectPescadorByColeta();
        foreach ( $coleta as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $emalhe = $this->modelRelatorios->selectPescadorByEmalhe();
        foreach ( $emalhe as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $grosseira = $this->modelRelatorios->selectPescadorByGrosseira();
        foreach ( $grosseira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $jerere = $this->modelRelatorios->selectPescadorByJerere();
        foreach ( $jerere as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $linha_pesca = $this->modelRelatorios->selectPescadorByLinha();
        foreach ( $linha_pesca as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $linhafundo = $this->modelRelatorios->selectPescadorByLinhaFundo();
        foreach ( $linhafundo as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $manzua = $this->modelRelatorios->selectPescadorByManzua();
        foreach ( $manzua as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $mergulho = $this->modelRelatorios->selectPescadorByMergulho();
        foreach ( $mergulho as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $ratoeira = $this->modelRelatorios->selectPescadorByRatoeira();
        foreach ( $ratoeira as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $siripoia = $this->modelRelatorios->selectPescadorBySiripoia();
        foreach ( $siripoia as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $tarrafa = $this->modelRelatorios->selectPescadorByTarrafa();
        foreach ( $tarrafa as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;
        
        $varapesca = $this->modelRelatorios->selectPescadorByVaraPesca();
        foreach ( $varapesca as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $ultimaLinha = $linha;
        $linha = 2;
        $coluna++;
        
        $i = 2;
        $j = 2;
        for($i; $i < $ultimaLinha; $i++):
            $formula = '=SUM(D'.$i.':Q'.$i.')';
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $formula);
            $linha++;
        endfor;
        
        $formula = '=SUM(R'.$j.':R'.($i-1).')';
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $formula);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pescadores Monitorados.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function valorespeciesAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelRelatorios = new Application_Model_Relatorios();
        
        $monitoramentos = $this->modelRelatorios->selectValorEspecies();
        
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Espécie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Valor Máximo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Valor Mínimo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Média Geral');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'ID');
        
        $coluna= 0;
        $linha++;
        foreach ( $monitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['max']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['min']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['media']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_id']);
            $coluna=0;
            $linha++;
        endforeach;    
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Valor das Espécies.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function verifporto($porto=null){
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelPorto = new Application_Model_Porto();
        
        $verificaPorto = $modelPorto->select('pto_id = '.$porto);
        
        return $verificaPorto[0]['pto_nome'];
    }
    
    public function biometriascamaraoAction(){
        set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $modelArrasto =    new Application_Model_ArrastoFundo;
        
        $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        $porto = $this->_getParam('porto');
        
        if($porto != '999'){
        $nomePorto = $this->verifporto($porto);
        $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
        }
         else{
             $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
         }       
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, 'Arrasto de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pesqueiro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Espécie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Nome Comum');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sexo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maturidade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprimento da Carapaça');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Peso');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data da Entrevista');

        
        $coluna= 0;
        $linha++;
        
        foreach ( $arrasto as $key => $consulta ):
            $pesqueiroArrasto = $modelArrasto->selectArrastoHasPesqueiro('af_id = '.$consulta['af_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  "Arrasto de Fundo");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_id']);
            if(empty($pesqueiroArrasto)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiroArrasto as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbc_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tmat_tipo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbc_comprimento_cabeca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbc_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Biometria de Camarao.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function biometriaspeixeAction(){
        set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $modelArrasto =    new Application_Model_ArrastoFundo;
        $modelCalao=       new Application_Model_Calao;
        $modelColetaManual=new Application_Model_ColetaManual;
        $modelEmalhe=      new Application_Model_Emalhe;
        $modelGrosseira=   new Application_Model_Grosseira;
        $modelJerere=      new Application_Model_Jerere;
        $modelLinha=       new Application_Model_Linha;
        $modelLinhaFundo=  new Application_Model_LinhaFundo;
        $modelManzua=      new Application_Model_Manzua;
        $modelMergulho=    new Application_Model_Mergulho;
        $modelRatoeira=    new Application_Model_Ratoeira;
        $modelSiripoia=    new Application_Model_Siripoia;
        $modelTarrafa=     new Application_Model_Tarrafa;
        $modelVaraPesca =  new Application_Model_VaraPesca;
        
         $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        $porto = $this->_getParam('porto');
        
        if($porto != '999'){
            $nomePorto = $this->verifporto($porto);
            $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $calao =$modelCalao->selectVBioPeixe("cal_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $coletamanual =$modelColetaManual->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $emalhe =$modelEmalhe->selectVBioPeixe("drecolhimento between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $grosseira =$modelGrosseira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $jerere =$modelJerere->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $pescalinha =$modelLinha->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $linhafundo =$modelLinhaFundo->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $manzua =$modelManzua->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $mergulho =$modelMergulho->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $ratoeira =$modelRatoeira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $siripoia =$modelSiripoia->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $tarrafa =$modelTarrafa->selectVBioPeixe("tar_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
            $varapesca =$modelVaraPesca->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
        }
         else{
             $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
             $calao =$modelCalao->selectVBioPeixe("cal_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $coletamanual =$modelColetaManual->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $emalhe =$modelEmalhe->selectVBioPeixe("drecolhimento between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $grosseira =$modelGrosseira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $jerere =$modelJerere->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $pescalinha =$modelLinha->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $linhafundo =$modelLinhaFundo->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $manzua =$modelManzua->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $mergulho =$modelMergulho->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $ratoeira =$modelRatoeira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $siripoia =$modelSiripoia->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $tarrafa =$modelTarrafa->selectVBioPeixe("tar_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
            $varapesca =$modelVaraPesca->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
         }  
        
                
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, 'Arte de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pesqueiro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Espécie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Nome Comum');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sexo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Peso');

        
        $coluna= 0;
        $linha++;
        
        foreach ( $arrasto as $key => $consulta ):
            $pesqueiroArrasto = $modelArrasto->selectArrastoHasPesqueiro('af_id = '.$consulta['af_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Arrasto de Fundo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_id']);
            if(empty($pesqueiroArrasto)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiroArrasto as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        foreach ( $calao as $key => $consulta ):
            $pesqueirocalao = $modelCalao->selectCalaoHasPesqueiro('cal_id = '.$consulta['cal_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Calão');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_id']);
            if(empty($pesqueirocalao)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
            }
            else{
                foreach($pesqueirocalao as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_data']);
            $coluna=0;
            $linha++;
        endforeach; 
		
		
        
        
        foreach ( $coletamanual as $key => $consulta ):
            $pesqueirocoletamanual = $modelColetaManual->selectColetaManualHasPesqueiro('cml_id = '.$consulta['cml_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Coleta Manual');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_id']);
            if(empty($pesqueirocoletamanual)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirocoletamanual as $key => $pesqueiro):
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        
        
        
        foreach ( $emalhe as $key => $consulta ):
            $pesqueiroemalhe = $modelEmalhe->selectEmalheHasPesqueiro('em_id = '.$consulta['em_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Emalhe');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
            if(empty($pesqueiroemalhe)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiroemalhe as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        foreach ( $grosseira as $key => $consulta ):
            $pesqueirogrosseira = $modelGrosseira->selectGrosseiraHasPesqueiro('grs_id = '.$consulta['grs_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Groseira');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
            if(empty($pesqueirogrosseira)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{    
                foreach($pesqueirogrosseira as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        foreach ( $jerere as $key => $consulta ):
            $pesqueirojerere = $modelJerere->selectJerereHasPesqueiro('jre_id = '.$consulta['jre_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Jereré');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_id']);
            if(empty($pesqueirogrosseira)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirojerere as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        foreach ( $pescalinha as $key => $consulta ):
            $pesqueirolinha = $modelLinha->selectLinhaHasPesqueiro('lin_id = '.$consulta['lin_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Linha');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
            if(empty($pesqueirolinha)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirolinha as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linha++;
        endforeach; 
        
        
        
        foreach ( $linhafundo as $key => $consulta ):
            $pesqueirolinhafundo = $modelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id = '.$consulta['lf_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Linha de Fundo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_id']);
            if(empty($pesqueirolinhafundo)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirolinhafundo as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $linhafundo++;
        endforeach; 
        
        
        
        
        foreach ( $manzua as $key => $consulta ):
            $pesqueiromanzua = $modelManzua->selectManzuaHasPesqueiro('man_id = '.$consulta['man_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Manzuá');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_id']);
            if(empty($pesqueiromanzua)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiromanzua as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $manzua++;
        endforeach; 
        
        
        
        foreach ( $mergulho as $key => $consulta ):
            $pesqueiromergulho = $modelMergulho->selectMergulhoHasPesqueiro('mer_id = '.$consulta['mer_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Mergulho');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_id']);
            if(empty($pesqueiromergulho)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiromergulho as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $mergulho++;
        endforeach; 
        
        
        
        foreach ( $ratoeira as $key => $consulta ):
            $pesqueiroratoeira = $modelRatoeira->selectRatoeiraHasPesqueiro('rat_id = '.$consulta['rat_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Ratoeira');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_id']);
            if(empty($pesqueiroratoeira)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueiroratoeira as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $ratoeira++;
        endforeach; 
        
        
        
        foreach ( $siripoia as $key => $consulta ):
            $pesqueirosiripoia = $modelSiripoia->selectSiripoiaHasPesqueiro('sir_id = '.$consulta['sir_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Siripóia');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_id']);
            if(empty($pesqueirosiripoia)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirosiripoia as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
                }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $siripoia++;
        endforeach; 
        
        
        
        foreach ( $tarrafa as $key => $consulta ):
            $pesqueirotarrafa = $modelTarrafa->selectTarrafaHasPesqueiro('tar_id = '.$consulta['tar_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Tarrafa');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
            if(empty($pesqueirotarrafa)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirotarrafa as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
            $coluna=0;
            $tarrafa++;
        endforeach; 
        
        
        
        foreach ( $varapesca as $key => $consulta ):
            $pesqueirovarapesca = $modelVaraPesca->selectVaraPescaHasPesqueiro('vp_id = '.$consulta['vp_id'],null, 1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Vara de Pesca');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_id']);
            if(empty($pesqueirovarapesca)){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
                }
            else{
                foreach($pesqueirovarapesca as $key => $pesqueiro):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
            $coluna=0;
            $varapesca++;
        endforeach; 
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Biometria de Peixes.xls'");
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    public function embarcacaodetalhadaAction(){
        set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $modelRelatorios = new Application_Model_Relatorios();
        
//        $date =  $this->_getParam('data');
//        $datend = $this->_getParam('datafim');
//        
//        $data = $this->dataInicial($date);
//        $datafim = $this->dataFinal($datend);
//        
//        $porto = $this->_getParam('porto');
//        
//        if($porto != '999'){
//        $nomePorto = $this->verifporto($porto);
//        $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//        }
//         else{
//             $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//         }       
       require_once "../library/Classes/PHPExcel.php";

        $embarcacao = $modelRelatorios->selectEmbarcacaoDetalhada(null, 'bar_nome');
        
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        
         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, 'ID Embarcacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Proprietario');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Possui Outras Embarcacoes?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maximo de Tripulantes');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tripulacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Cozinheiro?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Barco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprimento Total');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprimento da Boca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprimento do Calado');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Arqueadura');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Número de Registro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto de Origem');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Casco');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano de Compra');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado de Conservação');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado da Embarcacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Está Paga?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Como foi o Pagamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Financiador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano da Construção');
        
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Propulsao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Modelo do Motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Marca do Motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Potencia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Combustivel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Capacidade de Armazenamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Posto de Combustivel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano do motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado do Motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Já está pago?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Como foi o Pagamento?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Finaciador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano de Fabricacao do Motor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Observacao');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Gasto Mensal com Manutencao');
        
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Atuacao Batimetrica');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Autonomia no Mar');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Frequencia de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Horario de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Capacidade de Armazenamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Conservacao do Pescado');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Colonia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino do Pescado');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Outra Renda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estação que mais pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estação que menos pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Concorrência');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo de Atividade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data da entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevistador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Digitador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Para quem vende');
        
        $coluna= 0;
        $linha++;
        
        foreach ( $embarcacao as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $consulta['bar_id']);
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_id_desembarque']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_id_proprietario']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['proprietario']);
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_id_mestre']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mestre']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_quant_embarcacoes']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_max_tripulantes']);
            if($consulta['ted_tripulacao'] == '0'){
                $consulta['ted_tripulacao'] = 'Não Informado';
            }
            else if($consulta['ted_tripulacao'] == '1'){
                $consulta['ted_tripulacao'] = 'Variável';
            }
            else if($consulta['ted_tripulacao'] == '2'){
                $consulta['ted_tripulacao'] = 'Fixa';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_tripulacao']);
            if($consulta['ted_cozinheiro'] == '0'){
                $consulta['ted_cozinheiro'] = 'Não Informado';
            }
            else if($consulta['ted_cozinheiro'] == '1'){
                $consulta['ted_cozinheiro'] = 'Não';
            }
            else if($consulta['ted_cozinheiro'] == '2'){
                $consulta['ted_cozinheiro'] = 'Sim';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_cozinheiro']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_comp_total']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_comp_boca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_altura_calado']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_arqueadura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_num_registro']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_id_origem']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tcas_tipo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_ano_compra']);
            if($consulta['ted_estado_conservacao'] == '0'){
                $consulta['ted_estado_conservacao'] = 'Não Informado';
            }
            else if($consulta['ted_estado_conservacao'] == '1'){
                $consulta['ted_estado_conservacao'] = 'Nova';
            }
            else if($consulta['ted_estado_conservacao'] == '2'){
                $consulta['ted_estado_conservacao'] = 'Usada';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_estado_conservacao']);
            if($consulta['ted_estado'] == '0'){
                $consulta['ted_estado'] = 'Não Informado';
            }
            else if($consulta['ted_estado'] == '1'){
                $consulta['ted_estado'] = 'Bom';
            }
            else if($consulta['ted_estado'] == '2'){
                $consulta['ted_estado'] = 'Ruim';
            }
            else if($consulta['ted_estado'] == '3'){
                $consulta['ted_estado'] = 'Péssimo';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_estado']);
            if($consulta['ted_pagamento'] == '0'){
                $consulta['ted_pagamento'] = 'Não Informado';
            }
            else if($consulta['ted_pagamento'] == '1'){
                $consulta['ted_pagamento'] = 'Não';
            }
            else if($consulta['ted_pagamento'] == '2'){
                $consulta['ted_pagamento'] = 'Sim';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_pagamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tpg_pagamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tfin_financiador']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ted_ano_construcao']);
            
            $motor = $modelRelatorios->selectMotorEmbarcacao('ted_id ='. $consulta['ted_id']);
            if($consulta['tme_propulsao'] == '0'){
                $consulta['tme_propulsao'] = 'Não Informado';
            }
            else if($consulta['tme_propulsao'] == '1'){
                $consulta['tme_propulsao'] = 'Sem Propulsão';
            }
            else if($consulta['tme_propulsao'] == '2'){
                $consulta['tme_propulsao'] = 'Motor';
            }
            else if($consulta['tme_propulsao'] == '3'){
                $consulta['tme_propulsao'] = 'Remo';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_propulsao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tmot_tipo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tmod_modelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tmar_marca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_potencia']);
            if($consulta['tme_combustivel'] == '0'){
                $consulta['tme_combustivel'] = 'Não Informado';
            }
            else if($consulta['tme_combustivel'] == '1'){
                $consulta['tme_combustivel'] = 'Sem Propulsão';
            }
            else if($consulta['tme_combustivel'] == '2'){
                $consulta['tme_combustivel'] = 'Motor';
            }
            else if($consulta['tme_combustivel'] == '3'){
                $consulta['tme_combustivel'] = 'Remo';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_armazenamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tpc_posto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_ano_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_estado_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_pagamento_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tpg_pagamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tfin_financiador']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_ano_motor_fabricacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $motor[0]['tme_gasto_mensal']);
            
            $atuacao = $modelRelatorios->selectAtuacaoEmbarcacao('ted_id ='. $consulta['ted_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_atuacao_batimatrica']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_autonomia']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tfp_frequencia']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['thp_horario']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_capacidade']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tcp_conserva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tc_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['ttr_descricao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['maior']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['menor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_concorrencia']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_tempo_atividade']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['tae_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['entrevistador']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['digitador']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $atuacao[0]['dp_id_venda']);


            $coluna=0;
            $linha++;
        endforeach; 
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Embarcaçoes Detalhadas.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    public function cpueAction(){
        set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $modelArrasto =    new Application_Model_ArrastoFundo;
        $modelCalao=       new Application_Model_Calao;
        $modelColetaManual=new Application_Model_ColetaManual;
        $modelEmalhe=      new Application_Model_Emalhe;
        $modelGrosseira=   new Application_Model_Grosseira;
        $modelJerere=      new Application_Model_Jerere;
        $modelLinha=       new Application_Model_Linha;
        $modelLinhaFundo=  new Application_Model_LinhaFundo;
        $modelManzua=      new Application_Model_Manzua;
        $modelMergulho=    new Application_Model_Mergulho;
        $modelRatoeira=    new Application_Model_Ratoeira;
        $modelSiripoia=    new Application_Model_Siripoia;
        $modelTarrafa=     new Application_Model_Tarrafa;
        $modelVaraPesca =  new Application_Model_VaraPesca;
        
         $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
//        
//        $porto = $this->_getParam('porto');
        
//        if($porto != '999'){
//            $nomePorto = $this->verifporto($porto);
//            $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $calao =$modelCalao->selectVBioPeixe("cal_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $coletamanual =$modelColetaManual->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $emalhe =$modelEmalhe->selectVBioPeixe("drecolhimento between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $grosseira =$modelGrosseira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $jerere =$modelJerere->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $pescalinha =$modelLinha->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $linhafundo =$modelLinhaFundo->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $manzua =$modelManzua->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $mergulho =$modelMergulho->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $ratoeira =$modelRatoeira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $siripoia =$modelSiripoia->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $tarrafa =$modelTarrafa->selectVBioPeixe("tar_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $varapesca =$modelVaraPesca->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//        }
//         else{
//             $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//             $calao =$modelCalao->selectVBioPeixe("cal_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $coletamanual =$modelColetaManual->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $emalhe =$modelEmalhe->selectVBioPeixe("drecolhimento between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $grosseira =$modelGrosseira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $jerere =$modelJerere->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $pescalinha =$modelLinha->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $linhafundo =$modelLinhaFundo->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $manzua =$modelManzua->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $mergulho =$modelMergulho->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $ratoeira =$modelRatoeira->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $siripoia =$modelSiripoia->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $tarrafa =$modelTarrafa->selectVBioPeixe("tar_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $varapesca =$modelVaraPesca->selectVBioPeixe("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//         }  
         $arrasto = $modelArrasto->cpue(/*"dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum'*/"esp_id = 4532 Or esp_id = 4533 Or esp_id = 4534 Or esp_id = 4536",'tl_id');
             $calao =$modelCalao->cpue(/*"cal_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum'*/null, 'tl_id');
//            $coletamanual =$modelColetaManual->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $emalhe =$modelEmalhe->cpue("drecolhimento between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $grosseira =$modelGrosseira->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $jerere =$modelJerere->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $pescalinha =$modelLinha->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $linhafundo =$modelLinhaFundo->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $manzua =$modelManzua->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $mergulho =$modelMergulho->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $ratoeira =$modelRatoeira->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $siripoia =$modelSiripoia->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $tarrafa =$modelTarrafa->cpue("tar_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $varapesca =$modelVaraPesca->cpue("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
                
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Arrasto de Fundo');

        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, 0);
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, 'Arte');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mês');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Captura Total em kg');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Captura Total em T');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'CPUE (kg)');

        $coluna= 0;
        $linha++;
        
        foreach ( $arrasto as $key => $consulta ):
            if($consulta['cpue'] != ''){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Arrasto de Fundo');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cpue']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mesAno']);
                $coluna=0;
                $linha++;
            }
        endforeach; 
        
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Calão');

        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, 1);
        $objPHPExcel->setActiveSheetIndex(1);
        
        $coluna = 0;
        $linha = 1;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, 'Arte');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Local');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevista');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'CPUE');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mês/Ano');
        $coluna= 0;
        $linha++;
        
        foreach ( $calao as $key => $consulta ):
            if($consulta['cpue'] != ''){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Calão');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cpue']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mesAno']);
            
            $coluna=0;
            $linha++;
            }
        endforeach; 
//		
//		
//        
//        
//        foreach ( $coletamanual as $key => $consulta ):
//            $pesqueirocoletamanual = $modelColetaManual->selectColetaManualHasPesqueiro('cml_id = '.$consulta['cml_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Coleta Manual');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_id']);
//            if(empty($pesqueirocoletamanual)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirocoletamanual as $key => $pesqueiro):
//                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $linha++;
//        endforeach; 
//        
//        
//        
//        
//        
//        
//        foreach ( $emalhe as $key => $consulta ):
//            $pesqueiroemalhe = $modelEmalhe->selectEmalheHasPesqueiro('em_id = '.$consulta['em_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Emalhe');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
//            if(empty($pesqueiroemalhe)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueiroemalhe as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
//            $coluna=0;
//            $linha++;
//        endforeach; 
//        
//        
//        
//        foreach ( $grosseira as $key => $consulta ):
//            $pesqueirogrosseira = $modelGrosseira->selectGrosseiraHasPesqueiro('grs_id = '.$consulta['grs_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Groseira');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
//            if(empty($pesqueirogrosseira)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{    
//                foreach($pesqueirogrosseira as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//                }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $linha++;
//        endforeach; 
//        
//        
//        
//        foreach ( $jerere as $key => $consulta ):
//            $pesqueirojerere = $modelJerere->selectJerereHasPesqueiro('jre_id = '.$consulta['jre_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Jereré');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_id']);
//            if(empty($pesqueirogrosseira)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirojerere as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//                }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $linha++;
//        endforeach; 
//        
//        
//        
//        foreach ( $pescalinha as $key => $consulta ):
//            $pesqueirolinha = $modelLinha->selectLinhaHasPesqueiro('lin_id = '.$consulta['lin_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Linha');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
//            if(empty($pesqueirolinha)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirolinha as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $linha++;
//        endforeach; 
//        
//        
//        
//        foreach ( $linhafundo as $key => $consulta ):
//            $pesqueirolinhafundo = $modelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id = '.$consulta['lf_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Linha de Fundo');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_id']);
//            if(empty($pesqueirolinhafundo)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirolinhafundo as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $linhafundo++;
//        endforeach; 
//        
//        
//        
//        
//        foreach ( $manzua as $key => $consulta ):
//            $pesqueiromanzua = $modelManzua->selectManzuaHasPesqueiro('man_id = '.$consulta['man_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Manzuá');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_id']);
//            if(empty($pesqueiromanzua)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueiromanzua as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//                }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $manzua++;
//        endforeach; 
//        
//        
//        
//        foreach ( $mergulho as $key => $consulta ):
//            $pesqueiromergulho = $modelMergulho->selectMergulhoHasPesqueiro('mer_id = '.$consulta['mer_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Mergulho');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_id']);
//            if(empty($pesqueiromergulho)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueiromergulho as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//                }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $mergulho++;
//        endforeach; 
//        
//        
//        
//        foreach ( $ratoeira as $key => $consulta ):
//            $pesqueiroratoeira = $modelRatoeira->selectRatoeiraHasPesqueiro('rat_id = '.$consulta['rat_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Ratoeira');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_id']);
//            if(empty($pesqueiroratoeira)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueiroratoeira as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $ratoeira++;
//        endforeach; 
//        
//        
//        
//        foreach ( $siripoia as $key => $consulta ):
//            $pesqueirosiripoia = $modelSiripoia->selectSiripoiaHasPesqueiro('sir_id = '.$consulta['sir_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Siripóia');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_id']);
//            if(empty($pesqueirosiripoia)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirosiripoia as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//                }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $siripoia++;
//        endforeach; 
//        
//        
//        
//        foreach ( $tarrafa as $key => $consulta ):
//            $pesqueirotarrafa = $modelTarrafa->selectTarrafaHasPesqueiro('tar_id = '.$consulta['tar_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Tarrafa');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
//            if(empty($pesqueirotarrafa)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirotarrafa as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
//            $coluna=0;
//            $tarrafa++;
//        endforeach; 
//        
//        
//        
//        foreach ( $varapesca as $key => $consulta ):
//            $pesqueirovarapesca = $modelVaraPesca->selectVaraPescaHasPesqueiro('vp_id = '.$consulta['vp_id'],null, 1);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Vara de Pesca');
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['tl_local']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_id']);
//            if(empty($pesqueirovarapesca)){
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, '');
//                }
//            else{
//                foreach($pesqueirovarapesca as $key => $pesqueiro):
//                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
//                endforeach;
//            }
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['esp_nome_comum']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_sexo']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_comprimento']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tbp_peso']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dvolta']);
//            $coluna=0;
//            $varapesca++;
//        endforeach; 
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='CPUE.xls'");
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
    
    
    public function relartesbyportoAction(){
        set_time_limit(0);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $modelArrasto =    new Application_Model_ArrastoFundo;
        $modelCalao=       new Application_Model_Calao;
        $modelColetaManual=new Application_Model_ColetaManual;
        $modelEmalhe=      new Application_Model_Emalhe;
        $modelGrosseira=   new Application_Model_Grosseira;
        $modelJerere=      new Application_Model_Jerere;
        $modelLinha=       new Application_Model_Linha;
        $modelLinhaFundo=  new Application_Model_LinhaFundo;
        $modelManzua=      new Application_Model_Manzua;
        $modelMergulho=    new Application_Model_Mergulho;
        $modelRatoeira=    new Application_Model_Ratoeira;
        $modelSiripoia=    new Application_Model_Siripoia;
        $modelTarrafa=     new Application_Model_Tarrafa;
        $modelVaraPesca =  new Application_Model_VaraPesca;
        
         $date =  $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        
        $porto = $this->_getParam('porto');
        
//        if($porto != '999'){
//            $nomePorto = $this->verifporto($porto);
//            $arrasto = $modelArrasto->selectQuantPescadoresByPorto();
//            $calao =$modelCalao->selectQuantPescadoresByPorto("cal_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $coletamanual =$modelColetaManual->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $emalhe =$modelEmalhe->selectQuantPescadoresByPorto("drecolhimento between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $grosseira =$modelGrosseira->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $jerere =$modelJerere->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $pescalinha =$modelLinha->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $linhafundo =$modelLinhaFundo->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//            $manzua =$modelManzua->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'",      'esp_nome_comum');
//            $mergulho =$modelMergulho->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'",  'esp_nome_comum');
//            $ratoeira =$modelRatoeira->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'",  'esp_nome_comum');
//            $siripoia =$modelSiripoia->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'",   'esp_nome_comum');
//            $tarrafa =$modelTarrafa->selectQuantPescadoresByPorto("tar_data between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'",   'esp_nome_comum');
//            $varapesca =$modelVaraPesca->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."' and pto_nome ='".$nomePorto."'", 'esp_nome_comum');
//        }
//         else{
//             $arrasto = $modelArrasto->selectQuantPescadoresByPorto();
//             $calao =$modelCalao->selectQuantPescadoresByPorto("cal_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $coletamanual =$modelColetaManual->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $emalhe =$modelEmalhe->selectQuantPescadoresByPorto("drecolhimento between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $grosseira =$modelGrosseira->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $jerere =$modelJerere->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $pescalinha =$modelLinha->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $linhafundo =$modelLinhaFundo->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $manzua =$modelManzua->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $mergulho =$modelMergulho->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $ratoeira =$modelRatoeira->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $siripoia =$modelSiripoia->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $tarrafa =$modelTarrafa->selectQuantPescadoresByPorto("tar_data between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//            $varapesca =$modelVaraPesca->selectQuantPescadoresByPorto("dvolta between '". $data."'"." and '".$datafim."'", 'esp_nome_comum');
//         } 
        
                
        require_once "../library/Classes/PHPExcel.php";
        $arrayPortos = array('Amendoeira','Pontal','Prainha','Terminal Pesqueiro','Porto da Barra','São Miguel','Mamoã','Ponta da Tulha','Ponta do Ramo','Aritaguá','Juerana rio','Sambaituba','Urucutuca','Pé de Serra','Sobradinho','Vila Badú','Porto da Concha','Porto do Forte');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   'Arte de Pesca (n)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Praia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Rio');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Calão');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Coleta Manual');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Emalhe');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Groseira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Jereré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Manzuá');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Mergulho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Ratoeira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Siripoia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Tarrafa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'VaraPesca');
        $linha = 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Amendoeira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pontal');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Prainha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Terminal Pesqueiro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto da Barra');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'São Miguel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mamoã');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ponta da Tulha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ponta do Ramo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Aritaguá');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Juerana rio');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sambaituba');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Urucutuca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pé de Serra');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sobradinho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Vila Badú');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto da Concha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto do Forte');

        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrArrasto = $modelArrasto->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrArrasto[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;
        
        
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrAP = $modelCalao->selectEntrevistasByPorto("pto_nome = '".$porto."' And tcat_tipo = 'Arrasto de Praia'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrAP[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrAR = $modelCalao->selectEntrevistasByPorto("pto_nome = '".$porto."' And tcat_tipo = 'Arrasto de Rio'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrAR[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrCalao = $modelCalao->selectEntrevistasByPorto("pto_nome = '".$porto."' And tcat_tipo = 'Calão'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrCalao[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrColetaManual = $modelColetaManual->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrColetaManual[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrEmalhe = $modelEmalhe->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrEmalhe[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrGrosseira = $modelGrosseira->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrGrosseira[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrJerere = $modelJerere->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrJerere[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrLinha = $modelLinha->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrLinha[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrLinhaFundo = $modelLinhaFundo->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrLinhaFundo[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrManzua = $modelManzua->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrManzua[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrMergulho = $modelMergulho->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrMergulho[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrRatoeira = $modelRatoeira->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrRatoeira[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrSiripoia = $modelSiripoia->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrSiripoia[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrTarrafa = $modelTarrafa->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrTarrafa[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=1;
        $linha++;
        foreach ( $arrayPortos as $porto ):
            $quantEntrVaraPesca = $modelVaraPesca->selectEntrevistasByPorto("pto_nome = '".$porto."'");
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  $quantEntrVaraPesca[0]['count']);
            $coluna++;
            //$linha++;
        endforeach; 
        
        $coluna=0;
        $linha++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  'Total');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(B2:B17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(C2:C17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(D2:D17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(E2:E17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(F2:F17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(G2:G17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(H2:H17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(I2:I17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(J2:J17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(K2:K17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(L2:L17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(M2:M17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(N2:N17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(O2:O17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(P2:P17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(Q2:Q17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(R2:R17)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,  '=SUM(S2:S17)');
        
        $linha+=2;
        $coluna = 0;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   'Arte de Pesca (%)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Praia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Rio');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Calão');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Coleta Manual');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Emalhe');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Groseira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Jereré');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha de Fundo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Manzuá');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Mergulho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Ratoeira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Siripoia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'Tarrafa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, ++$linha, 'VaraPesca');
        $linha -=16;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Amendoeira');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pontal');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Prainha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Terminal Pesqueiro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto da Barra');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'São Miguel');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mamoã');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ponta da Tulha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ponta do Ramo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Aritaguá');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Juerana rio');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sambaituba');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Urucutuca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pé de Serra');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sobradinho');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Vila Badú');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto da Concha');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto do Forte');
        $linha++;

        
        for($linhaAux=2; $linhaAux<19; $linhaAux++){
            for($coluna=1; $coluna<19; $coluna++){
                $valEntrevistas = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linhaAux)->getFormattedValue();
                $valTotal = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 18)->getFormattedValue();
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, $valEntrevistas/$valTotal*100);
            }
            $linha++;
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Artes por Portos.xls'");
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
}

