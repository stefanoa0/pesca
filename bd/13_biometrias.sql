Drop view v_arrastofundo_has_t_biometria_camarao;
Drop view v_arrastofundo_has_t_biometria_peixe;
Drop view v_calao_has_t_biometria_camarao;
Drop view v_calao_has_t_biometria_peixe;
Drop view v_coletamanual_has_t_biometria_camarao;
Drop view v_coletamanual_has_t_biometria_peixe;
Drop view v_emalhe_has_t_biometria_camarao;
Drop view v_emalhe_has_t_biometria_peixe;
Drop view v_grosseira_has_t_biometria_camarao;
Drop view v_grosseira_has_t_biometria_peixe;
Drop view v_jerere_has_t_biometria_camarao;
Drop view v_jerere_has_t_biometria_peixe;
Drop view v_linha_has_t_biometria_camarao;
Drop view v_linha_has_t_biometria_peixe;
Drop view v_linhafundo_has_t_biometria_camarao;
Drop view v_linhafundo_has_t_biometria_peixe;
Drop view v_manzua_has_t_biometria_camarao;
Drop view v_manzua_has_t_biometria_peixe;
Drop view v_mergulho_has_t_biometria_camarao;
Drop view v_mergulho_has_t_biometria_peixe;
Drop view v_ratoeira_has_t_biometria_camarao;
Drop view v_ratoeira_has_t_biometria_peixe;
Drop view v_siripoia_has_t_biometria_camarao;
Drop view v_siripoia_has_t_biometria_peixe;
Drop view v_tarrafa_has_t_biometria_camarao;
Drop view v_tarrafa_has_t_biometria_peixe;
Drop view v_varapesca_has_t_biometria_camarao;
Drop view v_varapesca_has_t_biometria_peixe;





Drop table t_arrastofundo_has_t_biometria_camarao;
Drop table t_arrastofundo_has_t_biometria_peixe;
Drop table t_calao_has_t_biometria_camarao;
Drop table t_calao_has_t_biometria_peixe;
Drop table t_coletamanual_has_t_biometria_camarao;
Drop table t_coletamanual_has_t_biometria_peixe;
Drop table t_emalhe_has_t_biometria_camarao;
Drop table t_emalhe_has_t_biometria_peixe;
Drop table t_grosseira_has_t_biometria_camarao;
Drop table t_grosseira_has_t_biometria_peixe;
Drop table t_jerere_has_t_biometria_camarao;
Drop table t_jerere_has_t_biometria_peixe;
Drop table t_linha_has_t_biometria_camarao;
Drop table t_linha_has_t_biometria_peixe;
Drop table t_linhafundo_has_t_biometria_camarao;
Drop table t_linhafundo_has_t_biometria_peixe;
Drop table t_manzua_has_t_biometria_camarao;
Drop table t_manzua_has_t_biometria_peixe;
Drop table t_mergulho_has_t_biometria_camarao;
Drop table t_mergulho_has_t_biometria_peixe;
Drop table t_ratoeira_has_t_biometria_camarao;
Drop table t_ratoeira_has_t_biometria_peixe;
Drop table t_siripoia_has_t_biometria_camarao;
Drop table t_siripoia_has_t_biometria_peixe;
Drop table t_tarrafa_has_t_biometria_camarao;
Drop table t_tarrafa_has_t_biometria_peixe;
Drop table t_varapesca_has_t_biometria_camarao;
Drop table t_varapesca_has_t_biometria_peixe;




CREATE TABLE t_arrastofundo_has_t_biometria_camarao
(
  tafbc_id serial NOT NULL,
  taf_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tafbc_id),
  FOREIGN KEY (taf_id)
      REFERENCES t_arrastofundo (af_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_arrastofundo_has_t_biometria_peixe(
  
  tafbp_id serial NOT NULL,
  taf_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tafbp_id),
  FOREIGN KEY (taf_id)
      REFERENCES t_arrastofundo (af_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_calao_has_t_biometria_camarao
(
  tcalbc_id serial NOT NULL,
  tcal_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tcalbc_id),
  FOREIGN KEY (tcal_id)
      REFERENCES t_calao (cal_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_calao_has_t_biometria_peixe(
  
  tcalbp_id serial NOT NULL,
  tcal_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tcalbp_id),
  FOREIGN KEY (tcal_id)
      REFERENCES t_calao (cal_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_coletamanual_has_t_biometria_camarao
(
  tcmlbc_id serial NOT NULL,
  tcml_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tcmlbc_id),
  FOREIGN KEY (tcml_id)
      REFERENCES t_coletamanual (cml_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_coletamanual_has_t_biometria_peixe(
  
  tcmlbp_id serial NOT NULL,
  tcml_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tcmlbp_id),
  FOREIGN KEY (tcml_id)
      REFERENCES t_coletamanual (cml_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_emalhe_has_t_biometria_camarao
(
  tembc_id serial NOT NULL,
  tem_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tembc_id),
  FOREIGN KEY (tem_id)
      REFERENCES t_emalhe (em_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_emalhe_has_t_biometria_peixe(
  
  tembp_id serial NOT NULL,
  tem_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tembp_id),
  FOREIGN KEY (tem_id)
      REFERENCES t_emalhe (em_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_grosseira_has_t_biometria_camarao
(
  tgrsbc_id serial NOT NULL,
  tgrs_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tgrsbc_id),
  FOREIGN KEY (tgrs_id)
      REFERENCES t_grosseira (grs_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_grosseira_has_t_biometria_peixe(
  
  tgrsbp_id serial NOT NULL,
  tgrs_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tgrsbp_id),
  FOREIGN KEY (tgrs_id)
      REFERENCES t_grosseira (grs_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_jerere_has_t_biometria_camarao
(
  tjrebc_id serial NOT NULL,
  tjre_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tjrebc_id),
  FOREIGN KEY (tjre_id)
      REFERENCES t_jerere (jre_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_jerere_has_t_biometria_peixe(
  
  tjrebp_id serial NOT NULL,
  tjre_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tjrebp_id),
  FOREIGN KEY (tjre_id)
      REFERENCES t_jerere (jre_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_linha_has_t_biometria_camarao
(
  tlinbc_id serial NOT NULL,
  tlin_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tlinbc_id),
  FOREIGN KEY (tlin_id)
      REFERENCES t_linha (lin_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_linha_has_t_biometria_peixe(
  
  tlinbp_id serial NOT NULL,
  tlin_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tlinbp_id),
  FOREIGN KEY (tlin_id)
      REFERENCES t_linha (lin_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_linhafundo_has_t_biometria_camarao
(
  tlfbc_id serial NOT NULL,
  tlf_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tlfbc_id),
  FOREIGN KEY (tlf_id)
      REFERENCES t_linhafundo (lf_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_linhafundo_has_t_biometria_peixe(
  
  tlfbp_id serial NOT NULL,
  tlf_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tlfbp_id),
  FOREIGN KEY (tlf_id)
      REFERENCES t_linhafundo (lf_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE t_manzua_has_t_biometria_camarao
(
  tmanbc_id serial NOT NULL,
  tman_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tmanbc_id),
  FOREIGN KEY (tman_id)
      REFERENCES t_manzua (man_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_manzua_has_t_biometria_peixe(
  
  tmanbp_id serial NOT NULL,
  tman_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tmanbp_id),
  FOREIGN KEY (tman_id)
      REFERENCES t_manzua (man_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_mergulho_has_t_biometria_camarao
(
  tmerbc_id serial NOT NULL,
  tmer_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tmerbc_id),
  FOREIGN KEY (tmer_id)
      REFERENCES t_mergulho (mer_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_mergulho_has_t_biometria_peixe(
  
  tmerbp_id serial NOT NULL,
  tmer_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tmerbp_id),
  FOREIGN KEY (tmer_id)
      REFERENCES t_mergulho (mer_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_ratoeira_has_t_biometria_camarao
(
  tratbc_id serial NOT NULL,
  trat_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tratbc_id),
  FOREIGN KEY (trat_id)
      REFERENCES t_ratoeira (rat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_ratoeira_has_t_biometria_peixe(
  
  tratbp_id serial NOT NULL,
  trat_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tratbp_id),
  FOREIGN KEY (trat_id)
      REFERENCES t_ratoeira (rat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_siripoia_has_t_biometria_camarao
(
  tsirbc_id serial NOT NULL,
  tsir_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tsirbc_id),
  FOREIGN KEY (tsir_id)
      REFERENCES t_siripoia (sir_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_siripoia_has_t_biometria_peixe(
  
  tsirbp_id serial NOT NULL,
  tsir_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tsirbp_id),
  FOREIGN KEY (tsir_id)
      REFERENCES t_siripoia (sir_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_tarrafa_has_t_biometria_camarao
(
  ttarbc_id serial NOT NULL,
  ttar_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (ttarbc_id),
  FOREIGN KEY (ttar_id)
      REFERENCES t_tarrafa (tar_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_tarrafa_has_t_biometria_peixe(
  
  ttarbp_id serial NOT NULL,
  ttar_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (ttarbp_id),
  FOREIGN KEY (ttar_id)
      REFERENCES t_tarrafa (tar_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
CREATE TABLE t_varapesca_has_t_biometria_camarao
(
  tvpbc_id serial NOT NULL,
  tvp_id int NOT NULL,
  esp_id int Not NULL,
  tbc_sexo character varying(1),
  tmat_id integer NOT NULL,
  tbc_comprimento_cabeca double precision,
  tbc_peso double precision,
  PRIMARY KEY (tvpbc_id),
  FOREIGN KEY (tvp_id)
      REFERENCES t_varapesca (vp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (tmat_id)
      REFERENCES t_maturidade (tmat_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
	REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

Create Table t_varapesca_has_t_biometria_peixe(
  
  tvpbp_id serial NOT NULL,
  tvp_id integer NOT NULL,
  esp_id integer NOT NULL,
  tbp_comprimento double precision,
  tbp_peso double precision,
  tbp_sexo character varying(1),
  PRIMARY KEY (tvpbp_id),
  FOREIGN KEY (tvp_id)
      REFERENCES t_varapesca (vp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (esp_id)
      REFERENCES t_especie (esp_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
DROP VIEW v_amostra_camarao;
DROP VIEW v_amostra_peixe;
Drop Table t_amostra_camarao CASCADE;
Drop Table t_amostra_peixe CASCADE;
Drop Table t_unidade_camarao CASCADE;
Drop Table t_unidade_peixe CASCADE;

zf create db-table ArrastoFundoHasBioCamarao t_arrastofundo_has_t_biometria_camarao;
zf create db-table ArrastoFundoHasBioPeixe t_arrastofundo_has_t_biometria_peixe;
zf create db-table CalaoHasBioCamarao t_calao_has_t_biometria_camarao;
zf create db-table CalaoHasBioPeixe t_calao_has_t_biometria_peixe;
zf create db-table ColetaManualHasBioCamarao t_coletamanual_has_t_biometria_camarao;
zf create db-table ColetaManualHasBioPeixe t_coletamanual_has_t_biometria_peixe;
zf create db-table EmalheHasBioCamarao t_emalhe_has_t_biometria_camarao;
zf create db-table EmalheHasBioPeixe t_emalhe_has_t_biometria_peixe;
zf create db-table GrosseiraHasBioCamarao t_grosseira_has_t_biometria_camarao;
zf create db-table GrosseiraHasBioPeixe t_grosseira_has_t_biometria_peixe;
zf create db-table JerereHasBioCamarao t_jerere_has_t_biometria_camarao;
zf create db-table JerereHasBioPeixe t_jerere_has_t_biometria_peixe;
zf create db-table LinhaHasBioCamarao t_linha_has_t_biometria_camarao;
zf create db-table LinhaHasBioPeixe t_linha_has_t_biometria_peixe;
zf create db-table LinhaFundoHasBioCamarao t_linhafundo_has_t_biometria_camarao;
zf create db-table LinhaFundoHasBioPeixe t_linhafundo_has_t_biometria_peixe;
zf create db-table ManzuaHasBioCamarao t_manzua_has_t_biometria_camarao;
zf create db-table ManzuaHasBioPeixe t_manzua_has_t_biometria_peixe;
zf create db-table MergulhoHasBioCamarao t_mergulho_has_t_biometria_camarao;
zf create db-table MergulhoHasBioPeixe t_mergulho_has_t_biometria_peixe;
zf create db-table RatoeiraHasBioCamarao t_ratoeira_has_t_biometria_camarao;
zf create db-table RatoeiraHasBioPeixe t_ratoeira_has_t_biometria_peixe;
zf create db-table SiripoiaHasBioCamarao t_siripoia_has_t_biometria_camarao;
zf create db-table SiripoiaHasBioPeixe t_siripoia_has_t_biometria_peixe;
zf create db-table TarrafaHasBioCamarao t_tarrafa_has_t_biometria_camarao;
zf create db-table TarrafaHasBioPeixe t_tarrafa_has_t_biometria_peixe;
zf create db-table VaraPescaHasBioCamarao t_varapesca_has_t_biometria_camarao;
zf create db-table VaraPescaHasBioPeixe t_varapesca_has_t_biometria_peixe;


zf create db-table VArrastoFundoHasBioCamarao v_arrastofundo_has_t_biometria_camarao;
zf create db-table VArrastoFundoHasBioPeixe v_arrastofundo_has_t_biometria_peixe;
zf create db-table VCalaoHasBioCamarao v_calao_has_t_biometria_camarao;
zf create db-table VCalaoHasBioPeixe v_calao_has_t_biometria_peixe;
zf create db-table VColetaManualHasBioCamarao v_coletamanual_has_t_biometria_camarao;
zf create db-table VColetaManualHasBioPeixe v_coletamanual_has_t_biometria_peixe;
zf create db-table VEmalheHasBioCamarao v_emalhe_has_t_biometria_camarao;
zf create db-table VEmalheHasBioPeixe v_emalhe_has_t_biometria_peixe;
zf create db-table VGrosseiraHasBioCamarao v_grosseira_has_t_biometria_camarao;
zf create db-table VGrosseiraHasBioPeixe v_grosseira_has_t_biometria_peixe;
zf create db-table VJerereHasBioCamarao v_jerere_has_t_biometria_camarao;
zf create db-table VJerereHasBioPeixe v_jerere_has_t_biometria_peixe;
zf create db-table VLinhaHasBioCamarao v_linha_has_t_biometria_camarao;
zf create db-table VLinhaHasBioPeixe v_linha_has_t_biometria_peixe;
zf create db-table VLinhaFundoHasBioCamarao v_linhafundo_has_t_biometria_camarao;
zf create db-table VLinhaFundoHasBioPeixe v_linhafundo_has_t_biometria_peixe;
zf create db-table VManzuaHasBioCamarao v_manzua_has_t_biometria_camarao;
zf create db-table VManzuaHasBioPeixe v_manzua_has_t_biometria_peixe;
zf create db-table VMergulhoHasBioCamarao v_mergulho_has_t_biometria_camarao;
zf create db-table VMergulhoHasBioPeixe v_mergulho_has_t_biometria_peixe;
zf create db-table VRatoeiraHasBioCamarao v_ratoeira_has_t_biometria_camarao;
zf create db-table VRatoeiraHasBioPeixe v_ratoeira_has_t_biometria_peixe;
zf create db-table VSiripoiaHasBioCamarao v_siripoia_has_t_biometria_camarao;
zf create db-table VSiripoiaHasBioPeixe v_siripoia_has_t_biometria_peixe;
zf create db-table VTarrafaHasBioCamarao v_tarrafa_has_t_biometria_camarao;
zf create db-table VTarrafaHasBioPeixe v_tarrafa_has_t_biometria_peixe;
zf create db-table VVaraPescaHasBioCamarao v_varapesca_has_t_biometria_camarao;
zf create db-table VVaraPescaHasBioPeixe v_varapesca_has_t_biometria_peixe;

--ARRASTO DE FUNDO------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_arrastofundo_has_t_biometria_camarao AS 
 SELECT entr.tafbc_id, entr.taf_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_arrastofundo_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_arrastofundo
  WHERE entr.taf_id = t_arrastofundo.af_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_arrastofundo_has_t_biometria_peixe AS
SELECT entr.tafbp_id, entr.taf_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_arrastofundo_has_t_biometria_peixe entr, t_especie esp, t_arrastofundo
WHERE entr.taf_id = t_arrastofundo.af_id AND entr.esp_id = esp.esp_id;

--CALAO------------------------------------------------------------------------------------------------

CREATE OR REPLACE VIEW v_calao_has_t_biometria_camarao AS 
 SELECT entr.tcalbc_id, entr.tcal_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_calao_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_calao
  WHERE entr.tcal_id = t_calao.cal_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_calao_has_t_biometria_peixe AS
SELECT entr.tcalbp_id, entr.tcal_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_calao_has_t_biometria_peixe entr, t_especie esp, t_calao
WHERE entr.tcal_id = t_calao.cal_id AND entr.esp_id = esp.esp_id;

--COLETA MANUAL------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_coletamanual_has_t_biometria_camarao AS 
 SELECT entr.tcmlbc_id, entr.tcml_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_coletamanual_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_coletamanual
  WHERE entr.tcml_id = t_coletamanual.cml_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_coletamanual_has_t_biometria_peixe AS
SELECT entr.tcmlbp_id, entr.tcml_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_coletamanual_has_t_biometria_peixe entr, t_especie esp, t_coletamanual
WHERE entr.tcml_id = t_coletamanual.cml_id AND entr.esp_id = esp.esp_id;

--EMALHE----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_emalhe_has_t_biometria_camarao AS 
 SELECT entr.tembc_id, entr.tem_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_emalhe_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_emalhe
  WHERE entr.tem_id = t_emalhe.em_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_emalhe_has_t_biometria_peixe AS
SELECT entr.tembp_id, entr.tem_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_emalhe_has_t_biometria_peixe entr, t_especie esp, t_emalhe
WHERE entr.tem_id = t_emalhe.em_id AND entr.esp_id = esp.esp_id;



--GROSSEIRA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_grosseira_has_t_biometria_camarao AS 
 SELECT entr.tgrsbc_id, entr.tgrs_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_grosseira_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_grosseira
  WHERE entr.tgrs_id = t_grosseira.grs_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_grosseira_has_t_biometria_peixe AS
SELECT entr.tgrsbp_id, entr.tgrs_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_grosseira_has_t_biometria_peixe entr, t_especie esp, t_grosseira
WHERE entr.tgrs_id = t_grosseira.grs_id AND entr.esp_id = esp.esp_id;
--JERERE----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_jerere_has_t_biometria_camarao AS 
 SELECT entr.tjrebc_id, entr.tjre_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_jerere_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_jerere
  WHERE entr.tjre_id = t_jerere.jre_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_jerere_has_t_biometria_peixe AS
SELECT entr.tjrebp_id, entr.tjre_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_jerere_has_t_biometria_peixe entr, t_especie esp, t_jerere
WHERE entr.tjre_id = t_jerere.jre_id AND entr.esp_id = esp.esp_id;
--LINHA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_linha_has_t_biometria_camarao AS 
 SELECT entr.tlinbc_id, entr.tlin_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_linha_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_linha
  WHERE entr.tlin_id = t_linha.lin_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_linha_has_t_biometria_peixe AS
SELECT entr.tlinbp_id, entr.tlin_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_linha_has_t_biometria_peixe entr, t_especie esp, t_linha
WHERE entr.tlin_id = t_linha.lin_id AND entr.esp_id = esp.esp_id;
--LINHA DE FUNDO----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_linhafundo_has_t_biometria_camarao AS 
 SELECT entr.tlfbc_id, entr.tlf_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_linhafundo_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_linhafundo
  WHERE entr.tlf_id = t_linhafundo.lf_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_linhafundo_has_t_biometria_peixe AS
SELECT entr.tlfbp_id, entr.tlf_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_linhafundo_has_t_biometria_peixe entr, t_especie esp, t_linhafundo
WHERE entr.tlf_id = t_linhafundo.lf_id AND entr.esp_id = esp.esp_id;
--MANZUA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_manzua_has_t_biometria_camarao AS 
 SELECT entr.tmanbc_id, entr.tman_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_manzua_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_manzua
  WHERE entr.tman_id = t_manzua.man_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_manzua_has_t_biometria_peixe AS
SELECT entr.tmanbp_id, entr.tman_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_manzua_has_t_biometria_peixe entr, t_especie esp, t_manzua
WHERE entr.tman_id = t_manzua.man_id AND entr.esp_id = esp.esp_id;
--MERGULHO----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_mergulho_has_t_biometria_camarao AS 
 SELECT entr.tmerbc_id, entr.tmer_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_mergulho_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_mergulho
  WHERE entr.tmer_id = t_mergulho.mer_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_mergulho_has_t_biometria_peixe AS
SELECT entr.tmerbp_id, entr.tmer_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_mergulho_has_t_biometria_peixe entr, t_especie esp, t_mergulho
WHERE entr.tmer_id = t_mergulho.mer_id AND entr.esp_id = esp.esp_id;
--RATOEIRA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_ratoeira_has_t_biometria_camarao AS 
 SELECT entr.tratbc_id, entr.trat_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_ratoeira_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_ratoeira
  WHERE entr.trat_id = t_ratoeira.rat_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_ratoeira_has_t_biometria_peixe AS
SELECT entr.tratbp_id, entr.trat_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_ratoeira_has_t_biometria_peixe entr, t_especie esp, t_ratoeira
WHERE entr.trat_id = t_ratoeira.rat_id AND entr.esp_id = esp.esp_id;
--SIRIPOIA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_siripoia_has_t_biometria_camarao AS 
 SELECT entr.tsirbc_id, entr.tsir_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_siripoia_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_siripoia
  WHERE entr.tsir_id = t_siripoia.sir_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_siripoia_has_t_biometria_peixe AS
SELECT entr.tsirbp_id, entr.tsir_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_siripoia_has_t_biometria_peixe entr, t_especie esp, t_siripoia
WHERE entr.tsir_id = t_siripoia.sir_id AND entr.esp_id = esp.esp_id;
--TARRAFA----------------------------------------------------------------------------------------------------------
CREATE OR REPLACE VIEW v_tarrafa_has_t_biometria_camarao AS 
 SELECT entr.ttarbc_id, entr.ttar_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_tarrafa_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_tarrafa
  WHERE entr.ttar_id = t_tarrafa.tar_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_tarrafa_has_t_biometria_peixe AS
SELECT entr.ttarbp_id, entr.ttar_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_tarrafa_has_t_biometria_peixe entr, t_especie esp, t_tarrafa
WHERE entr.ttar_id = t_tarrafa.tar_id AND entr.esp_id = esp.esp_id;
--VARA DE PESCA----------------------------------------------------------------------------------------------------------

CREATE OR REPLACE VIEW v_varapesca_has_t_biometria_camarao AS 
 SELECT entr.tvpbc_id, entr.tvp_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbc_sexo, entr.tmat_id, mat.tmat_tipo, entr.tbc_comprimento_cabeca, entr.tbc_peso
   FROM t_varapesca_has_t_biometria_camarao entr, t_especie esp, t_maturidade mat, t_varapesca
  WHERE entr.tvp_id = t_varapesca.vp_id AND entr.esp_id = esp.esp_id AND entr.tmat_id = mat.tmat_id;

CREATE OR REPLACE VIEW v_varapesca_has_t_biometria_peixe AS
SELECT entr.tvpbp_id, entr.tvp_id, entr.esp_id, esp.esp_nome, esp.esp_nome_comum, entr.tbp_comprimento, entr.tbp_peso, entr.tbp_sexo
   FROM t_varapesca_has_t_biometria_peixe entr, t_especie esp, t_varapesca
WHERE entr.tvp_id = t_varapesca.vp_id AND entr.esp_id = esp.esp_id;


DROP VIEW v_entrevista_arrasto;
DROP VIEW v_entrevista_calao;
DROP VIEW v_entrevista_coletamanual;
DROP VIEW v_entrevista_emalhe;
DROP VIEW v_entrevista_grosseira;
DROP VIEW v_entrevista_jerere;
DROP VIEW v_entrevista_linha;
DROP VIEW v_entrevista_linhafundo;
DROP VIEW v_entrevista_manzua;
DROP VIEW v_entrevista_mergulho;
DROP VIEW v_entrevista_ratoeira;
DROP VIEW v_entrevista_siripoia;
DROP VIEW v_entrevista_tarrafa;
DROP VIEW v_entrevista_varapesca;
DROP VIEW v_entrevistas;



CREATE OR REPLACE VIEW v_entrevista_arrasto AS
 SELECT t_arrastofundo.af_id, t_pescador.tp_nome, t_barco.bar_nome, 
        t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_arrastofundo
   Left Join t_pescador On t_arrastofundo.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_arrastofundo.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_arrastofundo.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;


CREATE OR REPLACE VIEW v_entrevista_calao AS
 SELECT t_calao.cal_id, t_pescador.tp_nome, t_barco.bar_nome, 
        t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_calao
   Left Join t_pescador On t_calao.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_calao.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_calao.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;

CREATE OR REPLACE VIEW v_entrevista_coletamanual AS
 SELECT t_coletamanual.cml_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_coletamanual
   Left Join t_pescador On t_coletamanual.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_coletamanual.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_coletamanual.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;


CREATE OR REPLACE VIEW v_entrevista_emalhe AS
 SELECT t_emalhe.em_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_emalhe
   Left Join t_pescador On t_emalhe.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_emalhe.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_emalhe.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;


CREATE OR REPLACE VIEW v_entrevista_grosseira AS
 SELECT t_grosseira.grs_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_grosseira
   Left Join t_pescador On t_grosseira.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_grosseira.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_grosseira.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_jerere AS
 SELECT t_jerere.jre_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_jerere
   Left Join t_pescador On t_jerere.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_jerere.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_jerere.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_linha AS
 SELECT t_linha.lin_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_linha
   Left Join t_pescador On t_linha.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_linha.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_linha.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_linhafundo AS
 SELECT t_linhafundo.lf_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_linhafundo
   Left Join t_pescador On t_linhafundo.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_linhafundo.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_linhafundo.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_manzua AS
 SELECT t_manzua.man_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_manzua
   Left Join t_pescador On t_manzua.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_manzua.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_manzua.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_mergulho AS
 SELECT t_mergulho.mer_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_mergulho
   Left Join t_pescador On t_mergulho.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_mergulho.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_mergulho.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_ratoeira AS
 SELECT t_ratoeira.rat_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_ratoeira
   Left Join t_pescador On t_ratoeira.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_ratoeira.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_ratoeira.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_siripoia AS
 SELECT t_siripoia.sir_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_siripoia
   Left Join t_pescador On t_siripoia.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_siripoia.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_siripoia.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;


CREATE OR REPLACE VIEW v_entrevista_tarrafa AS
 SELECT t_tarrafa.tar_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_tarrafa
   Left Join t_pescador On t_tarrafa.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_tarrafa.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_tarrafa.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;



CREATE OR REPLACE VIEW v_entrevista_varapesca AS
 SELECT t_varapesca.vp_id, t_pescador.tp_nome, t_barco.bar_nome, t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_porto.pto_nome
   FROM t_varapesca
   Left Join t_pescador On t_varapesca.tp_id_entrevistado = t_pescador.tp_id 
Left Join t_barco ON t_varapesca.bar_id = t_barco.bar_id 
Left Join t_monitoramento On t_varapesca.mnt_id = t_monitoramento.mnt_id 
Left Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id
Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;


Create or Replace View v_entrevistas As
SELECT 'Arrasto-Fundo',t_arrastofundo.af_id as id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_arrastofundo.af_dhvolta
   FROM t_arrastofundo
   LEFT JOIN t_pescador ON t_arrastofundo.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_arrastofundo.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_arrastofundo.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Calão',t_calao.cal_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, (t_calao.cal_data +interval '0 hour')
   FROM t_calao
   LEFT JOIN t_pescador ON t_calao.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_calao.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_calao.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
    Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Coleta Manual',t_coletamanual.cml_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_coletamanual.cml_dhvolta
   FROM t_coletamanual
   LEFT JOIN t_pescador ON t_coletamanual.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_coletamanual.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_coletamanual.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
    Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Emalhe', t_emalhe.em_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_emalhe.em_dhrecolhimento
   FROM t_emalhe
   LEFT JOIN t_pescador ON t_emalhe.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_emalhe.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_emalhe.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
    Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Groseira',t_grosseira.grs_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_grosseira.grs_dhvolta
   FROM t_grosseira
   LEFT JOIN t_pescador ON t_grosseira.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_grosseira.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_grosseira.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
    Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Jereré',t_jerere.jre_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_jerere.jre_dhvolta
   FROM t_jerere
   LEFT JOIN t_pescador ON t_jerere.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_jerere.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_jerere.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Linha',t_linha.lin_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_linha.lin_dhvolta
   FROM t_linha
   LEFT JOIN t_pescador ON t_linha.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_linha.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_linha.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Linha de Fundo',t_linhafundo.lf_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_linhafundo.lf_dhvolta
   FROM t_linhafundo
   LEFT JOIN t_pescador ON t_linhafundo.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_linhafundo.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_linhafundo.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Manzuá',t_manzua.man_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_manzua.man_dhvolta
   FROM t_manzua
   LEFT JOIN t_pescador ON t_manzua.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_manzua.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_manzua.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Mergulho',t_mergulho.mer_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_mergulho.mer_dhvolta
   FROM t_mergulho
   LEFT JOIN t_pescador ON t_mergulho.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_mergulho.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_mergulho.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
 SELECT 'Ratoeira',t_ratoeira.rat_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_ratoeira.rat_dhvolta
   FROM t_ratoeira
   LEFT JOIN t_pescador ON t_ratoeira.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_ratoeira.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_ratoeira.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Siripóia',t_siripoia.sir_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_siripoia.sir_dhvolta
   FROM t_siripoia
   LEFT JOIN t_pescador ON t_siripoia.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_siripoia.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_siripoia.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
SELECT 'Tarrafa',t_tarrafa.tar_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_tarrafa.tar_data
   FROM t_tarrafa
   LEFT JOIN t_pescador ON t_tarrafa.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_tarrafa.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_tarrafa.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id
Union All
 SELECT 'Vara de Pesca',t_varapesca.vp_id, t_pescador.tp_nome, t_barco.bar_nome,
    t_monitoramento.mnt_id, t_ficha_diaria.fd_id, t_pescador.tp_apelido, t_porto.pto_nome, t_varapesca.vp_dhvolta
   FROM t_varapesca
   LEFT JOIN t_pescador ON t_varapesca.tp_id_entrevistado = t_pescador.tp_id
   LEFT JOIN t_barco ON t_varapesca.bar_id = t_barco.bar_id
   LEFT JOIN t_monitoramento ON t_varapesca.mnt_id = t_monitoramento.mnt_id
   LEFT JOIN t_ficha_diaria ON t_monitoramento.fd_id = t_ficha_diaria.fd_id
   Left Join t_porto ON t_ficha_diaria.pto_id = t_porto.pto_id;