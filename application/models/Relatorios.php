<?php

class Application_Model_Relatorios
{
    //ARRASTO DE FUNDO ////////////////////////////////////////////////////////////////////
    public function selectArrasto($where = null, $order = null, $limit = null){
        
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
        
        $arrasto = $this->modelArrastoFundo->selectEntrevistaArrasto($where, $order, $limit);
        
        return $arrasto;
    }
    
    public function selectArrastoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
        
        $arrasto = $this->modelArrastoFundo->selectArrastoHasPesqueiro($where, $order, $limit);
        
        return $arrasto;
    }
    public function countPesqueirosArrasto()
    {
        $this->dbTableArrastoHasPesqueiro = new Application_Model_DbTable_VArrastoFundoHasPesqueiro();
        $select = $this->dbTableArrastoHasPesqueiro->select()
                ->from('v_arrasto_has_t_pesqueiro','count(af_paf_id)')->
                group('af_id')->
                order('count(af_paf_id) DESC')->limit('1');

        return $this->dbTableArrastoHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspecies( $limit = null){
        $this->dbTableArrastoHasEspCapturada = new Application_Model_DbTable_VArrastoFundoHasEspecieCapturada();

        $select = $this->dbTableArrastoHasEspCapturada->select()
                ->from($this->dbTableArrastoHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableArrastoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectArrastoHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
        
        $arrasto = $this->modelArrastoFundo->selectArrastoHasEspCapturadas($where, $order, $limit);
        
        return $arrasto;
    }

    
    ///////////////////////////////////////////////////////////////////////////////////////
    
    //CALÃO////////////////////////////////////////////////////////////////////////////////

    public function selectCalao($where = null, $order = null, $limit = null){
        
        $this->modelCalao = new Application_Model_Calao();
        
        $Calao = $this->modelCalao->selectEntrevistaCalao($where, $order, $limit);
        
        return $Calao;
    }
    
    public function selectCalaoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelCalao = new Application_Model_Calao();
        
        $Calao = $this->modelCalao->selectCalaoHasPesqueiro($where, $order, $limit);
        
        return $Calao;
    }
    public function countPesqueirosCalao()
    {
        $this->dbTableCalaoHasPesqueiro = new Application_Model_DbTable_VCalaoHasPesqueiro();
        $select = $this->dbTableCalaoHasPesqueiro->select()
                ->from('v_calao_has_t_pesqueiro','count(cal_paf_id)')->
                group('cal_id')->
                order('count(cal_paf_id) DESC')->limit('1');

        return $this->dbTableCalaoHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesCalao( $limit = null){
        $this->dbTableCalaoHasEspCapturada = new Application_Model_DbTable_VCalaoHasEspecieCapturada();

        $select = $this->dbTableCalaoHasEspCapturada->select()
                ->from($this->dbTableCalaoHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableCalaoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectCalaoHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelCalao = new Application_Model_Calao();
        
        $Calao = $this->modelCalao->selectCalaoHasEspCapturadas($where, $order, $limit);
        
        return $Calao;
    }
    
    //////////////////////////////////////////////////////////////////////////////////////
    
    //COLETA MANUAL//////////////////////////////////////////////////////////////////////
    

    public function selectColetaManual($where = null, $order = null, $limit = null){
        
        $this->modelColetaManual = new Application_Model_ColetaManual();
        
        $ColetaManual = $this->modelColetaManual->selectEntrevistaColetaManual($where, $order, $limit);
        
        return $ColetaManual;
    }
    
    public function selectColetaManualHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelColetaManual = new Application_Model_ColetaManual();
        
        $ColetaManual = $this->modelColetaManual->selectColetaManualHasPesqueiro($where, $order, $limit);
        
        return $ColetaManual;
    }
    public function countPesqueirosColetaManual()
    {
        $this->dbTableColetaManualHasPesqueiro = new Application_Model_DbTable_VColetaManualHasPesqueiro();
        $select = $this->dbTableColetaManualHasPesqueiro->select()
                ->from('v_coletamanual_has_t_pesqueiro','count(cml_paf_id)')->
                group('cml_id')->
                order('count(cml_paf_id) DESC')->limit('1');

        return $this->dbTableColetaManualHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesColetamanual( $limit = null){
        $this->dbTableColetaManualHasEspCapturada = new Application_Model_DbTable_VColetaManualHasEspecieCapturada();

        $select = $this->dbTableColetaManualHasEspCapturada->select()
                ->from($this->dbTableColetaManualHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableColetaManualHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectColetaManualHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelColetaManual = new Application_Model_ColetaManual();
        
        $ColetaManual = $this->modelColetaManual->selectColetaManualHasEspCapturadas($where, $order, $limit);
        
        return $ColetaManual;
    }
    //////////////////////////////////////////////////////////////////////////////////////
    
    
    ///EMALHE//////////////////////////////////////////////////////////////////////////////
    

    public function selectEmalhe($where = null, $order = null, $limit = null){
        
        $this->modelEmalhe = new Application_Model_Emalhe();
        
        $Emalhe = $this->modelEmalhe->selectEntrevistaEmalhe($where, $order, $limit);
        
        return $Emalhe;
    }
    
    public function selectEmalheHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelEmalhe = new Application_Model_Emalhe();
        
        $Emalhe = $this->modelEmalhe->selectEmalheHasPesqueiro($where, $order, $limit);
        
        return $Emalhe;
    }
    public function countPesqueirosEmalhe()
    {
        $this->dbTableEmalheHasPesqueiro = new Application_Model_DbTable_VEmalheHasPesqueiro();
        $select = $this->dbTableEmalheHasPesqueiro->select()
                ->from('v_emalhe_has_t_pesqueiro','count(em_paf_id)')->
                group('em_id')->
                order('count(em_paf_id) DESC')->limit('1');

        return $this->dbTableEmalheHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesEmalhe($limit = null){
        $this->dbTableEmalheHasEspCapturada = new Application_Model_DbTable_VEmalheHasEspecieCapturada();

        $select = $this->dbTableEmalheHasEspCapturada->select()
                ->from($this->dbTableEmalheHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableEmalheHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectEmalheHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelEmalhe = new Application_Model_Emalhe();
        
        $Emalhe = $this->modelEmalhe->selectEmalheHasEspCapturadas($where, $order, $limit);
        
        return $Emalhe;
    }
    ///////////////////////////////////////////////////////////////////////////////////////
    
    ///Grosseira//////////////////////////////////////////////////////////////////////////////
    

    public function selectGrosseira($where = null, $order = null, $limit = null){
        
        $this->modelGrosseira = new Application_Model_Grosseira();
        
        $Grosseira = $this->modelGrosseira->selectEntrevistaGrosseira($where, $order, $limit);
        
        return $Grosseira;
    }
    
    public function selectGrosseiraHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelGrosseira = new Application_Model_Grosseira();
        
        $Grosseira = $this->modelGrosseira->selectGrosseiraHasPesqueiro($where, $order, $limit);
        
        return $Grosseira;
    }
    public function countPesqueirosGrosseira()
    {
        $this->dbTableGrosseiraHasPesqueiro = new Application_Model_DbTable_VGrosseiraHasPesqueiro();
        $select = $this->dbTableGrosseiraHasPesqueiro->select()
                ->from('v_grosseira_has_t_pesqueiro','count(grs_paf_id)')->
                group('grs_id')->
                order('count(grs_paf_id) DESC')->limit('1');

        return $this->dbTableGrosseiraHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesGrosseira($limit = null){
        $this->dbTableGrosseiraHasEspCapturada = new Application_Model_DbTable_VGrosseiraHasEspecieCapturada();

        $select = $this->dbTableGrosseiraHasEspCapturada->select()
                ->from($this->dbTableGrosseiraHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableGrosseiraHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectGrosseiraHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelGrosseira = new Application_Model_Grosseira();
        
        $Grosseira = $this->modelGrosseira->selectGrosseiraHasEspCapturadas($where, $order, $limit);
        
        return $Grosseira;
    }
    ///////////////////////////////////////////////////////////////////////////////////////
    
    ///Jerere//////////////////////////////////////////////////////////////////////////////

    public function selectJerere($where = null, $order = null, $limit = null){
        
        $this->modelJerere = new Application_Model_Jerere();
        
        $Jerere = $this->modelJerere->selectEntrevistaJerere($where, $order, $limit);
        
        return $Jerere;
    }
    
    public function selectJerereHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelJerere = new Application_Model_Jerere();
        
        $Jerere = $this->modelJerere->selectJerereHasPesqueiro($where, $order, $limit);
        
        return $Jerere;
    }
    public function countPesqueirosJerere()
    {
        $this->dbTableJerereHasPesqueiro = new Application_Model_DbTable_VJerereHasPesqueiro();
        $select = $this->dbTableJerereHasPesqueiro->select()
                ->from('v_jerere_has_t_pesqueiro','count(jre_paf_id)')->
                group('jre_id')->
                order('count(jre_paf_id) DESC')->limit('1');

        return $this->dbTableJerereHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesJerere($limit = null){
        $this->dbTableJerereHasEspCapturada = new Application_Model_DbTable_VJerereHasEspecieCapturada();

        $select = $this->dbTableJerereHasEspCapturada->select()
                ->from($this->dbTableJerereHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableJerereHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectJerereHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelJerere = new Application_Model_Jerere();
        
        $Jerere = $this->modelJerere->selectJerereHasEspCapturadas($where, $order, $limit);
        
        return $Jerere;
    }
    //////////////////////////////////////////////////////////////////////////////////////
    
    ///Linha//////////////////////////////////////////////////////////////////////////////
    

    public function selectLinha($where = null, $order = null, $limit = null){
        
        $this->modelLinha = new Application_Model_Linha();
        
        $Linha = $this->modelLinha->selectEntrevistaLinha($where, $order, $limit);
        
        return $Linha;
    }
    
    public function selectLinhaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelLinha = new Application_Model_Linha();
        
        $Linha = $this->modelLinha->selectLinhaHasPesqueiro($where, $order, $limit);
        
        return $Linha;
    }
    public function countPesqueirosLinha()
    {
        $this->dbTableLinhaHasPesqueiro = new Application_Model_DbTable_VLinhaHasPesqueiro();
        $select = $this->dbTableLinhaHasPesqueiro->select()
                ->from('v_linha_has_t_pesqueiro','count(lin_paf_id)')->
                group('lin_id')->
                order('count(lin_paf_id) DESC')->limit('1');

        return $this->dbTableLinhaHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesLinha( $limit = null){
        $this->dbTableLinhaHasEspCapturada = new Application_Model_DbTable_VLinhaHasEspecieCapturada();

        $select = $this->dbTableLinhaHasEspCapturada->select()
                ->from($this->dbTableLinhaHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableLinhaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectLinhaHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelLinha = new Application_Model_Linha();
        
        $Linha = $this->modelLinha->selectLinhaHasEspCapturadas($where, $order, $limit);
        
        return $Linha;
    }
    ///////////////////////////////////////////////////////////////////////////////////////
    
    ///LinhaFundo//////////////////////////////////////////////////////////////////////////////

    public function selectLinhaFundo($where = null, $order = null, $limit = null){
        
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        
        $LinhaFundo = $this->modelLinhaFundo->selectEntrevistaLinhaFundo($where, $order, $limit);
        
        return $LinhaFundo;
    }
    
    public function selectLinhaFundoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        
        $LinhaFundo = $this->modelLinhaFundo->selectLinhaFundoHasPesqueiro($where, $order, $limit);
        
        return $LinhaFundo;
    }
    public function countPesqueirosLinhaFundo()
    {
        $this->dbTableLinhaFundoHasPesqueiro = new Application_Model_DbTable_VLinhaFundoHasPesqueiro();
        $select = $this->dbTableLinhaFundoHasPesqueiro->select()
                ->from('v_linhafundo_has_t_pesqueiro','count(lf_paf_id)')->
                group('lf_id')->
                order('count(lf_paf_id) DESC')->limit('1');

        return $this->dbTableLinhaFundoHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesLinhaFundo( $limit = null){
        $this->dbTableLinhaFundoHasEspCapturada = new Application_Model_DbTable_VLinhaFundoHasEspecieCapturada();

        $select = $this->dbTableLinhaFundoHasEspCapturada->select()
                ->from($this->dbTableLinhaFundoHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableLinhaFundoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectLinhaFundoHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        
        $LinhaFundo = $this->modelLinhaFundo->selectLinhaFundoHasEspCapturadas($where, $order, $limit);
        
        return $LinhaFundo;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    ///Manzua//////////////////////////////////////////////////////////////////////////////

    public function selectManzua($where = null, $order = null, $limit = null){
        
        $this->modelManzua = new Application_Model_Manzua();
        
        $Manzua = $this->modelManzua->selectEntrevistaManzua($where, $order, $limit);
        
        return $Manzua;
    }
    
    public function selectManzuaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelManzua = new Application_Model_Manzua();
        
        $Manzua = $this->modelManzua->selectManzuaHasPesqueiro($where, $order, $limit);
        
        return $Manzua;
    }
    public function countPesqueirosManzua()
    {
        $this->dbTableManzuaHasPesqueiro = new Application_Model_DbTable_VManzuaHasPesqueiro();
        $select = $this->dbTableManzuaHasPesqueiro->select()
                ->from('v_manzua_has_t_pesqueiro','count(man_paf_id)')->
                group('man_id')->
                order('count(man_paf_id) DESC')->limit('1');

        return $this->dbTableManzuaHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesManzua( $limit = null){
        $this->dbTableManzuaHasEspCapturada = new Application_Model_DbTable_VManzuaHasEspecieCapturada();

        $select = $this->dbTableManzuaHasEspCapturada->select()
                ->from($this->dbTableManzuaHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableManzuaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectManzuaHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelManzua = new Application_Model_Manzua();
        
        $Manzua = $this->modelManzua->selectManzuaHasEspCapturadas($where, $order, $limit);
        
        return $Manzua;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
    ///Mergulho//////////////////////////////////////////////////////////////////////////////

    public function selectMergulho($where = null, $order = null, $limit = null){
        
        $this->modelMergulho = new Application_Model_Mergulho();
        
        $Mergulho = $this->modelMergulho->selectEntrevistaMergulho($where, $order, $limit);
        
        return $Mergulho;
    }
    
    public function selectMergulhoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelMergulho = new Application_Model_Mergulho();
        
        $Mergulho = $this->modelMergulho->selectMergulhoHasPesqueiro($where, $order, $limit);
        
        return $Mergulho;
    }
    public function countPesqueirosMergulho()
    {
        $this->dbTableMergulhoHasPesqueiro = new Application_Model_DbTable_VMergulhoHasPesqueiro();
        $select = $this->dbTableMergulhoHasPesqueiro->select()
                ->from('v_mergulho_has_t_pesqueiro','count(mer_paf_id)')->
                group('mer_id')->
                order('count(mer_paf_id) DESC')->limit('1');

        return $this->dbTableMergulhoHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesMergulho( $limit = null){
        $this->dbTableMergulhoHasEspCapturada = new Application_Model_DbTable_VMergulhoHasEspecieCapturada();

        $select = $this->dbTableMergulhoHasEspCapturada->select()
                ->from($this->dbTableMergulhoHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableMergulhoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectMergulhoHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelMergulho = new Application_Model_Mergulho();
        
        $Mergulho = $this->modelMergulho->selectMergulhoHasEspCapturadas($where, $order, $limit);
        
        return $Mergulho;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
    ///Ratoeira//////////////////////////////////////////////////////////////////////////////
    

    public function selectRatoeira($where = null, $order = null, $limit = null){
        
        $this->modelRatoeira = new Application_Model_Ratoeira();
        
        $Ratoeira = $this->modelRatoeira->selectEntrevistaRatoeira($where, $order, $limit);
        
        return $Ratoeira;
    }
    
    public function selectRatoeiraHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelRatoeira = new Application_Model_Ratoeira();
        
        $Ratoeira = $this->modelRatoeira->selectRatoeiraHasPesqueiro($where, $order, $limit);
        
        return $Ratoeira;
    }
    public function countPesqueirosRatoeira()
    {
        $this->dbTableRatoeiraHasPesqueiro = new Application_Model_DbTable_VRatoeiraHasPesqueiro();
        $select = $this->dbTableRatoeiraHasPesqueiro->select()
                ->from('v_ratoeira_has_t_pesqueiro','count(rat_paf_id)')->
                group('rat_id')->
                order('count(rat_paf_id) DESC')->limit('1');

        return $this->dbTableRatoeiraHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesRatoeira($limit = null){
        $this->dbTableRatoeiraHasEspCapturada = new Application_Model_DbTable_VRatoeiraHasEspecieCapturada();

        $select = $this->dbTableRatoeiraHasEspCapturada->select()
                ->from($this->dbTableRatoeiraHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableRatoeiraHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectRatoeiraHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelRatoeira = new Application_Model_Ratoeira();
        
        $Ratoeira = $this->modelRatoeira->selectRatoeiraHasEspCapturadas($where, $order, $limit);
        
        return $Ratoeira;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
    ///Siripoia//////////////////////////////////////////////////////////////////////////////

    public function selectSiripoia($where = null, $order = null, $limit = null){
        
        $this->modelSiripoia = new Application_Model_Siripoia();
        
        $Siripoia = $this->modelSiripoia->selectEntrevistaSiripoia($where, $order, $limit);
        
        return $Siripoia;
    }
    
    public function selectSiripoiaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelSiripoia = new Application_Model_Siripoia();
        
        $Siripoia = $this->modelSiripoia->selectSiripoiaHasPesqueiro($where, $order, $limit);
        
        return $Siripoia;
    }
    public function countPesqueirosSiripoia()
    {
        $this->dbTableSiripoiaHasPesqueiro = new Application_Model_DbTable_VSiripoiaHasPesqueiro();
        $select = $this->dbTableSiripoiaHasPesqueiro->select()
                ->from('v_siripoia_has_t_pesqueiro','count(sir_paf_id)')->
                group('sir_id')->
                order('count(sir_paf_id) DESC')->limit('1');

        return $this->dbTableSiripoiaHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesSiripoia( $limit = null){
        $this->dbTableSiripoiaHasEspCapturada = new Application_Model_DbTable_VSiripoiaHasEspecieCapturada();

        $select = $this->dbTableSiripoiaHasEspCapturada->select()
                ->from($this->dbTableSiripoiaHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->dbTableSiripoiaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectSiripoiaHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelSiripoia = new Application_Model_Siripoia();
        
        $Siripoia = $this->modelSiripoia->selectSiripoiaHasEspCapturadas($where, $order, $limit);
        
        return $Siripoia;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
    ///Tarrafa//////////////////////////////////////////////////////////////////////////////
    
    public function selectTarrafa($where = null, $order = null, $limit = null){
        
        $this->modelTarrafa = new Application_Model_Tarrafa();
        
        $Tarrafa = $this->modelTarrafa->selectEntrevistaTarrafa($where, $order, $limit);
        
        return $Tarrafa;
    }
    
    public function selectTarrafaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelTarrafa = new Application_Model_Tarrafa();
        
        $Tarrafa = $this->modelTarrafa->selectTarrafaHasPesqueiro($where, $order, $limit);
        
        return $Tarrafa;
    }
    public function countPesqueirosTarrafa()
    {
        $this->dbTableTarrafaHasPesqueiro = new Application_Model_DbTable_VTarrafaHasPesqueiro();
        $select = $this->dbTableTarrafaHasPesqueiro->select()
                ->from('v_tarrafa_has_t_pesqueiro','count(tar_paf_id)')->
                group('tar_id')->
                order('count(tar_paf_id) DESC')->limit('1');

        return $this->dbTableTarrafaHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesTarrafa( $limit = null){
        $this->dbTableTarrafaHasEspCapturada = new Application_Model_DbTable_VTarrafaHasEspecieCapturada();

        $select = $this->dbTableTarrafaHasEspCapturada->select()
                ->from($this->dbTableTarrafaHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableTarrafaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectTarrafaHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelTarrafa = new Application_Model_Tarrafa();
        
        $Tarrafa = $this->modelTarrafa->selectTarrafaHasEspCapturadas($where, $order, $limit);
        
        return $Tarrafa;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
    ///VaraPesca//////////////////////////////////////////////////////////////////////////////
    
    public function selectVaraPesca($where = null, $order = null, $limit = null){
        
        $this->modelVaraPesca = new Application_Model_VaraPesca();
        
        $VaraPesca = $this->modelVaraPesca->selectEntrevistaVaraPesca($where, $order, $limit);
        
        return $VaraPesca;
    }
    
    public function selectVaraPescaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->modelVaraPesca = new Application_Model_VaraPesca();
        
        $VaraPesca = $this->modelVaraPesca->selectVaraPescaHasPesqueiro($where, $order, $limit);
        
        return $VaraPesca;
    }
    public function countPesqueirosVaraPesca()
    {
        $this->dbTableVaraPescaHasPesqueiro = new Application_Model_DbTable_VVaraPescaHasPesqueiro();
        $select = $this->dbTableVaraPescaHasPesqueiro->select()
                ->from('v_varapesca_has_t_pesqueiro','count(vp_paf_id)')->
                group('vp_id')->
                order('count(vp_paf_id) DESC')->limit('1');

        return $this->dbTableVaraPescaHasPesqueiro->fetchAll($select)->toArray();
    } 
    public function selectNomeEspeciesVaraPesca( $limit = null){
        $this->dbTableVaraPescaHasEspCapturada = new Application_Model_DbTable_VVaraPescaHasEspecieCapturada();

        $select = $this->dbTableVaraPescaHasEspCapturada->select()
                ->from($this->dbTableVaraPescaHasEspCapturada,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);

        return $this->dbTableVaraPescaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function selectVaraPescaHasEspCapturadas($where = null, $order = null, $limit = null){
         
        $this->modelVaraPesca = new Application_Model_VaraPesca();
        
        $VaraPesca = $this->modelVaraPesca->selectVaraPescaHasEspCapturadas($where, $order, $limit);
        
        return $VaraPesca;
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    
   //Entrevistas Monitoradas////////////////////////////////////////////////////////////////
   public function selectMonitoramentos($where = null, $order = null, $limit = null){
        $this->dbTableVMonitoramentos = new Application_Model_DbTable_VMonitoramentos();

        $select = $this->dbTableVMonitoramentos->select()
                ->from($this->dbTableVMonitoramentos)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->dbTableVMonitoramentos->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    //Entrevistas Monitoradas////////////////////////////////////////////////////////////////
   public function selectEspeciesCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableVEspeciesCapturadas = new Application_Model_DbTable_VEspeciesCapturadas();

        $select = $this->dbTableVEspeciesCapturadas->select()
                ->from($this->dbTableVEspeciesCapturadas)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->dbTableVEspeciesCapturadas->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
     //Entrevistas Monitoradas////////////////////////////////////////////////////////////////
   public function selectEspeciesCapturadasMes($where = null, $order = null, $limit = null){
        $this->dbTableVEspeciesCapturadas = new Application_Model_DbTable_VEspeciesCapturadasByMes();

        $select = $this->dbTableVEspeciesCapturadas->select()
                ->from($this->dbTableVEspeciesCapturadas)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->dbTableVEspeciesCapturadas->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByProjeto($where = null, $order = null, $limit = null){
        $this->dbTableVPescadorByProjeto = new Application_Model_DbTable_VPescadorByProjeto();

        $select = $this->dbTableVPescadorByProjeto->select()
                ->from($this->dbTableVPescadorByProjeto)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->dbTableVPescadorByProjeto->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByArrasto($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByArrasto();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByCalao($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByCalao();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByColeta($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByColetaManual();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByEmalhe($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByEmalhe();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByGrosseira($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByGrosseira();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByJerere($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByJerere();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByLinha($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByLinha();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByLinhaFundo($where = null, $order = null, $limit = null){
       $this->selectEntrevista = new Application_Model_DbTable_VPescadorByLinhaFundo();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    public function selectPescadorByManzua($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByManzua();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByMergulho($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByMergulho();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByRatoeira($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByRatoeira();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorBySiripoia($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorBySiripoia();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByTarrafa($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByTarrafa();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadorByVaraPesca($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VPescadorByVaraPesca();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
    
   /////////////////////////////////////////////////////////////////////////////////////////////

    public function selectEspecies( $limit = null){
        $this->especies = new Application_Model_DbTable_Especie;

        $select = $this->especies->select()
                ->from($this->especies,'esp_nome_comum')->distinct(true)->
                order('esp_nome_comum')->limit($limit);


        return $this->especies->fetchAll($select)->toArray();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    public function selectPescadores($consulta, $where = false){
        $this->pescadores = new Application_Model_DbTable_VPescador;
        
        $select = $this->pescadores->select()
                ->from($this->pescadores, array('count(tp_id)',$consulta))->
                order($consulta)->group($consulta);
         if ($where == false) {
            $select->where($consulta.' IS NOT NULL');
        }       
        
        return $this->pescadores->fetchAll($select)->toArray();
    }
    public function selectValorEspecies($where = null, $order = null, $limit = null){
        $this->selectEntrevista = new Application_Model_DbTable_VValorEspecies();

        $select = $this->selectEntrevista->select()
                ->from($this->selectEntrevista)->
                order($order)->limit($limit);

         if (!is_null($where)) {
            $select->where($where);
        }
        return $this->selectEntrevista->fetchAll($select)->toArray();
    }
    
}

