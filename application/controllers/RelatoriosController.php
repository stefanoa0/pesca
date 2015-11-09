
<?php

ini_set('memory_limit', '-1');

class RelatoriosController extends Zend_Controller_Action {

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $identity2 = get_object_vars($identity);
        }
        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario", $this->usuario);



        if ($this->usuario['tp_id'] == 15 | $this->usuario['tp_id'] == 17 | $this->usuario['tp_id'] == 21) {
            $this->_redirect('index');
        }
        $this->modelRelatorios = new Application_Model_Relatorios();
    }
    
    function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

       if( is_string( $dt_menor)) {$dt_menor = date_create( $dt_menor);}
    if( is_string( $dt_maior)) {$dt_maior = date_create( $dt_maior);}

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
       
       switch( $str_interval){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }

    public function indexAction() {

        $modelPorto = new Application_Model_Porto();

        $porto = $modelPorto->select(null, 'pto_nome');

        $this->view->assign("portos", $porto);
    }

    public function graficosAction() {
        
    }

    public function monitoramentosAction() {
        $consultaPadrao = new Application_Model_VConsultaPadrao();
        $selectMonitoramentos = $consultaPadrao->selectMonitoramentos();

        $this->view->assign("monitoramentos", $selectMonitoramentos);
    }

    public function gerarAction() {

        $valueRelatorio = $this->_getAllParams();
        $rel = $valueRelatorio['tipoRelatorio'];
        $rel = 'id/' . $rel;

        $dia = $valueRelatorio['dia_ini'];
        $mes = $valueRelatorio['mes_ini'];
        $ano = $valueRelatorio['ano_ini'];
        $data = $ano . '-' . $mes . '-' . $dia;
        $data = '/data/' . $data;

        $diafim = $valueRelatorio['dia_fim'];
        $mesfim = $valueRelatorio['mes_fim'];
        $anofim = $valueRelatorio['ano_fim'];
        $datafim = $anofim . '-' . $mesfim . '-' . $diafim;

        $datafim = '/datafim/' . $datafim;


        $porto = $valueRelatorio['porto'];

        $porto = '/porto/' . $porto;

        switch ($valueRelatorio['artePesca']) {

            case 1:$this->_redirect("/relatorios/relatoriocompletoarrasto/" . $rel . $data . $datafim . $porto);
                break;
            case 2:$this->_redirect("/relatorios/relatoriocompletocalao/" . $rel . $data . $datafim . $porto);
                break;
            case 3:$this->_redirect("/relatorios/relatoriocompletocoletamanual/" . $rel . $data . $datafim . $porto);
                break;
            case 4:$this->_redirect("/relatorios/relatoriocompletoemalhe/" . $rel . $data . $datafim . $porto);
                break;
            case 5:$this->_redirect("/relatorios/relatoriocompletogroseira/" . $rel . $data . $datafim . $porto);
                break;
            case 6:$this->_redirect("/relatorios/relatoriocompletojerere/" . $rel . $data . $datafim . $porto);
                break;
            case 7:$this->_redirect("/relatorios/relatoriocompletolinha/" . $rel . $data . $datafim . $porto);
                break;
            case 8:$this->_redirect("/relatorios/relatoriocompletolinhafundo/" . $rel . $data . $datafim . $porto);
                break;
            case 9:$this->_redirect("/relatorios/relatoriocompletomanzua/" . $rel . $data . $datafim . $porto);
                break;
            case 10:$this->_redirect("/relatorios/relatoriocompletomergulho/" . $rel . $data . $datafim . $porto);
                break;
            case 11:$this->_redirect("/relatorios/relatoriocompletoratoeira/" . $rel . $data . $datafim . $porto);
                break;
            case 12:$this->_redirect("/relatorios/relatoriocompletosiripoia/" . $rel . $data . $datafim . $porto);
                break;
            case 13:$this->_redirect("/relatorios/relatoriocompletotarrafa/" . $rel . $data . $datafim . $porto);
                break;
            case 14:$this->_redirect("/relatorios/relatoriocompletovarapesca/" . $rel . $data . $datafim . $porto);
                break;
            case 15:$this->_redirect("/relatorios/relatoriocompleto/" . $rel . $data . $datafim . $porto);
                break;
            case 16:$this->_redirect("/relatorios/biometriascamarao" . $data . $datafim . $porto);
                break;
            case 17:$this->_redirect("/relatorios/biometriaspeixe" . $data . $datafim . $porto);
                break;
            case 18:$this->_redirect("/relatorios/cpue" . $data . $datafim . $porto);
                break;
            case 19:$this->_redirect("/relatorios/relartesbyporto" . $data . $datafim . $porto);
                break;
            case 20:$this->_redirect("/relatorios/relatorioestimativas" . $data . $datafim . $porto);
                break;
            case 21:$this->_redirect("/relatorios/relatoriocompletoresumido/" . $rel . $data . $datafim . $porto);
                break;
        }
    }

    public function gerarnovoAction() {

        $valueRelatorio = $this->_getAllParams();

        $rel = 'id/' . $rel;

        $dia = $valueRelatorio['dia_ini'];
        $mes = $valueRelatorio['mes_ini'];
        $ano = $valueRelatorio['ano_ini'];
        $data = $ano . '-' . $mes . '-' . $dia;
        $data = '/data/' . $data;

        $diafim = $valueRelatorio['dia_fim'];
        $mesfim = $valueRelatorio['mes_fim'];
        $anofim = $valueRelatorio['ano_fim'];
        $datafim = $anofim . '-' . $mesfim . '-' . $diafim;

        $datafim = '/datafim/' . $datafim;


        $porto = $valueRelatorio['porto'];

        $porto = '/porto/' . $porto;

        switch ($valueRelatorio['artePesca']) {

            case 18:$this->_redirect("/relatorios/cpue" . $data . $datafim . $porto);
                break;
            case 19:$this->_redirect("/relatorios/relartesbyporto" . $data . $datafim . $porto);
                break;
            case 20:$this->_redirect("/relatorios/relatorioestimativas" . $data . $datafim . $porto);
                break;
        }
    }

    public function listaEspecies($relatorioEspecies, $coluna, $linha, $objPHPExcel) {
        $sheet = $objPHPExcel->getActiveSheet();
        foreach ($relatorioEspecies as $key => $especie):
            $sheet->setCellValueByColumnAndRow($coluna++, $linha, $especie['esp_nome_comum']);
        endforeach;
        return $coluna;
    }

    public function verificaTipoRel($espRel) {
        if (empty($espRel)) {
            $espRel = '0';
        }
        return $espRel;
    }

    public function deleterelatorioAction() {
        if ($this->usuario['tp_id'] == 5) {
            $this->_redirect('index');
        }
        $relatorio = $this->_getParam('nome');
        $diretorio = $this->_getParam('diretorio');

        unlink($diretorio . '/' . $relatorio);
        $this->redirect('relatorios/index');
    }

    public function verificaRelatorio($var) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if ($var === '1' || $var === '0') {
            $tipoRel = 'spc_peso_kg';
        }
        if ($var === '2') {
            $tipoRel = 'spc_quantidade';
        }
        if ($var === '3') {
            $tipoRel = 'spc_preco';
        }
        return $tipoRel;
    }

    public function motor($var) {

        if ($var == false) {
            $var = "Não";
        } else {
            $var = "Sim";
        }
        return $var;
    }

    public function mare($mare) {

        if ($mare == false) {
            $mare = "Morta";
        } else {
            $mare = "Viva";
        }
        return $mare;
    }

    public function dataFinal($data) {

        if ($data == '--') {
            $data = date('Y-m-j');
        }
        return $data;
    }

    public function dataInicial($data) {
        if ($data == '--') {
            $data = '2013-10-01';
        }
        return $data;
    }

    public function loadingAction() {
        
    }

    public function formataDataPtbr($data) {
        $explode = explode('-', $data);

        return $explode[2] . '/' . $explode[1] . '/' . $explode[0];
    }

    public function relatoriocompletoarrastoAction() {
        $inicio1 = microtime(true);
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);


        $this->modelRelatorios = new Application_Model_Relatorios();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 21;

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');


        $maxPesqueiros = $this->modelRelatorios->countPesqueirosArrasto();
        $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
        $firstColunaEspecies = $colunaEspecies;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspecies();
        $sizeEspecies = $this->listaEspecies($relatorioEspecies, $colunaEspecies, $linha, $objPHPExcel);
        $Pesqueiros = $this->modelRelatorios->selectArrastoHasPesqueiro();
        
        $linha = 2;
        $coluna = 0;
        
        foreach ($relatorioArrasto as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_gelo']);
            $consulta['af_motor'] = $this->motor($consulta['af_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_obs']);
            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                if ($nome['af_id'] == $consulta['af_id']):
                    $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endif;
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                if ($tempo['af_id'] == $consulta['af_id']):
                    $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempopesqueiro']);
                endif;
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $Relesp = $this->modelRelatorios->selectArrastoHasEspCapturadas('af_id = '.$consulta['af_id'], 'esp_nome_comum');
            $colunaEspecies = $this->relatorioEspecies($relatorioEspecies, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'af_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $fim1 = microtime(true);

        //$sheet->setCellValueByColumnAndRow(1, $linha, $fim1-$inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioArrasto_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioArrasto_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatorioEspecies($relatorioEspecies, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, $id, $tipoRel) {
        foreach ($relatorioEspecies as $key => $nomeEspecie):
            foreach ($Relesp as $key => $esp):
                if ($esp[$id] == $consulta[$id] && $esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                    break;
                }
//                            $colunaEspecies++;
            endforeach;
            if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
            }
            $colunaEspecies++;
        endforeach;
        return $colunaEspecies;
    }

    public function relatoriocompletocoletamanualAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $quant = 19;
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosColetaManual();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioColetaManual = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioColetaManual = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspeciesColetaManual = $this->modelRelatorios->selectNomeEspeciesColetaManual();
        $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas(null, 'esp_nome_comum');
        $lastcolumn = $this->listaEspecies($relatorioEspeciesColetaManual, $coluna, $linha, $objPHPExcel);
        $Pesqueiros = $this->modelRelatorios->selectColetaManualHasPesqueiro();
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioColetaManual as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['cml_mreviva'] = $this->mare($consulta['cml_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_mreviva']);
            $consulta['cml_motor'] = $this->motor($consulta['cml_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_obs']);
            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                if ($nome['cml_id'] == $consulta['cml_id']):
                    $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endif;
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                if ($nome['cml_id'] == $consulta['cml_id']):
                    $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
                endif;
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesColetaManual, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'cml_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioColetaManual_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioColetaManual_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletocalaoAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();
        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 21;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data do Calão');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Num panos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tamanhos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Altura');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha2');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha3');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Calão');

        $relatorioEspeciesCalao = $this->modelRelatorios->selectNomeEspeciesCalao();

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosCalao();
        $coluna = $maxPesqueiros[0]['count'] + $quant;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $lastcolumn = $this->listaEspecies($relatorioEspeciesCalao, $coluna, $linha, $objPHPExcel);

        $Pesqueiros = $this->modelRelatorios->selectCalaoHasPesqueiro();
        $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas(null, 'esp_nome_comum');
        //$lastcolumn = $this->listaEspecies($relatorioEspecies, $coluna, $linha, $objPHPExcel);
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioCalao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_npanos']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_tamanho']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha1']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha2']);
            $consulta['cal_motor'] = $this->motor($consulta['cal_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tcat_tipo']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                if ($nome['cal_id'] == $consulta['cal_id']):
                    $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
                endif;
            endforeach;


            $colunaEspecies = $maxPesqueiros[0]['count'] + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesCalao, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'cal_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioCalao_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioCalao_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletoemalheAction() {
        set_time_limit(0);
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 25;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Lançamento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Lançamento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Recolhimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Recolhimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tamanho');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Altura');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Panos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosEmalhe();
        $coluna = $maxPesqueiros[0]['count'] + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspeciesEmalhe = $this->modelRelatorios->selectNomeEspeciesEmalhe();
        $lastcolumn = $this->listaEspecies($relatorioEspeciesEmalhe, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas(null, 'esp_nome_comum');
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioEmalhe as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['drecolhimento']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dlancamento']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hlancamento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['drecolhimento']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hrecolhimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dlancamento'].' '.$consulta['hlancamento'],$consulta['drecolhimento'].' '.$consulta['hrecolhimento'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_tamanho']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_numpanos']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_malha']);

            $consulta['em_motor'] = $this->motor($consulta['em_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_obs']);
            $Pesqueiros = $this->modelRelatorios->selectEmalheHasPesqueiro('em_id = ' . $consulta['em_id']);
            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;


            $colunaEspecies = $maxPesqueiros[0]['count'] + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesEmalhe, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'em_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioEmalhe_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioEmalhe_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletogroseiraAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();


        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 24;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Linhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Anzóis por Linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Isca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');


        $maxPesqueiros = $this->modelRelatorios->countPesqueirosGrosseira();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;
        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspeciesGrosseira = $this->modelRelatorios->selectNomeEspeciesGrosseira();
        $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas(null, 'esp_nome_comum');
        $lastcolumn = $this->listaEspecies($relatorioEspeciesGrosseira, $coluna, $linha, $objPHPExcel);
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioGrosseira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);

            $consulta['grs_motor'] = $this->motor($consulta['grs_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_obs']);
            $Pesqueiros = $this->modelRelatorios->selectGrosseiraHasPesqueiro('grs_id = ' . $consulta['grs_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesGrosseira, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'grs_id', $tipoRel);


            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioGrosseira_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioGroseira_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletojerereAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();


        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Armadilhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustível');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosJerere();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspeciesJerere = $this->modelRelatorios->selectNomeEspeciesJerere();

        $lastcolumn = $this->listaEspecies($relatorioEspeciesJerere, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas(null, '');
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioJerere as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['jre_mreviva'] = $this->mare($consulta['jre_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_combustivel']);
            $consulta['jre_motor'] = $this->motor($consulta['jre_motor']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_obs']);

            $Pesqueiros = $this->modelRelatorios->selectJerereHasPesqueiro('jre_id = ' . $consulta['jre_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesJerere, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'jre_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioJereré_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioJerere_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletolinhaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 24;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Linhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Anzóis por Linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Isca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosLinha();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesLinha = $this->modelRelatorios->selectNomeEspeciesLinha();

        $lastcolumn = $this->listaEspecies($relatorioEspeciesLinha, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas(null, 'esp_nome_comum');
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioLinha as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['lin_motor'] = $this->motor($consulta['lin_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_obs']);
            $Pesqueiros = $this->modelRelatorios->selectLinhaHasPesqueiro('lin_id = ' . $consulta['lin_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesLinha, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'lin_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioLinha' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioLinha_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletolinhafundoAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 25;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Linhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Anzóis por Linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Isca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosLinhaFundo();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $relatorioEspeciesLinhaFundo = $this->modelRelatorios->selectNomeEspeciesLinhaFundo();
        $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas();
        $lastcolumn = $this->listaEspecies($relatorioEspeciesLinhaFundo, $coluna, $linha, $objPHPExcel);
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioLinhaFundo as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['lf_motor'] = $this->motor($consulta['lf_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_obs']);

            $Pesqueiros = $this->modelRelatorios->selectLinhaFundoHasPesqueiro('lf_id = ' . $consulta['lf_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesLinhaFundo, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'lf_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioLinhaFundo_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioLinhaFundo_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletomanzuaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustível');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Armadilhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosManzua();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesManzua = $this->modelRelatorios->selectNomeEspeciesManzua();
        $lastcolumn = $this->listaEspecies($relatorioEspeciesManzua, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas(null, 'esp_nome_comum');

        $linha = 2;
        $coluna = 0;
        foreach ($relatorioManzua as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_combustivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['man_mreviva'] = $this->mare($consulta['man_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_mreviva']);

            $consulta['man_motor'] = $this->motor($consulta['man_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_obs']);

            $Pesqueiros = $this->modelRelatorios->selectManzuaHasPesqueiro('man_id = ' . $consulta['man_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesManzua, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'man_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioManzua' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioManzua_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletomergulhoAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 19;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Chegada');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosMergulho();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesMergulho = $this->modelRelatorios->selectNomeEspeciesMergulho();

        $lastcolumn = $this->listaEspecies($relatorioEspeciesMergulho, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas();
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioMergulho as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['mer_mreviva'] = $this->mare($consulta['mer_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_mreviva']);
            $consulta['mer_motor'] = $this->motor($consulta['mer_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_obs']);

            $Pesqueiros = $this->modelRelatorios->selectMergulhoHasPesqueiro('mer_id = ' . $consulta['mer_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesMergulho, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'mer_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioMergulho_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioMergulho_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletoratoeiraAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Armadilhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustível');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosRatoeira();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesRatoeira = $this->modelRelatorios->selectNomeEspeciesRatoeira();

        $lastcolumn = $this->listaEspecies($relatorioEspeciesRatoeira, $coluna, $linha, $objPHPExcel);
        $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas(null, 'esp_nome_comum');
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioRatoeira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['rat_mreviva'] = $this->mare($consulta['rat_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_combustivel']);
            $consulta['rat_motor'] = $this->motor($consulta['rat_motor']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_obs']);

            $Pesqueiros = $this->modelRelatorios->selectRatoeiraHasPesqueiro('rat_id = ' . $consulta['rat_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesRatoeira, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'rat_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioRatoeira_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioRatoeira_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletosiripoiaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 22;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Armadilhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustível');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosSiripoia();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesSiripoia = $this->modelRelatorios->selectNomeEspeciesSiripoia();

        $lastcolumn = $this->listaEspecies($relatorioEspeciesSiripoia, $coluna, $linha, $objPHPExcel);

        $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas(null, 'esp_nome_comum');
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioSiripoia as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['sir_mreviva'] = $this->mare($consulta['sir_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_combustivel']);
            $consulta['sir_motor'] = $this->motor($consulta['sir_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_obs']);

            $Pesqueiros = $this->modelRelatorios->selectSiripoiaHasPesqueiro('sir_id = ' . $consulta['sir_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesSiripoia, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'sir_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioSiripoia_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioSiripoia_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletotarrafaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);



        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 18;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data da Tarrafa');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Roda');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Altura');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Lances');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');

        $maxPesqueiros = $this->modelRelatorios->countPesqueirosTarrafa();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesTarrafa = $this->modelRelatorios->selectNomeEspeciesTarrafa();
        $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas(null, 'esp_nome_comum');
        $lastcolumn = $this->listaEspecies($relatorioEspeciesTarrafa, $coluna, $linha, $objPHPExcel);
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioTarrafa as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_roda']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_malha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_numlances']);
            $consulta['tar_motor'] = $this->motor($consulta['tar_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_obs']);

            $Pesqueiros = $this->modelRelatorios->selectTarrafaHasPesqueiro('tar_id = ' . $consulta['tar_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;


            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesTarrafa, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'tar_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioTarrafa_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioTarrafa_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletovarapescaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 28;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saída');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Diesel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Óleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimentos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Linhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Anzois Por linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Isca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosVaraPesca();
        $coluna = $maxPesqueiros[0]['count'] * 2 + $quant;


        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $relatorioEspeciesVaraPesca = $this->modelRelatorios->selectNomeEspeciesVaraPesca();
        $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas(null, 'esp_nome_comum');
        $lastcolumn = $this->listaEspecies($relatorioEspeciesVaraPesca, $coluna, $linha, $objPHPExcel);
        $linha = 2;
        $coluna = 0;
        foreach ($relatorioVaraPesca as $key => $consulta):

            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['vp_mreviva'] = $this->mare($consulta['vp_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_mreviva']);
            $consulta['vp_motor'] = $this->motor($consulta['vp_motor']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_obs']);

            $Pesqueiros = $this->modelRelatorios->selectVaraPescaHasPesqueiro('vp_id = ' . $consulta['vp_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = $maxPesqueiros[0]['count'] + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
            $colunaEspecies = $this->relatorioEspecies($relatorioEspeciesVaraPesca, $Relesp, $colunaEspecies, $linha, $sheet, $consulta, 'vp_id', $tipoRel);

            $coluna = 0;
            $linha++;
        endforeach;




        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioVaraPesca_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioVaraPesca_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletoresumidoAction() {
        ini_set('memory_limit', '-1');
        $inicio1 = microtime(true);
        set_time_limit(0);
        if ($this->usuario['tp_id'] == 5) {
            $this->_redirect('index');
        }
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender(true);
        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);
        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');
        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);
        $this->modelRelatorios = new Application_Model_Relatorios();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        $coluna = 0;
        $linha = 1;

        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Saida');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Calão');

        $relatorioEspecies = $this->modelRelatorios->selectEspecies();
        $coluna++;
        $lastcolumn = $this->listaEspecies($relatorioEspecies, $coluna, $linha, $objPHPExcel);
        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $linha = 2;
        $coluna = 0;
        $Relesp = $this->modelRelatorios->selectArrastoHasEspCapturadas();
        foreach ($relatorioArrasto as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['af_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $coluna++;
            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectArrastoHasEspCapturadas('af_id = '.$consulta['af_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;

        //unset($relatorioArrasto);
        //unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas();
        foreach ($relatorioCalao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '1');
            $explodedata = explode("-", $consulta['cal_data']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cal_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tcat_tipo']);
            $coluna++;

            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas('cal_id = '.$consulta['cal_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioCalao);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas();
        foreach ($relatorioColeta as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['cml_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $coluna++;

            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas('cml_id = '.$consulta['cml_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioColeta);
//        unset($Relesp);
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas();
        foreach ($relatorioEmalhe as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dlancamento']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['drecolhimento']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dlancamento'].' '.$consulta['hlancamento'],$consulta['drecolhimento'].' '.$consulta['hrecolhimento'])/60)/60)/24);
            $explodedata = explode("-", $consulta['drecolhimento']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['em_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $coluna++;

            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas('em_id = '.$consulta['em_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioEmalhe);
//        unset($Relesp);
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas();
        foreach ($relatorioGrosseira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['grs_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');
            $coluna++;

            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas('grs_id = '.$consulta['grs_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioGrosseira);
//        unset($Relesp);
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas();
        foreach ($relatorioJerere as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['jre_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas('jre_id = '.$consulta['jre_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            unset($consulta);

        endforeach;
//        
//        unset($relatorioJerere);
//        unset($Relesp);
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas();
        foreach ($relatorioLinha as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lin_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas('lin_id = '.$consulta['lin_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            unset($consulta);
        endforeach;
//        
//        unset($relatorioLinha);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas();
        foreach ($relatorioLinhaFundo as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['lf_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas('lf_id = '.$consulta['lf_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioLinhaFundo);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas();
        foreach ($relatorioManzua as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['man_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas('man_id = '.$consulta['man_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            unset($consulta);
        endforeach;
//        
//        unset($relatorioManzua);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas();
        foreach ($relatorioMergulho as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['mer_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas('mer_id = '.$consulta['mer_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
        unset($relatorioMergulho);
        unset($Relesp);

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas();
        foreach ($relatorioRatoeira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['rat_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas('rat_id = '.$consulta['rat_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        unset($relatorioRatoeira);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas();
        foreach ($relatorioSiripoia as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['sir_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas('sir_id = '.$consulta['sir_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            //unset($consulta);
        endforeach;
//        
//        unset($relatorioSiripoia);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas();
        foreach ($relatorioTarrafa as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['tar_data']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['tar_data']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '1');
            $explodedata = explode("-", $consulta['tar_data']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tar_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas('tar_id = '.$consulta['tar_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            unset($consulta);
        endforeach;
//        
//        unset($relatorioTarrafa);
//        unset($Relesp);
//        
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $porto2 = null;
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas();
        foreach ($relatorioVaraPesca as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $explodedata = explode("-", $consulta['dvolta']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[1]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $explodedata[0]);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['vp_id']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow(++$coluna, $linha, '');

            $coluna++;
            $colunaEspecies = $coluna;
            $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas('vp_id = '.$consulta['vp_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): foreach ($Relesp as $key => $esp): if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
            unset($consulta);
        endforeach;
//        
//        unset($relatorioVaraPesca);
//        unset($Relesp);
//        unset($relatorioEspecies);
//        
        $fim1 = microtime(true);
        $sheet->setCellValueByColumnAndRow(1, $linha, $fim1 - $inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioCompletoResumido_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioCompletoResumido_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletoAction() {
        ini_set('memory_limit', '-1');
        $inicio1 = microtime(true);
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $this->modelRelatorios = new Application_Model_Relatorios();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $quant = 37;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Saida');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Saida');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Hora Volta');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo Gasto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Código');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Pescadores');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustivel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Oleo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Alimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gelo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Lances');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de panos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Roda');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tamanhos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Altura');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha2');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Malha3');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Linhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Anzóis Por Linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Armadilhas');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Isca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Motor?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Maré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino da Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Calão');
        $coluna = 3 + $quant;
        $relatorioEspecies = $this->modelRelatorios->selectEspecies();
        $lastcolumn = $this->listaEspecies($relatorioEspecies, $coluna, $linha, $objPHPExcel);


        $porto = $this->_getParam('porto');
        $linha = 2;
        $coluna = 0;
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioCalao = $this->modelRelatorios->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas();

        foreach ($relatorioCalao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_npanos']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_tamanho']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha1']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_malha2']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['cal_motor'] = $this->motor($consulta['cal_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tcat_tipo']);

            $Pesqueiros = $this->modelRelatorios->selectCalaoHasPesqueiro('cal_id = ' . $consulta['cal_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;


            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectCalaoHasEspCapturadas('cal_id = ' . $consulta['cal_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie):
                foreach ($Relesp as $key => $esp):
                    if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioColeta = $this->modelRelatorios->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas();
        foreach ($relatorioColeta as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            if ($consulta['dias'] == '0') {
                $consulta['dias'] = '1';
            }
            
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['cml_mreviva'] = $this->mare($consulta['cml_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_mreviva']);
            $consulta['cml_motor'] = $this->motor($consulta['cml_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_obs']);


            $Pesqueiros = $this->modelRelatorios->selectColetaManualHasPesqueiro('cml_id = ' . $consulta['cml_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectColetaManualHasEspCapturadas('cml_id = ' . $consulta['cml_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioEmalhe = $this->modelRelatorios->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas();
        foreach ($relatorioEmalhe as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dlancamento']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hlancamento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['drecolhimento']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hrecolhimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dlancamento'].' '.$consulta['hlancamento'],$consulta['drecolhimento'].' '.$consulta['hrecolhimento'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_numpanos']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_tamanho']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_malha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['em_motor'] = $this->motor($consulta['em_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectEmalheHasPesqueiro('em_id = ' . $consulta['em_id']);
            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;


            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectEmalheHasEspCapturadas('em_id = ' . $consulta['em_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioGrosseira = $this->modelRelatorios->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas();
        foreach ($relatorioGrosseira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_id']);
            $consulta['grs_motor'] = $this->motor($consulta['grs_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectGrosseiraHasPesqueiro('grs_id = ' . $consulta['grs_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;


            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectGrosseiraHasEspCapturadas('grs_id = '.$consulta['grs_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioJerere = $this->modelRelatorios->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas();
        foreach ($relatorioJerere as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_combustivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['jre_motor'] = $this->motor($consulta['jre_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['jre_mreviva'] = $this->mare($consulta['jre_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectJerereHasPesqueiro('jre_id = ' . $consulta['jre_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectJerereHasEspCapturadas('jre_id = ' . $consulta['jre_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie):
                foreach ($Relesp as $key => $esp):
                    if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
//                            $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinha = $this->modelRelatorios->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas();
        foreach ($relatorioLinha as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);

            $consulta['lin_motor'] = $this->motor($consulta['lin_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectLinhaHasPesqueiro('lin_id = ' . $consulta['lin_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectLinhaHasEspCapturadas('lin_id = ' . $consulta['lin_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie):
                foreach ($Relesp as $key => $esp):
                    if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
//                            $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioLinhaFundo = $this->modelRelatorios->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas();
        foreach ($relatorioLinhaFundo as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);

            $consulta['lf_motor'] = $this->motor($consulta['lf_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');

            $Pesqueiros = $this->modelRelatorios->selectLinhaFundoHasPesqueiro('lf_id = ' . $consulta['lf_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;


            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectLinhaFundoHasEspCapturadas('lf_id = ' . $consulta['lf_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioManzua = $this->modelRelatorios->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas();
        foreach ($relatorioManzua as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_combustivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['man_motor'] = $this->motor($consulta['man_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['man_mreviva'] = $this->mare($consulta['man_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectManzuaHasPesqueiro('man_id = ' . $consulta['man_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;



            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectManzuaHasEspCapturadas('man_id = '.$consulta['man_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): foreach ($Relesp as $key => $esp): if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioMergulho = $this->modelRelatorios->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas();
        foreach ($relatorioMergulho as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['mer_motor'] = $this->motor($consulta['mer_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['mer_mreviva'] = $this->mare($consulta['mer_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');

            $Pesqueiros = $this->modelRelatorios->selectMergulhoHasPesqueiro('mer_id = ' . $consulta['mer_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectMergulhoHasEspCapturadas('mer_id = '.$consulta['mer_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioRatoeira = $this->modelRelatorios->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas();
        foreach ($relatorioRatoeira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_combustivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['rat_motor'] = $this->motor($consulta['rat_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['rat_mreviva'] = $this->mare($consulta['rat_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectRatoeiraHasPesqueiro('rat_id = ' . $consulta['rat_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectRatoeiraHasEspCapturadas('rat_id = '.$consulta['rat_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): foreach ($Relesp as $key => $esp): if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioSiripoia = $this->modelRelatorios->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas();
        foreach ($relatorioSiripoia as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_combustivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_numarmadilhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['sir_motor'] = $this->motor($consulta['sir_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['sir_mreviva'] = $this->mare($consulta['sir_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');

            $Pesqueiros = $this->modelRelatorios->selectSiripoiaHasPesqueiro('sir_id = ' . $consulta['sir_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectSiripoiaHasEspCapturadas('sir_id = '.$consulta['sir_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): foreach ($Relesp as $key => $esp): if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioTarrafa = $this->modelRelatorios->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "'");
        }

        $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas();
        foreach ($relatorioTarrafa as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['tar_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['tar_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_numlances']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_roda']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_altura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_malha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $consulta['tar_motor'] = $this->motor($consulta['tar_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $Pesqueiros = $this->modelRelatorios->selectTarrafaHasPesqueiro('tar_id = ' . $consulta['tar_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectTarrafaHasEspCapturadas('tar_id = '.$consulta['tar_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioVaraPesca = $this->modelRelatorios->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "'");

            $porto2 = null;
        }
        $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas();
        foreach ($relatorioVaraPesca as $key => $consulta):

            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['fd_data']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dsaida']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hsaida']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['hvolta']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, (($this->s_datediff('s',$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/60)/24);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_tempogasto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_quantpescadores']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_diesel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_oleo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_alimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_gelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_numlinhas']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_numanzoisplinha']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['isc_tipo']);
            $consulta['vp_motor'] = $this->motor($consulta['vp_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mre_tipo']);
            $consulta['vp_mreviva'] = $this->mare($consulta['vp_mreviva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_mreviva']);

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');

            $Pesqueiros = $this->modelRelatorios->selectVaraPescaHasPesqueiro('vp_id = ' . $consulta['vp_id']);

            $coluna++;
            foreach ($Pesqueiros as $key => $nome):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $nome['paf_pesqueiro']);
            endforeach;
            $coluna = 2 + $quant;
            foreach ($Pesqueiros as $key => $tempo):
                $sheet->setCellValueByColumnAndRow($coluna++, $linha, $tempo['t_tempoapesqueiro']);
            endforeach;

            $colunaEspecies = 4 + $quant;
            $Relesp = $this->modelRelatorios->selectVaraPescaHasEspCapturadas('vp_id = '.$consulta['vp_id']);
            foreach ($relatorioEspecies as $key => $nomeEspecie): 
                foreach ($Relesp as $key => $esp): 
                if ($esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, $this->verificaTipoRel($esp[$tipoRel]));
                        break;
                    }
// $colunaEspecies++;
                endforeach;
                if (empty($sheet->getCellByColumnAndRow($colunaEspecies, $linha)->getFormattedValue())) {
                    $sheet->setCellValueByColumnAndRow($colunaEspecies, $linha, '0');
                }
                $colunaEspecies++;
            endforeach;
            $coluna = 0;
            $linha++;
        endforeach;

        $fim1 = microtime(true);

        $sheet->setCellValueByColumnAndRow(1, $linha, $fim1 - $inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioCompleto_' . $tipoRel . '.xls"');
//        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioCompleto_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function relatoriocompletomonitoramentosAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $monitoramentos = $this->modelRelatorios->selectMonitoramentos();


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Não Monitorados');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Contagem de Entrevistas Monitoradas');

        $coluna = 0;
        $linha++;
        foreach ($monitoramentos as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            if ($consulta['monitorados'] == '') {
                $consulta['monitorados'] = 0;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $coluna = 0;
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

    public function relatoriocompletoespeciesAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $monitoramentos = $this->modelRelatorios->selectEspeciesCapturadas();


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Espécie');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nome Comum');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Peso Total');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Quantidade Total');

        $coluna = 0;
        $linha++;
        foreach ($monitoramentos as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['arte']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['quantidade']);
            $coluna = 0;
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

    public function relatoriocompletoespeciesmesAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $monitoramentos = $this->modelRelatorios->selectEspeciesCapturadasMes();


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte de pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês/Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nome Comum');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Peso Total');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Quantidade Total');

        $coluna = 0;
        $linha++;
        foreach ($monitoramentos as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['arte']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes'] . '/' . $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['quantidade']);
            $coluna = 0;
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

    public function relatoriopescadoresAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelPescador = new Application_Model_Pescador();

        $pescadores = $this->modelPescador->selectView('tpr_id = 2');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Id');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nome');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Apelido');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sexo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Naturalidade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado Naturalidade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mãe');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pai');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'RG');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CPF');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Matrícula');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'INSS');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CTPS');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'RGP/MAA/IBAMA');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'PIS');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CIR-Captania dos Portos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'NIT/CEI');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data de nascimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CMA');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Projeto Cadastrado');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nível de Escolaridade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Logradouro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Numero da Casa');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Complemento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Bairro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Colônia');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comunidade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Municipio');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CEP');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Local de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Responsável pelo Cadastro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Responsável pela Digitação');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data de Cadastro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observação');

        $coluna = 0;
        $linha++;
        foreach ($pescadores as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_apelido']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['munnat']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['signat']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_filiacaomae']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_filiacaopai']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_rg']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_cpf']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_matricula']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_inss']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_ctps']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_rgb_maa_ibama']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_pis']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_cir_cap_porto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nit_cei']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_datanasc']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_cma']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tpr_descricao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esc_nivel']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['te_logradouro']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['te_numero']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['te_comp']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['te_bairro']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tc_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tcom_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tmun_municipio']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['te_cep']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tu_nome_cad']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tu_nome_lan']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_dta_cad']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_obs']);
            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pescadores.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function relatoriocompletopescadoresAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $pescadores = $this->modelRelatorios->selectPescadorByProjeto();


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Porto de Desembarque');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pescador');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Projeto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Monitoramentos em Arrasto de Fundo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Calão');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Coleta Manual');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Emalhe');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Grosseira');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Jereré');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Linha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Linha de Fundo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Manzuá');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mergulho');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ratoeira');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Siripoia');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tarrafa');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Vara de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Total de Monitoramentos');

        $coluna = 0;
        $linha++;
        foreach ($pescadores as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tpr_descricao']);
            $coluna = 0;
            $linha++;
        endforeach;

        $arrasto = $this->modelRelatorios->selectPescadorByArrasto();
        $linha = 2;
        $coluna+=3;
        foreach ($arrasto as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $calao = $this->modelRelatorios->selectPescadorByCalao();
        foreach ($calao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $coleta = $this->modelRelatorios->selectPescadorByColeta();
        foreach ($coleta as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $emalhe = $this->modelRelatorios->selectPescadorByEmalhe();
        foreach ($emalhe as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $grosseira = $this->modelRelatorios->selectPescadorByGrosseira();
        foreach ($grosseira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $jerere = $this->modelRelatorios->selectPescadorByJerere();
        foreach ($jerere as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $linha_pesca = $this->modelRelatorios->selectPescadorByLinha();
        foreach ($linha_pesca as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $linhafundo = $this->modelRelatorios->selectPescadorByLinhaFundo();
        foreach ($linhafundo as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $manzua = $this->modelRelatorios->selectPescadorByManzua();
        foreach ($manzua as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $mergulho = $this->modelRelatorios->selectPescadorByMergulho();
        foreach ($mergulho as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $ratoeira = $this->modelRelatorios->selectPescadorByRatoeira();
        foreach ($ratoeira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $siripoia = $this->modelRelatorios->selectPescadorBySiripoia();
        foreach ($siripoia as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $tarrafa = $this->modelRelatorios->selectPescadorByTarrafa();
        foreach ($tarrafa as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $linha = 2;
        $coluna++;

        $varapesca = $this->modelRelatorios->selectPescadorByVaraPesca();
        foreach ($varapesca as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['quantidade']);
            $linha++;
        endforeach;
        $ultimaLinha = $linha;
        $linha = 2;
        $coluna++;

        $i = 2;
        $j = 2;
        for ($i; $i < $ultimaLinha; $i++):
            $formula = '=SUM(D' . $i . ':Q' . $i . ')';
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $formula);
            $linha++;
        endfor;

        $formula = '=SUM(R' . $j . ':R' . ($i - 1) . ')';
        $sheet->setCellValueByColumnAndRow($coluna, $linha, $formula);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pescadores Monitorados.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function valorespeciesAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRelatorios = new Application_Model_Relatorios();

        $monitoramentos = $this->modelRelatorios->selectValorEspecies();


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Espécie');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Valor Máximo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Valor Mínimo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Média Geral');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'ID');

        $coluna = 0;
        $linha++;
        foreach ($monitoramentos as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['max']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['min']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['media']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_id']);
            $coluna = 0;
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

    public function verifporto($porto = null) {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $modelPorto = new Application_Model_Porto();

        $verificaPorto = $modelPorto->select('pto_id = ' . $porto);

        return $verificaPorto[0]['pto_nome'];
    }

    public function biometriascamaraoAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $modelArrasto = new Application_Model_ArrastoFundo;

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $porto = $this->_getParam('porto');

        if ($porto != '999') {
            $nomePorto = $this->verifporto($porto);
            $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
        } else {
            $arrasto = $modelArrasto->selectVBioCamarao("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
        }
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arrasto de Fundo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pesqueiro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Espécie');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nome Comum');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sexo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maturidade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comprimento da Carapaça');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Peso');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data da Entrevista');

        $coluna = 0;
        $linha++;

        foreach ($arrasto as $key => $consulta):
            $pesqueiroArrasto = $modelArrasto->selectArrastoHasPesqueiro('af_id = ' . $consulta['af_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, "Arrasto de Fundo");
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_id']);
            if (empty($pesqueiroArrasto)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiroArrasto as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbc_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tmat_tipo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbc_comprimento_cabeca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbc_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Biometria de Camarao.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioBiometriasCamarao_' . $dataGerado . '_De_' . $data . '_Ate_' . $datafim . '.xls');
    }

    public function biometriaspeixeAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $modelArrasto = new Application_Model_ArrastoFundo;
        $modelCalao = new Application_Model_Calao;
        $modelColetaManual = new Application_Model_ColetaManual;
        $modelEmalhe = new Application_Model_Emalhe;
        $modelGrosseira = new Application_Model_Grosseira;
        $modelJerere = new Application_Model_Jerere;
        $modelLinha = new Application_Model_Linha;
        $modelLinhaFundo = new Application_Model_LinhaFundo;
        $modelManzua = new Application_Model_Manzua;
        $modelMergulho = new Application_Model_Mergulho;
        $modelRatoeira = new Application_Model_Ratoeira;
        $modelSiripoia = new Application_Model_Siripoia;
        $modelTarrafa = new Application_Model_Tarrafa;
        $modelVaraPesca = new Application_Model_VaraPesca;

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $porto = $this->_getParam('porto');

        if ($porto != '999') {
            $nomePorto = $this->verifporto($porto);
            $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $calao = $modelCalao->selectVBioPeixe("cal_data between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $coletamanual = $modelColetaManual->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $emalhe = $modelEmalhe->selectVBioPeixe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $grosseira = $modelGrosseira->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $jerere = $modelJerere->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $pescalinha = $modelLinha->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $linhafundo = $modelLinhaFundo->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $manzua = $modelManzua->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $mergulho = $modelMergulho->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $ratoeira = $modelRatoeira->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $siripoia = $modelSiripoia->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $tarrafa = $modelTarrafa->selectVBioPeixe("tar_data between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
            $varapesca = $modelVaraPesca->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'", 'esp_nome_comum');
        } else {
            $arrasto = $modelArrasto->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $calao = $modelCalao->selectVBioPeixe("cal_data between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $coletamanual = $modelColetaManual->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $emalhe = $modelEmalhe->selectVBioPeixe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $grosseira = $modelGrosseira->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $jerere = $modelJerere->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $pescalinha = $modelLinha->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $linhafundo = $modelLinhaFundo->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $manzua = $modelManzua->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $mergulho = $modelMergulho->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $ratoeira = $modelRatoeira->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $siripoia = $modelSiripoia->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $tarrafa = $modelTarrafa->selectVBioPeixe("tar_data between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
            $varapesca = $modelVaraPesca->selectVBioPeixe("dvolta between '" . $data . "'" . " and '" . $datafim . "'", 'esp_nome_comum');
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pesqueiro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Espécie');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Nome Comum');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sexo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comprimento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Peso');

        $coluna = 0;
        $linha++;

        foreach ($arrasto as $key => $consulta):
            $pesqueiroArrasto = $modelArrasto->selectArrastoHasPesqueiro('af_id = ' . $consulta['af_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arrasto de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_id']);
            if (empty($pesqueiroArrasto)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiroArrasto as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));

            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($calao as $key => $consulta):
            $pesqueirocalao = $modelCalao->selectCalaoHasPesqueiro('cal_id = ' . $consulta['cal_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Calão');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_id']);
            if (empty($pesqueirocalao)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirocalao as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $coluna = 0;
            $linha++;
        endforeach;




        foreach ($coletamanual as $key => $consulta):
            $pesqueirocoletamanual = $modelColetaManual->selectColetaManualHasPesqueiro('cml_id = ' . $consulta['cml_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Coleta Manual');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_id']);
            if (empty($pesqueirocoletamanual)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirocoletamanual as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;






        foreach ($emalhe as $key => $consulta):
            $pesqueiroemalhe = $modelEmalhe->selectEmalheHasPesqueiro('em_id = ' . $consulta['em_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Emalhe');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_id']);
            if (empty($pesqueiroemalhe)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiroemalhe as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['drecolhimento']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($grosseira as $key => $consulta):
            $pesqueirogrosseira = $modelGrosseira->selectGrosseiraHasPesqueiro('grs_id = ' . $consulta['grs_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Groseira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_id']);
            if (empty($pesqueirogrosseira)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirogrosseira as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($jerere as $key => $consulta):
            $pesqueirojerere = $modelJerere->selectJerereHasPesqueiro('jre_id = ' . $consulta['jre_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Jereré');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_id']);
            if (empty($pesqueirogrosseira)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirojerere as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($pescalinha as $key => $consulta):
            $pesqueirolinha = $modelLinha->selectLinhaHasPesqueiro('lin_id = ' . $consulta['lin_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_id']);
            if (empty($pesqueirolinha)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirolinha as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($linhafundo as $key => $consulta):
            $pesqueirolinhafundo = $modelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id = ' . $consulta['lf_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_id']);
            if (empty($pesqueirolinhafundo)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirolinhafundo as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;




        foreach ($manzua as $key => $consulta):
            $pesqueiromanzua = $modelManzua->selectManzuaHasPesqueiro('man_id = ' . $consulta['man_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Manzuá');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_id']);
            if (empty($pesqueiromanzua)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiromanzua as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($mergulho as $key => $consulta):
            $pesqueiromergulho = $modelMergulho->selectMergulhoHasPesqueiro('mer_id = ' . $consulta['mer_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Mergulho');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_id']);
            if (empty($pesqueiromergulho)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiromergulho as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($ratoeira as $key => $consulta):
            $pesqueiroratoeira = $modelRatoeira->selectRatoeiraHasPesqueiro('rat_id = ' . $consulta['rat_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Ratoeira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_id']);
            if (empty($pesqueiroratoeira)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueiroratoeira as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($siripoia as $key => $consulta):
            $pesqueirosiripoia = $modelSiripoia->selectSiripoiaHasPesqueiro('sir_id = ' . $consulta['sir_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Siripóia');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_id']);
            if (empty($pesqueirosiripoia)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirosiripoia as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($tarrafa as $key => $consulta):
            $pesqueirotarrafa = $modelTarrafa->selectTarrafaHasPesqueiro('tar_id = ' . $consulta['tar_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Tarrafa');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_id']);
            if (empty($pesqueirotarrafa)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirotarrafa as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['tar_data']));
            $coluna = 0;
            $linha++;
        endforeach;



        foreach ($varapesca as $key => $consulta):
            $pesqueirovarapesca = $modelVaraPesca->selectVaraPescaHasPesqueiro('vp_id = ' . $consulta['vp_id'], null, 1);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Vara de Pesca');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_id']);
            if (empty($pesqueirovarapesca)) {
                $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '');
            } else {
                foreach ($pesqueirovarapesca as $key => $pesqueiro):
                    $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $pesqueiro['paf_pesqueiro']);
                endforeach;
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['esp_nome_comum']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_sexo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_comprimento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tbp_peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Biometria de Peixes.xls'");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioBiometriasPeixe_' . $dataGerado . '_De_' . $data . '_Ate_' . $datafim . '.xls');
    }

    public function embarcacaodetalhadaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
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
        $embarcacao = $modelRelatorios->selectEmbarcacaoDetalhada(null, 'bar_nome');


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'ID Embarcacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Proprietario');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mestre');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Possui Outras Embarcacoes?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Maximo de Tripulantes');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tripulacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Cozinheiro?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Barco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comprimento Total');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comprimento da Boca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Comprimento do Calado');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arqueadura');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Número de Registro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto de Origem');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Casco');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano de Compra');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado de Conservação');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado da Embarcacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Está Paga?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Como foi o Pagamento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Financiador');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano da Construção');


        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Propulsao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tipo de Motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Modelo do Motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Marca do Motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Potencia');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Combustivel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Capacidade de Armazenamento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Posto de Combustivel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano do motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estado do Motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Já está pago?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Como foi o Pagamento?');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Finaciador');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano de Fabricacao do Motor');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Observacao');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Gasto Mensal com Manutencao');


        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Atuacao Batimetrica');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Autonomia no Mar');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Frequencia de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Horario de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Capacidade de Armazenamento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Conservacao do Pescado');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Colonia');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Destino do Pescado');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Outra Renda');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estação que mais pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Estação que menos pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Concorrência');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Tempo de Atividade');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data da entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Entrevistador');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Digitador');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Para quem vende');

        $coluna = 0;
        $linha++;

        foreach ($embarcacao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['bar_id']);
            //$sheet->setCellValueByColumnAndRow($coluna, $linha,   $consulta['pto_id_desembarque']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            //$sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_id_proprietario']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['proprietario']);
            //$sheet->setCellValueByColumnAndRow(++$coluna, $linha, $consulta['tp_id_mestre']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mestre']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['bar_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_quant_embarcacoes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_max_tripulantes']);
            if ($consulta['ted_tripulacao'] == '0') {
                $ted_tripulacao = 'Não Informado';
            } else if ($consulta['ted_tripulacao'] == '1') {
                $ted_tripulacao = 'Variável';
            } else if ($consulta['ted_tripulacao'] == '2') {
                $ted_tripulacao = 'Fixa';
            }

            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $ted_tripulacao);
            if ($consulta['ted_cozinheiro'] == '0') {
                $ted_cozinheiro = 'Não Informado';
            } else if ($consulta['ted_cozinheiro'] == '1') {
                $ted_cozinheiro = 'Não';
            } else if ($consulta['ted_cozinheiro'] == '2') {
                $ted_cozinheiro = 'Sim';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $ted_cozinheiro);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tte_tipoembarcacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_comp_total']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_comp_boca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_altura_calado']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_arqueadura']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_num_registro']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_id_origem']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tcas_tipo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_ano_compra']);
            if ($consulta['ted_estado_conservacao'] == '0') {
                $ted_estado_conservacao = 'Não Informado';
            } else if ($consulta['ted_estado_conservacao'] == '1') {
                $ted_estado_conservacao = 'Nova';
            } else if ($consulta['ted_estado_conservacao'] == '2') {
                $ted_estado_conservacao = 'Usada';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $ted_estado_conservacao);
            if ($consulta['ted_estado'] == '0') {
                $ted_estado = 'Não Informado';
            } else if ($consulta['ted_estado'] == '1') {
                $ted_estado = 'Bom';
            } else if ($consulta['ted_estado'] == '2') {
                $ted_estado = 'Ruim';
            } else if ($consulta['ted_estado'] == '3') {
                $ted_estado = 'Péssimo';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $ted_estado);
            if ($consulta['ted_pagamento'] == '0') {
                $ted_pagamento = 'Não Informado';
            } else if ($consulta['ted_pagamento'] == '1') {
                $ted_pagamento = 'Não';
            } else if ($consulta['ted_pagamento'] == '2') {
                $ted_pagamento = 'Sim';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $ted_pagamento);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tpg_pagamento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tfin_financiador']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ted_ano_construcao']);

            $motor = $modelRelatorios->selectMotorEmbarcacao('ted_id =' . $consulta['ted_id']);
            if ($motor[0]['tme_propulsao'] == '0') {
                $tme_propulsao = 'Não Informado';
            } else if ($motor[0]['tme_propulsao'] == '1') {
                $tme_propulsao = 'Sem Propulsão';
            } else if ($motor[0]['tme_propulsao'] == '2') {
                $tme_propulsao = 'Motor';
            } else if ($motor[0]['tme_propulsao'] == '3') {
                $tme_propulsao = 'Remo';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $tme_propulsao);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tmot_tipo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tmod_modelo']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tmar_marca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_potencia']);
            if ($motor[0]['tme_combustivel'] == '0') {
                $tme_combustivel = 'Não Informado';
            } else if ($motor[0]['tme_combustivel'] == '1') {
                $tme_combustivel = 'Sem Propulsão';
            } else if ($motor[0]['tme_combustivel'] == '2') {
                $tme_combustivel = 'Motor';
            } else if ($motor[0]['tme_combustivel'] == '3') {
                $tme_combustivel = 'Remo';
            }
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $tme_combustivel);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_armazenamento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tpc_posto']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_ano_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_estado_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_pagamento_motor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tpg_pagamento']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tfin_financiador']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_ano_motor_fabricacao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_obs']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $motor[0]['tme_gasto_mensal']);

            $atuacao = $modelRelatorios->selectAtuacaoEmbarcacao('ted_id =' . $consulta['ted_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_atuacao_batimatrica']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_autonomia']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tfp_frequencia']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['thp_horario']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_capacidade']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tcp_conserva']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tc_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['dp_destino']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['ttr_descricao']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['maior']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['menor']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_concorrencia']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_tempo_atividade']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['tae_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['entrevistador']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['digitador']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $atuacao[0]['dp_id_venda']);
            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Embarcaçoes Detalhadas.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioEmbarcacaoDetalhada_' . $dataGerado . '.xls');
    }

    public function formataData($data) {
        $arrayData = explode('-', $data);
        $mes = $arrayData[1];
        $ano = $arrayData[0];

        switch ($mes) {
            case 1: $dataFormatada = 'jan_' . $ano;
                break;
            case 2:$dataFormatada = 'fev_' . $ano;
                break;
            case 3:$dataFormatada = 'mar_' . $ano;
                break;
            case 4:$dataFormatada = 'abr_' . $ano;
                break;
            case 5:$dataFormatada = 'mai_' . $ano;
                break;
            case 6:$dataFormatada = 'jun_' . $ano;
                break;
            case 7:$dataFormatada = 'jul_' . $ano;
                break;
            case 8:$dataFormatada = 'ago_' . $ano;
                break;
            case 9:$dataFormatada = 'set_' . $ano;
                break;
            case 10:$dataFormatada = 'out_' . $ano;
                break;
            case 11:$dataFormatada = 'nov_' . $ano;
                break;
            case 12:$dataFormatada = 'dez_' . $ano;
                break;
        }


        return $dataFormatada;
    }

    public function cpueAction() {
        set_time_limit(0);

        $inicio1 = microtime(true);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $this->modelRel = new Application_Model_Relatorios();

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $porto = $this->_getParam('porto');

        if ($porto != '999') {
            $nomePorto = $this->verifporto($porto);
            $arrasto = $this->modelRel->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $calao = $this->modelRel->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $coletamanual = $this->modelRel->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $emalhe = $this->modelRel->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $grosseira = $this->modelRel->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $jerere = $this->modelRel->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $pescalinha = $this->modelRel->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $linhafundo = $this->modelRel->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $manzua = $this->modelRel->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $mergulho = $this->modelRel->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $ratoeira = $this->modelRel->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $siripoia = $this->modelRel->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $tarrafa = $this->modelRel->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
            $varapesca = $this->modelRel->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "' and pto_nome ='" . $nomePorto . "'");
        } else {
            $arrasto = $this->modelRel->selectArrasto("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $calao = $this->modelRel->selectCalao("cal_data between '" . $data . "'" . " and '" . $datafim . "'");
            $coletamanual = $this->modelRel->selectColetaManual("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $emalhe = $this->modelRel->selectEmalhe("drecolhimento between '" . $data . "'" . " and '" . $datafim . "'");
            $grosseira = $this->modelRel->selectGrosseira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $jerere = $this->modelRel->selectJerere("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $pescalinha = $this->modelRel->selectLinha("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $linhafundo = $this->modelRel->selectLinhaFundo("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $manzua = $this->modelRel->selectManzua("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $mergulho = $this->modelRel->selectMergulho("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $ratoeira = $this->modelRel->selectRatoeira("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $siripoia = $this->modelRel->selectSiripoia("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
            $tarrafa = $this->modelRel->selectTarrafa("tar_data between '" . $data . "'" . " and '" . $datafim . "'");
            $varapesca = $this->modelRel->selectVaraPesca("dvolta between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $objPHPExcel = new PHPExcel();
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Artes com Peso');

        //Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, 0);
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total em kg');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total em T');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CPUE (kg)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CPUE Detalhada (kg)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Completa');
        $coluna = 0;
        $linha++;

        foreach ($arrasto as $key => $consulta):

            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arrasto de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteArrasto('v_entrevista_arrasto.af_id=' . $consulta['af_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $diasDetalhados);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;
//        
        $coluna = 0;

//        
        foreach ($calao as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Calao');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteCalao('v_entrevista_calao.cal_id=' . $consulta['cal_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['cal_data']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($emalhe as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Emalhe');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dlancamento'].' '.$consulta['hlancamento'],$consulta['drecolhimento'].' '.$consulta['hrecolhimento'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteEmalhe('v_entrevista_emalhe.em_id=' . $consulta['em_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($grosseira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Groseira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteGrosseira('v_entrevista_grosseira.grs_id=' . $consulta['grs_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;
        $coluna = 0;
        foreach ($jerere as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Jereré');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteJerere('v_entrevista_jerere.jre_id=' . $consulta['jre_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($pescalinha as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteLinha('v_entrevista_linha.lin_id=' . $consulta['lin_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($linhafundo as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteLinhaFundo('v_entrevista_linhafundo.lf_id=' . $consulta['lf_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($manzua as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Manzuá');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteManzua('v_entrevista_manzua.man_id=' . $consulta['man_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;


        $coluna = 0;
        foreach ($mergulho as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Mergulho');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteMergulho('v_entrevista_mergulho.mer_id=' . $consulta['mer_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($tarrafa as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Tarrafa');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['tar_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['tar_data']);
            
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '1');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteTarrafa('v_entrevista_tarrafa.tar_id=' . $consulta['tar_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_data']);
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($varapesca as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'VaraPesca');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteVaraPesca('v_entrevista_varapesca.vp_id=' . $consulta['vp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / 1000);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['peso'] / $consulta['dias']);
             $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        // Create a new worksheet called "My Data"
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Artes com Quantidade');
        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, 1);
        $objPHPExcel->setActiveSheetIndex(1);

        $sheet = $objPHPExcel->getActiveSheet();
        $linha = 1;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Dias Detalhados de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total em n');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CPUE (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'CPUE Detalhada (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Data Completa');

        $linha++;
        $coluna = 0;
        foreach ($coletamanual as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Coleta Manual');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteColeta('v_entrevista_coletamanual.cml_id=' . $consulta['cml_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($ratoeira as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Ratoeira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteRatoeira('v_entrevista_ratoeira.rat_id=' . $consulta['rat_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $coluna = 0;
        foreach ($siripoia as $key => $consulta):
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Siripoia');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $dataFormatada = $this->formataData($consulta['fd_data']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $dataFormatada);
            $explodeData = explode('-', $consulta['fd_data']);
            $diasDetalhados = ($this->s_datediff("i",$consulta['dsaida'].' '.$consulta['hsaida'],$consulta['dvolta'].' '.$consulta['hvolta'])/60)/24;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[1]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $explodeData[0]);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_id']);
            $capturaTotal = $this->modelRel->selectCapturaByArteSiripoia('v_entrevista_siripoia.sir_id=' . $consulta['sir_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $consulta['dias']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal[0]['quant'] / $diasDetalhados);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $this->formataDataPtbr($consulta['dvolta']));
            $coluna = 0;
            $linha++;
        endforeach;

        $fim1 = microtime(true);
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Tempo para gerar:');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $fim1 - $inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='CPUE.xls'");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioCPUE_' . $dataGerado . '_De_' . $data . '_Ate_' . $datafim . '.xls');
    }

    public function relartesbyportoAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $modelArrasto = new Application_Model_ArrastoFundo;
        $modelCalao = new Application_Model_Calao;
        $modelColetaManual = new Application_Model_ColetaManual;
        $modelEmalhe = new Application_Model_Emalhe;
        $modelGrosseira = new Application_Model_Grosseira;
        $modelJerere = new Application_Model_Jerere;
        $modelLinha = new Application_Model_Linha;
        $modelLinhaFundo = new Application_Model_LinhaFundo;
        $modelManzua = new Application_Model_Manzua;
        $modelMergulho = new Application_Model_Mergulho;
        $modelRatoeira = new Application_Model_Ratoeira;
        $modelSiripoia = new Application_Model_Siripoia;
        $modelTarrafa = new Application_Model_Tarrafa;
        $modelVaraPesca = new Application_Model_VaraPesca;

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $porto = $this->_getParam('porto');


        $arrayPortos = array('Amendoeira', 'Pontal', 'Prainha', 'Terminal Pesqueiro', 'Porto da Barra', 'São Miguel', 'Mamoã', 'Ponta da Tulha', 'Ponta do Ramo', 'Aritaguá', 'Juerana', 'Sambaituba', 'Urucutuca', 'Pé de Serra', 'Sobradinho', 'Vila Badu', 'Porto da Concha', 'Porto do Forte');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;

        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte de Pesca (n)');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Fundo');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Praia');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Rio');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Calão');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Coleta Manual');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Emalhe');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Groseira');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Jereré');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha de Fundo');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Manzuá');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Mergulho');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Ratoeira');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Siripoia');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Tarrafa');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'VaraPesca');
        $linha = 1;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Amendoeira');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pontal');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Prainha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Terminal Pesqueiro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto da Barra');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'São Miguel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mamoã');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ponta da Tulha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ponta do Ramo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Aritaguá');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Juerana');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sambaituba');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Urucutuca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pé de Serra');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sobradinho');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Vila Badu');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto da Concha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto do Forte');
        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrArrasto = $modelArrasto->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrArrasto[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;



        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrAP = $modelCalao->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND  pto_nome = '" . $porto . "' And tcat_tipo = 'Arrasto de Praia'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrAP[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrAR = $modelCalao->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "' And tcat_tipo = 'Arrasto de Rio'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrAR[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrCalao = $modelCalao->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "' And tcat_tipo = 'Calão'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrCalao[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrColetaManual = $modelColetaManual->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrColetaManual[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrEmalhe = $modelEmalhe->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrEmalhe[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrGrosseira = $modelGrosseira->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrGrosseira[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrJerere = $modelJerere->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrJerere[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrLinha = $modelLinha->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrLinha[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrLinhaFundo = $modelLinhaFundo->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrLinhaFundo[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrManzua = $modelManzua->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrManzua[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrMergulho = $modelMergulho->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrMergulho[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrRatoeira = $modelRatoeira->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrRatoeira[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrSiripoia = $modelSiripoia->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrSiripoia[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrTarrafa = $modelTarrafa->selectEntrevistasByPorto("tar_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrTarrafa[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 1;
        $linha++;
        foreach ($arrayPortos as $porto):
            $quantEntrVaraPesca = $modelVaraPesca->selectEntrevistasByPorto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto . "'");
            $sheet->setCellValueByColumnAndRow($coluna, $linha, $quantEntrVaraPesca[0]['count']);
            $coluna++;
            //$linha++;
        endforeach;

        $coluna = 0;
        $linha++;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Total');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(B2:B17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(C2:C17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(D2:D17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(E2:E17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(F2:F17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(G2:G17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(H2:H17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(I2:I17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(J2:J17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(K2:K17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(L2:L17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(M2:M17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(N2:N17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(O2:O17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(P2:P17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(Q2:Q17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(R2:R17)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, '=SUM(S2:S17)');

        $linha+=2;
        $coluna = 0;
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte de Pesca (%)');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Fundo');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Praia');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Arrasto de Rio');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Calão');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Coleta Manual');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Emalhe');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Groseira');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Jereré');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Linha de Fundo');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Manzuá');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Mergulho');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Ratoeira');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Siripoia');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'Tarrafa');
        $sheet->setCellValueByColumnAndRow($coluna, ++$linha, 'VaraPesca');
        $linha -=16;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Amendoeira');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pontal');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Prainha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Terminal Pesqueiro');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto da Barra');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'São Miguel');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mamoã');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ponta da Tulha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ponta do Ramo');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Aritaguá');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Juerana');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sambaituba');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Urucutuca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Pé de Serra');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Sobradinho');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Vila Badu');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto da Concha');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto do Forte');
        $linha++;

        for ($linhaAux = 2; $linhaAux < 19; $linhaAux++) {
            for ($coluna = 1; $coluna < 19; $coluna++) {
                $valEntrevistas = $sheet->getCellByColumnAndRow($coluna, $linhaAux)->getFormattedValue();
                $valTotal = $sheet->getCellByColumnAndRow($coluna, 18)->getFormattedValue();
                $sheet->setCellValueByColumnAndRow($coluna, $linha, $valEntrevistas / $valTotal * 100);
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

    public function divisao($peso, $monitoramentos) {
        if ($monitoramentos == 0) {
            $media = $peso;
        } else {
            $media = $peso / $monitoramentos;
        }
        return $media;
    }

    public function relatorioestimativasAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $modelArrasto = new Application_Model_ArrastoFundo();
        $modelCalao = new Application_Model_Calao;
        $modelColetaManual = new Application_Model_ColetaManual;
        $modelEmalhe = new Application_Model_Emalhe;
        $modelGrosseira = new Application_Model_Grosseira;
        $modelJerere = new Application_Model_Jerere;
        $modelLinha = new Application_Model_Linha;
        $modelLinhaFundo = new Application_Model_LinhaFundo;
        $modelManzua = new Application_Model_Manzua;
        $modelMergulho = new Application_Model_Mergulho;
        $modelRatoeira = new Application_Model_Ratoeira;
        $modelSiripoia = new Application_Model_Siripoia;
        $modelTarrafa = new Application_Model_Tarrafa;
        $modelVaraPesca = new Application_Model_VaraPesca;

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);

        $explode_data = explode('-', $data);
        $explode_dataFim = explode('-', $datafim);

        $mes = $explode_data[1];
        $ano = $explode_data[0];

        $mesfim = $explode_dataFim[1];
        $anofim = $explode_dataFim[0];

        $porto = $this->_getParam('porto');

        $objPHPExcel = new PHPExcel();
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Estimativa por Peso');
        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet, 0);
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;

        if ($porto != '999') {
            $nomePorto = $this->verifporto($porto);
            $arrasto = $modelArrasto->selectEstimativaByPorto("pto_nome = '" . $nomePorto . "' AND mes between " . $mes . " and " . $mesfim . " AND ano between " . $ano . " And " . $anofim . "", array('pto_nome', 'mes', 'ano'));
            $calao = $modelCalao->selectEstimativaByPorto("pto_nome = '$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $coletamanual = $modelColetaManual->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $emalhe = $modelEmalhe->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $grosseira = $modelGrosseira->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $jerere = $modelJerere->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $pescalinha = $modelLinha->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $linhafundo = $modelLinhaFundo->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $manzua = $modelManzua->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $mergulho = $modelMergulho->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $ratoeira = $modelRatoeira->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $siripoia = $modelSiripoia->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $tarrafa = $modelTarrafa->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
            $varapesca = $modelVaraPesca->selectEstimativaByPorto("pto_nome ='$nomePorto' AND mes between $mes and $mesfim AND ano between $ano And $anofim", array('pto_nome', 'mes', 'ano'));
        } elseif ($porto == '999') {
            $arrasto = $modelArrasto->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $calao = $modelCalao->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $coletamanual = $modelColetaManual->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $emalhe = $modelEmalhe->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $grosseira = $modelGrosseira->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $jerere = $modelJerere->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $pescalinha = $modelLinha->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $linhafundo = $modelLinhaFundo->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $manzua = $modelManzua->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $mergulho = $modelMergulho->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $ratoeira = $modelRatoeira->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $siripoia = $modelSiripoia->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $tarrafa = $modelTarrafa->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
            $varapesca = $modelVaraPesca->selectEstimativaByPorto("mes between 1 and 7 AND ano between 2015 And 2015", array('pto_nome', 'mes', 'ano'));
        }
        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Artes de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Monitoradoss (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Monitorada (kg)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Média');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Não Monitorados');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Não Monitorada (kg)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Total de Monitoramentos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total Estimada (kg)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total Estimada (t)');

        $linha++;
        $coluna = 0;
        foreach ($arrasto as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $arrasto[0]['pto_nome']);
        foreach ($calao as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $linha);
        foreach ($emalhe as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, "mes between " . $mes . " and " . $mesfim . " AND ano between " . $ano . " And " . $anofim);
        foreach ($grosseira as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $linha);
        foreach ($jerere as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $linha);
        foreach ($pescalinha as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($linhafundo as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($manzua as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($mergulho as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($tarrafa as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($varapesca as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['peso']);
            $media = $this->divisao($consulta['peso'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['peso'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal / 1000);

            $coluna = 0;
            $linha++;
        endforeach;

        // Create a new worksheet called "My Data"
        $myWorkSheet2 = new PHPExcel_Worksheet($objPHPExcel, 'Estimativa por Quantidades');
        // Attach the "My Data" worksheet as the first worksheet in the PHPExcel object
        $objPHPExcel->addSheet($myWorkSheet2, 1);
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet = $objPHPExcel->getActiveSheet();
        $linha = 1;
        $coluna = 0;

        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Local');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Artes de Pesca');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Mês');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Ano');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Monitorados (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Monitorada (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Média');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Não Monitorados');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Não Monitorada (n)');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Total de Monitoramentos');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Captura Total Estimada (n)');

        $linha++;
        $coluna = 0;
        foreach ($coletamanual as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['quantidade']);
            $media = $this->divisao($consulta['quantidade'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['quantidade'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);

            $coluna = 0;
            $linha++;
        endforeach;
        foreach ($ratoeira as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['quantidade']);
            $media = $this->divisao($consulta['quantidade'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['quantidade'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($siripoia as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mes']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['ano']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['quantidade']);
            $media = $this->divisao($consulta['quantidade'], $consulta['monitorados']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $media);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados']);
            $capturaNaoMonitorada = $media * $consulta['naomonitorados'];
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaNaoMonitorada);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['naomonitorados'] + $consulta['monitorados']);
            $capturaTotal = $consulta['quantidade'] + $capturaNaoMonitorada;
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $capturaTotal);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Estimativas de Captura.xls'");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $dataGerado = date('d-m-Y');
        $objWriter->save('php://output');
        $objWriter->save('files/relatorioEstimativasCapturas_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

    public function monitoramentosartepescaAction() {
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $porto = $this->_getParam('porto');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $coluna = 0;
        $linha = 1;
//
        if ($porto != '999') {
            $nomePorto = $this->verifporto($porto);
            $arrasto = $this->modelRelatorios->selectArrastoMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $calao = $this->modelRelatorios->selectCalaoMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $coletamanual = $this->modelRelatorios->selectColetaMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $emalhe = $this->modelRelatorios->selectEmalheMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $grosseira = $this->modelRelatorios->selectGrosseiraMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $jerere = $this->modelRelatorios->selectJerereMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $pescalinha = $this->modelRelatorios->selectLinhaMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $linhafundo = $this->modelRelatorios->selectLinhaFundoMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $manzua = $this->modelRelatorios->selectManzuaMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $mergulho = $this->modelRelatorios->selectMergulhoMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $ratoeira = $this->modelRelatorios->selectRatoeiraMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $siripoia = $this->modelRelatorios->selectSiripoiaMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $tarrafa = $this->modelRelatorios->selectTarrafaMonitoramentos("pto_nome ='" . $nomePorto . "'");
            $varapesca = $this->modelRelatorios->selectVaraPescaMonitoramentos("pto_nome ='" . $nomePorto . "'");
        } else {
            $arrasto = $this->modelRelatorios->selectArrastoMonitoramentos();
            $calao = $this->modelRelatorios->selectCalaoMonitoramentos();
            $coletamanual = $this->modelRelatorios->selectColetaMonitoramentos();
            $emalhe = $this->modelRelatorios->selectEmalheMonitoramentos();
            $grosseira = $this->modelRelatorios->selectGrosseiraMonitoramentos();
            $jerere = $this->modelRelatorios->selectJerereMonitoramentos();
            $pescalinha = $this->modelRelatorios->selectLinhaMonitoramentos();
            $linhafundo = $this->modelRelatorios->selectLinhaFundoMonitoramentos();
            $manzua = $this->modelRelatorios->selectManzuaMonitoramentos();
            $mergulho = $this->modelRelatorios->selectMergulhoMonitoramentos();
            $ratoeira = $this->modelRelatorios->selectRatoeiraMonitoramentos();
            $siripoia = $this->modelRelatorios->selectSiripoiaMonitoramentos();
            $tarrafa = $this->modelRelatorios->selectTarrafaMonitoramentos();
            $varapesca = $this->modelRelatorios->selectVaraPescaMonitoramentos();
        }
        $arrayCompleto = array_merge_recursive($arrasto, $calao, $coletamanual, $emalhe, $grosseira, $jerere, $pescalinha, $linhafundo, $manzua, $mergulho, $ratoeira, $siripoia, $tarrafa, $varapesca);

        $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arte');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Porto');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Id da Entrevista');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Id Monitoramento');
        $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, 'Arte Monitorada');
//         
        $linha++;
        $coluna = 0;
        foreach ($arrasto as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Arrasto de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['af_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;

//        
        foreach ($calao as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Calão');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cal_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($emalhe as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Emalhe');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['em_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($grosseira as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Espinhel/Groseira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['grs_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($jerere as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Jereré');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['jre_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($pescalinha as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lin_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($linhafundo as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Linha de Fundo');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['lf_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($manzua as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Manzuá');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['man_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($mergulho as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Mergulho');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mer_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($tarrafa as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Tarrafa');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tar_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;
//        
        foreach ($varapesca as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Vara de Pesca');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['vp_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($coletamanual as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Coleta Manual');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['cml_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($ratoeira as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Ratoeira');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['rat_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);
            $coluna = 0;
            $linha++;
        endforeach;

        foreach ($siripoia as $key => $consulta):
            //$sheet->setCellValueByColumnAndRow($coluna, $linha, $consulta['tl_local']);
            $sheet->setCellValueByColumnAndRow($coluna, $linha, 'Siripoia');
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['pto_nome']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['sir_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['mnt_id']);
            $sheet->setCellValueByColumnAndRow( ++$coluna, $linha, $consulta['tap_artepesca']);

            $coluna = 0;
            $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='Artes Por Monitoramentos.xls'");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function listaEspecies1($relatorioEspecies, $position, $objPHPExcel) {
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->fromArray($relatorioEspecies, null, $position);
        return sizeof($relatorioEspecies);
    }

    public function arrastoAction() {
        $inicio1 = microtime(true);
        set_time_limit(0);
//        if($this->usuario['tp_id']==5){
//            $this->_redirect('index');
//        }
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender(true);
//        
        $var = $this->_getParam('id');
        $tipoRel = $this->verificaRelatorio($var);

        $date = $this->_getParam('data');
        $datend = $this->_getParam('datafim');

        $data = $this->dataInicial($date);
        $datafim = $this->dataFinal($datend);


        $this->modelRelatorios = new Application_Model_Relatorios();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant = 21;
//        
        $sheet = $objPHPExcel->getActiveSheet();
        $cabecalho = array('Local', 'Porto de Desembarque', 'Arte de pesca', 'Data Entrevista', 'Data Saída', 'Hora Saída', 'Data Chegada', 'Hora Chegada',
            'Dias de Pesca', 'Código', 'Barco', 'Mestre', 'Número de Pescadores', 'Tipo de Barco', 'Diesel', 'Óleo', 'Alimento', 'Gelo', 'Motor?',
            'Destino da Pesca', 'Observacao');
        $maxPesqueiros = $this->modelRelatorios->countPesqueirosArrasto();
        for ($i = 0; $i < $maxPesqueiros[0]['count']; $i++):
            $cabecalhoPesqueiros[$i] = 'Pesqueiro';
        endfor;
        $relatorioEspecies = $this->modelRelatorios->selectNomeEspecies();
        foreach ($relatorioEspecies as $key => $especie):
            $cabecalhoEspecie[$key] = $especie['esp_nome_comum'];
        endforeach;

        $cabecalhoCompleto = array_merge_recursive($cabecalho, $cabecalhoPesqueiros, $cabecalhoEspecie);
        $startCell = 'A1';
        //print_r($cabecalhoCompleto);
        //$sheet->fromArray($cabecalhoCompleto, null, $startCell);
        #coluna de inicio das espécies
        $colunaEspecies = $maxPesqueiros[0]['count'] * 2 + $quant;
        $firstColunaEspecies = $colunaEspecies;

        $porto = $this->_getParam('porto');
        if ($porto != '999') {
            $porto2 = $this->verifporto($porto);
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("fd_data between '" . $data . "'" . " and '" . $datafim . "' AND pto_nome = '" . $porto2 . "'");
        } else {
            $relatorioArrasto = $this->modelRelatorios->selectArrasto("fd_data between '" . $data . "'" . " and '" . $datafim . "'");
        }
        $Relesp = $this->modelRelatorios->selectArrastoHasEspCapturadas();
        $startCell2 = 'A2';
        //
////      
        foreach ($relatorioArrasto as $key1 => $consulta):
            foreach ($relatorioEspecies as $key2 => $nomeEspecie):
                foreach ($Relesp as $key3 => $esp):
                    if ($esp['af_id'] == $consulta['af_id'] && $esp['esp_nome_comum'] === $nomeEspecie['esp_nome_comum']) {
                        $arrayEspecies[$key1][$key2] = $this->verificaTipoRel($esp['spc_peso_kg']);
                        break;
                    }
                endforeach;
                if (empty($arrayEspecies[$key1][$key2])) {
                    $arrayEspecies[$key1][$key2] = '0';
                }
            endforeach;
            $arrayEntrevistas[$key1] = array_merge_recursive($relatorioArrasto, $arrayEspecies[$key1]);
        endforeach;

        $sheet->fromArray($arrayEntrevistas, null, $startCell2);
        $sheet->setCellValueByColumnAndRow(1, 2211, $fim1 - $inicio1);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioArrasto_' . $tipoRel . '.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $dataGerado = date('d-m-Y');
        //$objWriter->save('php://output');
        $objWriter->save('files/relatorioArrasto_' . $dataGerado . '_' . $tipoRel . '_De_' . $data . '_Ate_' . $datafim . $porto2 . '.xls');
    }

}
