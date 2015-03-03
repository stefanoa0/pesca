<?php
/** 
 * Model Barcos
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Barcos
{
private $dbTableBarcos;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableBarcos = new Application_Model_DbTable_Barcos();
        $select = $this->dbTableBarcos->select()
                ->from($this->dbTableBarcos)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableBarcos->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableBarcos = new Application_Model_DbTable_Barcos();
        $arr = $this->dbTableBarcos->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableBarcos = new Application_Model_DbTable_Barcos();
        
        $dadosBarcos = array(
            'bar_nome' => $request['tbar_nome']
        );
        
        $this->dbTableBarcos->insert($dadosBarcos);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableBarcos = new Application_Model_DbTable_Barcos();
        
        $dadosBarcos = array(
            'bar_nome' => $request['tbar_nome']
        );
        
        $whereBarcos= $this->dbTableBarcos->getAdapter()
                ->quoteInto('"bar_id" = ?', $request['tbar_id']);
        
        $this->dbTableBarcos->update($dadosBarcos, $whereBarcos);
    }
    
    public function delete($idBarcos)
    {
        $this->dbTableBarcos = new Application_Model_DbTable_Barcos();       
                
        $whereBarcos= $this->dbTableBarcos->getAdapter()
                ->quoteInto('"bar_id" = ?', $idBarcos);
        
        $this->dbTableBarcos->delete($whereBarcos);
    }
    
    public function insertEmbarcacao(array $request){
        
        $this->dbTableBarcos = new Application_Model_DbTable_EmbarcacaoDetalhada();
        $this->dbTableMotor = new Application_Model_DbTable_MotorEmbarcacao();
        $this->dbTableAtuacao = new Application_Model_DbTable_AtuacaoEmbarcacao();
        
        $dadosEmbarcacao = array (
            'pto_id_desembarque' => $request['portoDesembarque'],
            'tp_id_proprietario' => $request['proprietario'],
            'tp_id_mestre' => $request['mestre'],
            'bar_id' => $request['embarcacao'],
            'ted_quant_embarcacoes' => $request['quantEmbarcacao'],
            'ted_max_tripulantes' => $request['quantTripulantes'],
            'ted_tripulacao' => $request['tripulacao'],
            'ted_cozinheiro' => $request['cozinheiro'],
            'ted_estado_conservacao' => $request['estadoConservacao'],
            'tte_id_tipobarco' => $request['tipoBarco'],
            'ted_comp_total' => $request['comprimentoTotal'],
            'ted_comp_boca' => $request['comprimentoBoca'],
            'ted_altura_calado' => $request['alturaCalado'],
            'ted_arqueadura' => $request['arqueaduraBruta'],
            'ted_num_registro' => $request['numRegistro'],
            'pto_id_origem' => $request['portoOrigem'],
            'tcas_id' => $request['tipoCasco'],
            'ted_ano_compra' => $request['anoCompra'],
            'ted_estado' => $request['estadoEmbarcacao'],
            'ted_pagamento' => $request['jaPaga'],
            'tpg_id' => $request['tipoPagamentoBarco'],
            'ted_financiamento' => $request['financiadorBarco'],
            'ted_ano_construcao' => $request['anoConstrucao'],
            'ted_propulsao'=>$request['tipoPropulsao']
    
        );
        
        $idEmbarcacao = $this->dbTableBarcos->insert($dadosEmbarcacao);
        
        $dadosMotor = array(
            'ted_id'=> $idEmbarcacao,
            'tmot_id'=>$request['tipoMotor'],
            'tmod_id'=>$request['modelo'],
            'tmar_id'=>$request['marca'],
            'tme_potencia'=>$request['potenciaMotor'],
            'tme_combustivel'=>$request['tipoCombustivel'],
            'tme_armazenamento'=>$request['capacidadeCombustivel'],
            'tpc_id'=>$request['postoCombustivel'],
            'tme_ano_motor'=>$request['anoCompraMotor'],
            'tme_estado_motor'=>$request['estadoMotor'],
            'tme_pagamento_motor'=>$request['jaPagoMotor'],
            'tpg_id_motor'=>$request['tipoPagamentoMotor'],
            'tfin_id'=>$request['financiadorMotor'],
            'tme_ano_motor_fabricacao'=>$request['anoFabricacao'],
            'tme_obs'=>$request['obs'],
            'tme_gasto_mensal'=>$request['gastoMensalMotor']

        );
        
        $this->dbTableMotor->insert($dadosMotor);
        
        $dadosAtuacao = array('ted_id'=>$idEmbarcacao,
            'tae_atuacao_batimatrica'=>$request['atuacaoBatimetrica'],
            'tae_autonomia'=>$request['autonomiaMar'],
            'tfp_id_pesca'=>$request['frequenciaPesca'],
            'thp_id_pesca'=>$request['horarioPesca'],
            'tae_capacidade'=>$request['capacidadeArmazenamento'],
            'tcp_id_pescado'=>$request['conservacaoPescado'],
            'tae_onde_adquire'=>$request['ondeAdquire'],
            'dp_id'=>$request['destinoPescado'],
            'dp_id_venda'=>$request['compradorPescado'],
            'ttr_id_renda'=>$request['outraAtividade'],
            'tea_id_maior'=>$request['maiorQuantidade'],
            'tea_id_menor'=>$request['menorQuantidade'],
            'tae_concorrencia'=>$request['competicaoPescadores'],
            'tae_tempo_atividade'=>$request['tempoAtuacao'],
            'tae_data'=>$request['dataEntrevista'],
            'tu_entrevistador'=>$request['entrevistador'],
            'tu_digitador'=>$request['lancador'],
            'tae_divisao_pescado'=>$request['divisaoPescado']
        );
        
        $this->dbTableAtuacao->insert($dadosAtuacao);
    }

}

