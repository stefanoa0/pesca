<?php
require_once "../library/fpdf/fpdf.php";
class PortoController extends Zend_Controller_Action
{
    private $modelPorto;
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


        $this->modelPorto = new Application_Model_Porto();
        $this->modelArrasto = new Application_Model_ArrastoFundo();
        $this->modelCalao= new Application_Model_Calao();
        $this->modelColeta= new Application_Model_ColetaManual();
        $this->modelEmalhe= new Application_Model_Emalhe();
        $this->modelGrosseira= new Application_Model_Grosseira();
        $this->modelJerere= new Application_Model_Jerere();
        $this->modelLinha= new Application_Model_Linha();
        $this->modelLinhaFundo= new Application_Model_LinhaFundo();
        $this->modelManzua= new Application_Model_Manzua();
        $this->modelMergulho= new Application_Model_Mergulho();
        $this->modelRatoeira= new Application_Model_Ratoeira();
        $this->modelSiripoia= new Application_Model_Siripoia();
        $this->modelTarrafa= new Application_Model_Tarrafa();
        $this->modelVaraPesca =  new Application_Model_VaraPesca();
    }

    public function indexAction()
    {
        $dados = $this->modelPorto->select(null, 'pto_prioridade');

        $this->view->assign("dados", $dados);
    }

    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelMunicipio = new Application_Model_Municipio();

        $municipios = $modelMunicipio->select();

        $this->view->assign("municipios", $municipios);
    }

    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorto->insert($this->_getAllParams());

        $this->_redirect('porto/index');
    }

    public function editarAction()
    {

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelMunicipio = new Application_Model_Municipio();

        $municipios = $modelMunicipio->select();

        $this->view->assign("municipios", $municipios);

        $porto = $this->modelPorto->find($this->_getParam('id'));

        $this->view->assign("porto", $porto);
    }

    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorto->update($this->_getAllParams());

        $this->_redirect('porto/index');
    }

    public function excluirAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelPorto->delete($this->_getParam('id'));

        $this->_redirect('porto/index');
        }
    }
    public function relatorioindexAction(){
        $ano = $this->_getParam('ano');
        $id = $this->_getParam('porto');
        
        switch($id){
            case 1: $this->_redirect('porto/pontal/ano/'.$ano);
            case 2: $this->_redirect('porto/terminal/ano/'.$ano); 
            case 3: $this->_redirect('porto/prainha/ano/'.$ano); 
            case 4: $this->_redirect('porto/amendoeira/ano/'.$ano);
            case 5: $this->_redirect('porto/barra/ano/'.$ano); 
            case 6: $this->_redirect('porto/saomiguel/ano/'.$ano);
            case 7: $this->_redirect('porto/tulha/ano/'.$ano);
            case 8: $this->_redirect('porto/mamoa/ano/'.$ano); 
            case 9: $this->_redirect('porto/ramo/ano/'.$ano); 
            case 10: $this->_redirect('porto/urucutuca/ano/'.$ano);
            case 11: $this->_redirect('porto/sambaituba/ano/'.$ano); 
            case 12: $this->_redirect('porto/juerana/ano/'.$ano); 
            case 13: $this->_redirect('porto/aritagua/ano/'.$ano); 
            case 14: $this->_redirect('porto/sobradinho/ano/'.$ano); 
            case 15: $this->_redirect('porto/serra/ano/'.$ano); 
            case 16: $this->_redirect('porto/badu/ano/'.$ano); 
            case 17: $this->_redirect('porto/concha/ano/'.$ano);
            case 18: $this->_redirect('porto/forte/ano/'.$ano); 
        }
        
    }
    public function dataFinal($data){
        
        if($data==''){
            $mes = date('m')-1;
            $ano = date('Y');
            $dia = date('d');
            while(!checkdate($mes, $dia, $ano)){
                $dia--;
            }
            $data = $ano.'-0'.$mes.'-'.$dia;
        }
        else{
            $data = explode('-', $data);
            $mes = $data[1];
            switch($mes){
                case '01': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '02': $data = $data[0].'-'.$data[1].'-'.'28'; break;
                case '03': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '04': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '05': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '06': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '07': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '08': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '09': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '10': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '11': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '12': $data = $data[0].'-'.$data[1].'-'.'31'; break;
            }
        }
        return $data;
    }
    public function dataInicial($data){
        if($data == ''){
            $data = '2013-11-01';
        }
        else{
            $data = explode('-', $data);
            $data = $data[0].'-'.$data[1].'-01';
        }
        return $data;
    }

    //Funções para verificar os vetores vazios e não dar erro nos gráficos.
    public function verifVazioCaptura($array, $porto, $tipo){
        if($tipo == 'peso'){
            if(empty($array)){
                $array = array( array(
                    'pto_nome' => $porto,
                    'pesototal' => 0,
                    )
                );
            }
            else if($array[0]['pesototal'] == ""){
                $array[0]['pesototal'] = 0;
            }
        }
        else{
            if(empty($array)){
                $array = array( array(
                    'pto_nome' => $porto,
                    'quanttotal' => 0,
                    )
                );
            }
            else if($array[0]['quanttotal'] == ""){
                $array[0]['quanttotal'] = 0;
            }
        }
        return $array;
    }
    public function verifVazioQuantCaptura($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'peso' => 0,
                'quant' => 0,
                )
            );
        }
        else if($array[0]['quant'] == ""){
            $array[0]['quant'] = 0;
        }
        else if($array[0]['peso'] == ""){
            $array[0]['peso'] = 0;
        }

        $array[0]['arte'] = $arte;
        return $array;
    }    
    //Funções para verificar os vetores vazios e não dar erro nos gráficos.
    public function verifVazioBarcos($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'quant' => 0,
                )
            );
        }
        else if($array[0]['quant'] == ""){
            $array[0]['quant'] = 0;
        }

        $array[0]['arte'] = $arte;
        return $array;
    }
    
    //Funções para verificar os vetores vazios e não dar erro nos gráficos.
    public function verifVazioEntrevistas($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'count' => 0,
                )
            );
        }
        else if($array[0]['count'] == ""){
            $array[0]['count'] = 0;
        }
        $array[0]['arte'] = $arte;
        return $array;
    }
    public function verifVazioCpue($array, $porto){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'cpue' => 0,
                )
            );
        }
        else if($array[0]['cpue'] == ""){
            $array[0]['cpue'] = 0;
        }
        return $array;
    }
    //Remove valores duplicados do array
//    function removeDuplicate($in, $key1, $key2) {
//        $out = array();
//
//        foreach ($in as $elem) {
//            if(array_key_exists($elem[$key1], $out)) {
//                $out[$elem[$key1]][$key2] += $elem[$key2];
//            } else {
//                $out[$elem[$key1]] = array($key1 => $elem[$key1],$key2 => $elem[$key2]);
//            }
//        }
//
//        return $out;
//    }
    
    //Ordena array por Key utilizada;
    function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    public function verificaEspecies($array){
        
        foreach($array as $campo){
            if($campo['esp_nome_comum'] == 'Rosinha'){
                $rosinha = $campo['peso'];
            }
            if($campo['esp_nome_comum'] == 'Rosa'){
                $rosa = array(
                'esp_nome_comum' => 'Rosa',
                'peso' => $campo['peso']+$rosinha,
                'quant' => $campo['quant']
                );
               

            }
            //print_r($campo);
        }
       
        array_push($array, $rosa);
        return $array;
    }
    //Gera as quantidade de captura por porto, mês e ano
    public function gerarquantcaptura($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $quantCaptJaneiro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and mes = 12 And ano = ".$ano);
        }
        if($arte == 'Calao'){
            $quantCaptJaneiro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Coleta'){
            $quantCaptJaneiro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Emalhe'){
            $quantCaptJaneiro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Grosseira'){
            $quantCaptJaneiro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Linha'){
            $quantCaptJaneiro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'LinhaFundo'){
            $quantCaptJaneiro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Jerere'){
            $quantCaptJaneiro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Manzua'){
            $quantCaptJaneiro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Mergulho'){
            $quantCaptJaneiro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Ratoeira'){
            $quantCaptJaneiro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Tarrafa'){
            $quantCaptJaneiro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and mes =   12 And ano = ".$ano);
        }
        if($arte == 'Siripoia'){
            $quantCaptJaneiro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'VaraPesca'){
            $quantCaptJaneiro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  1  And ano = ".$ano);
            $quantCaptFevereiro = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  2  And ano = ".$ano);
            $quantCaptMarco     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  3  And ano = ".$ano);
            $quantCaptAbril     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  4  And ano = ".$ano);
            $quantCaptMaio      = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  5  And ano = ".$ano);
            $quantCaptJunho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  6  And ano = ".$ano);
            $quantCaptJulho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  7  And ano = ".$ano);
            $quantCaptAgosto    = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  8  And ano = ".$ano);
            $quantCaptSetembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  9  And ano = ".$ano);
            $quantCaptOutubro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  10 And ano = ".$ano);
            $quantCaptNovembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  11 And ano = ".$ano);
            $quantCaptDezembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and mes =  12 And ano = ".$ano);
        }
        if($arte == 'Ratoeira' OR  $arte == 'Coleta' OR $arte == 'Siripoia'){
            $quantCaptJaneiro  = $this->verifVazioCaptura($quantCaptJaneiro,   $porto,'quant');
            $quantCaptFevereiro= $this->verifVazioCaptura($quantCaptFevereiro, $porto,'quant');
            $quantCaptMarco    = $this->verifVazioCaptura($quantCaptMarco    , $porto,'quant');
            $quantCaptAbril    = $this->verifVazioCaptura($quantCaptAbril    , $porto,'quant');
            $quantCaptMaio     = $this->verifVazioCaptura($quantCaptMaio     , $porto,'quant');
            $quantCaptJunho    = $this->verifVazioCaptura($quantCaptJunho    , $porto,'quant');
            $quantCaptJulho    = $this->verifVazioCaptura($quantCaptJulho    , $porto,'quant');
            $quantCaptAgosto   = $this->verifVazioCaptura($quantCaptAgosto   , $porto,'quant');
            $quantCaptSetembro = $this->verifVazioCaptura($quantCaptSetembro , $porto,'quant');
            $quantCaptOutubro  = $this->verifVazioCaptura($quantCaptOutubro  , $porto,'quant');
            $quantCaptNovembro = $this->verifVazioCaptura($quantCaptNovembro , $porto,'quant');
            $quantCaptDezembro = $this->verifVazioCaptura($quantCaptDezembro , $porto,'quant');
        }
        else{
            $quantCaptJaneiro  = $this->verifVazioCaptura($quantCaptJaneiro,   $porto,'peso');
            $quantCaptFevereiro= $this->verifVazioCaptura($quantCaptFevereiro, $porto,'peso');
            $quantCaptMarco    = $this->verifVazioCaptura($quantCaptMarco    , $porto,'peso');
            $quantCaptAbril    = $this->verifVazioCaptura($quantCaptAbril    , $porto,'peso');
            $quantCaptMaio     = $this->verifVazioCaptura($quantCaptMaio     , $porto,'peso');
            $quantCaptJunho    = $this->verifVazioCaptura($quantCaptJunho    , $porto,'peso');
            $quantCaptJulho    = $this->verifVazioCaptura($quantCaptJulho    , $porto,'peso');
            $quantCaptAgosto   = $this->verifVazioCaptura($quantCaptAgosto   , $porto,'peso');
            $quantCaptSetembro = $this->verifVazioCaptura($quantCaptSetembro , $porto,'peso');
            $quantCaptOutubro  = $this->verifVazioCaptura($quantCaptOutubro  , $porto,'peso');
            $quantCaptNovembro = $this->verifVazioCaptura($quantCaptNovembro , $porto,'peso');
            $quantCaptDezembro = $this->verifVazioCaptura($quantCaptDezembro , $porto,'peso');
        }
        $arrayQuantCapturaTotal = array_merge_recursive($quantCaptJaneiro, 
                $quantCaptFevereiro, 
                $quantCaptMarco,
                $quantCaptAbril, 
                $quantCaptMaio, 
                $quantCaptJunho, 
                $quantCaptJulho, 
                $quantCaptAgosto, 
                $quantCaptSetembro,
                $quantCaptOutubro, 
                $quantCaptNovembro, 
                $quantCaptDezembro);
        
        if($arte == 'Ratoeira' OR  $arte == 'Coleta' OR $arte == 'Siripoia'){
            foreach($arrayQuantCapturaTotal as $quant):
                $quantTotal[] = $quant['quanttotal'];
            endforeach;
            $jsQuantidade = json_encode($quantTotal);
            $this->view->assign("countCaptQuantidade".$arte,$jsQuantidade);
        }
        else{
            foreach($arrayQuantCapturaTotal as $quant):
                $pesoTotal[] = $quant['pesototal'];
            endforeach;
            $jsPeso   = json_encode($pesoTotal);
            $this->view->assign("countCaptPeso".$arte,      $jsPeso);
        }
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels = json_encode($labels);
        
        
        $this->view->assign("countCaptLabels".$arte,    $jsLabels);
        
       
    }
    
    //Gera a quantidade total de entrevistas por porto, mês e por Arte
    public function gerarquantentrevistas($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $quantEntrJaneiro   = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Calao'){
            $quantEntrJaneiro   = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Coleta'){
            $quantEntrJaneiro   = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Emalhe'){
            $quantEntrJaneiro   = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Grosseira'){
            $quantEntrJaneiro   = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Linha'){
            $quantEntrJaneiro   = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'LinhaFundo'){
            $quantEntrJaneiro   = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Jerere'){
            $quantEntrJaneiro   = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Manzua'){
            $quantEntrJaneiro   = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Mergulho'){
            $quantEntrJaneiro   = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Ratoeira'){
            $quantEntrJaneiro   = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Tarrafa'){
            $quantEntrJaneiro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrFevereiro = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrMarco     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrAbril     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrMaio      = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrJunho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrJulho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrAgosto    = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrSetembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrOutubro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrNovembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM tar_data) = ".$ano);
            $quantEntrDezembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM tar_data) = ".$ano);
        }
        if($arte == 'Siripoia'){
            $quantEntrJaneiro   = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'VaraPesca'){
            $quantEntrJaneiro   = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        $quantEntrJaneiro  =   $this->verifVazioEntrevistas($quantEntrJaneiro  ,$porto, $arte);
        $quantEntrFevereiro  = $this->verifVazioEntrevistas($quantEntrFevereiro,$porto, $arte);
        $quantEntrMarco  =     $this->verifVazioEntrevistas($quantEntrMarco    ,$porto, $arte);
        $quantEntrAbril  =     $this->verifVazioEntrevistas($quantEntrAbril    ,$porto, $arte);
        $quantEntrMaio  =      $this->verifVazioEntrevistas($quantEntrMaio     ,$porto, $arte);
        $quantEntrJunho  =     $this->verifVazioEntrevistas($quantEntrJunho    ,$porto, $arte);
        $quantEntrJulho  =     $this->verifVazioEntrevistas($quantEntrJulho    ,$porto, $arte);
        $quantEntrAgosto  =    $this->verifVazioEntrevistas($quantEntrAgosto   ,$porto, $arte);
        $quantEntrSetembro  =  $this->verifVazioEntrevistas($quantEntrSetembro ,$porto, $arte);
        $quantEntrOutubro  =   $this->verifVazioEntrevistas($quantEntrOutubro  ,$porto, $arte);
        $quantEntrNovembro  =  $this->verifVazioEntrevistas($quantEntrNovembro ,$porto, $arte);
        $quantEntrDezembro  =  $this->verifVazioEntrevistas($quantEntrDezembro ,$porto, $arte);
//        print_r($quantArrastoJaneiro);
        
        foreach($quantEntrJaneiro as $quant):
            $quantJaneiro[] = $quant['count'];
        endforeach;
        foreach($quantEntrFevereiro as $quant):
            $quantFevereiro[] = $quant['count'];
        endforeach;
        foreach($quantEntrMarco as $quant):
            $quantMarco[] = $quant['count'];
        endforeach;
        foreach($quantEntrAbril as $quant):
            $quantAbril[] = $quant['count'];
        endforeach;
        foreach($quantEntrMaio as $quant):
            $quantMaio[] = $quant['count'];
        endforeach;
        foreach($quantEntrJunho as $quant):
            $quantJunho[] = $quant['count'];
        endforeach;
        foreach($quantEntrJulho as $quant):
            $quantJulho[] = $quant['count'];
        endforeach;
        foreach($quantEntrAgosto as $quant):
            $quantAgosto[] = $quant['count'];
        endforeach;
        foreach($quantEntrSetembro as $quant):
            $quantSetembro[] = $quant['count'];
        endforeach;
        foreach($quantEntrOutubro as $quant):
            $quantOutubro[] = $quant['count'];
        endforeach;
        foreach($quantEntrNovembro as $quant):
            $quantNovembro[] = $quant['count'];
        endforeach;
        foreach($quantEntrDezembro as $quant):
            $quantDezembro[] = $quant['count'];
        endforeach;
        
        $arrayQuantEntrevistas = array_merge_recursive($quantJaneiro, 
                $quantFevereiro, 
                $quantMarco,
                $quantAbril, 
                $quantMaio, 
                $quantJunho, 
                $quantJulho, 
                $quantAgosto, 
                $quantSetembro,
                $quantOutubro, 
                $quantNovembro, 
                $quantDezembro);
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels        = json_encode($labels);
        $jsQuantEntrevistas   = json_encode($arrayQuantEntrevistas);
        
        $this->view->assign("quantLabels".$arte,    $jsLabels);
        $this->view->assign("quantEntrevistas".$arte,   $jsQuantEntrevistas);

    }
    //Gera o relatório de CPUE de cada porto, por mês e por Arte
    public function gerarcpue($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $cpueEntrJaneiro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Calão'){
            $cpueEntrJaneiro   = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Coleta'){
            $cpueEntrJaneiro   = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Emalhe'){
            $cpueEntrJaneiro   = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Grosseira'){
            $cpueEntrJaneiro   = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Linha'){
            $cpueEntrJaneiro   = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'LinhaFundo'){
            $cpueEntrJaneiro   = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Jerere'){
            $cpueEntrJaneiro   = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Manzua'){
            $cpueEntrJaneiro   = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Mergulho'){
            $cpueEntrJaneiro   = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Ratoeira'){
            $cpueEntrJaneiro   = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Tarrafa'){
            $cpueEntrJaneiro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrMarco     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrAbril     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrMaio      = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrJunho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrJulho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM tar_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM tar_data) = ".$ano);
        }
        else if($arte == 'Siripoia'){
            $cpueEntrJaneiro   = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'VaraPesca'){
            $cpueEntrJaneiro   = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        $cpueEntrJaneiro  = $this->verifVazioCpue($cpueEntrJaneiro, $porto);
        $cpueEntrFevereiro= $this->verifVazioCpue($cpueEntrFevereiro, $porto);
        $cpueEntrMarco    = $this->verifVazioCpue($cpueEntrMarco    , $porto);
        $cpueEntrAbril    = $this->verifVazioCpue($cpueEntrAbril    , $porto);
        $cpueEntrMaio     = $this->verifVazioCpue($cpueEntrMaio     , $porto);
        $cpueEntrJunho    = $this->verifVazioCpue($cpueEntrJunho    , $porto);
        $cpueEntrJulho    = $this->verifVazioCpue($cpueEntrJulho    , $porto);
        $cpueEntrAgosto   = $this->verifVazioCpue($cpueEntrAgosto   , $porto);
        $cpueEntrSetembro = $this->verifVazioCpue($cpueEntrSetembro , $porto);
        $cpueEntrOutubro  = $this->verifVazioCpue($cpueEntrOutubro  , $porto);
        $cpueEntrNovembro = $this->verifVazioCpue($cpueEntrNovembro , $porto);
        $cpueEntrDezembro = $this->verifVazioCpue($cpueEntrDezembro , $porto);
        
        $ArrayCpue = array_merge_recursive($cpueEntrJaneiro,  
                                            $cpueEntrFevereiro,
                                            $cpueEntrMarco    ,
                                            $cpueEntrAbril    ,
                                            $cpueEntrMaio     ,
                                            $cpueEntrJunho    ,
                                            $cpueEntrJulho    ,
                                            $cpueEntrAgosto   ,
                                            $cpueEntrSetembro ,
                                            $cpueEntrOutubro  ,
                                            $cpueEntrNovembro ,
                                            $cpueEntrDezembro );
        
        $ArrayCpueOrdenado = $this->array_sort($ArrayCpue, 'cpue', SORT_DESC);
        
        foreach($ArrayCpueOrdenado as $cpue):
            $ArrayOrdCpue[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrJaneiro as $cpue):
            $cpueJaneiro[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrFevereiro as $cpue):
            $cpueFevereiro[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrMarco as $cpue):
            $cpueMarco[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrAbril as $cpue):
            $cpueAbril[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrMaio as $cpue):
            $cpueMaio[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrJunho as $cpue):
            $cpueJunho[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrJulho as $cpue):
            $cpueJulho[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrAgosto as $cpue):
            $cpueAgosto[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrSetembro as $cpue):
            $cpueSetembro[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrOutubro as $cpue):
            $cpueOutubro[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrNovembro as $cpue):
            $cpueNovembro[] = floatval($cpue['cpue']);
        endforeach;
        foreach($cpueEntrDezembro as $cpue):
            $cpueDezembro[] = floatval($cpue['cpue']);
        endforeach;
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels        = json_encode($labels);
        $jsCpueJaneiro   = json_encode($cpueJaneiro);
        $jsCpueFevereiro = json_encode($cpueFevereiro);
        $jsCpueMarco     = json_encode($cpueMarco);
        $jsCpueAbril     = json_encode($cpueAbril);
        $jsCpueMaio      = json_encode($cpueMaio);
        $jsCpueJunho     = json_encode($cpueJunho);
        $jsCpueJulho     = json_encode($cpueJulho);
        $jsCpueAgosto    = json_encode($cpueAgosto);
        $jsCpueSetembro  = json_encode($cpueSetembro);
        $jsCpueOutubro   = json_encode($cpueOutubro);
        $jsCpueNovembro  = json_encode($cpueNovembro);
        $jsCpueDezembro  = json_encode($cpueDezembro);

        
        $scale = $ArrayOrdCpue[0]/15;
        $this->view->assign("arte", $arte);
        $this->view->assign("porto", $porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("scale", $scale);
        $this->view->assign("cpueLabels",    $jsLabels);
        $this->view->assign("cpueJaneiro",   $jsCpueJaneiro);
        $this->view->assign("cpueFevereiro", $jsCpueFevereiro);
        $this->view->assign("cpueMarco",     $jsCpueMarco);
        $this->view->assign("cpueAbril",     $jsCpueAbril);
        $this->view->assign("cpueMaio",      $jsCpueMaio);
        $this->view->assign("cpueJunho",     $jsCpueJunho);
        $this->view->assign("cpueJulho",     $jsCpueJulho);
        $this->view->assign("cpueAgosto",    $jsCpueAgosto);
        $this->view->assign("cpueSetembro",  $jsCpueSetembro);
        $this->view->assign("cpueOutubro",   $jsCpueOutubro);
        $this->view->assign("cpueNovembro",  $jsCpueNovembro);
        $this->view->assign("cpueDezembro",  $jsCpueDezembro);
        
        //print_r($jsCpueNovembro);
    }
    //Gera o relatório dos barcos que mais apareceram no porto.
    public function gerarquantbarcos($porto, $ano, $arte){
        
        switch($arte){
            case 'Arrasto':
                $arrayQuantBarcos = $this->modelArrasto->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Calao':
                $arrayQuantBarcos =$this->modelCalao->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Coleta':
                $arrayQuantBarcos =$this->modelColeta->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Emalhe':
               $arrayQuantBarcos = $this->modelEmalhe->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Grosseira':
                $arrayQuantBarcos =$this->modelGrosseira->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Jerere':
               $arrayQuantBarcos = $this->modelJerere->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Linha':
               $arrayQuantBarcos = $this->modelLinha->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'LinhaFundo':
               $arrayQuantBarcos = $this->modelLinhaFundo->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Manzua':
               $arrayQuantBarcos = $this->modelManzua->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Mergulho':
              $arrayQuantBarcos =  $this->modelMergulho->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Ratoeira':
               $arrayQuantBarcos = $this->modelRatoeira->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Siripoia':
               $arrayQuantBarcos = $this->modelSiripoia->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Tarrafa':
              $arrayQuantBarcos =  $this->modelTarrafa->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM tar_data) = ".$ano);
            break;
            case 'VaraPesca':
               $arrayQuantBarcos = $this->modelVaraPesca->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
        }
 
        $arrayQuantBarcos = $this->verifVazioBarcos($arrayQuantBarcos, $porto, $arte);

        $i = 0;
        foreach($arrayQuantBarcos as $quant):
            if ($i++ < 10){
                $quantBarcos[] = $quant['quant'];
                $labelBarcos[] = $quant['bar_nome'];
            }
        endforeach;

        $jsQuantBarcos = json_encode($quantBarcos);
        $jsLabelBarcos = json_encode($labelBarcos);

        $this->view->assign("quantBarcos".$arte, $jsQuantBarcos);
        $this->view->assign("labelBarcos".$arte, $jsLabelBarcos);
        
            
    }
    public function gerarespeciescapturadas($porto, $ano, $arte){
        
        switch($arte){
            case 'Arrasto':
                $arrayEsp = $this->modelArrasto->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
                $arrayQuantCaptura = $this->verificaEspecies($arrayEsp);
            break;
            case 'Calao':
                $arrayQuantCaptura =$this->modelCalao->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Coleta':
                $arrayQuantCaptura =$this->modelColeta->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Emalhe':
               $arrayQuantCaptura = $this->modelEmalhe->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Grosseira':
                $arrayQuantCaptura =$this->modelGrosseira->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Jerere':
               $arrayQuantCaptura = $this->modelJerere->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Linha':
               $arrayQuantCaptura = $this->modelLinha->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'LinhaFundo':
               $arrayQuantCaptura = $this->modelLinhaFundo->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Manzua':
               $arrayQuantCaptura = $this->modelManzua->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Mergulho':
              $arrayQuantCaptura =  $this->modelMergulho->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Ratoeira':
               $arrayQuantCaptura = $this->modelRatoeira->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Siripoia':
               $arrayQuantCaptura = $this->modelSiripoia->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'Tarrafa':
              $arrayQuantCaptura =  $this->modelTarrafa->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM tar_data) = ".$ano);
            break;
            case 'VaraPesca':
               $arrayQuantCaptura = $this->modelVaraPesca->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
        }
 
        $arrayQuantCaptura = $this->verifVazioQuantCaptura($arrayQuantCaptura, $porto, $arte);
        
        
        $arrayQuantCapturaOrdenado = $this->array_sort($arrayQuantCaptura, 'peso', SORT_DESC);
        $i=0;
        foreach($arrayQuantCapturaOrdenado as $quant):
            if($i<=10 && $quant['esp_nome_comum'] != 'Rosinha'){
                $quantCaptura[] = $quant['quant'];
		$pesoCaptura[] = $quant['peso'];
                $labelCaptura[] = $quant['esp_nome_comum'];
            }
            $i++;
        endforeach;

        $jsQuantCaptura = json_encode($quantCaptura);
	$jsPesoCaptura = json_encode($pesoCaptura);
        $jsLabelCaptura = json_encode($labelCaptura);

        $this->view->assign("quantCaptura".$arte, $jsQuantCaptura);
	$this->view->assign("pesoCaptura".$arte, $jsPesoCaptura);
        $this->view->assign("labelCaptura".$arte, $jsLabelCaptura);
            
    }
    
    public function gerarrelqtdporarte($porto, $ano){
        $quantidadeArrasto    = $this->modelArrasto   ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeCalao      = $this->modelCalao     ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeColeta     = $this->modelColeta    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeEmalhe     = $this->modelEmalhe    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeGrosseira  = $this->modelGrosseira ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeJerere     = $this->modelJerere    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeLinha      = $this->modelLinha     ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeLinhaFundo = $this->modelLinhaFundo->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeManzua     = $this->modelManzua    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeMergulho   = $this->modelMergulho  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeRatoeira   = $this->modelRatoeira  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeSiripoia   = $this->modelSiripoia  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeTarrafa    = $this->modelTarrafa   ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM tar_data) = ".$ano);
        $quantidadeVaraPesca  = $this->modelVaraPesca ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        
        $qtdArrasto =  $this->verifVazioEntrevistas($quantidadeArrasto   , $porto, 'Arrasto de Fundo');
        $qtdCalao =    $this->verifVazioEntrevistas($quantidadeCalao     , $porto, 'Calão');
        $qtdColeta =   $this->verifVazioEntrevistas($quantidadeColeta    , $porto, 'Coleta');
        $qtdEmalhe =   $this->verifVazioEntrevistas($quantidadeEmalhe    , $porto, 'Emalhe');
        $qtdGrosseira= $this->verifVazioEntrevistas($quantidadeGrosseira , $porto, 'Grosseira');
        $qtdJerere =   $this->verifVazioEntrevistas($quantidadeJerere    , $porto, 'Jereré');
        $qtdLinha =    $this->verifVazioEntrevistas($quantidadeLinha     , $porto, 'Pesca de Linha');
        $qtdLinhaFundo=$this->verifVazioEntrevistas($quantidadeLinhaFundo, $porto, 'Linha de Fundo');
        $qtdManzua=    $this->verifVazioEntrevistas($quantidadeManzua    , $porto, 'Manzuá');
        $qtdMergulho=  $this->verifVazioEntrevistas($quantidadeMergulho  , $porto, 'Mergulho');
        $qtdRatoeira=  $this->verifVazioEntrevistas($quantidadeRatoeira  , $porto, 'Ratoeira');
        $qtdSiripoia=  $this->verifVazioEntrevistas($quantidadeSiripoia  , $porto, 'Siripoia');
        $qtdTarrafa=   $this->verifVazioEntrevistas($quantidadeTarrafa   , $porto, 'Tarrafa');
        $qtdVaraPesca =$this->verifVazioEntrevistas($quantidadeVaraPesca , $porto, 'Vara de Pesca');

        $arrayQuantidades =  array_merge_recursive(
                $qtdArrasto, 
                $qtdCalao, 
                $qtdColeta, 
                $qtdEmalhe, 
                $qtdGrosseira, 
                $qtdJerere, 
                $qtdLinha, 
                $qtdLinhaFundo,
                $qtdManzua,
                $qtdMergulho,
                $qtdRatoeira,
                $qtdSiripoia,
                $qtdTarrafa,
                $qtdVaraPesca);
        
        $arrayQtds = $this->array_sort($arrayQuantidades,'count', SORT_DESC);
        $i=0;
        $soma = 0;
        foreach($arrayQtds as $qtd):
            $soma += $qtd['count'];
            if($i++ < 5){
                $arrayTopFive[] = $qtd['count'];
                $labels[] = $qtd['arte'];
            }
        endforeach;
        
        for ($i = 0; $i < 5; $i++){
            $porcentagem = ($arrayTopFive[$i]/$soma)*100;
            $arrayTopFive[$i] = $porcentagem;
        }
        
        $jsTopFive = json_encode($arrayTopFive);
        $jsLabels = json_encode($labels);

        $this->view->assign("arrayPorArteQtds", $jsTopFive);
        $this->view->assign("arrayPorArteLabels", $jsLabels);
        
//        print_r($jsTopFive);
//        print_r($jsLabels);

    }
    
    
    public function amendoeiraAction(){
        
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
//        $dataIni = $this->dataInicial($dateStart);
//        $date = explode('-',$dataIni);
//        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
//        $this->view->assign("dataini", $datainicial);
//        
//        $dataFim = $this->dataFinal($dateEnd);
//        $date = explode('-',$dataFim);
//        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
//        $this->view->assign("datafim", $datafinal);
        

        
        $porto = "Amendoeira";
        
        
        //Barcos que mais pescam
        //$this->modelCalao     
        //$this->modelEmalhe    
        //$this->modelGrosseira 
        //$this->modelLinha     
        //$this->modelManzua    
        //$this->modelMergulho  
        //$this->modelTarrafa   
        
        $this->gerarquantentrevistas($porto, $ano, 'Calao');
        //$this->gerarquantentrevistas($porto, $ano, 'Emalhe');
        //$this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
        //$this->gerarquantentrevistas($porto, $ano, 'Manzua');
        
        
        $this->gerarquantcaptura($porto, $ano, 'Calao');
        //$this->gerarquantcaptura($porto, $ano, 'Emalhe');
        //$this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
        //$this->gerarquantcaptura($porto, $ano, 'Manzua');
        
        $this->gerarquantbarcos($porto, $ano, 'Calao');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
        
        $this->gerarespeciescapturadas($porto, $ano, 'Calao');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Calão");
    }
    public function aritaguaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Aritaguá";
        
        /* Artes desse porto:
         * Coleta   
         * Emalhe   
         * Jerere   
         * Linha    
         * Manzua   
         * Mergulho 
         * Ratoeira 
         * Siripoia 
         * Tarrafa  
         * VaraPesca
         */
        
//        $this->gerarquantentrevistas($porto, $ano,'Coleta');
//        $this->gerarquantentrevistas($porto, $ano,'Emalhe');
        $this->gerarquantentrevistas($porto, $ano,'Jerere');
//        $this->gerarquantentrevistas($porto, $ano,'Linha');
//        $this->gerarquantentrevistas($porto, $ano,'Manzua');
//        $this->gerarquantentrevistas($porto, $ano,'Mergulho');
        $this->gerarquantentrevistas($porto, $ano,'Ratoeira');
//        $this->gerarquantentrevistas($porto, $ano,'Siripoia');
//        $this->gerarquantentrevistas($porto, $ano,'Tarrafa');
//        $this->gerarquantentrevistas($porto, $ano,'VaraPesca');        
        
//        $this->gerarquantcaptura($porto, $ano, 'Coleta');
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
        $this->gerarquantcaptura($porto, $ano, 'Jerere');
//        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Manzua');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
        $this->gerarquantcaptura($porto, $ano, 'Ratoeira');
//        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
//        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');  
        
//        $this->gerarquantbarcos($porto, $ano, 'Coleta');
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
        $this->gerarquantbarcos($porto, $ano, 'Jerere');
//        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Manzua');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
        $this->gerarquantbarcos($porto, $ano, 'Ratoeira');
//        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
//        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');  
      
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Jerere');
        $this->gerarespeciescapturadas($porto, $ano, 'Ratoeira');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Jereré");
        $this->view->assign("segArteMaisPescada", "Ratoeira");
    }
    public function baduAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Vila Badú";
                
        /* Artes desse porto:
         * Coleta   
         * Emalhe   
         * Jerere   
         * Linha   
         * Mergulho 
         * Ratoeira 
         * Siripoia 
         * Tarrafa  
         * VaraPesca
         */
        
//        $this->gerarquantentrevistas($porto, $ano,'Coleta');
//        $this->gerarquantentrevistas($porto, $ano,'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano,'Jerere');
//        $this->gerarquantentrevistas($porto, $ano,'Manzua');
        $this->gerarquantentrevistas($porto, $ano,'Linha');
//        $this->gerarquantentrevistas($porto, $ano,'Mergulho');
//        $this->gerarquantentrevistas($porto, $ano,'Ratoeira');
//        $this->gerarquantentrevistas($porto, $ano,'Siripoia');
        $this->gerarquantentrevistas($porto, $ano,'Tarrafa');
//        $this->gerarquantentrevistas($porto, $ano,'VaraPesca');        
        
//        $this->gerarquantcaptura($porto, $ano, 'Coleta');
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Jerere');
//        $this->gerarquantcaptura($porto, $ano, 'Manzua');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
//        $this->gerarquantcaptura($porto, $ano, 'Ratoeira');
//        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');  
        
//        $this->gerarquantbarcos($porto, $ano, 'Coleta');
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Jerere');
//        $this->gerarquantbarcos($porto, $ano, 'Manzua');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
//        $this->gerarquantbarcos($porto, $ano, 'Ratoeira');
//        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');  
      
        $this->gerarespeciescapturadas($porto, $ano, 'Tarrafa');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Tarrafa");
        $this->view->assign("segArteMaisPescada", "Linha");
    }
    public function barraAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Porto da Barra";
        
        /* Artes desse porto:
         * Arrasto
         */
                
        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
        $this->gerarquantentrevistas($porto, $ano, 'Siripoia');
        
        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
        
        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Arrasto');
        $this->gerarespeciescapturadas($porto, $ano, 'Siripoia');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Arrasto");
        $this->view->assign("segArteMaisPescada", "Siripoia");
    }
    public function conchaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Porto da Concha";
                
        /* Artes desse porto:
         * Arrasto
         * Calao
         * Emalhe
         * Grosseira
         * Linha
         * Mergulho
         * VaraPesca
         */
                
//        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
//        $this->gerarquantentrevistas($porto, $ano, 'Calao');
        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
//        $this->gerarquantentrevistas($porto, $ano, 'Mergulho');
//        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca');
                
//        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
//        $this->gerarquantcaptura($porto, $ano, 'Calao');
        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');
        
//        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
//        $this->gerarquantbarcos($porto, $ano, 'Calao');
        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Emalhe');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Emalhe");
    }
    
    public function cpueAction(){
        $porto = $this->_getParam('porto');
        $arte = $this->_getParam('arte');
        $ano = $this->_getParam('ano');
        
        
        $this->gerarcpue($porto, $ano, $arte);
    }
    public function forteAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Porto do Forte";
          
        /* Artes desse porto:
         * Arrasto
         * Coleta
         * Emalhe
         * Grosseira
         * Linha
         * Siripoia
         * Tarrafa
         */
                
//        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
//        $this->gerarquantentrevistas($porto, $ano, 'Coleta');
//        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
//        $this->gerarquantentrevistas($porto, $ano, 'Siripoia');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
                
//        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
//        $this->gerarquantcaptura($porto, $ano, 'Coleta');
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
//        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
        
//        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
//        $this->gerarquantbarcos($porto, $ano, 'Coleta');
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
//        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Arrasto');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Arrasto");
        $this->view->assign("segArteMaisPescada", "Linha");
    }
    public function jueranaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Juerana rio";
        
        /* Artes desse porto:
         * Linha
         * LinhaFundo
         * Manzua
         * Mergulho 
         * Ratoeira 
         * VaraPesca
         */
                
        $this->gerarquantentrevistas($porto, $ano, 'Manzua');
        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca'); 

        $this->gerarquantcaptura($porto, $ano, 'Manzua');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
        $this->gerarquantcaptura($porto, $ano, 'VaraPesca'); 
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');
        
//        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'LinhaFundo');
        $this->gerarquantbarcos($porto, $ano, 'Manzua');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
        $this->gerarquantbarcos($porto, $ano, 'VaraPesca'); 
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Manzua');
        $this->gerarespeciescapturadas($porto, $ano, 'VaraPesca');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Manzua");
        $this->view->assign("segArteMaisPescada", "Vara de Pesca");
    }
    public function mamoaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Mamoã";
                  
        /* Artes desse porto:
         * Calao    
         * Emalhe   
         * Grosseira
         * Linha
         * Mergulho 
         * Siripoia 
         * Tarrafa  
         */
                
        $this->gerarquantentrevistas($porto, $ano, 'Calao');
//        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
//        $this->gerarquantentrevistas($porto, $ano, 'Mergulho');
//        $this->gerarquantentrevistas($porto, $ano, 'Siripoia');
//        $this->gerarquantentrevistas($porto, $ano, 'Tarrafa');
                
        $this->gerarquantcaptura($porto, $ano, 'Calao');
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
//        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
//        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
        
        $this->gerarquantbarcos($porto, $ano, 'Calao');
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
//        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
//        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        $this->gerarespeciescapturadas($porto, $ano, 'Calao');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Calao");
    }
    public function pontalAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Pontal";
        
        /* Artes desse porto:
         * Arrasto
         * Emalhe
         * Grosseira
         * Linha
         * Siripoia
         * VaraPesca
         */
                
        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
//        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
//        $this->gerarquantentrevistas($porto, $ano, 'Siripoia');
//        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca');
                
        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Siripoia');
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');
        
        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Siripoia');
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Arrasto');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Arrasto");
    }
    public function prainhaAction(){
        $ano = $this->_getParam('ano');
        
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Prainha";
        
        /* Artes desse porto:
         * Arrasto
         * Calao
         * Grosseira
         * Linha
         * Mergulho
         */
        
        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
//        $this->gerarquantentrevistas($porto, $ano, 'Calao');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
//        $this->gerarquantentrevistas($porto, $ano, 'Mergulho');
                
        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
//        $this->gerarquantcaptura($porto, $ano, 'Calao');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
        
        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
//        $this->gerarquantbarcos($porto, $ano, 'Calao');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        $this->gerarespeciescapturadas($porto, $ano, 'Arrasto');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Arrasto");
    }
    public function ramoAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Ponta do Ramo";
        
        /* Artes desse porto:
         * Calao
         * Grosseira
         * Linha
         */
        
        $this->gerarquantentrevistas($porto, $ano, 'Calao');
//        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
                
        $this->gerarquantcaptura($porto, $ano, 'Calao');
//        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
        
        $this->gerarquantbarcos($porto, $ano, 'Calao');
//        $this->gerarquantbarcos($porto, $ano, 'Grosseira');
        $this->gerarquantbarcos($porto, $ano, 'Linha');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Calao');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Calao");
    }
    public function sambaitubaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Sambaituba";
        
        /* Artes desse porto:
         * Emalhe
         * Jerere 
         * Linha
         * Manzua
         * Mergulho 
         * Ratoeira 
         * Tarrafa  
         * VaraPesca
         */
                
//        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
//        $this->gerarquantentrevistas($porto, $ano, 'Jerere');   
//        $this->gerarquantentrevistas($porto, $ano, 'Linha');
        $this->gerarquantentrevistas($porto, $ano, 'Manzua');  
//        $this->gerarquantentrevistas($porto, $ano, 'Mergulho');
        $this->gerarquantentrevistas($porto, $ano, 'Ratoeira');
//        $this->gerarquantentrevistas($porto, $ano, 'Tarrafa');
//        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca');
//                
//        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
//        $this->gerarquantcaptura($porto, $ano, 'Jerere');   
//        $this->gerarquantcaptura($porto, $ano, 'Linha');
        $this->gerarquantcaptura($porto, $ano, 'Manzua');  
//        $this->gerarquantcaptura($porto, $ano, 'Mergulho');
        $this->gerarquantcaptura($porto, $ano, 'Ratoeira');
//        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
//        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');
//        
//        $this->gerarquantbarcos($porto, $ano, 'Emalhe');
//        $this->gerarquantbarcos($porto, $ano, 'Jerere');   
//        $this->gerarquantbarcos($porto, $ano, 'Linha');
        $this->gerarquantbarcos($porto, $ano, 'Manzua');  
//        $this->gerarquantbarcos($porto, $ano, 'Mergulho');
        $this->gerarquantbarcos($porto, $ano, 'Ratoeira');
//        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
//        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Manzua');
        $this->gerarespeciescapturadas($porto, $ano, 'Ratoeira');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Manzua");
        $this->view->assign("segArteMaisPescada", "Ratoeira");
    }
    public function saomiguelAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "São Miguel";
        
        /* Artes desse porto:
         * Arrasto
         * Calao
         * Emalhe
         * Grosseira
         * Linha
         * Mergulho
         * Siripoia
         * Tarrafa  
         * VaraPesca
         */
        
        $this->gerarquantentrevistas($porto, $ano, 'Calao');
        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');

        $this->gerarquantcaptura($porto, $ano, 'Calao');
        $this->gerarquantcaptura($porto, $ano, 'Emalhe');

        $this->gerarquantbarcos($porto, $ano, 'Calao');
        $this->gerarquantbarcos($porto, $ano, 'Emalhe');

        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Calao');
        $this->gerarespeciescapturadas($porto, $ano, 'Emalhe');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Calao");
        $this->view->assign("segArteMaisPescada", "Emalhe");
    }
    public function serraAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Pé de Serra";
        
        /* Artes desse porto:
         * Calao    
         * Coleta   
         * Emalhe  
         * Linha    
         * Mergulho 
         * Siripoia 
         * Tarrafa  
         * VaraPesca
         */
        

        $this->gerarquantentrevistas($porto, $ano, 'Tarrafa');
        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca');
                

        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');

        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Tarrafa');
        $this->gerarespeciescapturadas($porto, $ano, 'VaraPesca');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Tarrafa");
        $this->view->assign("segArteMaisPescada", "VaraPesca");
    }
    public function sobradinhoAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Sobradinho";
        
        /* Artes desse porto:
         * Calao    
         * Emalhe  
         * Linha    
         * Mergulho 
         * Siripoia 
         * Tarrafa  
         * VaraPesca
         */
               
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
        $this->gerarquantentrevistas($porto, $ano, 'Tarrafa');

        $this->gerarquantcaptura($porto, $ano, 'Linha');
        $this->gerarquantcaptura($porto, $ano, 'Tarrafa');
        

        $this->gerarquantbarcos($porto, $ano, 'Linha');
        $this->gerarquantbarcos($porto, $ano, 'Tarrafa');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Tarrafa');
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Tarrafa");
    }
    public function terminalAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Terminal Pesqueiro";
        
        /* Artes desse porto:
         * Arrasto     
         * Grosseira  
         * Linha    
         * Mergulho 
         * Siripoia 
         */
               
        $this->gerarquantentrevistas($porto, $ano, 'Arrasto');
        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');

                
        $this->gerarquantcaptura($porto, $ano, 'Arrasto');
        $this->gerarquantcaptura($porto, $ano, 'Grosseira');

        
        $this->gerarquantbarcos($porto, $ano, 'Arrasto');
        $this->gerarquantbarcos($porto, $ano, 'Grosseira');

        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Arrasto');
        $this->gerarespeciescapturadas($porto, $ano, 'Grosseira');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Arrasto");
        $this->view->assign("segArteMaisPescada", "Groseira");
    }
    public function tulhaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Ponta da Tulha";
        
        /* Artes desse porto:
         * Calao  
         * Coleta 
         * Emalhe 
         * Grosseira
         * Linha  
         * Mergulho
         * Ratoeira
         * Siripoia
         * Tarrafa 
         */
               
        $this->gerarquantentrevistas($porto, $ano, 'Calao');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');

                
        $this->gerarquantcaptura($porto, $ano, 'Calao');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
        
        $this->gerarquantbarcos($porto, $ano, 'Calao');
        $this->gerarquantbarcos($porto, $ano, 'Linha');

        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Linha');
        $this->gerarespeciescapturadas($porto, $ano, 'Calao');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Linha");
        $this->view->assign("segArteMaisPescada", "Calao");
    }
    public function urucutucaAction(){
        $ano = $this->_getParam('ano');
        if($ano == ""){
            $ano = 2014;
        }
        $porto = "Urucutuca";
        
        /* Artes desse porto:
         * Emalhe 
         * Jerere
         * Manzua
         * Siripoia
         * Tarrafa 
         * VaraPesca
         */
               

        $this->gerarquantentrevistas($porto, $ano, 'Manzua');
        $this->gerarquantentrevistas($porto, $ano, 'VaraPesca');
                
        $this->gerarquantcaptura($porto, $ano, 'Manzua');
        $this->gerarquantcaptura($porto, $ano, 'VaraPesca');
        
        $this->gerarquantbarcos($porto, $ano, 'Manzua');
        $this->gerarquantbarcos($porto, $ano, 'VaraPesca');
        
        $this->gerarrelqtdporarte($porto, $ano);
        
        $this->gerarespeciescapturadas($porto, $ano, 'Manzua');
        $this->gerarespeciescapturadas($porto, $ano, 'VaraPesca');
        
        $this->view->assign("porto",$porto);
        $this->view->assign("ano", $ano);
        $this->view->assign("arteMaisPescada", "Manzua");
        $this->view->assign("segArteMaisPescada", "VaraPesca");
    }
            
	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPorto = new Application_Model_Porto();
		$localPorto = $localModelPorto->selectView(NULL, array('tuf_sigla', 'tmun_municipio', 'pto_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Portos');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'UF');
		$modeloRelatorio->setLegenda(110, 'Município');
		$modeloRelatorio->setLegenda(220, 'Porto');
		$modeloRelatorio->setLegenda(400, 'Local');

		foreach ($localPorto as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['pto_id']);
			$modeloRelatorio->setValue(80, $localData['tuf_sigla']);
			$modeloRelatorio->setValue(110, $localData['tmun_municipio']);
			$modeloRelatorio->setValue(220, $localData['pto_nome']);
			$modeloRelatorio->setValue(400, $localData['pto_local']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_portos.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}

