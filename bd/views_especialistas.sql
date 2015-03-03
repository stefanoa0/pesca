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

