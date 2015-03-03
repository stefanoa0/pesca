    
Drop table if exists t_estado_civil Cascade;
Drop table if exists t_origem Cascade;
Drop table if exists t_residencia Cascade;
Drop table if exists t_possui_em_casa Cascade;
Drop table if exists t_estrutura_residencial Cascade;
Drop table if exists t_seguro_defeso Cascade;
Drop table if exists t_no_seguro Cascade;
Drop table if exists t_motivo_pesca Cascade;
Drop table if exists t_tipo_transporte Cascade;
Drop table if exists t_horario_pesca Cascade;
Drop table if exists t_frequencia_pesca Cascade;
Drop table if exists t_ultima_pesca Cascade;
Drop table if exists t_fornecedor_insumos Cascade;
Drop table if exists t_sobra_pesca Cascade;
Drop table if exists t_rgp_orgao Cascade;
Drop table if exists t_dificuldade Cascade;
Drop table if exists t_estacao_ano Cascade;
Drop table if exists t_associacao_pesca Cascade;
Drop table if exists t_acompanhado Cascade;
Drop table if exists t_insumo Cascade;
Drop table if exists t_recurso Cascade;

Drop table if exists t_estado_civil Cascade;
Drop table if exists t_origem Cascade;
Drop table if exists t_residencia Cascade;
Drop table if exists t_possui_em_casa Cascade;
Drop table if exists t_estrutura_residencial Cascade;
Drop table if exists t_seguro_defeso Cascade;
Drop table if exists t_no_seguro Cascade;
Drop table if exists t_motivo_pesca Cascade;
Drop table if exists t_tipo_transporte Cascade;
Drop table if exists t_horario_pesca Cascade;
Drop table if exists t_frequencia_pesca Cascade;
Drop table if exists t_ultima_pesca Cascade;
Drop table if exists t_fornecedor_insumos Cascade;
Drop table if exists t_sobra_pesca Cascade;
Drop table if exists t_rgp_orgao Cascade;
Drop table if exists t_dificuldade Cascade;
Drop table if exists t_estacao_ano Cascade;
Drop table if exists t_associacao_pesca Cascade;
Drop table if exists t_acompanhado Cascade;
Drop table if exists t_insumo Cascade;
Drop table if exists t_recurso Cascade;
Drop table if exists t_local_tratamento Cascade;

DROP VIEW  if exists v_pescador_especialista_has_t_acompanhado;
DROP VIEW  if exists v_pescador_especialista_has_t_companhia;
DROP VIEW  if exists v_pescador_especialista_has_t_estrutura_residencial;
DROP VIEW  if exists v_pescador_especialista_has_t_horario_pesca;
DROP VIEW  if exists v_pescador_especialista_has_t_insumo;
DROP VIEW  if exists v_pescador_especialista_has_t_motivo_pesca;
DROP VIEW  if exists v_pescador_especialista_has_t_no_seguro;
DROP VIEW  if exists v_pescador_especialista_has_t_parentes;
DROP VIEW  if exists v_pescador_especialista_has_t_programa_social;
DROP VIEW  if exists v_pescador_especialista_has_t_seguro_defeso;
DROP VIEW  if exists v_pescador_especialista_has_t_tipo_transporte;


Drop table if exists t_pescador_especialista_has_t_estrutura_residencial;
Drop table if exists t_pescador_especialista_has_t_programa_social;
Drop table if exists t_pescador_especialista_has_t_seguro_defeso;
Drop table if exists t_pescador_especialista_has_t_no_seguro; 
Drop table if exists t_pescador_especialista_has_t_motivo_pesca; 
Drop table if exists t_pescador_especialista_has_t_tipo_transporte;
Drop table if exists t_pescador_especialista_has_t_acompanhado;
Drop table if exists t_pescador_especialista_has_t_companhia;
Drop table if exists t_pescador_especialista_has_t_parentes;
Drop table if exists t_pescador_especialista_has_t_horario_pesca;
Drop table if exists t_pescador_especialista_has_t_insumo;
Drop table if exists t_pescador_especialista;


Create Table t_estado_civil(
    tec_id serial,
    tec_estado Varchar(30),
    Primary Key (tec_id)
);

INSERT INTO t_estado_civil(tec_estado)VALUES ('Não Declarado');
INSERT INTO t_estado_civil(tec_estado)VALUES ('Solteiro(a)');
INSERT INTO t_estado_civil(tec_estado)VALUES ('Casado(a)');
INSERT INTO t_estado_civil(tec_estado)VALUES ('Amasiado(a)');
INSERT INTO t_estado_civil(tec_estado)VALUES ('Divorciado(a)');
INSERT INTO t_estado_civil(tec_estado)VALUES ('Viúvo(a)');


Create Table t_residencia(
    tre_id serial,
    tre_residencia Varchar(50),
    Primary Key (tre_id)
);
INSERT INTO t_residencia(tre_residencia)VALUES ('Não Declarado');
INSERT INTO t_residencia(tre_residencia)VALUES ('Própria');
INSERT INTO t_residencia(tre_residencia)VALUES ('Alugada');
INSERT INTO t_residencia(tre_residencia)VALUES ('Financiada');
INSERT INTO t_residencia(tre_residencia)VALUES ('Cedida');
INSERT INTO t_residencia(tre_residencia)VALUES ('Mora com a família');
INSERT INTO t_residencia(tre_residencia)VALUES ('Mora com outra família');

Create Table t_estrutura_residencial(
    terd_id serial,
    terd_estrutura Varchar(50),
    Primary Key (terd_id)

);
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Não Declarado');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Banheiro');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Água Encanada');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Energia Elétrica');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Rede de Esgoto');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Fossa');
INSERT INTO t_estrutura_residencial(terd_estrutura)VALUES ('Não Possui');


Create Table t_seguro_defeso(
    tsd_id serial,
    tsd_seguro Varchar(45),
    Primary Key (tsd_id)
);
INSERT INTO t_seguro_defeso(tsd_seguro)VALUES ('Não Declarado');
INSERT INTO t_seguro_defeso(tsd_seguro)VALUES ('Camarão');
INSERT INTO t_seguro_defeso(tsd_seguro)VALUES ('Robalo');
INSERT INTO t_seguro_defeso(tsd_seguro)VALUES ('Não Possui');




Create Table t_no_seguro(
    tns_id serial,
    tns_situacao Varchar(45),
    Primary Key (tns_id)

);
INSERT INTO t_tiporenda(ttr_descricao)VALUES ('Pesca outras espécies');
INSERT INTO t_tiporenda(ttr_descricao)VALUES ('Busca outra renda em terra');

Create Table t_motivo_pesca(
    tmp_id serial,
    tmp_motivo Varchar(100),
    Primary Key (tmp_id)

);

INSERT INTO t_motivo_pesca(tmp_motivo)VALUES ('Não Declarado');
INSERT INTO t_motivo_pesca(tmp_motivo)VALUES ('Gosta');
INSERT INTO t_motivo_pesca(tmp_motivo)VALUES ('Tradição de Família');
INSERT INTO t_motivo_pesca(tmp_motivo)VALUES ('Não teve outra opção');
INSERT INTO t_motivo_pesca(tmp_motivo)VALUES ('Sobrevivência');



Create Table t_tipo_transporte(
    ttr_id serial,
    ttr_transporte Varchar(100),
    Primary Key (ttr_id)

);
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('Não Declarado');
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('A Pé');
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('Bicicleta');
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('Õnibus');
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('Moto');
INSERT INTO t_tipo_transporte(ttr_transporte)VALUES ('Carro');


Create Table t_horario_pesca(
    thp_id serial,
    thp_horario Varchar(50),
    Primary Key (thp_id)

);
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Não Declarado');
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Dia todo');
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Manhã');
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Tarde');
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Entardecer');
INSERT INTO t_horario_pesca(thp_horario)VALUES ('Noite');


Create Table t_frequencia_pesca(
    tfp_id serial,
    tfp_frequencia Varchar(50),
    Primary Key (tfp_id)

);
INSERT INTO t_frequencia_pesca(tfp_frequencia)VALUES ('Não Declarado');
INSERT INTO t_frequencia_pesca(tfp_frequencia)VALUES ('Diária');
INSERT INTO t_frequencia_pesca(tfp_frequencia)VALUES ('Semanal');
INSERT INTO t_frequencia_pesca(tfp_frequencia)VALUES ('Quinzenal');
INSERT INTO t_frequencia_pesca(tfp_frequencia)VALUES ('Semestral');

Create Table t_ultima_pesca(
    tup_id serial,
    tup_pesca Varchar(50),
    Primary Key (tup_id)
);
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('Não Declarado');
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('Hoje');
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('1 Dia');
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('1 Semana');
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('15 Dias');
INSERT INTO t_ultima_pesca(tup_pesca)VALUES ('1 Mês');


Create Table t_fornecedor_insumos(
    tfi_id serial,
    tfi_fornecedor Varchar(50),
    Primary Key (tfi_id)

);

INSERT INTO t_fornecedor_insumos(tfi_fornecedor)VALUES ('Não Declarado');
INSERT INTO t_fornecedor_insumos(tfi_fornecedor)VALUES ('Você que leva');
INSERT INTO t_fornecedor_insumos(tfi_fornecedor)VALUES ('Dono da Embarcação');





Create Table t_sobra_pesca(
    tsp_id serial,
    tsp_sobra Varchar(100),
    Primary Key (tsp_id)

);

INSERT INTO t_sobra_pesca(tsp_sobra)VALUES ('Não Declarado');
INSERT INTO t_sobra_pesca(tsp_sobra)VALUES ('Joga Fora');
INSERT INTO t_sobra_pesca(tsp_sobra)VALUES ('Usa como isca');
INSERT INTO t_sobra_pesca(tsp_sobra)VALUES ('Faz artesanato');
INSERT INTO t_sobra_pesca(tsp_sobra)VALUES ('Ração');





Create Table t_rgp_orgao(
    trgp_id serial,
    trgp_emissor Varchar(30),
    Primary Key (trgp_id)
);
INSERT INTO t_rgp_orgao(trgp_emissor)VALUES ('Não Declarado');
INSERT INTO t_rgp_orgao(trgp_emissor)VALUES ('Ibama');
INSERT INTO t_rgp_orgao(trgp_emissor)VALUES ('SEAP');
INSERT INTO t_rgp_orgao(trgp_emissor)VALUES ('Não Possui');


Create Table t_dificuldade(
    tdif_id serial,
    tdif_dificuldade Varchar(100),
    Primary Key (tdif_id)
);

INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Não Declarado');
INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Financiamento');
INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Equipamentos');
INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Assitência Técnica');
INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Capacitação Técnica');
INSERT INTO t_dificuldade(tdif_dificuldade)VALUES ('Não Possui');



Create Table t_estacao_ano(
    tea_id serial,
    tea_estacao Varchar(20),
    Primary Key (tea_id)
);

Insert Into t_estacao_ano(tea_estacao)Values ('Não Declarado');
Insert Into t_estacao_ano(tea_estacao)Values ('Inverno');
Insert Into t_estacao_ano(tea_estacao)Values ('Verão');



Create Table t_local_tratamento(
    tlt_id serial,
    tlt_local Varchar(100),
    Primary Key (tlt_id)
);

Insert Into t_local_tratamento(tlt_local)Values('Não Declarado');
Insert Into t_local_tratamento(tlt_local)Values('Casa');
Insert Into t_local_tratamento(tlt_local)Values('Local de Pesca');




Create Table t_associacao_pesca(
    tasp_id serial,
    tasp_associacao Varchar(100),
    Primary Key (tasp_id)
);

Insert Into t_associacao_pesca(tasp_associacao)Values('Não Declarado');
Insert Into t_associacao_pesca(tasp_associacao)Values('ASPERI');
Insert Into t_associacao_pesca(tasp_associacao)Values('Assoc. Pesc. e Marisq. do Porto de Trás');
Insert Into t_associacao_pesca(tasp_associacao)Values('ASPEMAR A-87');
Insert Into t_associacao_pesca(tasp_associacao)Values('Assoc. Pesc. e Marisc. SG');
Insert Into t_associacao_pesca(tasp_associacao)Values('Não Possui');


Create Table t_acompanhado(
    tacp_id serial,
    tacp_companhia Varchar(100),
    Primary Key (tacp_id)
);

Insert Into t_acompanhado(tacp_companhia)Values('Não Declarado');
Insert Into t_acompanhado(tacp_companhia)Values('Sozinho');
Insert Into t_acompanhado(tacp_companhia)Values('Acompanhado');

Create Table t_insumo(
    tin_id serial,
    tin_insumo Varchar(50),
    Primary Key (tin_id)
);

Insert Into t_insumo(tin_insumo) Values('Não Declarado');
Insert Into t_insumo(tin_insumo) Values('Alimentação');
Insert Into t_insumo(tin_insumo) Values('Combustível');
Insert Into t_insumo(tin_insumo) Values('Gelo');
Insert Into t_insumo(tin_insumo) Values('Gás');
Insert Into t_insumo(tin_insumo) Values('Aviamentos');
Insert Into t_insumo(tin_insumo) Values('Não Utiliza');




Create Table t_recurso(
    trec_id serial,
    trec_recurso Varchar(50),
    Primary Key (trec_id)
);

Insert Into t_recurso(trec_recurso) Values('Não Declarado');
Insert Into t_recurso(trec_recurso) Values('Vale');
Insert Into t_recurso(trec_recurso) Values('Recurso Próprio');
Insert Into t_recurso(trec_recurso) Values('Não Utiliza');


-- IMPORTAR ATÉ AQUI -----------------------------
 Create Table if not exists t_pescador_especialista(
     tp_id int unique,
     tp_resp_cad int,
     pto_id int,
 tps_data_nasc Date,
 tps_idade int,
     tec_id int, 
 tps_filhos int,
 tps_tempo_residencia float,
      to_id int,
      tre_id int,
 tps_pessoas_na_casa int,
 tps_tempo_sustento float,
 tps_renda_menor_ano float,
     tea_id_menor int,
 tps_renda_maior_ano float,
     tea_id_maior int,
 tps_renda_no_defeso float,
 tps_tempo_de_pesca float,
     ttd_id_tutor_pesca int,
     ttr_id_antes_pesca int,
 tps_mora_onde_pesca int,
 tps_embarcado int,
 tps_num_familiar_pescador int,
     tfp_id int,
 tps_num_dias_pescando int,
 tps_hora_pescando float,
      tup_id int,
      --tfi_id int,
      --trec_id int,
      --dp_id_pescado int,
      tfp_id_consumo int,
      --dp_id_comprador int,
      tsp_id int,
      tlt_id int,
 tps_unidade_beneficiamento Varchar(100),
 tps_curso_beneficiamento Varchar(100),
      tasp_id int,
      tc_id int,
 tps_tempo_em_colonia float,
 tps_motivo_falta_pagamento Varchar(100),
 tps_beneficio_colonia Varchar(100),
      trgp_id int,
      --tdif_id_area int,
      --ttr_id_outra_habilidade int,
      ttr_id_alternativa_renda int,
      ttr_id_outra_profissao int,
 tps_filho_seguir_profissao Varchar(100),
 tps_grau_dependencia_pesca float,
      tu_id_entrevistador int,
 tps_data date,
 Primary Key (tp_id),
 Foreign Key (pto_id) References t_porto,
 Foreign Key (tec_id) References t_estado_civil,
 Foreign Key (to_id) References t_municipio,
 Foreign Key (tre_id) References t_residencia,
 Foreign Key (tea_id_maior) References t_estacao_ano,
 Foreign Key (tea_id_menor) References t_estacao_ano,
 Foreign Key (ttd_id_tutor_pesca) References t_tipodependente,
 Foreign Key (ttr_id_antes_pesca) References t_tiporenda,
 Foreign Key (tfp_id) References t_frequencia_pesca,
 Foreign Key (tup_id) References t_ultima_pesca,
 --Foreign Key (tfi_id) References t_fornecedor_insumos,
 --Foreign Key (trec_id) References t_recurso,
--Foreign Key (dp_id_pescado) References t_destinopescado,
 Foreign Key (tfp_id_consumo) References t_frequencia_pesca,
 --Foreign Key (dp_id_comprador) References t_destinopescado,
 Foreign Key (tsp_id) References t_sobra_pesca,
 Foreign Key (tlt_id) References t_local_tratamento,
 Foreign Key (tc_id) References t_colonia,
 Foreign Key (tasp_id) References t_associacao_pesca,
 Foreign Key (trgp_id) References t_rgp_orgao,
 --Foreign Key (tdif_id_area) References t_dificuldade,
 Foreign Key (ttr_id_outra_profissao) References t_tiporenda,
 --Foreign Key (ttr_id_outra_habilidade) References t_tiporenda,
 Foreign Key (ttr_id_alternativa_renda) References t_tiporenda,
 Foreign Key (tp_id) References t_pescador,
 Foreign Key (tp_resp_cad) References t_usuario,
 Foreign Key (tu_id_entrevistador) References t_usuario
 );
 --Alter table t_pescador_especialista ADD CONSTRAINT tp_id_unique UNIQUE (tp_id);
 --Alter Table t_pescador Add column tp_especialidade timestamp without time zone;
--Alter table t_pescador_especialista Add Column bar_id_barco int, Add Column tps_obs Varchar(200);

 Create Table t_pescador_especialista_has_t_estrutura_residencial(
     tpsterd_id serial,
     tps_id int,
     terd_id int,
     Primary Key (tpsterd_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (terd_id) References t_estrutura_residencial
 );
 
 Create Table t_pescador_especialista_has_t_programa_social(
     tps_id int,
     prs_id int,
     Primary Key (tps_id, prs_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (prs_id) References t_programasocial
 );
 
 Create Table t_pescador_especialista_has_t_seguro_defeso(
     tpstsd_id serial,
     tps_id int,
     tsd_id int,
     Primary Key (tpstsd_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (tsd_id) References t_seguro_defeso
 );
 
 Create Table t_pescador_especialista_has_t_no_seguro(
     ttr_id int,
     tps_id int,
     Primary Key (ttr_id, tps_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (ttr_id) References t_tiporenda
 );
 
 Create Table t_pescador_especialista_has_t_motivo_pesca(
     tps_id int,
     tmp_id int,
     Primary Key (tps_id, tmp_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (tmp_id) References t_motivo_pesca
 );
 
 Create Table t_pescador_especialista_has_t_tipo_transporte(
     tps_id int,
     ttr_id int,
     Primary Key (tps_id, ttr_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (ttr_id) References t_tipo_transporte
 );
 
 Create Table t_pescador_especialista_has_t_acompanhado(
     tpstacp_id serial,
     tps_id int,
     tacp_id int,
     tpstacp_quantidade int,
     Primary Key (tpstacp_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (tacp_id) References t_acompanhado
 );

 Drop table if exists t_pescador_especialista_has_t_companhia;
 Create Table t_pescador_especialista_has_t_companhia(
     tpstcp_id serial,
     tps_id int,
     tpstcp_quantidade int,
     ttd_id int, -- t_tipodependente
     Primary Key (tpstcp_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (ttd_id) References t_tipodependente
 );
 
 Create Table t_pescador_especialista_has_t_parentes (
     tpsttd_id serial, 
     tps_id int,
     ttd_id_parente int, -- t_tipodependente
     Primary Key (tpsttd_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (ttd_id_parente) References t_tipodependente
     
 );
 
 Create Table t_pescador_especialista_has_t_horario_pesca(
     tps_id int,
     thp_id int,
     Primary Key (tps_id, thp_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (thp_id) References t_horario_pesca
 );
 
 Create Table t_pescador_especialista_has_t_insumo(
   tpstin_id serial,
   tps_id int,
   tin_id int,
   tin_valor_insumo float,
     Primary Key (tpstin_id),
     Foreign Key (tps_id) References t_pescador_especialista,
     Foreign Key (tin_id) References t_insumo
 );

 Create Table t_pescador_especialista_has_t_destino_pescado(
    tpsdp_id serial,
    dp_id_pescado int,
    tps_id int,
    Primary Key (tpsdp_id), 
    Foreign Key (dp_id_pescado) References t_destinopescado,
    Foreign Key (tps_id) References t_pescador_especialista

 );
 
 Create Table t_pescador_especialista_has_t_dificuldade_area(
    tpstdif_id serial,
    tdif_id_area int,
    tps_id int,
    Primary Key (tpstdif_id),
    Foreign Key (tdif_id_area) References t_dificuldade,
    Foreign Key (tps_id) References t_pescador_especialista

 );


--SUGESTÕES CARLA 08-09---------------------------------------------------------
Create Table t_pescador_especialista_has_t_recurso(

    tpsrec_id serial,
    trec_id int,
    tps_id int,
    Primary Key (tpsrec_id),
    Foreign Key (trec_id) References t_recurso,
    Foreign Key (tps_id) References t_pescador_especialista
    
);


Create Table t_pescador_especialista_has_t_fornecedor_insumos(

    tpsfi_id serial,
    tfi_id int,
    tps_id int,
    Primary Key (tpsfi_id),
    Foreign Key (tfi_id) References t_fornecedor_insumos,
    Foreign Key (tps_id) References t_pescador_especialista

);

Create Table t_pescador_especialista_has_t_comprador_pescado(

    tpsdp_id serial,
    dp_id int,
    tps_id int,
    Primary Key (tpsdp_id),
    Foreign Key (dp_id) References t_destinopescado,
    Foreign Key (tps_id) References t_pescador_especialista
);


Create Table t_pescador_especialista_has_t_habilidades(

    tpsttr_id serial,
    ttr_id int,
    tps_id int,
    Primary Key (tpsttr_id),
    Foreign Key (ttr_id) References t_tiporenda,
    Foreign Key (tps_id) References t_pescador_especialista

);


Create Table t_pescador_especialista_has_t_barco(

    tpsbar_id serial,
    bar_id int,
    tps_id int,
    Primary Key (tpsbar_id),
    Foreign Key (bar_id) References t_barco,
    Foreign Key (tps_id) References t_pescador_especialista

);

ALTER TABLE t_pescador_especialista DROP COLUMN tfi_id ,DROP COLUMN trec_id, DROP COLUMN dp_id_comprador, DROP COLUMN ttr_id_outra_habilidade, DROP COLUMN bar_id_barco;
--ALTER TABLE t_pescador_especialista DROP CONSTRAINT t_pescador_especialista_tfi_id_fkey, DROP CONSTRAINT t_pescador_especialista_trec_id_fkey, DROP CONSTRAINT t_pescador_especialista_ttr_id_outra_habilidade_fkey,DROP CONSTRAINT t_pescador_especialista_dp_id_comprador_fkey; 

Drop View v_pescador_especialista_has_t_acompanhado;
Drop View v_pescador_especialista_has_t_barco;
Drop View v_pescador_especialista_has_t_companhia;
Drop View v_pescador_especialista_has_t_comprador_pescado;
Drop View v_pescador_especialista_has_t_destino_pescado;
Drop View v_pescador_especialista_has_t_dificuldade_area;
Drop View v_pescador_especialista_has_t_estrutura_residencial;
Drop View v_pescador_especialista_has_t_fornecedor_insumos;
Drop View v_pescador_especialista_has_t_habilidades;
Drop View v_pescador_especialista_has_t_horario_pesca;
Drop View v_pescador_especialista_has_t_insumo;
Drop View v_pescador_especialista_has_t_motivo_pesca;
Drop View v_pescador_especialista_has_t_no_seguro;
Drop View v_pescador_especialista_has_t_parentes;
Drop View v_pescador_especialista_has_t_programa_social;
Drop View v_pescador_especialista_has_t_recurso;
Drop View v_pescador_especialista_has_t_seguro_defeso;
Drop View v_pescador_especialista_has_t_tipo_transporte;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_recurso AS 
 SELECT hasrecurso.tps_id, hasrecurso.trec_id, recurso.trec_recurso, hasrecurso.tpsrec_id
   FROM t_pescador_especialista_has_t_recurso as hasrecurso, t_recurso as recurso
  WHERE hasrecurso.trec_id = recurso.trec_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_fornecedor_insumos AS 
 SELECT hasfornecedor_insumos.tps_id, hasfornecedor_insumos.tfi_id, fornecedor_insumos.tfi_fornecedor, hasfornecedor_insumos.tpsfi_id
   FROM t_pescador_especialista_has_t_fornecedor_insumos as hasfornecedor_insumos, t_fornecedor_insumos as fornecedor_insumos
  WHERE hasfornecedor_insumos.tfi_id = fornecedor_insumos.tfi_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_comprador_pescado AS 
 SELECT hasdestino_pescado.tps_id, hasdestino_pescado.dp_id, destino_pescado.dp_destino, hasdestino_pescado.tpsdp_id
   FROM t_pescador_especialista_has_t_comprador_pescado as hasdestino_pescado, t_destinopescado as destino_pescado
  WHERE hasdestino_pescado.dp_id = destino_pescado.dp_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_habilidades AS 
 SELECT hashabilidades.tps_id, hashabilidades.ttr_id, habilidades.ttr_descricao, hashabilidades.tpsttr_id
   FROM t_pescador_especialista_has_t_habilidades as hashabilidades, t_tiporenda as habilidades
  WHERE hashabilidades.ttr_id = habilidades.ttr_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_barco AS 
 SELECT hasbarco.tps_id, hasbarco.bar_id, barco.bar_nome, hasbarco.tpsbar_id
   FROM t_pescador_especialista_has_t_barco as hasbarco, t_barco as barco
  WHERE hasbarco.bar_id = barco.bar_id;


--------------------------------------------------------------------------------


CREATE OR REPLACE VIEW v_pescador_especialista_has_t_estrutura_residencial AS 
 SELECT hasestr.tps_id, hasestr.terd_id, estrutura.terd_estrutura, hasestr.tpsterd_id
   FROM t_pescador_especialista_has_t_estrutura_residencial as hasestr, t_estrutura_residencial as estrutura
  WHERE hasestr.terd_id = estrutura.terd_id;

Alter table t_pescador_especialista_has_t_programa_social Drop Constraint t_pescador_especialista_has_t_programa_social_pkey, Add column tpsprs_id serial, Add Primary Key (tpsprs_id);
CREATE OR REPLACE VIEW v_pescador_especialista_has_t_programa_social AS 
 SELECT hasprogsocial.tps_id, hasprogsocial.prs_id, social.prs_programa, hasprogsocial.tpsprs_id
   FROM t_pescador_especialista_has_t_programa_social as hasprogsocial, t_programasocial as social
  WHERE hasprogsocial.prs_id = social.prs_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_seguro_defeso AS 
 SELECT hassegdefeso.tps_id, hassegdefeso.tsd_id, segdefeso.tsd_seguro, hassegdefeso.tpstsd_id
   FROM t_pescador_especialista_has_t_seguro_defeso as hassegdefeso, t_seguro_defeso as segdefeso
  WHERE hassegdefeso.tsd_id = segdefeso.tsd_id;

Alter table t_pescador_especialista_has_t_no_seguro Drop Constraint t_pescador_especialista_has_t_no_seguro_pkey, Add column tpsttr_id serial, Add Primary Key (tpsttr_id);
CREATE OR REPLACE VIEW v_pescador_especialista_has_t_no_seguro AS 
 SELECT hastiporenda.tps_id, hastiporenda.ttr_id, tiporenda.ttr_descricao, hastiporenda.tpsttr_id
   FROM t_pescador_especialista_has_t_no_seguro as hastiporenda, t_tiporenda as tiporenda
  WHERE hastiporenda.ttr_id = tiporenda.ttr_id;

Alter table t_pescador_especialista_has_t_motivo_pesca Drop Constraint t_pescador_especialista_has_t_motivo_pesca_pkey, Add column tpstmp_id serial, Add Primary Key (tpstmp_id);
CREATE OR REPLACE VIEW v_pescador_especialista_has_t_motivo_pesca AS 
 SELECT hasmotivopesca.tps_id, hasmotivopesca.tmp_id, motivopesca.tmp_motivo, hasmotivopesca.tpstmp_id
   FROM t_pescador_especialista_has_t_motivo_pesca as hasmotivopesca, t_motivo_pesca as motivopesca
  WHERE hasmotivopesca.tmp_id = motivopesca.tmp_id;

Alter table t_pescador_especialista_has_t_tipo_transporte Drop Constraint t_pescador_especialista_has_t_tipo_transporte_pkey, Add column tpsttr_id serial, Add Primary Key (tpsttr_id);
CREATE OR REPLACE VIEW v_pescador_especialista_has_t_tipo_transporte AS 
 SELECT hastransporte.tps_id, hastransporte.ttr_id, transporte.ttr_transporte, hastransporte.tpsttr_id
   FROM t_pescador_especialista_has_t_tipo_transporte as hastransporte, t_tipo_transporte as transporte
  WHERE hastransporte.ttr_id = transporte.ttr_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_acompanhado AS 
 SELECT hasacompanhado.tps_id, hasacompanhado.tacp_id, hasacompanhado.tpstacp_quantidade, acompanhado.tacp_companhia, hasacompanhado.tpstacp_id
   FROM t_pescador_especialista_has_t_acompanhado as hasacompanhado, t_acompanhado as acompanhado
  WHERE hasacompanhado.tacp_id = acompanhado.tacp_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_companhia AS 
 SELECT hascompanhia.tps_id, hascompanhia.ttd_id, hascompanhia.tpstcp_quantidade, companhia.ttd_tipodependente, hascompanhia.tpstcp_id
   FROM t_pescador_especialista_has_t_companhia as hascompanhia, t_tipodependente as companhia
  WHERE hascompanhia.ttd_id = companhia.ttd_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_parentes AS 
 SELECT hasparentes.tps_id, hasparentes.ttd_id_parente, parentes.ttd_tipodependente, hasparentes.tpsttd_id
   FROM t_pescador_especialista_has_t_parentes as hasparentes, t_tipodependente as parentes
  WHERE hasparentes.ttd_id_parente = parentes.ttd_id;

Alter table t_pescador_especialista_has_t_horario_pesca Drop Constraint t_pescador_especialista_has_t_horario_pesca_pkey, Add column tpsthp_id serial, Add Primary Key (tpsthp_id);
CREATE OR REPLACE VIEW v_pescador_especialista_has_t_horario_pesca AS 
 SELECT hashorariopesca.tps_id, hashorariopesca.thp_id, horariopesca.thp_horario, hashorariopesca.tpsthp_id
   FROM t_pescador_especialista_has_t_horario_pesca as hashorariopesca, t_horario_pesca as horariopesca
  WHERE hashorariopesca.thp_id = horariopesca.thp_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_insumo AS 
 SELECT hasinsumo.tps_id, hasinsumo.tin_id, insumo.tin_insumo, hasinsumo.tin_valor_insumo, hasinsumo.tpstin_id
   FROM t_pescador_especialista_has_t_insumo as hasinsumo, t_insumo as insumo
  WHERE hasinsumo.tin_id = insumo.tin_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_destino_pescado AS 
 SELECT hasdestino.tps_id, hasdestino.dp_id_pescado, destino.dp_destino, hasdestino.tpsdp_id
   FROM t_pescador_especialista_has_t_destino_pescado as hasdestino, t_destinopescado as destino
  WHERE hasdestino.dp_id_pescado = destino.dp_id;

CREATE OR REPLACE VIEW v_pescador_especialista_has_t_dificuldade_area AS 
 SELECT hasdificuldade.tps_id, hasdificuldade.tdif_id_area, dificuldade.tdif_dificuldade, hasdificuldade.tpstdif_id
   FROM t_pescador_especialista_has_t_dificuldade_area as hasdificuldade, t_dificuldade as dificuldade
  WHERE hasdificuldade.tdif_id_area = dificuldade.tdif_id;

CREATE OR REPLACE VIEW v_pescador AS 
 SELECT tp.tp_id, tp.tp_nome, tp.tp_sexo, tp.tp_matricula, tp.tp_apelido, 
    tp.tp_filiacaopai, tp.tp_filiacaomae, tp.tp_ctps, tp.tp_pis, tp.tp_inss, 
    tp.tp_nit_cei, tp.tp_rg, tp.tp_cma, tp.tp_rgb_maa_ibama, 
    tp.tp_cir_cap_porto, tp.tp_cpf, tp.tp_datanasc, tp.tp_dta_cad, 
    tp.tp_especificidade, tp.esc_id, tesc.esc_nivel, tp.tmun_id_natural, 
    tm.tmun_municipio AS munnat, tm.tuf_sigla AS signat, tp.te_id, 
    te.te_logradouro, te.te_numero, te.te_comp, te.te_bairro, te.te_cep, 
    te.tmun_id, tmi.tmun_municipio, tmi.tuf_sigla, tp.tp_resp_lan, 
    tlan.tu_nome AS tu_nome_lan, tp.tp_resp_cad, tcad.tu_nome AS tu_nome_cad, 
    tp.tp_obs, col.tc_id, tc.tc_nome, tcom.tcom_id, tcom.tcom_nome, tp.tpr_id, 
    tpr.tpr_descricao, tp.tp_pescadordeletado, tp.tp_especialidade
   FROM t_pescador tp
   LEFT JOIN t_municipio tm ON tp.tmun_id_natural = tm.tmun_id
   LEFT JOIN t_endereco te ON tp.te_id = te.te_id
   LEFT JOIN t_escolaridade tesc ON tp.esc_id = tesc.esc_id
   LEFT JOIN t_usuario tlan ON tp.tp_resp_lan = tlan.tu_id
   LEFT JOIN t_usuario tcad ON tp.tp_resp_cad = tcad.tu_id
   LEFT JOIN t_pescador_has_t_comunidade com ON com.tp_id = tp.tp_id
   LEFT JOIN t_comunidade tcom ON tcom.tcom_id = com.tcom_id
   LEFT JOIN t_pescador_has_t_colonia col ON col.tp_id = tp.tp_id
   LEFT JOIN t_municipio tmi ON te.tmun_id = tmi.tmun_id
   LEFT JOIN t_colonia tc ON tc.tc_id = col.tc_id
   LEFT JOIN t_projeto tpr ON tp.tpr_id = tpr.tpr_id
  WHERE tp.tp_pescadordeletado = false;



Alter Table t_pescador_especialista alter tps_filho_seguir_profissao type varchar(200);
Alter Table t_pescador_especialista alter tps_motivo_falta_pagamento type varchar(200);
Alter Table t_pescador_especialista alter tps_obs type varchar(300);
Alter Table t_pescador_especialista alter tps_unidade_beneficiamento type varchar(200);
Alter Table t_pescador_especialista alter tps_curso_beneficiamento type varchar(200);
Alter Table t_pescador_especialista alter tps_beneficio_colonia type varchar(200);

Alter Table t_pescador_especialista alter tps_tempo_sustento type varchar(60);
Alter Table t_pescador_especialista alter tps_renda_no_defeso type varchar(60);
Alter Table t_pescador_especialista alter tps_hora_pescando type varchar(60);
Alter Table t_pescador_especialista alter tps_tempo_em_colonia type varchar(60);

Drop View v_pescador_especialista;
CREATE OR REPLACE VIEW v_pescador_especialista AS 
 SELECT esp.tp_id, pesc.tp_nome, pesc.tp_apelido, esp.tp_resp_cad, resp.tu_nome, 
    esp.pto_id, pto.pto_nome, esp.tps_data_nasc, esp.tps_idade, esp.tec_id, 
    ec.tec_estado, esp.tps_filhos, esp.tps_tempo_residencia, esp.to_id, 
    mun.tmun_municipio, esp.tre_id, resi.tre_residencia, 
    esp.tps_pessoas_na_casa, esp.tps_tempo_sustento, esp.tps_renda_menor_ano, 
    esp.tea_id_menor, menor.tea_estacao AS tea_menor, esp.tps_renda_maior_ano, 
    esp.tea_id_maior, maior.tea_estacao AS tea_maior, esp.tps_renda_no_defeso, 
    esp.tps_tempo_de_pesca, esp.ttd_id_tutor_pesca, 
    td.ttd_tipodependente AS tutor, esp.ttr_id_antes_pesca, 
    ants.ttr_descricao AS antes, esp.tps_mora_onde_pesca, esp.tps_embarcado, 
    esp.tps_num_familiar_pescador, esp.tfp_id, 
    fp.tfp_frequencia AS frequencia_pesca, esp.tps_num_dias_pescando, 
    esp.tps_hora_pescando, esp.tup_id, up.tup_pesca, esp.tfp_id_consumo, 
    cons.tfp_frequencia AS consumo, esp.tsp_id, spes.tsp_sobra, esp.tlt_id, 
    lt.tlt_local, esp.tps_unidade_beneficiamento, esp.tps_curso_beneficiamento, 
    esp.tasp_id, asp.tasp_associacao, esp.tc_id, col.tc_nome, 
    esp.tps_tempo_em_colonia, esp.tps_motivo_falta_pagamento, 
    esp.tps_beneficio_colonia, esp.trgp_id, rgp.trgp_emissor, 
    esp.ttr_id_alternativa_renda, alt.ttr_descricao AS alternativa, 
    esp.ttr_id_outra_profissao, outr.ttr_descricao AS outra, 
    esp.tps_filho_seguir_profissao, esp.tps_grau_dependencia_pesca, 
    esp.tu_id_entrevistador, entr.tu_nome AS entrevistador, esp.tps_data, 
    pesc.esc_id, tesc.esc_nivel
   FROM t_pescador_especialista esp
   LEFT JOIN t_porto pto ON esp.pto_id = pto.pto_id
   LEFT JOIN t_associacao_pesca asp ON esp.tasp_id = asp.tasp_id
   LEFT JOIN t_colonia col ON esp.tc_id = col.tc_id
   LEFT JOIN t_estacao_ano maior ON esp.tea_id_maior = maior.tea_id
   LEFT JOIN t_estacao_ano menor ON esp.tea_id_menor = menor.tea_id
   LEFT JOIN t_estado_civil ec ON esp.tec_id = ec.tec_id
   LEFT JOIN t_frequencia_pesca cons ON esp.tfp_id_consumo = cons.tfp_id
   LEFT JOIN t_frequencia_pesca fp ON esp.tfp_id = fp.tfp_id
   LEFT JOIN t_local_tratamento lt ON esp.tlt_id = lt.tlt_id
   LEFT JOIN t_municipio mun ON esp.to_id = mun.tmun_id
   LEFT JOIN t_pescador pesc ON esp.tp_id = pesc.tp_id
   LEFT JOIN t_usuario resp ON esp.tp_resp_cad = resp.tu_id
   LEFT JOIN t_residencia resi ON esp.tre_id = resi.tre_id
   LEFT JOIN t_rgp_orgao rgp ON esp.trgp_id = rgp.trgp_id
   LEFT JOIN t_sobra_pesca spes ON esp.tsp_id = spes.tsp_id
   LEFT JOIN t_tipodependente td ON esp.ttd_id_tutor_pesca = td.ttd_id
   LEFT JOIN t_tiporenda alt ON esp.ttr_id_alternativa_renda = alt.ttr_id
   LEFT JOIN t_tiporenda ants ON esp.ttr_id_antes_pesca = ants.ttr_id
   LEFT JOIN t_tiporenda outr ON esp.ttr_id_outra_profissao = outr.ttr_id
   LEFT JOIN t_usuario entr ON esp.tu_id_entrevistador = entr.tu_id
   LEFT JOIN t_ultima_pesca up ON esp.tup_id = up.tup_id
   LEFT JOIN t_escolaridade tesc ON pesc.esc_id = tesc.esc_id;

