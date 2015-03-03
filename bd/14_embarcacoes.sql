
--ALTERAÇÕES CALÃO!--------------------------------------------------------------------------------
Create table If Not Exists t_calao_tipo(
	tcat_id serial,
	tcat_tipo Varchar(30),
	Primary Key (tcat_id)
	);
Insert into t_calao_tipo(tcat_tipo) Values ('Calão');
Insert into t_calao_tipo(tcat_tipo) Values ('Arrasto de Rio');
Insert into t_calao_tipo(tcat_tipo) Values ('Arrasto de Praia');

Alter table t_calao Add Column cal_tipo int, Add Foreign Key (cal_tipo) References t_calao_tipo (tcat_id);

Update t_calao Set cal_tipo = 1;
------------------------------------------------------------------------------------------------




Drop Table if exists t_embarcacao_detalhada_has_t_cor Cascade; 
Drop Table if exists t_embarcacao_detalhada_has_t_seguro_defeso Cascade;
Drop Table if exists t_embarcacao_detalhada_has_t_material Cascade;
Drop Table if exists t_embarcacao_detalhada_has_t_equipamento Cascade;
Drop Table if exists t_embarcacao_detalhada_has_t_savatagem Cascade;
Drop Table if exists t_motor_embarcacao_has_t_frequencia_manutencao Cascade;
Drop Table if exists t_atuacao_embarcacao_has_t_areapesca Cascade;
Drop Table if exists t_atuacao_embarcacao_has_t_artepesca Cascade;
Drop Table if exists t_atuacao_embarcacao_has_t_fornecedor_petrechos Cascade;
Drop table if exists t_motor_embarcacao Cascade;
Drop table if exists t_atuacao_embarcacao Cascade;
Drop table if exists t_embarcacao_detalhada Cascade;
Drop table if exists t_tipocasco Cascade;
Drop table if exists t_cor Cascade;
Drop table if exists t_material Cascade;
Drop table if exists t_tipopagamento Cascade;
Drop table if exists t_equipamento Cascade;
Drop table if exists t_savatagem Cascade;
Drop table if exists t_tipomotor Cascade;
Drop table if exists t_conservacao_pescado Cascade;
Drop table if exists t_modelo Cascade;
Drop table if exists t_marca Cascade;
Drop table if exists t_posto_combustivel Cascade; 
Drop table if exists t_financiador Cascade;
Drop table if exists t_area_atuacao Cascade;

-- Delete From t_atuacao_embarcacao;
-- Delete From t_motor_embarcacao;
-- Delete From t_embarcacao_detalhada;
-- Delete From t_tipocasco;
-- Delete From t_cor;
-- Delete From t_material;
-- Delete From t_tipopagamento;
-- Delete From t_equipamento;
-- Delete From t_savatagem;
-- Delete From t_tipomotor;
-- Delete From t_modelo;
-- Delete From t_marca;
-- Delete From t_posto_combustivel;
-- Delete From t_financiador;
-- Delete From t_conservacao_pescado;

Create table If Not Exists t_tipocasco ( tcas_id serial, tcas_tipo Varchar(30), Primary Key (tcas_id) );
Insert Into t_tipocasco (tcas_tipo)VALUES ('Plano');
Insert Into t_tipocasco (tcas_tipo)VALUES ('Arredondado');
Insert Into t_tipocasco (tcas_tipo)VALUES ('profundo');
Insert Into t_tipocasco (tcas_tipo)VALUES ('V Profundo');


Create table If Not Exists t_cor (tcor_id serial, tcor_cor Varchar(30), Primary Key(tcor_id));
Insert Into t_cor (tcor_cor)VALUES ('Branco');
Insert Into t_cor (tcor_cor)VALUES ('Azul');
Insert Into t_cor (tcor_cor)VALUES ('Laranja');
Insert Into t_cor (tcor_cor)VALUES ('Vermelho');
Insert Into t_cor (tcor_cor)VALUES ('Amarelo');
Insert Into t_cor (tcor_cor)VALUES ('Preto');
Insert Into t_cor (tcor_cor)VALUES ('Cinza');
Insert Into t_cor (tcor_cor)VALUES ('Verde');
Insert Into t_cor (tcor_cor)VALUES ('Madeira');
Insert Into t_cor (tcor_cor)VALUES ('Roxo');
Insert Into t_cor (tcor_cor)VALUES ('Rosa');
Insert Into t_cor (tcor_cor)VALUES ('Não é pintada');


Create table If Not Exists t_material (tmt_id serial, tmt_material Varchar(50), Primary Key(tmt_id));
Insert Into t_material (tmt_material)VALUES ('Madeira');
Insert Into t_material (tmt_material)VALUES ('Fibra de Vidro');
Insert Into t_material (tmt_material)VALUES ('Alumínio');

Create table If Not Exists t_tipopagamento (tpg_id serial,tpg_pagamento Varchar(50), Primary Key(tpg_id));
insert Into t_tipopagamento (tpg_pagamento)VALUES ('A Vista');
insert Into t_tipopagamento (tpg_pagamento)VALUES ('Parcelado');
insert Into t_tipopagamento (tpg_pagamento)VALUES ('Financiado');
insert Into t_tipopagamento (tpg_pagamento)VALUES ('Doado');

Create table If Not Exists t_equipamento (teq_id serial,teq_equipamento Varchar(50), Primary Key(teq_id));
Insert Into t_equipamento (teq_equipamento)VALUES ('GPS');
Insert Into t_equipamento (teq_equipamento)VALUES ('Rádio');
Insert Into t_equipamento (teq_equipamento)VALUES ('Bússola');
Insert Into t_equipamento (teq_equipamento)VALUES ('Celular');
Insert Into t_equipamento (teq_equipamento)VALUES ('Rádio VHF');
Insert Into t_equipamento (teq_equipamento)VALUES ('UHF');
Insert Into t_equipamento (teq_equipamento)VALUES ('Sonda');
Insert Into t_equipamento (teq_equipamento)VALUES ('Radar');
Insert Into t_equipamento (teq_equipamento)VALUES ('Outro');
Insert Into t_equipamento (teq_equipamento)VALUES ('Nenhum');


Create table If Not Exists t_savatagem (tsav_id serial, tsav_savatagem Varchar(50), Primary Key(tsav_id));
Insert Into t_savatagem (tsav_savatagem)VALUES ('Colete');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Boia');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Bote');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Sinalizador');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Extintor');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Luzes de navegação');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Corda');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Âncora');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Outro');
Insert Into t_savatagem (tsav_savatagem)VALUES ('Nenhuma');

Create table If Not Exists t_tipomotor ( tmot_id serial, tmot_tipo Varchar(50), Primary Key(tmot_id));
Insert into t_tipomotor (tmot_tipo)VALUES ('Popa');
Insert into t_tipomotor (tmot_tipo)VALUES ('Centro');
Insert into t_tipomotor (tmot_tipo)VALUES ('Rabeta');

Create table If Not Exists t_modelo ( tmod_id serial, tmod_modelo Varchar(50), Primary Key(tmod_id));
Insert Into t_modelo (tmod_modelo)VALUES ('229');
Insert Into t_modelo (tmod_modelo)VALUES ('352');
Insert Into t_modelo (tmod_modelo)VALUES ('366');
Insert Into t_modelo (tmod_modelo)VALUES ('B 11');
Insert Into t_modelo (tmod_modelo)VALUES ('B 18');
Insert Into t_modelo (tmod_modelo)VALUES ('BT 22');
Insert Into t_modelo (tmod_modelo)VALUES ('BT 33');
Insert Into t_modelo (tmod_modelo)VALUES ('NS 18');
Insert Into t_modelo (tmod_modelo)VALUES ('CL 10');

Create table If Not Exists t_marca (tmar_id serial, tmar_marca Varchar(50), Primary Key(tmar_id));
Insert Into t_marca (tmar_marca)VALUES ('MWM');
Insert Into t_marca (tmar_marca)VALUES ('Mercedes');
Insert Into t_marca (tmar_marca)VALUES ('Yamaha');
Insert Into t_marca (tmar_marca)VALUES ('Toyama');
Insert Into t_marca (tmar_marca)VALUES ('Honda');
Insert Into t_marca (tmar_marca)VALUES ('Outro');

Create table If Not Exists t_posto_combustivel (tpc_id serial, tpc_posto Varchar(50),	Primary Key(tpc_id));
Insert Into t_posto_combustivel (tpc_posto)VALUES ('Posto de Combustível de Ilhéus');
Insert Into t_posto_combustivel (tpc_posto)VALUES ('Posto de Combustível de Itacaré');
Insert Into t_posto_combustivel (tpc_posto)VALUES ('Posto de Combustível de Serra Grande');
Insert Into t_posto_combustivel (tpc_posto)VALUES ('Terminal Pesqueiro/Bahia Pesca');

Create table If Not Exists t_financiador (tfin_id serial, tfin_financiador Varchar(50), Primary Key(tfin_id));
Insert Into t_financiador (tfin_financiador)VALUES ('Banco do Nordeste');
Insert Into t_financiador (tfin_financiador)VALUES ('Colônia Z-34');

Create table If Not Exists t_conservacao_pescado (tcp_id serial, tcp_conserva Varchar(30), Primary Key(tcp_id));
Insert Into t_conservacao_pescado (tcp_conserva)VALUES ('Gelo');
Insert Into t_conservacao_pescado (tcp_conserva)VALUES ('Freezer');
Insert Into t_conservacao_pescado (tcp_conserva)VALUES ('Água');
Insert Into t_conservacao_pescado (tcp_conserva)VALUES ('Viveiro');
Insert Into t_conservacao_pescado (tcp_conserva)VALUES ('Geladeira');


Create Table t_embarcacao_detalhada(
    ted_id serial,
    pto_id_desembarque int,
    tp_id_proprietario int,
    tp_id_mestre int,
    bar_id int,
    ted_quant_embarcacoes int,
    ted_max_tripulantes int,
    ted_tripulacao int,
    ted_cozinheiro int,
    ted_estado_conservacao int,
    tte_id_tipobarco int,
    ted_comp_total float,
    ted_comp_boca float,
    ted_altura_calado float,
    ted_arqueadura float,
    ted_num_registro Varchar(20),
    pto_id_origem int,
    tcas_id	int,
    ted_ano_compra int,
    ted_estado int,
    ted_pagamento int,
    tpg_id	int,
    ted_financiamento int,
    ted_ano_construcao int,
    ted_propulsao int,
    Primary Key (ted_id),
    Foreign Key (pto_id_desembarque) References t_porto (pto_id),
    Foreign Key (tp_id_proprietario) References t_pescador (tp_id),
    Foreign Key (tp_id_mestre) References t_pescador (tp_id),
    Foreign Key (bar_id) References t_barco (bar_id),
    Foreign Key (tp_id_proprietario) References t_pescador (tp_id),
    Foreign Key (tte_id_tipobarco) References t_tipoembarcacao(tte_id),
    Foreign Key (ted_financiamento) References t_financiador (tfin_id),
    Foreign Key (tcas_id) References t_tipocasco(tcas_id),
    Foreign Key (tpg_id) References t_tipopagamento(tpg_id)
);

Create Table t_motor_embarcacao	(
    tme_id serial,
    ted_id int,
    tmot_id int,
    tmod_id int,
    tmar_id int,
    tme_potencia float,
    tme_combustivel int,
    tme_armazenamento float,
    tpc_id int,
    tme_ano_motor int,
    tme_estado_motor int,
    tme_pagamento_motor	int,
    tpg_id_motor int,
    tfin_id int,
    tme_ano_motor_fabricacao int,
    tme_obs Varchar(200),
    tme_gasto_mensal float,
    Primary Key (tme_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id),
    Foreign Key (tmot_id) References t_tipomotor (tmot_id),
    Foreign Key (tmod_id) References t_modelo (tmod_id),
    Foreign Key (tmar_id) References t_marca (tmar_id),
    Foreign Key (tpc_id) References t_posto_combustivel (tpc_id),
    Foreign Key (tpg_id_motor) References t_tipopagamento (tpg_id),
    Foreign Key (tfin_id) References t_financiador (tfin_id)
);
CREATE TABLE t_atuacao_embarcacao
(
  tae_id serial NOT NULL,
  ted_id integer,
  tae_atuacao_batimatrica integer,
  tae_autonomia integer,
  tfp_id_pesca integer,
  thp_id_pesca integer,
  tae_capacidade double precision,
  tcp_id_pescado integer,
  tae_onde_adquire varchar(100),
  dp_id integer,
  dp_id_venda integer,
  ttr_id_renda integer,
  tea_id_maior integer,
  tea_id_menor integer,
  tae_concorrencia integer,
  tae_tempo_atividade integer,
  tae_data date,
  tu_entrevistador integer,
  tu_digitador integer,
  tae_divisao_pescado character varying(100),
  CONSTRAINT t_atuacao_embarcacao_pkey PRIMARY KEY (tae_id),
  CONSTRAINT t_atuacao_embarcacao_dp_id_fkey FOREIGN KEY (dp_id)
      REFERENCES t_destinopescado (dp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_dp_id_venda_fkey FOREIGN KEY (dp_id_venda)
      REFERENCES t_destinopescado (dp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tcp_id_pescado_fkey FOREIGN KEY (tcp_id_pescado)
      REFERENCES t_conservacao_pescado (tcp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tea_id_maior_fkey FOREIGN KEY (tea_id_maior)
      REFERENCES t_estacao_ano (tea_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tea_id_menor_fkey FOREIGN KEY (tea_id_menor)
      REFERENCES t_estacao_ano (tea_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_ted_id_fkey FOREIGN KEY (ted_id)
      REFERENCES t_embarcacao_detalhada (ted_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tfp_id_pesca_fkey FOREIGN KEY (tfp_id_pesca)
      REFERENCES t_frequencia_pesca (tfp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_thp_id_pesca_fkey FOREIGN KEY (thp_id_pesca)
      REFERENCES t_horario_pesca (thp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_ttr_id_renda_fkey FOREIGN KEY (ttr_id_renda)
      REFERENCES t_tiporenda (ttr_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tu_digitador_fkey FOREIGN KEY (tu_digitador)
      REFERENCES t_usuario (tu_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT t_atuacao_embarcacao_tu_entrevistador_fkey FOREIGN KEY (tu_entrevistador)
      REFERENCES t_usuario (tu_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

------------------------------------------------------------------------------------------------

Create Table t_embarcacao_detalhada_has_t_cor (
    
    tedcor_id serial,
    tcor_id int,
    ted_id int,
    
    Primary Key (tedcor_id),
    Foreign Key (tcor_id) References t_cor (tcor_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id)
); 

Create Table t_embarcacao_detalhada_has_t_seguro_defeso (
    
    tsded_id serial,
    tsd_id_licenca int,
    ted_id int,
    
    Primary Key (tsded_id),
    Foreign Key (tsd_id_licenca) References t_seguro_defeso (tsd_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id)
);


Create Table t_embarcacao_detalhada_has_t_material (
    
    tsdmt_id serial,
    tmt_id int,
    ted_id int,
    
    Primary Key (tsdmt_id),
    Foreign Key (tmt_id) References t_material (tmt_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id)
);

Create Table t_embarcacao_detalhada_has_t_equipamento (
    
    tsdeq_id serial,
    teq_id int,
    ted_id int,
    
    Primary Key (tsdeq_id),
    Foreign Key (teq_id) References t_equipamento (teq_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id)
);

Create Table t_embarcacao_detalhada_has_t_savatagem (
    
    tsdsav_id serial,
    tsav_id int,
    ted_id int,
    
    Primary Key (tsdsav_id),
    Foreign Key (tsav_id) References t_savatagem (tsav_id),
    Foreign Key (ted_id) References t_embarcacao_detalhada (ted_id)
);


Create Table t_motor_embarcacao_has_t_frequencia_manutencao(

    tmefp_id serial,
    tme_id int,
    tfp_id int,

    Primary Key (tmefp_id),
    Foreign Key (tme_id) References t_motor_embarcacao (tme_id),
    Foreign Key (tfp_id) References t_frequencia_pesca (tfp_id)

);

Create Table t_atuacao_embarcacao_has_t_areapesca (
    
    taeap_id serial,
    tae_id int,
    tap_id_atuacao int,
    
    Primary Key (taeap_id),
    Foreign Key (tae_id) References t_atuacao_embarcacao (tae_id),
    Foreign Key (tap_id_atuacao) References t_areapesca (tareap_id)

);

Create Table t_atuacao_embarcacao_has_t_artepesca (

    taeatp_id serial,
    tae_id int,
    tap_id int,

    Primary Key (taeatp_id),
    Foreign Key (tae_id) References t_atuacao_embarcacao (tae_id),
    Foreign Key (tap_id) References t_artepesca (tap_id)

);

Create Table t_atuacao_embarcacao_has_t_fornecedor_petrechos (

    taefp_id serial,
    tae_id int,
    tfp_id int,

    Primary Key (taefp_id),
    Foreign Key (tae_id) References t_atuacao_embarcacao (tae_id),
    Foreign Key (tfp_id) References t_fornecedor_insumos (tfi_id)

);

Drop Table t_local;
Create Table t_local (

    tl_id serial,
    tl_local Varchar(50),

    Primary Key (tl_id)
);

Alter table t_porto Add column tl_id int, add Foreign Key (tl_id) References t_local (tl_id);

Update table t_porto set tl_id = 1 Where pto_id = 1;
Update table t_porto set tl_id = 1 Where pto_id = 3;
Update table t_porto set tl_id = 1 Where pto_id = 4;
Update table t_porto set tl_id = 1 Where pto_id = 5;
Update table t_porto set tl_id = 1 Where pto_id = 6;
Update table t_porto set tl_id = 1 Where pto_id = 7;
Update table t_porto set tl_id = 1 Where pto_id = 9;
Update table t_porto set tl_id = 1 Where pto_id = 10;
Update table t_porto set tl_id = 2 Where pto_id = 13;
Update table t_porto set tl_id = 2 Where pto_id = 14;
Update table t_porto set tl_id = 2 Where pto_id = 15;
Update table t_porto set tl_id = 3 Where pto_id = 18;
Update table t_porto set tl_id = 3 Where pto_id = 19;
Update table t_porto set tl_id = 4 Where pto_id = 16;
Update table t_porto set tl_id = 4 Where pto_id = 17;

