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
        switch($valueRelatorio['artePesca']){
            
            case 1: $this->_redirect("/relatorios/relatoriocompletoarrasto".$data.$datafim);break;
            case 2:$this->_redirect("/relatorios/relatoriocompletocalao/".$rel.$data.$datafim);break;
            case 3:$this->_redirect("/relatorios/relatoriocompletocoletamanual/".$rel.$data.$datafim);break;
            case 4:$this->_redirect("/relatorios/relatoriocompletoemalhe/".$rel.$data.$datafim);break;
            case 5:$this->_redirect("/relatorios/relatoriocompletogroseira/".$rel.$data.$datafim);break;
            case 6:$this->_redirect("/relatorios/relatoriocompletojerere/".$rel.$data.$datafim);break;
            case 7:$this->_redirect("/relatorios/relatoriocompletolinha/".$rel.$data.$datafim);break;
            case 8:$this->_redirect("/relatorios/relatoriocompletolinhafundo/".$rel.$data.$datafim);break;
            case 9:$this->_redirect("/relatorios/relatoriocompletomanzua/".$rel.$data.$datafim);break;
            case 10:$this->_redirect("/relatorios/relatoriocompletomergulho/".$rel.$data.$datafim);break;
            case 11:$this->_redirect("/relatorios/relatoriocompletoratoeira/".$rel.$data.$datafim);break;
            case 12:$this->_redirect("/relatorios/relatoriocompletosiripoia/".$rel.$data.$datafim);break;
            case 13:$this->_redirect("/relatorios/relatoriocompletotarrafa/".$rel.$data.$datafim);break;
            case 14:$this->_redirect("/relatorios/relatoriocompletovarapesca/".$rel.$data.$datafim);break;
            case 15:$this->_redirect("/relatorios/relatoriocompleto/".$rel.$data.$datafim);break;
            case 16:$this->_redirect("/relatorios/relatoriocompletomonitoramentos");break;
            case 17:$this->_redirect("/relatorios/relatoriocompletoespecies");break;
            case 18:$this->_redirect("/relatorios/relatoriocompletoespeciesmes");break;
            case 19:$this->_redirect("/relatorios/relatoriocompletopescadores");break;
            case 20:$this->_redirect("/pescador/relatorioespecialista");break;
            case 21:$this->_redirect("/consulta-padrao/avistamentos");break;
        }
    }
    public function outrosrelatoriosAction(){
        $valueRelatorio = $this->_getAllParams();
        
        
        switch($valueRelatorio['relatorios']){
            case 1:$this->_redirect("/relatorios/relatoriocompletomonitoramentos");break;
            case 2:$this->_redirect("/relatorios/relatoriocompletoespecies");break;
            case 3:$this->_redirect("/relatorios/relatoriocompletoespeciesmes");break;
            case 4:$this->_redirect("/relatorios/relatoriocompletopescadores");break;
            case 5:$this->_redirect("/pescador/relatorioespecialista");break;
            case 6:$this->_redirect("/consulta-padrao/avistamentos");break;
            case 7:$this->_redirect("/relatorios/valorespecies");break;
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
        
        $relatorioArrasto = $this->modelRelatorios->selectArrasto("fd_data between '". $data."'"." and '".$datafim."'");
        
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
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $esp['spc_peso_kg']);
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
        
        $relatorioArrasto = $this->modelRelatorios->selectColetaManual("dvolta between '". $data."'"." and '".$datafim."'");

        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioArrasto as $key => $consulta ):
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
        $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."'");

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

        $relatorioArrasto = $this->modelRelatorios->selectEmalhe("drecolhimento between '". $data."'"." and '".$datafim."'");
        
        $linha = 2;
        $coluna= 0;

        foreach ( $relatorioArrasto as $key => $consulta ):
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

        $relatorioArrasto = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."'");
        
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
        $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."'");

        
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
        $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."'");
      
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
        $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."'");
      
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
        $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."'");
        
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
        $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."'");
        
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
        $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."'");
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
        $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."'");
        
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
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Data do Calão');
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
        $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."'");
        
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
        $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."'");
        
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
        set_time_limit(800);
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
        $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_obs']);
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

        $relatorioColeta = $this->modelRelatorios->selectColetaManual("dvolta between '". $data."'"." and '".$datafim."'");

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
        
        $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("fd_data between '". $data."'"." and '".$datafim."'");
        
        foreach($relatorioEmalhe as $key=> $consulta):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['fd_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dlancamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hlancamento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['drecolhimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['hrecolhimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_numpanos']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_tamanho']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_malha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['em_motor'] = $this->motor($consulta['em_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);

            $Pesqueiros = $this->modelRelatorios->selectEmalheHasPesqueiro('em_id = '.$consulta['em_id']);
             $coluna++;
            foreach($Pesqueiros as $key => $nome):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            
            
            $coluna = 2+$quant;
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
        
        $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['grs_motor'] = $this->motor($consulta['grs_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $Pesqueiros = $this->modelRelatorios->selectGrosseiraHasPesqueiro('grs_id = '.$consulta['grs_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= 2+$quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas('grs_id = '.$consulta['grs_id']);
                
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
        
        $relatorioJerere = $this->modelRelatorios->selectJerere("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['jre_motor'] = $this->motor($consulta['jre_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['jre_mreviva'] = $this->mare($consulta['jre_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
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
        
        $relatorioLinha = $this->modelRelatorios->selectLinha("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
	    
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_diesel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_oleo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_alimento']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_gelo']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            
            $consulta['lin_motor'] = $this->motor($consulta['lin_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
	
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);

            $Pesqueiros = $this->modelRelatorios->selectLinhaHasPesqueiro('lin_id = '.$consulta['lin_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas('lin_id = '.$consulta['lin_id']);
                
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
        
        $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("fd_data between '". $data."'"." and '".$datafim."'");
        
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
	    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            
            $consulta['lf_motor'] = $this->motor($consulta['lf_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            
            $Pesqueiros = $this->modelRelatorios->selectLinhaFundoHasPesqueiro('lf_id = '.$consulta['lf_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas('lf_id = '.$consulta['lf_id']);
                
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
        
        $relatorioManzua = $this->modelRelatorios->selectManzua("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['man_motor'] = $this->motor($consulta['man_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['man_mreviva'] = $this->mare($consulta['man_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_mreviva']);  
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
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
        
        $relatorioMergulho = $this->modelRelatorios->selectMergulho("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['mer_motor'] = $this->motor($consulta['mer_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['mer_mreviva'] = $this->mare($consulta['mer_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_mreviva']);      
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            
            $Pesqueiros = $this->modelRelatorios->selectMergulhoHasPesqueiro('mer_id = '.$consulta['mer_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas('mer_id = '.$consulta['mer_id']);
                
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
        
        $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['rat_motor'] = $this->motor($consulta['rat_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['rat_mreviva'] = $this->mare($consulta['rat_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $Pesqueiros = $this->modelRelatorios->selectRatoeiraHasPesqueiro('rat_id = '.$consulta['rat_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas('rat_id = '.$consulta['rat_id']);
                
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
        
        $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_combustivel']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_numarmadilhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['sir_motor'] = $this->motor($consulta['sir_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['sir_mreviva'] = $this->mare($consulta['sir_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            
            $Pesqueiros = $this->modelRelatorios->selectSiripoiaHasPesqueiro('sir_id = '.$consulta['sir_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas('sir_id = '.$consulta['sir_id']);
                
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
        
        $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '". $data."'"." and '".$datafim."'");
        
        foreach ( $relatorioTarrafa as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['tl_local']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_data']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['1']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_tempogasto']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_quantpescadores']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_numlances']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_roda']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_altura']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_malha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $consulta['tar_motor'] = $this->motor($consulta['tar_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $Pesqueiros = $this->modelRelatorios->selectTarrafaHasPesqueiro('tar_id = '.$consulta['tar_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas('tar_id = '.$consulta['tar_id']);
                
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
        
        $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("fd_data between '". $data."'"." and '".$datafim."'");
        
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numlinhas']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_numanzoisplinha']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['vp_motor'] = $this->motor($consulta['vp_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_motor']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['vp_mreviva'] = $this->mare($consulta['vp_mreviva']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_mreviva']);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dp_destino']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_obs']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['']);
            
            $Pesqueiros = $this->modelRelatorios->selectVaraPescaHasPesqueiro('vp_id = '.$consulta['vp_id']);
                
                $coluna++;
                foreach($Pesqueiros as $key => $nome):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endforeach;
                $coluna= $quant;
                foreach($Pesqueiros as $key => $tempo):
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endforeach;
                
                $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas('vp_id = '.$consulta['vp_id']);
                
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
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Monitorados');
        
        $coluna= 0;
        $linha++;
        foreach ( $monitoramentos as $key => $consulta ):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_nome']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tap_artepesca']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mes']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['ano']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['naomonitorados']);
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
    
    public function biometrias(){
        set_time_limit(300);
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
        
        $modelArrasto->selectVBioCamarao();
        $modelCalao->selectVBioCamarao();
        $modelColetaManual->selectVBioCamarao();
        $modelEmalhe->selectVBioCamarao();
        $modelGrosseira->selectVBioCamarao();
        $modelJerere->selectVBioCamarao();
        $modelLinha->selectVBioCamarao();
        $modelLinhaFundo->selectVBioCamarao();
        $modelManzua->selectVBioCamarao();
        $modelMergulho->selectVBioCamarao();
        $modelRatoeira->selectVBioCamarao();
        $modelSiripoia->selectVBioCamarao();
        $modelTarrafa->selectVBioCamarao();
        $modelVaraPesca->selectVBioCamarao();
                
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
    }
}

