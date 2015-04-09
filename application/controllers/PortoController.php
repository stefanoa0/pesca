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
            case 1: $this->_redirect('porto/forte/ano/'.$ano); 
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
    public function verifVazioCaptura($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'quant' => 0,
                'peso' => 0,
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
                'quant' => 0,
                )
            );
        }
        else if($array[0]['quant'] == ""){
            $array[0]['quant'] = 0;
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
    function array_sort($array, $on, $order=SORT_ASC){
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

    


    //Gera as quantidade de captura por porto, mês e ano
    public function gerarquantcaptura($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $quantCaptJaneiro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Calao'){
            $quantCaptJaneiro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Coleta'){
            $quantCaptJaneiro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Emalhe'){
            $quantCaptJaneiro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Grosseira'){
            $quantCaptJaneiro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Linha'){
            $quantCaptJaneiro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'LinhaFundo'){
            $quantCaptJaneiro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Jerere'){
            $quantCaptJaneiro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Manzua'){
            $quantCaptJaneiro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Mergulho'){
            $quantCaptJaneiro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Ratoeira'){
            $quantCaptJaneiro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Tarrafa'){
            $quantCaptJaneiro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Siripoia'){
            $quantCaptJaneiro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'VaraPesca'){
            $quantCaptJaneiro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        $quantCaptJaneiro  = $this->verifVazioCaptura($quantCaptJaneiro,   $porto,$arte);
        $quantCaptFevereiro= $this->verifVazioCaptura($quantCaptFevereiro, $porto,$arte);
        $quantCaptMarco    = $this->verifVazioCaptura($quantCaptMarco    , $porto,$arte);
        $quantCaptAbril    = $this->verifVazioCaptura($quantCaptAbril    , $porto,$arte);
        $quantCaptMaio     = $this->verifVazioCaptura($quantCaptMaio     , $porto,$arte);
        $quantCaptJunho    = $this->verifVazioCaptura($quantCaptJunho    , $porto,$arte);
        $quantCaptJulho    = $this->verifVazioCaptura($quantCaptJulho    , $porto,$arte);
        $quantCaptAgosto   = $this->verifVazioCaptura($quantCaptAgosto   , $porto,$arte);
        $quantCaptSetembro = $this->verifVazioCaptura($quantCaptSetembro , $porto,$arte);
        $quantCaptOutubro  = $this->verifVazioCaptura($quantCaptOutubro  , $porto,$arte);
        $quantCaptNovembro = $this->verifVazioCaptura($quantCaptNovembro , $porto,$arte);
        $quantCaptDezembro = $this->verifVazioCaptura($quantCaptDezembro , $porto,$arte);
        
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
        
        foreach($arrayQuantCapturaTotal as $quant):
            $pesoTotal[] = $quant['peso'];
            $quantTotal[] = $quant['quant'];
        endforeach;
        
//        foreach($quantCaptJaneiro as $quant):
//            $pesoJaneiro[] = $quant['peso'];
//            $quantJaneiro[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptFevereiro as $quant):
//            $pesoFevereiro[] = $quant['peso'];
//            $quantFevereiro[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptMarco as $quant):
//            $pesoMarco[] = $quant['peso'];
//            $quantMarco[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptAbril as $quant):
//            $pesoAbril[] = $quant['peso'];
//            $quantAbril[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptMaio as $quant):
//            $pesoMaio[] = $quant['peso'];
//            $quantMaio[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptJunho as $quant):
//            $pesoJunho[] = $quant['peso'];
//            $quantJunho[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptJulho as $quant):
//            $pesoJulho[] = $quant['peso'];
//            $quantJulho[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptAgosto as $quant):
//            $pesoAgosto[] = $quant['peso'];
//            $quantAgosto[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptSetembro as $quant):
//            $pesoSetembro[] = $quant['peso'];
//            $quantSetembro[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptOutubro as $quant):
//            $pesoOutubro[] = $quant['peso'];
//            $quantOutubro[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptNovembro as $quant):
//            $pesoNovembro[] = $quant['peso'];
//            $quantNovembro[] = $quant['quant'];
//        endforeach;
//        foreach($quantCaptDezembro as $quant):
//            $pesoDezembro[] = $quant['peso'];
//            $quantDezembro[] = $quant['quant'];
//        endforeach;
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels = json_encode($labels);
        $jsPeso   = json_encode($pesoTotal);
        $jsQuantidade = json_encode($quantTotal);
//        $jsquantCaptJaneiro   = json_encode($quantJaneiro);
//        $jsquantCaptFevereiro = json_encode($quantFevereiro);
//        $jsquantCaptMarco     = json_encode($quantMarco);
//        $jsquantCaptAbril     = json_encode($quantAbril);
//        $jsquantCaptMaio      = json_encode($quantMaio);
//        $jsquantCaptJunho     = json_encode($quantJunho);
//        $jsquantCaptJulho     = json_encode($quantJulho);
//        $jsquantCaptAgosto    = json_encode($quantAgosto);
//        $jsquantCaptSetembro  = json_encode($quantSetembro);
//        $jsquantCaptOutubro   = json_encode($quantOutubro);
//        $jsquantCaptNovembro  = json_encode($quantNovembro);
//        $jsquantCaptDezembro  = json_encode($quantDezembro);
//        
//        $jspesoCaptJaneiro   = json_encode($pesoJaneiro);
//        $jspesoCaptFevereiro = json_encode($pesoFevereiro);
//        $jspesoCaptMarco     = json_encode($pesoMarco);
//        $jspesoCaptAbril     = json_encode($pesoAbril);
//        $jspesoCaptMaio      = json_encode($pesoMaio);
//        $jspesoCaptJunho     = json_encode($pesoJunho);
//        $jspesoCaptJulho     = json_encode($pesoJulho);
//        $jspesoCaptAgosto    = json_encode($pesoAgosto);
//        $jspesoCaptSetembro  = json_encode($pesoSetembro);
//        $jspesoCaptOutubro   = json_encode($pesoOutubro);
//        $jspesoCaptNovembro  = json_encode($pesoNovembro);
//        $jspesoCaptDezembro  = json_encode($pesoDezembro);
        
        $this->view->assign("countCaptLabels".$arte,    $jsLabels);
        $this->view->assign("countCaptPeso".$arte,      $jsPeso);
        $this->view->assign("countCaptQuantidade".$arte,$jsQuantidade);
//        $this->view->assign("countCaptJaneiro".$arte,   $jsquantCaptJaneiro); 
//        $this->view->assign("countCaptFevereiro".$arte, $jsquantCaptFevereiro);
//        $this->view->assign("countCaptMarco".$arte,     $jsquantCaptMarco);
//        $this->view->assign("countCaptAbril".$arte,     $jsquantCaptAbril); 
//        $this->view->assign("countCaptMaio".$arte,      $jsquantCaptMaio); 
//        $this->view->assign("countCaptJunho".$arte,     $jsquantCaptJunho);  
//        $this->view->assign("countCaptJulho".$arte,     $jsquantCaptJulho); 
//        $this->view->assign("countCaptAgosto".$arte,    $jsquantCaptAgosto); 
//        $this->view->assign("countCaptSetembro".$arte,  $jsquantCaptSetembro);
//        $this->view->assign("countCaptOutubro".$arte,   $jsquantCaptOutubro);
//        $this->view->assign("countCaptNovembro".$arte,  $jsquantCaptNovembro);
//        $this->view->assign("countCaptDezembro".$arte,  $jsquantCaptDezembro);
//        
//        $this->view->assign("pesoCaptJaneiro".$arte,   $jspesoCaptJaneiro); 
//        $this->view->assign("pesoCaptFevereiro".$arte, $jspesoCaptFevereiro);
//        $this->view->assign("pesoCaptMarco".$arte,     $jspesoCaptMarco);
//        $this->view->assign("pesoCaptAbril".$arte,     $jspesoCaptAbril); 
//        $this->view->assign("pesoCaptMaio".$arte,      $jspesoCaptMaio); 
//        $this->view->assign("pesoCaptJunho".$arte,     $jspesoCaptJunho);  
//        $this->view->assign("pesoCaptJulho".$arte,     $jspesoCaptJulho); 
//        $this->view->assign("pesoCaptAgosto".$arte,    $jspesoCaptAgosto); 
//        $this->view->assign("pesoCaptSetembro".$arte,  $jspesoCaptSetembro);
//        $this->view->assign("pesoCaptOutubro".$arte,   $jspesoCaptOutubro);
//        $this->view->assign("pesoCaptNovembro".$arte,  $jspesoCaptNovembro);
//        $this->view->assign("pesoCaptDezembro".$arte,  $jspesoCaptDezembro);
        
        //print_r($jsquantCaptNovembro);
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
            $quantEntrJaneiro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
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
        else if($arte == 'Calao'){
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
            $cpueEntrJaneiro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
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
//        print_r($cpueArrastoJaneiro);
        
        foreach($cpueEntrJaneiro as $cpue):
            $cpueJaneiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrFevereiro as $cpue):
            $cpueFevereiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrMarco as $cpue):
            $cpueMarco[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrAbril as $cpue):
            $cpueAbril[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrMaio as $cpue):
            $cpueMaio[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrJunho as $cpue):
            $cpueJunho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrJulho as $cpue):
            $cpueJulho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrAgosto as $cpue):
            $cpueAgosto[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrSetembro as $cpue):
            $cpueSetembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrOutubro as $cpue):
            $cpueOutubro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrNovembro as $cpue):
            $cpueNovembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrDezembro as $cpue):
            $cpueDezembro[] = $cpue['cpue'];
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
        
        

        $this->view->assign("cpueLabels".$arte,    $jsLabels);
        $this->view->assign("cpueJaneiro".$arte,   $jsCpueJaneiro);
        $this->view->assign("cpueFevereiro".$arte, $jsCpueFevereiro);
        $this->view->assign("cpueMarco".$arte,     $jsCpueMarco);
        $this->view->assign("cpueAbril".$arte,     $jsCpueAbril);
        $this->view->assign("cpueMaio".$arte,      $jsCpueMaio);
        $this->view->assign("cpueJunho".$arte,     $jsCpueJunho);
        $this->view->assign("cpueJulho".$arte,     $jsCpueJulho);
        $this->view->assign("cpueAgosto".$arte,    $jsCpueAgosto);
        $this->view->assign("cpueSetembro".$arte,  $jsCpueSetembro);
        $this->view->assign("cpueOutubro".$arte,   $jsCpueOutubro);
        $this->view->assign("cpueNovembro".$arte,  $jsCpueNovembro);
        $this->view->assign("cpueDezembro".$arte,  $jsCpueDezembro);
        
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
              $arrayQuantBarcos =  $this->modelTarrafa->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'VaraPesca':
               $arrayQuantBarcos = $this->modelVaraPesca->selectQuantBarcosByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
        }
 
        $arrayQuantBarcos = $this->verifVazioBarcos($arrayQuantBarcos, $porto, $arte);

        foreach($arrayQuantBarcos as $quant):
            
                $quantBarcos[] = $quant['quant'];
                $labelBarcos[] = $quant['bar_nome'];


        endforeach;

        $jsQuantBarcos = json_encode($quantBarcos);
        $jsLabelBarcos = json_encode($labelBarcos);

        $this->view->assign("quantBarcos".$arte, $jsQuantBarcos);
        $this->view->assign("labelBarcos".$arte, $jsLabelBarcos);
            
            
    }
    public function gerarespeciescapturadas($porto, $ano, $arte){
        
        switch($arte){
            case 'Arrasto':
                $arrayQuantCaptura = $this->modelArrasto->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
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
              $arrayQuantCaptura =  $this->modelTarrafa->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
            case 'VaraPesca':
               $arrayQuantCaptura = $this->modelVaraPesca->selectQuantCapturaByPorto("pto_nome='".$porto."' And Extract(YEAR FROM fd_data) = ".$ano);
            break;
        }
 
        $arrayQuantCaptura = $this->verifVazioCaptura($arrayQuantCaptura, $porto, $arte);
        
        $arrayQuantCapturaOrdenado = $this->array_sort($arrayQuantCaptura, 'peso', SORT_DESC);
        $i=0;
        foreach($arrayQuantCapturaOrdenado as $quant):
            if($i<=10){
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
        foreach($arrayQtds as $qtd):
            if($i++ < 5){
                $arrayTopFive[] = $qtd['count'];
                $labels[] = $qtd['arte'];
            }
        endforeach;
        
        $jsTopFive = json_encode($arrayTopFive);
        $jsLabels = json_encode($labels);

        $this->view->assign("arrayPorArteQtds", $jsTopFive);
        $this->view->assign("arrayPorArteLabels", $jsLabels);
        
//        print_r($jsTopFive);
//        print_r($jsLabels);

    }
    
    
    public function amendoeiraAction(){
        
        $ano = $this->_getParam('ano');
        
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
        $this->gerarquantentrevistas($porto, $ano, 'Emalhe');
        $this->gerarquantentrevistas($porto, $ano, 'Grosseira');
        $this->gerarquantentrevistas($porto, $ano, 'Linha');
        $this->gerarquantentrevistas($porto, $ano, 'Manzua');
        
        
        $this->gerarquantcaptura($porto, $ano, 'Calao');
        $this->gerarquantcaptura($porto, $ano, 'Emalhe');
        $this->gerarquantcaptura($porto, $ano, 'Grosseira');
        $this->gerarquantcaptura($porto, $ano, 'Linha');
        $this->gerarquantcaptura($porto, $ano, 'Manzua');
        
        $this->gerarquantbarcos($porto, $ano, 'Calao');
        
        $this->gerarespeciescapturadas($porto, $ano, 'Calao').
        
        $this->gerarrelqtdporarte($porto, $ano);
    }
    public function aritaguaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        $ano = $date[0];
        $porto = "Aritaguá";
        
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $this->gerarquantentrevistas($porto, $ano,'Coleta');
        $this->gerarquantentrevistas($porto, $ano,'Emalhe');
        $this->gerarquantentrevistas($porto, $ano,'Jerere');
        $this->gerarquantentrevistas($porto, $ano,'Linha');
        $this->gerarquantentrevistas($porto, $ano,'Manzua');
        $this->gerarquantentrevistas($porto, $ano,'Mergulho');
        $this->gerarquantentrevistas($porto, $ano,'Ratoeira');
        $this->gerarquantentrevistas($porto, $ano,'Siripoia');
        $this->gerarquantentrevistas($porto, $ano,'Tarrafa');
        $this->gerarquantentrevistas($porto, $ano,'VaraPesca');
    }
    public function baduAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Vila Badú";
        
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function barraAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Porto da Barra";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function conchaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Porto da Concha";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function forteAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Porto do Forte";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function jueranaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Juerana rio";
        
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinhaFundo = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function mamoaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Mamoã";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function pontalAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Pontal";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function prainhaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Prainha";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function ramoAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Ponta do Ramo";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function sambaitubaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Sambaituba";
        
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function saomiguelAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "São Miguel";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function serraAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Pé de Serra";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
       $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function sobradinhoAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Sobradinho";
        
       $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
       $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
       
    }
    public function terminalAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Terminal Pesqueiro";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        $a = $this->gerarquantcaptura('Terminal Pesqueiro', 2014, 'Arrasto');
        
        print_r($a);
        
        $this->gerarrelqtdporarte($porto, '2014');
    }
    public function tulhaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Ponta da Tulha";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function urucutucaAction(){
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Urucutuca";
        
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
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

