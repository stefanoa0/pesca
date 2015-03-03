
----- PERFIL
insert into t_perfil (tp_id, tp_perfil)
select at.codigo, left(at.atividades, 40) from access.atividades as at;


-- USUÁRIOS
--Delete from t_usuario where id>9;
SELECT pg_catalog.setval(' t_login_tl_id_seq', 10, true);
SELECT pg_catalog.setval(' t_endereco_te_id_seq', 10, true);


CREATE OR REPLACE FUNCTION import_user( ) returns int4 AS $$
DECLARE R RECORD;
declare ret int4;
BEGIN
FOR R IN SELECT CODIGO, NOME, cod_ativ, email, tel, cel FROM ACCESS.EQUIPE
LOOP
    INSERT INTO T_Endereco (TE_ID, TE_Logradouro, TE_Numero, TE_Bairro, TE_CEP, TE_Comp, TMun_ID)
        VALUES (nextval('t_endereco_te_id_seq'), NULL, NULL, NULL, NULL, NULL, 7);
    INSERT INTO T_Login (TL_ID, TL_Login, TL_HashSenha, TL_UltimoAcesso) 
        VALUES (nextval('t_login_tl_id_seq'), R.CODIGO, '80980fcaf2ab3f243874695f57b2ed065d8e67e4', NULL);
    INSERT INTO T_USUARIO (TU_ID, TU_NOME, TU_SEXO,TU_CPF,TU_RG, TU_EMAIL,TU_TELRES,TU_TELCEL, TL_ID,TP_ID,TE_ID)
        VALUES (R.CODIGO, R.NOME, 'M','1','1','r.email',r.tel,r.cel,currval('t_login_tl_id_seq'),r.cod_ativ,currval('t_endereco_te_id_seq'));
END LOOP;
RETURN ret;
END;
$$ LANGUAGE PLPGSQL;

select import_user();

-- -- Programa social
-- select count(*), prog_soc from access.pescador group by prog_soc order by prog_soc;
-- update access.pescador  set prog_soc=NULL where prog_soc='Não';
-- 
-- CREATE OR REPLACE FUNCTION import_psocial( ) returns int4 AS $$
-- DECLARE R RECORD;
-- declare ret int4;
-- BEGIN
-- FOR R IN SELECT prog_soc from access.pescador group by prog_soc order by prog_soc
-- LOOP
--     INSERT INTO t_programasocial(prs_id, prs_programa)
--         VALUES (nextval('t_programasocial_prs_id_seq'::regclass), r.prog_soc);
-- END LOOP;
-- RETURN ret;
-- END;
-- $$ LANGUAGE PLPGSQL;

-- Escolaridade
select count(*), escolaridade from access.pescador group by escolaridade order by escolaridade;
update access.pescador  set escolaridade='Médio Completo' where escolaridade='médio completo' or escolaridade='Médio completo';
update access.pescador  set escolaridade='Fundamental Completo' where escolaridade='fundamental completo' or escolaridade='Fundamental completo';
update access.pescador  set escolaridade='Não Alfabetizado' where escolaridade='Não alfabetizado';
update access.pescador  set escolaridade='Não Declarado' where escolaridade ISNULL;

CREATE OR REPLACE FUNCTION import_escolaridade( ) returns int4 AS $$
DECLARE R RECORD;
declare ret int4;
BEGIN
FOR R IN SELECT escolaridade from access.pescador group by escolaridade order by escolaridade
LOOP
    INSERT INTO t_escolaridade(esc_id,esc_nivel)
        VALUES (nextval('t_escolaridade_esc_id_seq'::regclass), r.escolaridade);
END LOOP;
RETURN ret;
END;
$$ LANGUAGE PLPGSQL;

-- Renda
select count(*), renda from access.pescador group by renda order by renda;
update access.pescador  set renda='até 1/2 salário mínimo' where renda='200,00' or renda='220,00' or renda='300,00';
update access.pescador  set renda='de 1/2 a 1 salário mínimo' where renda='400,00' or renda='430,00' or renda='500,00' or renda='600,00';
update access.pescador  set renda='Subsistência' where renda='subsistência';
update access.pescador  set renda='maior que 5 salários mínimos' where renda='> 5 salários mínimos';
update access.pescador  set renda='Não Declarado' where renda ISNULL;

CREATE OR REPLACE FUNCTION import_renda( ) returns int4 AS $$
DECLARE R RECORD;
declare ret int4;
BEGIN
FOR R IN SELECT renda from access.pescador group by renda order by renda
LOOP
    INSERT INTO t_renda(ren_id, ren_renda)
        VALUES (nextval('t_renda_ren_id_seq'::regclass), r.renda);
END LOOP;
RETURN ret;
END;
$$ LANGUAGE PLPGSQL;

-- Responsável por cadastro
select responsavel_cadastramento from access.pescador where responsavel_cadastramento notnull order by responsavel_cadastramento;
select responsavel_cadastramento from access.pescador where responsavel_cadastramento like 'Tamires O%' or responsavel_cadastramento like 'TAMIRES O%' order by responsavel_cadastramento;
update access.pescador set responsavel_cadastramento='63' where responsavel_cadastramento like 'Taí%' or responsavel_cadastramento like 'Tai%' or responsavel_cadastramento like 'TAÍSSA%' or responsavel_cadastramento like 'TAISSA%';
update access.pescador set responsavel_cadastramento='45' where responsavel_cadastramento like 'Tamires O%' or responsavel_cadastramento like 'TAMIRES O%' ;
update access.pescador set responsavel_cadastramento='60' where responsavel_cadastramento like 'Andressa%' or responsavel_cadastramento like 'ANDRESSA%' 
or responsavel_cadastramento like 'Adressa%' or responsavel_cadastramento like 'Claúdia%' or responsavel_cadastramento like 'CLAUDIA%' or responsavel_cadastramento like 'Cláudia%'
or responsavel_cadastramento like 'Claudia%';
update access.pescador set responsavel_cadastramento='31' where responsavel_cadastramento like 'Joyce%' or responsavel_cadastramento like 'JOYCE%';
update access.pescador set responsavel_cadastramento='62' where responsavel_cadastramento like 'CARLA%' or responsavel_cadastramento like 'Carla%';
update access.pescador set responsavel_cadastramento='15' where responsavel_cadastramento like 'Alexsandro%' or responsavel_cadastramento like 'ALEXSANDO%';
update access.pescador set responsavel_cadastramento='16' where responsavel_cadastramento like 'Anderson%' or responsavel_cadastramento like 'ANDERSON%';
update access.pescador set responsavel_cadastramento='13' where responsavel_cadastramento ='Adriana Martins de Lima';

insert into access.equipe (codigo, nome) values (77,'AÍSSA HELENA');
update access.pescador set responsavel_cadastramento='77' where responsavel_cadastramento ='AÍSSA HELENA';
update access.pescador set responsavel_cadastramento='20' where responsavel_cadastramento ='APOLO';
update access.pescador set responsavel_cadastramento='21' where responsavel_cadastramento like 'CLEBERSON%' or responsavel_cadastramento like 'Cleberson%';
update access.pescador set responsavel_cadastramento='50' where responsavel_cadastramento like 'VANDERLEI%' or responsavel_cadastramento like 'Vanderlei%';
update access.pescador set responsavel_cadastramento='61' where responsavel_cadastramento like 'VALÉRIA%' or responsavel_cadastramento like 'Valéria%'or responsavel_cadastramento like 'VALERIA%';
update access.pescador set responsavel_cadastramento='49' where responsavel_cadastramento like 'Uilas%' or responsavel_cadastramento like 'UILAS%';
update access.pescador set responsavel_cadastramento='48' where responsavel_cadastramento like 'Uellington%';
update access.pescador set responsavel_cadastramento='46' where responsavel_cadastramento like 'TATIANO%' or responsavel_cadastramento like 'TATIANA%' or responsavel_cadastramento like 'Tatiana%';
update access.pescador set responsavel_cadastramento='55' where responsavel_cadastramento like 'TAYNÁ%';
update access.pescador set responsavel_cadastramento='45' where responsavel_cadastramento like 'Tamires%';
update access.pescador set responsavel_cadastramento='44' where responsavel_cadastramento like 'TALISSON%';
update access.pescador set responsavel_cadastramento='42' where responsavel_cadastramento like 'SILAS%' or responsavel_cadastramento like '? SANTOS SILVA%' or responsavel_cadastramento like 'Silas%';

update access.pescador set responsavel_cadastramento='54' where responsavel_cadastramento like 'ROON%' or responsavel_cadastramento like 'Roon%'or responsavel_cadastramento like 'RON%' or responsavel_cadastramento like 'Ron%';
update access.pescador set responsavel_cadastramento='41' where responsavel_cadastramento like 'Ramires%' or responsavel_cadastramento like 'RAMIRES%';
update access.pescador set responsavel_cadastramento='40' where responsavel_cadastramento like 'NUBIA%' or responsavel_cadastramento like 'Núbia%' or responsavel_cadastramento like 'NÚBIA%';

update access.pescador set responsavel_cadastramento='39' where responsavel_cadastramento like 'MARCOS VINICIUS%' or responsavel_cadastramento like 'Marcos Vinicius%'or responsavel_cadastramento like ' MARCOS  VINICIUS%' 
or responsavel_cadastramento like 'Marcus Vinicius%' or responsavel_cadastramento like 'MARCOS%'or responsavel_cadastramento like 'Mário%';
update access.pescador set responsavel_cadastramento='64' where responsavel_cadastramento like 'Marcio%' or responsavel_cadastramento like 'MÁRCIO%'or responsavel_cadastramento like 'Márcio%'or responsavel_cadastramento like 'MARCIO%';

insert into access.equipe (codigo, nome) values (78,'Márcia');
update access.pescador set responsavel_cadastramento='78' where responsavel_cadastramento like 'Márcia%' or responsavel_cadastramento like 'Marcia%';

insert into access.equipe (codigo, nome) values (79,'Nilson');
update access.pescador set responsavel_cadastramento='79' where responsavel_cadastramento like 'Nilson%';
update access.pescador set responsavel_cadastramento='66' where responsavel_cadastramento like 'MARCELO%' or responsavel_cadastramento like 'Marcelo%';

update access.pescador set responsavel_cadastramento='37' where responsavel_cadastramento like 'Luciano Martins%' or responsavel_cadastramento like 'LUCIANO MARQUES%'
 or responsavel_cadastramento like ' LUCIANO MARQUES%'or responsavel_cadastramento like 'Luciano Marques%'or responsavel_cadastramento like 'Luciano dos Santos%';

update access.pescador set responsavel_cadastramento='36' where responsavel_cadastramento like 'LUCIANO%' or responsavel_cadastramento like 'Luciano%';

update access.pescador set responsavel_cadastramento='35' where responsavel_cadastramento like 'Letícia%' or responsavel_cadastramento like 'LETICIA%';
update access.pescador set responsavel_cadastramento='34' where responsavel_cadastramento like 'JUVAN%' or responsavel_cadastramento like 'Juvan%';
update access.pescador set responsavel_cadastramento='33' where responsavel_cadastramento like 'Juliano%';

update access.pescador set responsavel_cadastramento='32' where responsavel_cadastramento like 'JOSÉ%' or responsavel_cadastramento like 'José%'or responsavel_cadastramento like 'Jose%';
update access.pescador set responsavel_cadastramento='31' where responsavel_cadastramento like 'JOICE%';
update access.pescador set responsavel_cadastramento='29' where responsavel_cadastramento like 'JAILTON%' or responsavel_cadastramento like 'Jailton%';
update access.pescador set responsavel_cadastramento='27' where responsavel_cadastramento like 'HUAN%' or responsavel_cadastramento like 'Huan%';

update access.pescador set responsavel_cadastramento='25' where responsavel_cadastramento like 'Eliana%' or responsavel_cadastramento like 'ELIANA%';
update access.pescador set responsavel_cadastramento='59' where responsavel_cadastramento like 'DIEGO%' or responsavel_cadastramento like 'Diego%';

insert into access.equipe (codigo, nome) values (80,'Débora Bluhu');
update access.pescador set responsavel_cadastramento='80' where responsavel_cadastramento like 'Débora%' or responsavel_cadastramento like 'DÉBORA%'or responsavel_cadastramento like 'Debora%'or responsavel_cadastramento like 'DEBORA%';

update access.pescador set responsavel_cadastramento='22' where responsavel_cadastramento like 'DANILA%' or responsavel_cadastramento like 'Danila%';
update access.pescador set responsavel_cadastramento='20' where responsavel_cadastramento like '%Apolo';

insert into access.equipe (codigo, nome) values (81,'Cristiane de Jesus');
update access.pescador set responsavel_cadastramento='81' where responsavel_cadastramento like 'Cristiane de Jesus%';


update access.pescador set responsavel_cadastramento='18' where responsavel_cadastramento like '%LOBO%'or responsavel_cadastramento like '%Lobo%'or responsavel_cadastramento like 'ANTÔNIO N.%'or responsavel_cadastramento like 'Antonio N.%'
or responsavel_cadastramento like '%ANTONIO A.';
update access.pescador set responsavel_cadastramento='19' where responsavel_cadastramento like '%Filho' or responsavel_cadastramento like '%SANTOS'or responsavel_cadastramento like '%FILHO';
update access.pescador set responsavel_cadastramento='17' where responsavel_cadastramento like 'Antonio Maicon%';

update access.pescador set responsavel_cadastramento='18' where responsavel_cadastramento like 'Ant%' or responsavel_cadastramento like 'ANT%';






-- FICHA DIÁRIA
insert into t_ficha_diaria (fd_id, t_estagiario_tu_id, t_monitor_tu_id1, fd_data, fd_turno, obs, pto_id, tmp_id, vnt_id)
select fd.cod_ficha, cast(fd.estagiario as int8), cast(fd.monitor as int8), fd.data, case to_char(fd.horach, 'AM') when 'AM' then 'M' else 'V' end, left(fd.obs, 255), fd.porto_de_desembarque, tmp.tmp_id, vnt.vnt_id 
from access.ficha_diaria as fd, t_vento as vnt, t_tempo as tmp
where fd.vento = vnt.vnt_forca and
fd.tempo = tmp.tmp_estado;


-- Exemplo original
-- SELECT p.p_name, a.activity, a.category
-- FROM people As p 
--   LEFT JOIN lu_activities AS a ON(';' || p.activities || ';' LIKE '%;' || a.activity || ';%')
-- ORDER BY p,p_name, a.category, a.activity;

--arte de pesca
select tap_id, tap_artepesca from t_artepesca;

select codigo, arte_pesca from access.pescador;

SELECT pesc.codigo, pesc.arte_pesca, arte.tap_artepesca, arte.tap_id
FROM access.pescador As pesc 
    INNER JOIN t_artepesca AS arte ON(';' || pesc.arte_pesca || ';' LIKE '%;' || arte.tap_artepesca || ';%')
ORDER BY pesc.codigo, arte.tap_id, arte.tap_artepesca;

-- tipo dependente
select ttd_id, ttd_tipodependente from t_tipodependente;

select codigo, dependente from access.pescador;

SELECT pesc.codigo, pesc.dependente, dep.ttd_tipodependente, dep.ttd_id
FROM access.pescador As pesc 
    INNER JOIN t_tipodependente AS dep ON(';' || pesc.dependente || ';' LIKE '%;' || dep.ttd_tipodependente || ';%')
ORDER BY pesc.codigo, dep.ttd_id, dep.ttd_tipodependente;


-- tipo capturada
select itc_id, itc_tipo from t_tipocapturada;

select codigo, sp_capt from access.pescador;

SELECT pesc.codigo, pesc.sp_capt, cap.itc_tipo, cap.itc_id
FROM access.pescador As pesc 
    INNER JOIN t_tipocapturada AS cap ON(';' || pesc.sp_capt || ';' LIKE '%;' || cap.itc_tipo || ';%')
ORDER BY pesc.codigo, cap.itc_id, cap.itc_tipo;

--
-- --- Tem que ser no final do arquivo
-- select relname from pg_class where relkind='S' order by relname;
--
SELECT pg_catalog.setval(' t_areapesca_tareap_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_artepesca_tap_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_colonia_tc_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_comunidade_tcom_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_endereco_te_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_escolaridade_esc_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_especie_esp_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_familia_fam_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_ficha_diaria_fd_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_genero_gen_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_grupo_grp_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_login_tl_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_monitoramento_mnt_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_municipio_tmun_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_ordem_ord_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_perfil_tp_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_pescador_has_tt_dependente_tptd_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_pescador_tp_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_pesqueiro_af_paf_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_porteembarcacao_tpe_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_porto_pto_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_programasocial_prs_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_renda_ren_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_situacao_ts_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_subamostra_sa_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_telefonecontato_ttcont_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tempo_tmp_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tipocapturada_itc_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tipodependente_ttd_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tipoembarcacao_tte_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tiporenda_ttr_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_tipotel_ttel_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_usuario_tu_id_seq', 11000, true);
SELECT pg_catalog.setval(' t_vento_vnt_id_seq', 11000, true);



CREATE OR REPLACE FUNCTION IMPORT_PESCADOR( ) RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT 
CODIGO, NOME, SEXO, MATRICULA, APELIDO,
PAI, MAE, CTPS, PIS, INSS,
CEI, RG, RGP, CIR, CPF, DT_NASC,
NATURALIDADE, ESPECIFICIDADE, ESCOLARIDADE, DATA_INSC, RESPONSAVEL_LANCAMENTO,
RESPONSAVEL_CADASTRAMENTO, DATA_CADASTRO, P.MUNICIPIO, M.TMUN_ID AS MUN, P.NATURALIDADE, M2.TMUN_ID AS NAT, M2.TMUN_MUNICIPIO, OBS, ESC.ESC_ID AS ESCID, RUA, BAIRRO
FROM ACCESS.PESCADOR AS P
LEFT JOIN T_MUNICIPIO AS M 
ON  P.MUNICIPIO=M.TMUN_MUNICIPIO
LEFT JOIN T_MUNICIPIO AS M2
ON  P.NATURALIDADE=M2.TMUN_MUNICIPIO
LEFT JOIN T_ESCOLARIDADE AS ESC
ON  P.ESCOLARIDADE=ESC.ESC_NIVEL
LOOP
    INSERT INTO T_ENDERECO ( TE_ID, TE_LOGRADOURO,TE_NUMERO,TE_BAIRRO,TE_CEP,TE_COMP,TMUN_ID)
        VALUES (NEXTVAL('T_ENDERECO_TE_ID_SEQ'),R.RUA,NULL,R.BAIRRO,NULL,NULL,R.MUN);
    
    INSERT INTO  T_PESCADOR (TP_ID,TP_NOME,TP_SEXO,TP_MATRICULA,TP_APELIDO,
            TP_FILIACAOPAI,TP_FILIACAOMAE,TP_CTPS,TP_PIS,TP_INSS,TP_NIT_CEI,
            TP_RG, TP_CMA,TP_RGB_MAA_IBAMA,TP_CIR_CAP_PORTO,TP_CPF,
            TP_DATANASC,TMUN_ID_NATURAL,TE_ID,TP_ESPECIFICIDADE,
            ESC_ID,TP_RESP_LAN,TP_RESP_CAD,TP_DTA_CAD,TP_OBS)
        VALUES (R.CODIGO,left(R.NOME,60),left(R.SEXO,1),R.MATRICULA,R.APELIDO,
            left(R.PAI,60), left(R.MAE,60),R.CTPS,R.PIS,R.INSS,R.CEI,
            R.RG,NULL,R.RGP,R.CIR,R.CPF,
            TO_DATE(R.DT_NASC, 'DD/MM/YYYY'),R.NAT,CURRVAL('T_ENDERECO_TE_ID_SEQ'),R.ESPECIFICIDADE,
            R.ESCID,to_number(R.RESPONSAVEL_LANCAMENTO,'999'),to_number(R.RESPONSAVEL_CADASTRAMENTO,'999'),TO_DATE(R.DATA_CADASTRO, 'DD/MM/YYYY'),R.OBS);
END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

select codigo, nome, sexo, matricula, apelido, pai,mae,ctps,pis,inss,cei,rg, rgp,cir,cpf,dt_nasc,naturalidade, 
especificidade, escolaridade, data_insc, responsavel_lancamento,responsavel_cadastramento,data_cadastro, p.municipio,
 m.tmun_id, p.naturalidade, m2.tmun_id, m2.tmun_municipio, esc.esc_id
from access.pescador as p
left join t_municipio as m 
on  p.municipio=m.tmun_municipio
left join t_municipio as m2
on  p.naturalidade=m2.tmun_municipio
left join t_escolaridade as esc
on  p.escolaridade=esc.esc_nivel;


select codigo, p.municipio, m.tmun_id, p.naturalidade, m2.tmun_id, m2.tmun_municipio as nat, p.escolaridade, esc.esc_nivel, esc.esc_id
from access.pescador as p
left join t_municipio as m 
on  p.municipio=m.tmun_municipio
left join t_municipio as m2
on  p.naturalidade=m2.tmun_municipio
left join t_escolaridade as esc
on  p.escolaridade=esc.esc_nivel;

SELECT pg_catalog.setval(' t_endereco_te_id_seq', 11000, true);

select codigo, m.tmun_id, p.municipio,  m2.tmun_id, p.naturalidade
from access.pescador as p
left join t_municipio as m 
on  p.municipio=m.tmun_municipio
left join t_municipio as m2
on  p.naturalidade=m2.tmun_municipio;

update access.pescador set municipio='Uruçuca' where municipio like 'Serra Grande%' or municipio like 'Serra Grsande-Uruçuca%';
update access.pescador set municipio='Ilhéus' where municipio like 'ILHÉUS%' or municipio like 'Ilhéusx%';


update access.pescador set naturalidade='Una' where naturalidade like 'Uma%' ;
update access.pescador set naturalidade='Itabuna' where naturalidade like 'ITABUNA%' ;
update access.pescador set naturalidade='Ituberá' where naturalidade like 'ITUBERÁ%' ;
update access.pescador set naturalidade='Camamu' where naturalidade like 'CAMAMU%' or naturalidade like 'Camacau%'or naturalidade like 'Camumu%';
update access.pescador set naturalidade='Iramaia' where naturalidade like 'IRAMAIA/BA%' ;
update access.pescador set naturalidade='Maraú' where naturalidade like 'MARAÚ%' ;
update access.pescador set naturalidade='Jaquacuara' where naturalidade like 'JAQUACUARA%' ;
update access.pescador set naturalidade='Conceição Do Almeida' where naturalidade like 'Conceição do Almeida%' ;
update access.pescador set naturalidade='Vitorino Freire' where naturalidade like 'VITORINO FREIRE%' ;
update access.pescador set naturalidade='São José Dos Campos' where naturalidade like 'São José dos Campos%' ;
update access.pescador set naturalidade='Neopolis' where naturalidade like 'Neopolis%';
update access.pescador set naturalidade='Canavieiras' where naturalidade like 'Canavieras%' ;
update access.pescador set naturalidade='Catú' where naturalidade like 'Cairu%' ;
update access.pescador set naturalidade='Piacabucu' where naturalidade like 'PIAÇABUÇU%' ;
update access.pescador set naturalidade='Itacaré' where naturalidade like 'ITACARÉ%' ;
update access.pescador set naturalidade='Duque De Caxias' where naturalidade like 'Duque de Caxias%' ;
update access.pescador set naturalidade='Macambira' where naturalidade like 'Macambira%' ;
update access.pescador set naturalidade='Itaju Da Colônia' where naturalidade like 'Itaju da Colônia%' ;
update access.pescador set naturalidade='Uruçuca' where naturalidade like 'URUÇUCA%'or naturalidade like 'uruçuca%';
update access.pescador set naturalidade='Ilhéus' where naturalidade like 'ILHÉUS%'or naturalidade like 'ilhéus%';
update access.pescador set naturalidade='Osasco' where naturalidade like 'Osasco%';
update access.pescador set naturalidade='Caravelas' where naturalidade like 'Caravelas%';

update access.pescador set naturalidade='' where naturalidade like '%' or naturalidade like '%';


select codigo, m.tmun_id, p.municipio
from access.pescador as p, t_municipio as m 
where
p.municipio=m.tmun_municipio;

select codigo, m2.tmun_id, p.naturalidade
from access.pescador as p, t_municipio as m2
where
p.naturalidade=m2.tmun_municipio;


insert into t_escolaridade values (0, 'Não Declarado');
insert into t_renda (ren_id, ren_renda) values (0, 'Não Declarado');

insert into t_pescador_has_telefone (tpt_tp_id, tpt_ttel_id, tpt_telefone )
select codigo, '2', cel from access.pescador where cel notnull order by codigo;

insert into t_pescador_has_telefone (tpt_tp_id, tpt_ttel_id, tpt_telefone )
select codigo, '1', tel from access.pescador where tel notnull order by codigo;

select codigo, area_pesca from access.pescador where area_pesca notnull order by codigo;

select codigo, area_pesca from access.pescador where area_pesca='';
update access.pescador set area_pesca=NULL where area_pesca='';
select * from t_areapesca;


SELECT pesc.codigo, pesc.area_pesca, area.tareap_id, area.tareap_areapesca
FROM access.pescador As pesc 
    INNER JOIN t_areapesca AS area ON(';' || pesc.area_pesca || ';' LIKE '%;' || area.tareap_areapesca || ';%')
ORDER BY pesc.codigo, area.tareap_id, area.tareap_areapesca;

insert into t_pescador_has_t_areapesca ( tp_id, tareap_id)
SELECT pesc.codigo, area.tareap_id
FROM access.pescador As pesc 
    INNER JOIN t_areapesca AS area ON(';' || pesc.area_pesca || ';' LIKE '%;' || area.tareap_areapesca || ';%')
ORDER BY pesc.codigo, area.tareap_id, area.tareap_areapesca;


select * from t_artepesca;

insert into T_PESCADOR_HAS_T_ARTEPESCA (TP_ID, TAP_ID)
SELECT pesc.codigo, arte.tap_id 
FROM access.pescador As pesc 
    INNER JOIN t_artepesca AS arte ON(';' || pesc.arte_pesca || ';' LIKE '%;' || arte.tap_artepesca || ';%')
ORDER BY pesc.codigo, arte.tap_id, arte.tap_artepesca;




insert into T_PESCADOR_HAS_T_TIPOCAPTURADA (TP_ID, ITC_ID)
SELECT pesc.codigo, tipo.itc_id
FROM access.pescador As pesc 
    INNER JOIN t_tipocapturada AS tipo ON(';' || pesc.sp_capt || ';' LIKE '%;' || tipo.itc_tipo || ';%')
ORDER BY pesc.codigo, tipo.itc_id, tipo.itc_tipo;


select * from T_PESCADOR_HAS_T_EMBARCACAO

insert into T_PESCADOR_HAS_T_EMBARCACAO (tp_id, tte_id, tpe_id, tpte_motor, tpte_dono)
SELECT pesc.codigo, tipo.tte_id, porte.tpe_id, case pesc.motor_embarc when 1 then true else false end, pesc.prop_embarc
FROM access.pescador As pesc 
    INNER JOIN t_tipoembarcacao AS tipo ON(';' || pesc.tipo_embarc || ';' LIKE '%;' || tipo.tte_tipoembarcacao || ';%')
    left join T_PORTEEMBARCACAO as porte on  pesc.tam_ambarc=porte.tpe_porte
ORDER BY pesc.codigo, tipo.tte_id, tipo.tte_tipoembarcacao; 



select count(*), colonia from access.pescador group by colonia;
update access.pescador set colonia='A-87' where colonia like 'Associação de São Miguel (A-87)%' ;

insert into t_pescador_has_t_colonia (tp_id, tc_id, tptc_datainsccolonia)
select p.codigo, col.tc_id, TO_DATE(p.data_insc, 'DD/MM/YYYY')
from access.pescador as p
inner join t_colonia as col on p.colonia=col.tc_nome;




-- tipo-renda
select count(*), qual from access.pescador group by qual order by qual;
update access.pescador set qual='Agricultor(a)' where qual='AGRICOLA' or qual='Agricultor' or qual='AGRICULTOR' or qual='AGRICULTURA';
update access.pescador set qual='Aposentado(a)' where qual='Aposentado' or qual='aposentado' or qual='Aposentadoria' or qual='APOSENTADORIA';
update access.pescador set qual='Pensionista' where qual like'Pensão%' or qual like'PENSÃO%' or qual='Pensionista' ;
update access.pescador set qual='Artesão' where qual='Artesão' or qual='Artesanato' or qual='artesão' or qual='Atersão';
update access.pescador set qual='Vendedor(a)' where qual like'Vende%';
update access.pescador set qual='Auxiliar de Construção Cívil' where 
qual='Ajudante de pedreiro' or qual='AJUDANTE DE PEDREIRO' or qual='Ajudante de pintor' or qual='Auxiliar de pedreiro' or qual='AUX. CARPINTEIRO' or qual='Servente'or qual='SERVENTE'or qual='servente de pedreiro';
update access.pescador set qual='Aluguel' where qual='' or qual='Aluga uma casa' or qual like'Aluguel%';
update access.pescador set qual='Construção Cívil' where qual='pedreiro' or qual='Pedreiro' or qual='PEDREIRO' or qual='Pintor' or qual='PINTOR' or qual='Carpinteiro'or qual='CARPINTEIRO' or qual='Construção Civil' or qual='MARCENEIRO';
update access.pescador set qual='Trabalhador(a) autônomo(a)/Diarista' 
where qual='Autônoma' or qual='AUTÔNOMA' or qual='AUTÔNOMO' or qual='AUTONÔMO' or qual='Ambulante' or qual='Avulso' or qual='BICOS' or qual='Biscateiro' or qual='diarista' or qual='DIARISTA' or qual='DIARISTA E TRABALHA NA PRAIA' 
or qual='Faxineira' or qual='FAXINEIRA' or qual='Faz bico' or qual='Faz \"bicos\".' or qual='Faz biscate' or qual='Faz faxina e lava roupa pra fora' or qual like'Bic%' or qual='R$ 245' 
or qual='Rende R$ 678,00'or qual='Tira coco pra vender' or qual='200,00' or qual='Ajudante' or qual='or qual='''or qual='SALGADINHOS'or qual='Tem uma horta'or qual='Trabalha com horta' or qual='Atravessador. Trabalho Expresso (Rio Cachoeira)'
or qual='confecciona redes' or qual='fabrica bombas' or qual='ROÇAGEM' or qual='Instalação de Antena';
update access.pescador set qual='Diarista/Faxineiro(a)' where qual='Ás vezes Faxina' or qual='Diarista' or qual='LAVA ROUPA PARA FORA';
update access.pescador set qual='Doméstico(a)/Caseiro(a)' where qual='caseiro' or qual='Caseiro' or qual='DOMÉSTICA' or qual='Doméstica';
update access.pescador set qual='Cabelereiro(a)/Manicure' where qual='CABELEREIRO' or qual='Manicure';
update access.pescador set qual='Vendedor(a)' where qual like'vende%' or  qual like'VENDE%';
update access.pescador set qual='Revendedor(a)' where qual like'REVENDE%';
update access.pescador set qual='Motorista' where qual='Motorista' or qual like'MOTORISTA%';
update access.pescador set qual='Turismo' where qual='GUIA TURÍSTICO' or qual like'TURISMO%';
update access.pescador set qual='Serviço Geral' where qual='SERVIÇO GERAL' or qual='SERVIÇOS GERAIS';
update access.pescador set qual='Sindicato' where qual like 'Sindicato%' ;
update access.pescador set qual='Comercializa Peixes/Frutos do Mar/Mariscos' where qual like 'Comercializa%' or qual like 'COMERCIALIZA%' or qual='venda de pescado';
update access.pescador set qual='Comerciante de Praia' where qual like '%praia%' or qual like '%Praia%';
update access.pescador set qual='Feirante' where qual like '%eirante%' or qual='TRABALHA COM MARISCO NA FEIRA';
update access.pescador set qual='Comerciante' where qual='Bar' or qual='BAR' or qual='Comerciante' or qual='COMERCIANTE'or qual='POSSUI UM BAR'or qual='PROPRIETRIO DE BAR'or qual='Quintadeira'or qual='Tem um bar'or qual='Mercearia';
update access.pescador set qual='Agricultor(a)' where qual='Trabalha na roça' or qual='TRABALHA NA ROÇA' or qual='Trabalha no sítio' or qual='Roça'or qual='ROÇA'or qual='ROÇA PRÓPRIA'or qual='tem uma rocinha';
update access.pescador set qual='Trabalho Assalariado' where qual='ASSALARIADO' or qual like 'Trabalha em um%' or qual like 'Trabalha n%' or qual ='Ass. Porto de Trás';
update access.pescador set qual=NULL where qual='NÃO' or qual='não' or qual='Ilegível no cadastro';
update access.pescador set qual='Estágio/Monitoria' where qual='MONITOR DE PESCA (MPESCA)' or qual='Pesquisador de desembarque pesqueiro' ;
update access.pescador set qual='Peeiro(a)' where qual='Peeiro' or qual='PEEIRO';
update access.pescador set qual='Marisqueira(o)' where qual='MARISCAGEM' or qual='Marisqueira' ;
update access.pescador set qual='Fileta camarão' where qual='Fileta camarão' or qual='FILETA CAMARÃO' or qual LIKE 'Fileta camarão%';
update access.pescador set qual='Servidor(a) Público(a)' where qual='Servidora Pública' or qual='Servidor Público Municipal (R$ 1190,00)'or qual='Funcionária municipal' or qual='Funcionário Público';
update access.pescador set qual='Portuário/Embarcado' where qual='Portuário' or qual='Trabalha embarcado';

CREATE OR REPLACE FUNCTION import_trenda( ) returns int4 AS $$
DECLARE R RECORD;
declare ret int4;
BEGIN
FOR R IN SELECT qual from access.pescador where qual notnull group by qual order by qual
LOOP
    INSERT INTO t_tiporenda(ttr_id, ttr_descricao)
        VALUES (nextval('t_tiporenda_ttr_id_seq'::regclass), r.qual);
END LOOP;
RETURN ret;
END;
$$ LANGUAGE PLPGSQL;

SELECT pg_catalog.setval(' t_tiporenda_ttr_id_seq'::regclass, 10, true);

insert into t_pescador_has_t_renda (tp_id, ren_id, ttr_id)
select p.codigo, renda.ren_id, '1'
from access.pescador as p
left join t_renda as renda on p.renda=renda.ren_renda;

insert into t_pescador_has_t_renda (tp_id, ren_id, ttr_id)
select p.codigo, '0', tren.ttr_id
from access.pescador as p
left join t_tiporenda as tren on p.qual=tren.ttr_descricao
where p.qual notnull;





update access.pescador set prog_soc=NULL where prog_soc='Não%';


insert into t_pescador_has_t_programasocial ( tp_id, prs_id)
select p.codigo, ps.prs_id
from access.pescador as p
left join t_programasocial as ps on p.prog_soc=ps.prs_programa
where p.prog_soc notnull;



-- tipo dependente
select ttd_id, ttd_tipodependente from t_tipodependente;

select codigo, dependente from access.pescador;

insert into t_pescador_has_t_tipodependente (tp_id, ttd_id, tptd_quantidade)
SELECT pesc.codigo, dep.ttd_id, cast(pesc.n_dependentes as int8)
FROM access.pescador As pesc 
    INNER JOIN t_tipodependente AS dep ON(';' || pesc.dependente || ';' LIKE '%;' || dep.ttd_tipodependente || ';%')
ORDER BY pesc.codigo, dep.ttd_id, dep.ttd_tipodependente;

select * from t_pescador_has_t_tipodependente order by tp_id, ttd_id;

update t_pescador_has_t_tipodependente set tptd_quantidade=1 where ttd_id=1;

insert into t_comunidade ( tcom_id, tcom_nome) 
select codigo, comunidade from access.comunidade;


select tp_id, tcom_id from t_pescador_has_t_comunidade;

insert into t_pescador_has_t_comunidade (tp_id, tcom_id)
select codigo, cast(comunidade as int8) from access.pescador where comunidade notnull order by codigo;



select codigo, comunidade from access.pescador where comunidade notnull;
select * from t_pescador_has_t_comunidade;

insert into t_pescador_has_t_comunidade (tp_id, tcom_id)
select codigo, cast(comunidade as int8) from access.pescador where comunidade notnull;

insert into T_PESCADOR_HAS_T_PORTO (TP_ID, PTO_ID)
select codigo, cod_pdesemb from access.pescador where cod_pdesemb notnull;

--Avistamento

select count(*), avist from access.entrev_pesca group by avist;

update access.entrev_pesca set avist='Tartaruga' where avist='Tartaruga.' or avist='Tartaruga (grande)' or avist='tartaruga' or avist='Tartaruga grande'
or avist='TARTARUGA' or avist='Tartaruga (cor amarelada)' or avist='tartaruga grande';

update access.entrev_pesca set avist='Tartaruga de Pente' where avist='Tartaruga de Pente.' or avist='tartaruga de pente' or avist='tartaruga pente' 
or avist='tartaruga pente (2 filhotes e 1 adulto)' or avist='Tartaruga de pente' or avist='três tartarugas de pente';

update access.entrev_pesca set avist='Baleia Jubarte' where avist='baleia jubarte' or avist='Balei Jubarte' or avist='baleia jubarte/ cacalote';

update access.entrev_pesca set avist='Baleia' where avist='BALEIA' or avist='baleia';

update access.entrev_pesca set avist='Golfinho' where avist='4 golfinhos' or avist='GOLFINHO' or avist='Golfinhos' or avist='golfinho'
or avist='Golfinho.' or avist='Golfinho - Boto' or avist=' Golfinho - Boto';

update access.entrev_pesca set avist='Tubarão' where avist='tubarão';

update access.entrev_pesca set avist='Boto Cinza' where avist='Boto cinza';

update access.entrev_pesca set avist='Tartaruga;Golfinho' where avist='Golfinho e Tartaruga.' or avist='Tartaruga e Golfinho (boto)'
or avist='Tartaruga e Golfinho.' or avist='Tartaruga e golfinho.' or avist='Tartarua e golfinho' or avist='golfinho e tartarugas'
or avist='Tartarura e golfinho' or avist='artaruga, golfinho' or avist='Tartaruga e Golfinho' or avist='Tartaruga, Golfinho'
or avist='tartarugas e golfinho' or avist='Tartaruga e golfinho' or avist='tartaruga e golfinho' or avist='Tartaruga, golfinho'
or avist=' Tartaruga e Golfinho' or avist='tartaruga, golfinho' or avist='Tartaruga e  Golfinho';

update access.entrev_pesca set avist='Tartaruga;Baleia' where avist='Tartaruga e baleia'or avist='Tartaruga e Baleia';

update access.entrev_pesca set avist='Golfinho;Baleia' where avist='baleia e golfinho'or avist='Baleia e Golfinho'or avist='golfinho e baleia'
or avist='Golfinho e Baleia';

update access.entrev_pesca set avist='Golfinho;Baleia Jubarte' where avist='Golfinho e Baleia Jubarte';

update access.entrev_pesca set avist='Golfinho;Tartaruga de Pente' where avist='tartaruga pente e golfinho';

update access.entrev_pesca set avist='Tartaruga;Golfinho;Baleia Cachalote' where avist='tartaruga, golfinho, baleia cachalote';

update access.entrev_pesca set avist='Tartaruga;Golfinho;Baleia' where avist='Tartaruga, golfinho e baleia';

update access.entrev_pesca set avist='Golfinho;Baleia Jubarte' where avist='Golfinho e Baleia Jubarte' or avist='Golfinho e Baleia Jubarte';

update access.entrev_pesca set avist='Golfinho;Baleia' where avist='Golfinho e Baleia' or avist='Golfinho e Baleia';

update access.entrev_pesca set avist='Tartaruga;Baleia Jubarte' where avist='Tartaruga e Baleia Jubarte' or avist='Tartaruga e Baleia (Jubarte)';

update access.entrev_pesca set avist='Boto Preto' where avist='8 individuos de boto preto';

update access.entrev_pesca set avist='Tartaruga de Pente;Baleia Jubarte' where avist='Jubart, tartaruga de pente';

update access.entrev_pesca set avist='Golfinho Nariz de Garrafa' where avist='Golfinho nariz de garrafa';

update access.entrev_pesca set avist='Tartaruga do Casco Mole' where avist='Tartaruga do casco mole';

update access.entrev_pesca set avist='Tartaruga - Ninho' where avist='Ninho de tartaruga';

update access.entrev_pesca set avist='Tartaruga - Morta' where avist='Tartaruga (morta)';

update access.entrev_pesca set avist='Baleia Jubarte - Morta' where avist='Jubarte morta em Barra Grande';

update access.entrev_pesca set avist='Peixe Lua;Baleia Jubarte' where avist='Peixe lua, Baleia Jubarte';

update access.entrev_pesca set avist='Peixe Lua;Baleia Jubarte' where avist='Peixe lua, Baleia Jubarte';

update access.entrev_pesca set avist=NULL where avist='';


select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='Uma rede de mais de 1000 metros com peixes mortos.';
update access.entrev_pesca set obs=avist where cod_fichadiaria=2440;
update access.entrev_pesca set avist='' where cod_fichadiaria=2440;

select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='Também utilizou rede de emalhar';
update access.entrev_pesca set obs=avist where cod_fichadiaria=494;
update access.entrev_pesca set avist='' where cod_fichadiaria=494;

select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='atravessadores' or avist='Atravessadores' or avist='Atravessador';
update access.entrev_pesca set obs=avist where cod_fichadiaria=1768;
update access.entrev_pesca set avist='' where cod_fichadiaria=1768;

update access.entrev_pesca set obs=avist where cod_fichadiaria=1155;
update access.entrev_pesca set avist='' where cod_fichadiaria=1155;

update access.entrev_pesca set obs=avist where cod_fichadiaria=1550;
update access.entrev_pesca set avist='' where cod_fichadiaria=1550;

select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='Sem captura';
update access.entrev_pesca set obs=avist where cod_fichadiaria=1061;
update access.entrev_pesca set avist='' where cod_fichadiaria=1061;

select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='Vender na banca mais próxima';
update access.entrev_pesca set obs=avist where cod_fichadiaria=582;
update access.entrev_pesca set avist='' where cod_fichadiaria=582;

select cod_fichadiaria, avist, obs from access.entrev_pesca where avist='Entrega na peixaria';
update access.entrev_pesca set obs=avist where cod_fichadiaria=1462;
update access.entrev_pesca set avist='' where cod_fichadiaria=1462;

CREATE TABLE T_AVISTAMENTO (
TA_ID SERIAL,
TA_DESCRICAO VARCHAR(50) NOT NULL,
CONSTRAINT T_TAVISTAMENTO_TA_ID_PKEY PRIMARY KEY (TA_ID)
);

INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 1, 'Baleia');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 2, 'Baleia Jubarte');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 3, 'Baleia Jubarte - Morta');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 4, 'Baleia Cachalote');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 5, 'Bijupirá 50kg');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 6, 'Boto');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 7, 'Boto Cinza');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 8, 'Boto Preto');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 9, 'Cardume de Tuninha');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 10, 'Golfinho');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 11, 'Golfinho Nariz de Garrafa');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 12, 'Lontras');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 13, 'Peixe Lua');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 14, 'Tartaruga');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 15, 'Tartaruga de Pente');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 16, 'Tartaruga do Casco Mole');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 17, 'Tartaruga - Morta');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 18, 'Tartaruga - Ninho');
INSERT INTO T_AVISTAMENTO (TA_ID, TA_DESCRICAO) VALUES ( 19, 'Tubarão');

CREATE TABLE T_ENTREVISTA_HAS_T_AVISTAMENTO (
TE_ID INTEGER,
FD_ID INTEGER, 
TA_ID INTEGER, 
CONSTRAINT T_T_ENTREVISTA_HAS_T_AVISTAMENTO_PKEY PRIMARY KEY (TE_ID,  FD_ID,  TA_ID)
);



INSERT INTO T_ENTREVISTA_HAS_T_AVISTAMENTO (TE_ID,  FD_ID,  TA_ID)
SELECT PESC.CODIGO, PESC.COD_FICHADIARIA, AV.TA_ID
FROM ACCESS.ENTREV_PESCA AS PESC 
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || PESC.AVIST || ';' LIKE '%;' || AV.TA_DESCRICAO || ';%')
ORDER BY PESC.COD_FICHADIARIA, AV.TA_ID, AV.TA_DESCRICAO;



select count(*), arte from access.entrev_pesca group by arte;
select * from t_artepesca;
update access.entrev_pesca set arte='15' where arte='Mariscagem' or arte='MARISCAGEM';
update access.entrev_pesca set arte='5' where arte='REDE';
update access.entrev_pesca set arte='4' where arte='Pesca DE LINHA' or arte='PESCA DE LINHA';
update access.entrev_pesca set arte='1' where arte='ARRASTO DE FUNDO';



insert into t_tipoembarcacao(tte_id,tte_tipoembarcacao) values(0,'Sem Embarcação');

select count(*), tp_barco from access.entrev_pesca group by tp_barco;
update access.entrev_pesca set tp_barco='3' where tp_barco='Canoa';
update access.entrev_pesca set tp_barco='4' where tp_barco='Jangada';
update access.entrev_pesca set tp_barco='6' where tp_barco='Batera';
update access.entrev_pesca set tp_barco='0' where tp_barco='Sem barco' or tp_barco='sem barco';
update access.entrev_pesca set tp_barco='1;Motor1' where tp_barco='Barco a motor';



select count(*), tp_pesca from access.entrev_pesca group by tp_pesca;
select * from t_artepesca;
update access.entrev_pesca set tp_pesca='4' where tp_pesca='Linha de mão';
update access.entrev_pesca set tp_pesca='3' where tp_pesca='Grosseira';

select count(*), tp_rede from access.entrev_pesca group by tp_rede;
select * from t_artepesca;
update access.entrev_pesca set tp_rede='2' where tp_rede='Calão';
update access.entrev_pesca set tp_rede='5' where tp_rede='Emalhe' or tp_rede='3 malhos';
update access.entrev_pesca set tp_rede='7' where tp_rede='Tarrafa';
update access.entrev_pesca set tp_rede='5' where tp_rede='6';

-- Precisa terminar
select count(*), mare from access.entrev_pesca group by mare;
update access.entrev_pesca set mare='Viva' where mare='viva';
update access.entrev_pesca set mare='Morta' where mare='morta';

-- Precisa terminar
select count(*), tipomariscagem from access.entrev_pesca group by tipomariscagem;
update access.entrev_pesca set tipomariscagem='11' where tipomariscagem='Manzuá';
update access.entrev_pesca set tipomariscagem='5' where tipomariscagem='Emalhe' or tipomariscagem='3 malhos';


select count(*), tempo from access.ficha_diaria group by tempo;
update access.ficha_diaria set tempo='1' where tempo='chuva' or tempo='Chuva';
update access.ficha_diaria set tempo='2' where tempo='Nublado';
update access.ficha_diaria set tempo='3' where tempo='Sol' or tempo='SOL' or tempo='sol';

select count(*), vento from access.ficha_diaria group by vento;
update access.ficha_diaria set vento='1' where vento='Forte';
update access.ficha_diaria set vento='2' where vento='Fraco';
update access.ficha_diaria set vento='3' where vento='Moderado';

CREATE TABLE IF NOT EXISTS t_turno (
TURNO_ID VARCHAR NOT NULL,
TURNO_NOME VARCHAR(30) NOT NULL,
PRIMARY KEY (TURNO_ID)
);

insert into t_turno(TURNO_ID, TURNO_NOME) values ('M','Matutino');
insert into t_turno(TURNO_ID, TURNO_NOME) values ('V','Vespertino');
insert into t_turno(TURNO_ID, TURNO_NOME) values ('N','Noturno');
insert into t_turno(TURNO_ID, TURNO_NOME) values ('I','Integral');

-- Precisa terminar
update access.ficha_diaria set turno='1' where turno='Forte';
update access.ficha_diaria set turno='2' where turno='Fraco';
update access.ficha_diaria set turno='3' where turno='Moderado';





SELECT P.TP_ID, INITCAP(P.TP_NOME) AS TP_NOME FROM T_PESCADOR AS P;

SELECT P.TP_ID, INITCAP(P.TP_NOME) AS TP_NOME , TE.TMUN_ID,  TM.TMUN_MUNICIPIO
FROM T_PESCADOR AS P,  T_ENDERECO AS TE,  T_MUNICIPIO AS TM
WHERE
P.TE_ID = TE.TE_ID AND
TE.TMUN_ID = TM.TMUN_ID
ORDER BY P.TP_NOME;
q

SELECT TP.TP_ID,  INITCAP(TP.TP_NOME), TE.TE_ID, TE.TMUN_ID,  TM.TMUN_MUNICIPIO
FROM T_PESCADOR AS TP
left join T_ENDERECO AS TE on TP.TE_ID = TE.TE_ID
left join T_MUNICIPIO AS TM on TE.TMUN_ID = TM.TMUN_ID
ORDER BY TM.TMUN_MUNICIPIO,  TP.TP_NOME;

left join t_escolaridade as esc
on  p.escolaridade=esc.esc_nivel;


SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_rede, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.Tempomariscando
FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
WHERE (((Entrev_Pesca.Tp_rede)="tarrafa"))


select ep.codigo,  fd.porto_de_desembarque, ep.tp_rede,  ep.tp_rede,  ep.mestre,
ep.pesqueiro1, ep.n_pesc,  ep.tempomariscando
from access.entrev_pesca as ep
left join access.ficha_diaria as fd on ep.cod_fichadiaria = fd.cod_ficha
where ep.tp_rede = '7'
order by ep.codigo;

select ep.codigo,  fd.porto_de_desembarque as pto, pt.pto_nome,  ep.tp_rede,  ap.tap_artepesca,  ep.mestre, pe.tp_nome, ep.pesqueiro1, pq.paf_pesqueiro, ep.n_pesc,  ep.tempomariscando
from access.entrev_pesca as ep
left join access.ficha_diaria as fd on ep.cod_fichadiaria = fd.cod_ficha
left join t_porto as pt on fd.porto_de_desembarque = pt.pto_id
left join t_artepesca as ap on cast(ep.tp_rede as int8) = ap.tap_id
left join t_pescador as pe on ep.mestre = pe.tp_id
left join t_pesqueiro_af as pq on cast(ep.pesqueiro1 as int8) = pq.paf_id
where ep.tp_rede = '7'
order by ep.codigo;

select * from t_artepesca;

INSERT INTO T_PESQUEIRO_AF (PAF_ID,  PAF_PESQUEIRO)
SELECT CODIGO,  PESQUEIRO FROM ACCESS.PESQUEIRO;

INSERT INTO T_BARCO (BAR_ID,  BAR_NOME)
SELECT CODIGO,  EMBARCACAO FROM ACCESS.EMBARCACAO;

select * from (
	

select barco from access.entrev_pesca;

select * from t_barco;


//////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
--Linha de Fundo

select 
ep.codigo,
-- case cast(left(ep.tp_barco, 1) as int8) when '' then 0 else 1 end as embarcado,
case ep.tp_barco when '' then 0 else 1 end as embarcado, -- ERRO
ep.barco, 
left(ep.tp_barco,  1) as tp_barco, 
ep.tp_barco, 
ep.mestre,
ep.n_pesc,
ep.datasaida,
ep.horasaida,
ep.datachegada,
ep.horachegada,
ep.combustivel,
ep.'Óleo',
ep.alimentos,
ep.gelo,
ep.n_linhas,
ep.n_anzois,
ep.isca,
ep.mare,
ep.avist,
ep.subamostra,
ep.id_subamostra,
ep.cod_fichadiaria
from access.entrev_pesca as ep
where ep.tp_mariscagem = 'Linha de Fundo'
order by ep.codigo;





/// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////



----> correção da importação da ficha diaria
insert into t_ficha_diaria (fd_id, t_estagiario_tu_id, t_monitor_tu_id1, fd_data, fd_turno, obs, pto_id, tmp_id, vnt_id)
select fd.cod_ficha,
cast(fd.estagiario as int8),
cast(fd.monitor as int8), 
fd.data,
case to_char(fd.horach, 'AM') when 'AM' then 'M' else 'V' end,
left(fd.obs, 255),
fd.porto_de_desembarque, 
coalesce(cast(fd.tempo as int8), 2),
coalesce(cast(fd.vento as int8), 2)
from access.ficha_diaria as fd;


/// //////////////////////////////////////////////////////////////////

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_SUBAMOSTRA -t T_MONITORAMENTO -t T_ARRASTOFUNDO_HAS_T_PESQUEIRO -t T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA -t  T_ARRASTOFUNDO_HAS_T_AVISTAMENTO -t T_ARRASTOFUNDO > /tmp/arrastofundo.sql
-- 
-- 
-- DELETE FROM T_ARRASTOFUNDO_HAS_T_PESQUEIRO;
-- DELETE FROM T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA;
-- DELETE FROM T_ARRASTOFUNDO_HAS_T_AVISTAMENTO;
-- DELETE FROM T_ARRASTOFUNDO;
-- DELETE FROM T_SUBAMOSTRA;
-- DELETE FROM T_MONITORAMENTO;
-- 
-- ----> Sequencia inicial
-- SELECT PG_CATALOG.SETVAL('T_MONITORAMENTO_MNT_ID_SEQ', 1, TRUE);
-- SELECT PG_CATALOG.SETVAL('T_ARRASTOFUNDO_AF_ID_SEQ', 1, TRUE);
-- SELECT PG_CATALOG.SETVAL('T_SUBAMOSTRA_SA_ID_SEQ', 1, TRUE);
-- SELECT PG_CATALOG.SETVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ', 1, TRUE);
-- SELECT PG_CATALOG.SETVAL('T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA_SPC_AF_ID_SEQ', 1, TRUE);
-- SELECT PG_CATALOG.SETVAL('T_SUBAMOSTRA_SA_ID_SEQ', 1, TRUE);

----> Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.ARRFUNDO,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.ARTE='1' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.ARRFUNDO <> 0
ORDER BY FD.COD_FICHA;

--> Arrasto de Fundo
INSERT INTO T_ARRASTOFUNDO (
AF_ID, AF_EMBARCADO,  BAR_ID,  TTE_ID,  TP_ID_ENTREVISTADO,  AF_QUANTPESCADORES,  AF_DHSAIDA, AF_DHVOLTA,
AF_DIESEL,  AF_OLEO,  AF_ALIMENTO,  AF_GELO,  AF_AVISTOU,  AF_SUBAMOSTRA,  SA_ID, AF_OBS,  AF_MOTOR, AF_DESTINO, MNT_ID  )
( SELECT
	EP.CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CAST(LEFT(EP.TP_BARCO,  1) AS INT4) AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	EP.COMBUSTIVEL,
	EP."Óleo" AS OLEO,
	EP.ALIMENTOS,
	EP.GELO,
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	EP.OBS,
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO, 
	MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.ARTE = '1' AND MNT.MNT_MONITORADO = TRUE ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO T_ARRASTOFUNDO_HAS_T_PESQUEIRO (AF_PAF_ID, AF_ID, PAF_ID, T_TEMPOPESQUEIRO )
SELECT NEXTVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ'), EP.CODIGO, CAST(EP.PESQUEIRO1 AS INT8),TO_CHAR(EP.DUR_ARRASTO1*60, '999999')::INTERVAL
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ( SELECT FD.COD_FICHA FROM ACCESS.FICHA_DIARIA AS FD WHERE FD.ARRFUNDO <> 0 ORDER BY FD.COD_FICHA) AS FD ON EP.COD_FICHADIARIA=FD.COD_FICHA
WHERE EP.ARTE='1' AND EP.PESQUEIRO1 NOTNULL ORDER BY EP.CODIGO;

INSERT INTO T_ARRASTOFUNDO_HAS_T_PESQUEIRO (AF_PAF_ID, AF_ID, PAF_ID, T_TEMPOPESQUEIRO )
SELECT NEXTVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ'), EP.CODIGO, CAST(EP.PESQUEIRO2 AS INT8),TO_CHAR(EP.DUR_ARRASTO2*60, '999999')::INTERVAL
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ( SELECT FD.COD_FICHA FROM ACCESS.FICHA_DIARIA AS FD WHERE FD.ARRFUNDO <> 0 ORDER BY FD.COD_FICHA) AS FD ON EP.COD_FICHADIARIA=FD.COD_FICHA
WHERE EP.ARTE='1' AND EP.PESQUEIRO2 NOTNULL ORDER BY EP.CODIGO;

INSERT INTO T_ARRASTOFUNDO_HAS_T_PESQUEIRO (AF_PAF_ID, AF_ID, PAF_ID, T_TEMPOPESQUEIRO )
SELECT NEXTVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ'), EP.CODIGO, CAST(EP.PESQUEIRO3 AS INT8),TO_CHAR(EP.DUR_ARRASTO3*60, '999999')::INTERVAL
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ( SELECT FD.COD_FICHA FROM ACCESS.FICHA_DIARIA AS FD WHERE FD.ARRFUNDO <> 0 ORDER BY FD.COD_FICHA) AS FD ON EP.COD_FICHADIARIA=FD.COD_FICHA
WHERE EP.ARTE='1' AND EP.PESQUEIRO3 NOTNULL ORDER BY EP.CODIGO;

INSERT INTO T_ARRASTOFUNDO_HAS_T_PESQUEIRO (AF_PAF_ID, AF_ID, PAF_ID, T_TEMPOPESQUEIRO )
SELECT NEXTVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ'), EP.CODIGO, CAST(EP.PESQUEIRO4 AS INT8),TO_CHAR(EP.DUR_ARRASTO4*60, '999999')::INTERVAL
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ( SELECT FD.COD_FICHA FROM ACCESS.FICHA_DIARIA AS FD WHERE FD.ARRFUNDO <> 0 ORDER BY FD.COD_FICHA) AS FD ON EP.COD_FICHADIARIA=FD.COD_FICHA
WHERE EP.ARTE='1' AND EP.PESQUEIRO4 NOTNULL ORDER BY EP.CODIGO;

INSERT INTO T_ARRASTOFUNDO_HAS_T_PESQUEIRO (AF_PAF_ID, AF_ID, PAF_ID, T_TEMPOPESQUEIRO )
SELECT NEXTVAL('T_ARRASTOFUNDO_HAS_T_PESQUEIRO_AF_PAF_ID_SEQ'), EP.CODIGO, CAST(EP.PESQUEIRO5 AS INT8),TO_CHAR(EP.DUR_ARRASTO5*60, '999999')::INTERVAL
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ( SELECT FD.COD_FICHA FROM ACCESS.FICHA_DIARIA AS FD WHERE FD.ARRFUNDO <> 0 ORDER BY FD.COD_FICHA) AS FD ON EP.COD_FICHADIARIA=FD.COD_FICHA
WHERE EP.ARTE='1' AND EP.PESQUEIRO5 NOTNULL ORDER BY EP.CODIGO;


---> Especie Capturada
INSERT INTO T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA (SPC_AF_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  AF_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT AF_ID FROM T_ARRASTOFUNDO ORDER BY AF_ID) AS AF ON SP.COD_ENTREV = AF.AF_ID
ORDER BY SP.COD_ENTREV;


-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_ARRASTOFUNDO_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT 
AF.AF_ID, AF.TP_ID_ENTREVISTADO, AF.AF_DHSAIDA, AF.AF_DHVOLTA, AF.AF_SUBAMOSTRA
FROM T_ARRASTOFUNDO AS AF
WHERE AF.AF_SUBAMOSTRA = TRUE AND AF.AF_DHVOLTA NOTNULL
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.AF_DHSAIDA );

    UPDATE T_ARRASTOFUNDO SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE AF_ID=R.AF_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

select IMPORT_ARRASTOFUNDO_SUBAMOSTRA();

----> avistamento
INSERT INTO T_ARRASTOFUNDO_HAS_T_AVISTAMENTO (AF_ID, AVS_ID)
SELECT AF.AF_ID, AV.AVS_ID
FROM T_ARRASTOFUNDO AS AF
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || AF.AF_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY AF.AF_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

---> Não Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.ARRFUNDONM,  FALSE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.ARTE='1' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
where FD.ARRFUNDONM <> 0
ORDER BY FD.COD_FICHA;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_ARRASTOFUNDO_HAS_T_PESQUEIRO -t T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA -t  T_ARRASTOFUNDO_HAS_T_AVISTAMENTO -t T_ARRASTOFUNDO > /tmp/01_arrastofundo.sql

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00_monitoramento.sql

///////////////////////////////////////////////////////////////////// CALÃO
-- DELETE FROM T_CALAO_HAS_T_PESQUEIRO;
-- DELETE FROM T_CALAO_HAS_T_ESPECIE_CAPTURADA;
-- DELETE FROM T_CALAO_HAS_T_AVISTAMENTO;
-- DELETE FROM T_CALAO;
-- DELETE FROM T_SUBAMOSTRA;
-- DELETE FROM T_MONITORAMENTO;


----> Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.RDEMA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.CODIGO, EP.TP_REDE, EP.ARTE
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5'
    AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA, EP.CODIGO
) AS EP ON FD.COD_FICHA = EP.COD_FICHADIARIA
ORDER BY FD.COD_FICHA;

--> Arrasto de Fundo
INSERT INTO T_CALAO (
	CAL_ID, CAL_EMBARCADA, BAR_ID, TTE_ID, TP_ID_ENTREVISTADO, CAL_QUANTPESCADORES, CAL_DATA, CAL_TEMPOGASTO, 
	CAL_AVISTOU, CAL_SUBAMOSTRA, SA_ID, CAL_NPANOS, CAL_TAMANHO, CAL_ALTURA, CAL_MALHA, CAL_NUMLANCES, 
	CAL_OBS, CAL_MOTOR, CAL_DESTINO,  MNT_ID
) ( SELECT
	EP.CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI') -
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	EP.AVIST, 
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	EP.N_PANOS, 
	EP.COMP_PANO, 
	EP.ALT_PANO, 
	EP.TAM_MALHA, 
	EP.N_LANCES,
	EP.OBS,
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR, -- AF_MOTOR
	EP.DESTINO,
	MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TP_REDE='2' AND EP.ARTE='5' ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO t_calao_has_t_pesqueiro (cal_paf_id,  cal_id,  paf_id)
SELECT nextval('t_calao_has_t_pesqueiro_cal_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5' AND EP.PESQUEIRO1 NOTNULL
UNION
	SELECT nextval('t_calao_has_t_pesqueiro_cal_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5' AND EP.PESQUEIRO2 NOTNULL
UNION
    SELECT nextval('t_calao_has_t_pesqueiro_cal_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5' AND EP.PESQUEIRO3 NOTNULL
UNION
    SELECT nextval('t_calao_has_t_pesqueiro_cal_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5' AND EP.PESQUEIRO4 NOTNULL
UNION
    SELECT nextval('t_calao_has_t_pesqueiro_cal_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5' AND EP.PESQUEIRO5 NOTNULL ORDER BY CODIGO;

------> Especie Capturada    
INSERT INTO T_CALAO_HAS_T_ESPECIE_CAPTURADA (SPC_CAL_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  CAL_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT CAL_ID FROM T_CALAO ORDER BY CAL_ID) AS CAL ON SP.COD_ENTREV = CAL.CAL_ID
ORDER BY SP.COD_ENTREV;

-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_CALAO_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT CAL_ID, TP_ID_ENTREVISTADO,  CAL_DATA,  CAL_SUBAMOSTRA FROM T_CALAO WHERE CAL_SUBAMOSTRA = TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.CAL_DATA );

    UPDATE T_CALAO SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE CAL_ID=R.CAL_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

select IMPORT_CALAO_SUBAMOSTRA();

----> avistamento
INSERT INTO T_CALAO_HAS_T_AVISTAMENTO (CAL_ID, AVS_ID)
SELECT CAL.CAL_ID, AV.AVS_ID
FROM T_CALAO AS CAL
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || CAL.CAL_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY CAL.CAL_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

----> Não monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.RDEMANM,  FALSE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.CODIGO, EP.TP_REDE, EP.ARTE
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='2' AND EP.ARTE='5'
) AS EP ON FD.COD_FICHA = EP.COD_FICHADIARIA
where FD.RDEMANM <> 0
ORDER BY FD.COD_FICHA;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_CALAO_HAS_T_PESQUEIRO -t T_CALAO_HAS_T_ESPECIE_CAPTURADA -t  T_CALAO_HAS_T_AVISTAMENTO -t T_CALAO > /tmp/02_calao.sql

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00_monitoramento.sql

//////////////////////////////////////////////////////////////////// EMALHE
-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_rede, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, 
-- Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.Tp_rede)="emalhe" Or (Entrev_Pesca.Tp_rede)="3 malhos"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_rede, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, 
-- Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc;

--------------------------------------------------------------------------------------------
--Monitoramentos de Emalhe


--3MALHOS
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 5,  FD.TRES_MALHOS,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='5' OR EP.TIPOMARISCAGEM = '5'
     AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA, EP.CODIGO
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.TRES_MALHOS > 0 ORDER BY FD.COD_FICHA;

--MONITORADAS
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 5,  FD.RDEMA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='5' OR EP.TIPOMARISCAGEM = '5'
    AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA, EP.CODIGO
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.RDEMA > 0 ORDER BY FD.COD_FICHA;

--> T_EMALHE
INSERT INTO T_EMALHE (
	EM_ID, EM_EMBARCADO, BAR_ID, TTE_ID, TP_ID_ENTREVISTADO, EM_QUANTPESCADORES, EM_DHLANCAMENTO, 
	EM_DHRECOLHIMENTO, EM_DIESEL, EM_OLEO, EM_ALIMENTO, EM_GELO, EM_AVISTOU, EM_SUBAMOSTRA, 
	SA_ID, EM_TAMANHO, EM_ALTURA, EM_NUMPANOS, EM_MALHA, EM_OBS, EM_MOTOR, EM_DESTINO, MNT_ID
) ( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	EP.COMBUSTIVEL,
	EP."Óleo" AS OLEO,
	EP.ALIMENTOS,
	EP.GELO,
	EP.AVIST, 
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA, 
	EP.COMP_PANO, 
	EP.ALT_PANO,
	EP.N_PANOS, 
	EP.TAM_MALHA, 
	EP.OBS,
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO,
	MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5' ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO t_emalhe_has_t_pesqueiro (em_paf_id,  em_id,  paf_id)
SELECT nextval('t_emalhe_has_t_pesqueiro_em_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5') and ep.pesqueiro1 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
	SELECT nextval('t_emalhe_has_t_pesqueiro_em_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5') and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_emalhe_has_t_pesqueiro_em_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5') and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_emalhe_has_t_pesqueiro_em_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5') and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_emalhe_has_t_pesqueiro_em_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '5' OR EP.TIPOMARISCAGEM = '5') and ep.pesqueiro5 notnull
	AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO);


------> Especie Capturada    
INSERT INTO T_EMALHE_HAS_T_ESPECIE_CAPTURADA (SPC_EM_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  EM_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT EM_ID FROM T_EMALHE ORDER BY EM_ID) AS EM ON SP.COD_ENTREV = EM.EM_ID
ORDER BY SP.COD_ENTREV;


-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_EMALHE_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT EM_ID,  TP_ID_ENTREVISTADO,  EM_DHRECOLHIMENTO,  EM_SUBAMOSTRA FROM T_EMALHE WHERE EM_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.EM_DHRECOLHIMENTO );

    UPDATE T_EMALHE SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE EM_ID=R.EM_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_EMALHE_SUBAMOSTRA();

----> avistamento
INSERT INTO T_EMALHE_HAS_T_AVISTAMENTO (EM_ID, AVS_ID)
SELECT EM.EM_ID, AV.AVS_ID
FROM t_emalhe AS em
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || em.em_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY em.em_ID, AV.AVS_ID, AV.AVS_DESCRICAO;


--Não Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 5,  FD.RDEMANM,  FALSE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='5' OR EP.TIPOMARISCAGEM = '5' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.RDEMANM > 0 ORDER BY FD.COD_FICHA;



-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_emalhe_HAS_T_PESQUEIRO -t T_emalhe_HAS_T_ESPECIE_CAPTURADA -t  T_emalhe_HAS_T_AVISTAMENTO -t T_emalhe > /tmp/03_emalhe.sql

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00_monitoramento.sql



//////////////////////////////////////////////////////////////////////



-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_rede, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.Tempomariscando
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.Tp_rede)="tarrafa"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_rede, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.Tempomariscando;



---------------------------------------------------------------------------------------------
--Monitoramentos de Tarrafa
--Monitoradas

-- ------> 
-- update ACCESS.ENTREV_PESCA set TIPOMARISCAGEM = '7' where TIPOMARISCAGEM='Tarrafa';

-- UPDATE ACCESS.FICHA_DIARIA SET TARRAFA=CNT.NENTREV FROM (
-- SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7' 
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

------> Monitoramentos
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 7,  FD.TARRAFA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_REDE='7' OR EP.TIPOMARISCAGEM = '7'
    AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
ORDER BY FD.COD_FICHA;

------> TARRAFAS
INSERT INTO T_TARRAFA (
	TAR_ID,  TAR_EMBARCADO,  BAR_ID,  TTE_ID,  TP_ID_ENTREVISTADO,  TAR_QUANTPESCADORES,  TAR_DATA,  TAR_TEMPOGASTO, 
	TAR_AVISTOU,  TAR_SUBAMOSTRA,  SA_ID,  TAR_RODA,  TAR_ALTURA,  TAR_MALHA,  TAR_NUMLANCES,  TAR_OBS,  TAR_MOTOR, 
	TAR_DESTINO,  MNT_ID
) ( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI') -
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	EP.AVIST, 
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA, 
	NULL, 
	EP.ALT_PANO,
	EP.TAM_MALHA, 
	EP.N_LANCES, 
	EP.OBS,
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO, 
	MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7' ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO t_tarrafa_has_t_pesqueiro (tar_paf_id,  tar_id,  paf_id)
SELECT nextval('t_tarrafa_has_t_pesqueiro_tar_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7') and ep.pesqueiro1 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
	SELECT nextval('t_tarrafa_has_t_pesqueiro_tar_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7') and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_tarrafa_has_t_pesqueiro_tar_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7') and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_tarrafa_has_t_pesqueiro_tar_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7') and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_tarrafa_has_t_pesqueiro_tar_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TP_REDE = '7' OR EP.TIPOMARISCAGEM = '7') and ep.pesqueiro5 notnull
	AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO);

	
------> Especie Capturada    
INSERT INTO T_TARRAFA_HAS_T_ESPECIE_CAPTURADA (SPC_TAR_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  TAR_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT TAR_ID FROM T_TARRAFA ORDER BY TAR_ID) AS TAR ON SP.COD_ENTREV = TAR.TAR_ID
ORDER BY SP.COD_ENTREV;	
	
-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_TARRAFA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT TAR_ID,  TP_ID_ENTREVISTADO,  TAR_DATA,  TAR_SUBAMOSTRA FROM T_TARRAFA WHERE TAR_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.TAR_DATA );

    UPDATE T_TARRAFA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE TAR_ID=R.TAR_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_TARRAFA_SUBAMOSTRA();	

----> avistamento
INSERT INTO T_TARRAFA_HAS_T_AVISTAMENTO (TAR_ID, AVS_ID)
SELECT TAR.TAR_ID, AV.AVS_ID
FROM t_tarrafa AS tar
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || tar.tar_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY tar.tar_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

--Não Monitoradas ? ? ? ? 


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_tarrafa_HAS_T_PESQUEIRO -t T_tarrafa_HAS_T_ESPECIE_CAPTURADA -t  T_tarrafa_HAS_T_AVISTAMENTO -t T_tarrafa > /tmp/04_tarrafa.sql

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00_monitoramento.sql


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_ARRASTOFUNDO_HAS_T_PESQUEIRO -t T_ARRASTOFUNDO_HAS_T_ESPECIE_CAPTURADA -t  T_ARRASTOFUNDO_HAS_T_AVISTAMENTO -t T_ARRASTOFUNDO > /tmp/01.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_CALAO_HAS_T_PESQUEIRO -t T_CALAO_HAS_T_ESPECIE_CAPTURADA -t  T_CALAO_HAS_T_AVISTAMENTO -t T_CALAO >> /tmp/01.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_emalhe_HAS_T_PESQUEIRO -t T_emalhe_HAS_T_ESPECIE_CAPTURADA -t  T_emalhe_HAS_T_AVISTAMENTO -t T_emalhe >> /tmp/01.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_tarrafa_HAS_T_PESQUEIRO -t T_tarrafa_HAS_T_ESPECIE_CAPTURADA -t  T_tarrafa_HAS_T_AVISTAMENTO -t T_tarrafa >> /tmp/01.sql

	
/// //////////////////////////////////////////////////////////////////



-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="gereré"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;



--------------------------------------------------------------------------------------------
--Monitoramentos de Jereré
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 9,  FD.JERERE,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%'
    AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
where FD.JERERE > 0
ORDER BY FD.COD_FICHA;

-- alter table t_jerere alter column mre_id drop not null;
-- alter table t_jerere alter column jre_mreviva drop not null;

insert into t_jerere (
	jre_id, jre_embarcada,  bar_id,  tte_id,  tp_id_entrevistado,  jre_quantpescadores,  jre_dhsaida,  jre_dhvolta, 
	jre_tempogasto,  jre_avistamento, jre_subamostra,  sa_id,  jre_numarmadilhas,  jre_obs, 
	 mre_id, jre_mreviva, jre_motor,  jre_destino,  mnt_id	
) ( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(ep.tempomariscando*60, '999999')::INTERVAL, 
	EP.AVIST, 
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA, 
	ep.n_armadilhas, 
	EP.OBS,
	Null, --> mre_id
	case ep.mare when 'Viva' then TRUE else FALSE end, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO, 
	MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM like '%Gerer%' and FD.JERERE > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );


-----> Pesqueiro
INSERT INTO t_jerere_has_t_pesqueiro (jre_paf_id,  jre_id,  paf_id)
SELECT nextval('t_jerere_has_t_pesqueiro_jre_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%' and ep.pesqueiro1 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (JRE_ID) JRE_ID FROM T_JERERE ORDER BY JRE_ID)
UNION
	SELECT nextval('t_jerere_has_t_pesqueiro_jre_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%' and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (JRE_ID) JRE_ID FROM T_JERERE ORDER BY JRE_ID)
UNION
    SELECT nextval('t_jerere_has_t_pesqueiro_jre_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%' and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (JRE_ID) JRE_ID FROM T_JERERE ORDER BY JRE_ID)
UNION
    SELECT nextval('t_jerere_has_t_pesqueiro_jre_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%' and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (JRE_ID) JRE_ID FROM T_JERERE ORDER BY JRE_ID)
UNION
    SELECT nextval('t_jerere_has_t_pesqueiro_jre_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Gerer%' and ep.pesqueiro5 notnull
	AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
  AND EP.CODIGO IN (SELECT DISTINCT ON (JRE_ID) JRE_ID FROM T_JERERE ORDER BY JRE_ID);


------> Especie Capturada    
INSERT INTO T_JERERE_HAS_T_ESPECIE_CAPTURADA (SPC_JRE_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  JRE_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT JRE_ID FROM T_JERERE ORDER BY JRE_ID) AS JRE ON SP.COD_ENTREV = JRE.JRE_ID
ORDER BY SP.COD_ENTREV;	


-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_JERERE_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT JRE_ID,  TP_ID_ENTREVISTADO,  JRE_DHVOLTA,  JRE_SUBAMOSTRA FROM T_JERERE WHERE JRE_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.JRE_DHVOLTA );

    UPDATE T_JERERE SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE JRE_ID=R.JRE_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_JERERE_SUBAMOSTRA();	



----> avistamento
INSERT INTO T_JERERE_HAS_T_AVISTAMENTO (JRE_ID, AVS_ID)
SELECT JRE.JRE_ID, AV.AVS_ID
FROM t_jerere AS jre
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || jre.jre_AVIStamento || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY jre.jre_ID, AV.AVS_ID, AV.AVS_DESCRICAO;


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_JERERE_HAS_T_PESQUEIRO -t T_JERERE_HAS_T_ESPECIE_CAPTURADA -t  T_JERERE_HAS_T_AVISTAMENTO -t T_JERERE > /tmp/01.sql





/// ////////////////////////////////////////////////////////////////// ---> Linha Mão

-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_pesca, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.Tp_pesca)="linha de mão"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_pesca, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc;


--Monitoramentos de Linha de mâo

-- UPDATE ACCESS.FICHA_DIARIA SET LINHAMAO=CNT.NENTREV FROM (
-- SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' 
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.LINHAMAO,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' 
    AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.LINHAMAO > 0
ORDER BY FD.COD_FICHA;


-- -- Necessário para tirar a arte de pesca "Mariscagem"
-- UPDATE t_monitoramento
--    SET mnt_arte=4
--  WHERE mnt_arte=15;

-- alter table T_LINHA alter column ISC_ID drop not null;

INSERT INTO T_LINHA (
	LIN_ID,  LIN_EMBARCADA,  BAR_ID,  TTE_ID, TP_ID_ENTREVISTADO,  LIN_NUMPESCADORES,  LIN_DHSAIDA,  LIN_DHVOLTA, 
	LIN_DIESEL,  LIN_OLEO,  LIN_ALIMENTO,  LIN_GELO,  LIN_NUMLINHAS,  LIN_NUMANZOISPLINHA, ISC_ID,
	LIN_AVISTOU,  LIN_SUBAMOSTRA,  SA_ID, LIN_MOTOR,  LIN_OBS,  LIN_DESTINO, MNT_ID
) ( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	EP.COMBUSTIVEL,
	EP."Óleo", 
	EP.ALIMENTOS, 
	EP.GELO,  
	EP.N_LINHAS, 
	EP.N_ANZOIS, 
	CAST (EP.ISCA AS INT4), 
	EP.AVIST, 
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.OBS,
	EP.DESTINO 
	,MNT.MNT_ID
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TP_PESCA='4' ORDER BY EP.CODIGO,  FD.COD_FICHA );


-----> Pesqueiro
INSERT INTO t_linha_has_t_pesqueiro (lin_paf_id,  lin_id,  paf_id,  t_tempoapesqueiro)
SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(ep.tempoatepesq*60, '999999')::INTERVAL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' and ep.pesqueiro1 notnull and ep.pesqueiro1<>'31'
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (LIN_ID) LIN_ID FROM T_LINHA ORDER BY LIN_ID)
UNION
	SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (LIN_ID) LIN_ID FROM T_LINHA ORDER BY LIN_ID)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (LIN_ID) LIN_ID FROM T_LINHA ORDER BY LIN_ID)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'),EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (LIN_ID) LIN_ID FROM T_LINHA ORDER BY LIN_ID)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'),EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' and ep.pesqueiro5 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (LIN_ID) LIN_ID FROM T_LINHA ORDER BY LIN_ID);  
  
------> Especie Capturada    
INSERT INTO T_LINHA_HAS_T_ESPECIE_CAPTURADA (SPC_LIN_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  LIN_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT LIN_ID FROM T_LINHA ORDER BY LIN_ID) AS LIN ON SP.COD_ENTREV = LIN.LIN_ID
WHERE COD_SP<>4692
ORDER BY SP.COD_ENTREV;

-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_LINHA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT LIN_ID,  TP_ID_ENTREVISTADO,  LIN_DHVOLTA,  LIN_SUBAMOSTRA FROM T_LINHA WHERE LIN_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.LIN_DHVOLTA );

    UPDATE T_LINHA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE LIN_ID = R.LIN_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_LINHA_SUBAMOSTRA();

----> avistamento
INSERT INTO T_LINHA_HAS_T_AVISTAMENTO (LIN_ID, AVS_ID)
SELECT lin.lin_ID, AV.AVS_ID
FROM t_linha AS lin
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || lin.LIN_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY lin.lin_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

 
 --Não Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), CAST(EP.ARTE AS INT4),  FD.LINHAMAONM,  FALSE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='4' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.LINHAMAONM > 0 ORDER BY FD.COD_FICHA;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_LINHA_HAS_T_PESQUEIRO -t T_LINHA_HAS_T_ESPECIE_CAPTURADA -t  T_LINHA_HAS_T_AVISTAMENTO -t T_LINHA > /tmp/01.sql


 /// ////////////////////////////////////////////////////////////////// ---> GROSSEIRA
-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_pesca, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc, Entrev_Pesca.n_anzois
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha]=Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código=[Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código=Sp_cap.Cod_entrev) ON Espécies.Código=Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.Tp_pesca)="grosseira"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.Tp_pesca, Entrev_Pesca.Tp_barco, Entrev_Pesca.Barco, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.DataChegada, Entrev_Pesca.DataSaída, Entrev_Pesca.n_pesc, Entrev_Pesca.n_anzois;


--------------------------------------------------------------------------------------------
--Monitoramentos de Grosseira
-- UPDATE ACCESS.FICHA_DIARIA SET GROS=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' 
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 3,  FD.GROS,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' 
--     AND EP.COD_FICHADIARIA NOT IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO) ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.GROS > 0
ORDER BY FD.COD_FICHA;

INSERT INTO T_GROSSEIRA (
	GRS_ID,  GRS_EMBARCADA, BAR_ID, TTE_ID, TP_ID_ENTREVISTADO, GRS_NUMPESCADORES,  GRS_DHSAIDA,  GRS_DHVOLTA, 
	GRS_DIESEL,  GRS_OLEO,  GRS_ALIMENTO,  GRS_GELO,  GRS_AVISTOU,  GRS_NUMLINHAS,  GRS_NUMANZOISPLINHA,  
	GRS_SUBAMOSTRA,  SA_ID,  ISC_ID,  GRS_OBS, MNT_ID,  GRS_MOTOR, GRS_DESTINO
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4), 
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	
	EP.COMBUSTIVEL,
	EP."Óleo", 
	EP.ALIMENTOS, 
	EP.GELO,  
	EP.AVIST,
	EP.N_LINHAS, 
	EP.N_ANZOIS, 
	
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA, 
	CAST (EP.ISCA AS INT4), 
	EP.OBS
	,MNT.MNT_ID, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TP_PESCA='3' ORDER BY EP.CODIGO,  FD.COD_FICHA );

INSERT INTO t_grosseira_has_t_pesqueiro (grs_paf_id,  grs_id,  paf_id,  t_tempoapesqueiro)
SELECT nextval('t_grosseira_has_t_pesqueiro_grs_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(ep.tempoatepesq*60, '999999')::INTERVAL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' and ep.pesqueiro1 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
	SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'),EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
UNION
    SELECT nextval('t_linha_has_t_pesqueiro_lin_paf_id_seq'),EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO,  NULL
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' and ep.pesqueiro5 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO);
    
------> Especie Capturada    
INSERT INTO T_Grosseira_HAS_T_ESPECIE_CAPTURADA (SPC_grs_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  grs_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT GRS_ID FROM T_GROSSEIRA ORDER BY GRS_ID) AS GRS ON SP.COD_ENTREV = GRS.GRS_ID
ORDER BY SP.COD_ENTREV;

-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_GROSSEIRA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT GRS_ID, TP_ID_ENTREVISTADO, GRS_DHVOLTA, GRS_SUBAMOSTRA FROM T_GROSSEIRA WHERE GRS_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.GRS_DHVOLTA );

    UPDATE T_GROSSEIRA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE GRS_ID = R.GRS_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_GROSSEIRA_SUBAMOSTRA();


----> avistamento
INSERT INTO T_GROSSEIRA_HAS_T_AVISTAMENTO (grs_ID, AVS_ID)
SELECT grs.grs_ID, AV.AVS_ID
FROM t_grosseira AS grs
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || grs.grs_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY grs.grs_ID, AV.AVS_ID, AV.AVS_DESCRICAO;


--Não Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 3,  FD.GROSNM,  FALSE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TP_PESCA='3' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE FD.GROSNM > 0 ORDER BY FD.COD_FICHA;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_GROSSEIRA_HAS_T_PESQUEIRO -t T_GROSSEIRA_HAS_T_ESPECIE_CAPTURADA -t  T_GROSSEIRA_HAS_T_AVISTAMENTO -t T_GROSSEIRA > /tmp/01.sql



///////////////////////////////////////////////////////////////////// --> Vara de Pesca
-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="vara de pesca"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc;

-- Vara pesca

--------------------------------------------------------------------------------------------
--Monitoramentos de Vara de Pesca




-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' group by EP.TIPOMARISCAGEM;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET VARA_DE_PESCA=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' 
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

--alter table T_varapesca alter column mre_id drop not null;

--------------> Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 8,  FD.VARA_DE_PESCA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE  FD.VARA_DE_PESCA > 0
ORDER BY FD.COD_FICHA;

INSERT INTO T_VARAPESCA (
	VP_ID, VP_EMBARCADA, BAR_ID, TTE_ID, TP_ID_ENTREVISTADO, VP_QUANTPESCADORES, VP_DHSAIDA, VP_DHVOLTA, VP_TEMPOGASTO, 
	VP_DIESEL, VP_OLEO, VP_ALIMENTO, VP_GELO, VP_AVISTAMENTO, VP_SUBAMOSTRA, SA_ID, VP_NUMANZOISPLINHA, VP_NUMLINHAS, 
	ISC_ID, VP_OBS, MNT_ID, MRE_ID, VP_MREVIVA, VP_MOTOR, VP_DESTINO
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.COMBUSTIVEL,
	EP."Óleo", 
	EP.ALIMENTOS, 
	EP.GELO,  
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	EP.N_ANZOIS, 
	EP.N_LINHAS, 
	
	CAST (EP.ISCA AS INT4),
	EP.OBS,
	MNT.MNT_ID, 
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM LIKE '%Vara%' AND FD.VARA_DE_PESCA > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO t_varapesca_has_t_pesqueiro (vp_paf_id, vp_id, paf_id,  t_tempoapesqueiro,  t_distapesqueiro)
SELECT nextval('t_varapesca_has_t_pesqueiro_vp_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(ep.tempoatepesq*60, '999999')::INTERVAL,  distmarisco
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' and ep.pesqueiro1 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (VP_ID) VP_ID FROM T_VARAPESCA ORDER BY VP_ID)
UNION
SELECT nextval('t_varapesca_has_t_pesqueiro_vp_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO2 AS INT8) AS PESQUEIRO,  null,  null
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' and ep.pesqueiro2 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (VP_ID) VP_ID FROM T_VARAPESCA ORDER BY VP_ID)
UNION
SELECT nextval('t_varapesca_has_t_pesqueiro_vp_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO3 AS INT8) AS PESQUEIRO,  null,  null
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' and ep.pesqueiro3 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (VP_ID) VP_ID FROM T_VARAPESCA ORDER BY VP_ID)
UNION
SELECT nextval('t_varapesca_has_t_pesqueiro_vp_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO4 AS INT8) AS PESQUEIRO,  null,  null
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' and ep.pesqueiro4 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (VP_ID) VP_ID FROM T_VARAPESCA ORDER BY VP_ID)
UNION
SELECT nextval('t_varapesca_has_t_pesqueiro_vp_paf_id_seq'),  EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO5 AS INT8) AS PESQUEIRO,  null,  null
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Vara%' and ep.pesqueiro5 notnull
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (VP_ID) VP_ID FROM T_VARAPESCA ORDER BY VP_ID)

------> Especie Capturada    
INSERT INTO T_VARAPESCA_HAS_T_ESPECIE_CAPTURADA (SPC_VP_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  VP_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT VP_ID FROM T_VARAPESCA ORDER BY VP_ID) AS VP ON SP.COD_ENTREV = VP.VP_ID
ORDER BY SP.COD_ENTREV;


-----> SUBAMOSTRA
CREATE OR REPLACE FUNCTION IMPORT_VARAPESCA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT VP_ID, TP_ID_ENTREVISTADO, VP_DHVOLTA, VP_SUBAMOSTRA FROM T_VARAPESCA WHERE VP_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.VP_DHVOLTA );

    UPDATE T_VARAPESCA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE VP_ID = R.VP_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_VARAPESCA_SUBAMOSTRA();


----> avistamento
INSERT INTO T_VARAPESCA_HAS_T_AVISTAMENTO (vp_ID, AVS_ID)
SELECT vp.vp_ID, AV.AVS_ID
FROM t_varapesca AS vp
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || vp.VP_AVISTAMENTO || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY vp.vp_ID, AV.AVS_ID, AV.AVS_DESCRICAO;


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_varapesca_HAS_T_PESQUEIRO -t T_varapesca_HAS_T_ESPECIE_CAPTURADA -t  T_varapesca_HAS_T_AVISTAMENTO -t T_varapesca > /tmp/01.sql



/// //////////////////////////////////////////////////////////////////

-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="mergulho"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;

-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Mergulho%' group by EP.TIPOMARISCAGEM;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET MERGULHO=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Mergulho%' 
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

--alter table T_mergulho alter column bar_id drop not null;
--alter table T_mergulho alter column tte_id drop not null;

--------------------------------------------------------------------------------------------
--Monitoramentos de Mergulho
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 14,  FD.MERGULHO,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Mergulho%' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE  FD.MERGULHO > 0 ORDER BY FD.COD_FICHA;


INSERT INTO T_mergulho (
	mer_id, mer_embarcada, bar_id, tte_id, tp_id_entrevistado, mer_quantpescadores, mer_dhsaida, mer_dhvolta, mer_tempogasto, 
	mer_avistou, mer_subamostra, sa_id, mnt_id, mer_obs, mre_id, mer_mreviva, mer_motor, mer_destino
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	EP.MESTRE,
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	MNT.MNT_ID, 
	EP.OBS,
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM like '%Mergulho%' AND FD.MERGULHO > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );


-----> Pesqueiro
INSERT INTO T_MERGULHO_HAS_T_PESQUEIRO (MER_PAF_ID, MER_ID, PAF_ID,  T_TEMPOAPESQUEIRO,  T_DISTAPESQUEIRO)
SELECT NEXTVAL('T_MERGULHO_HAS_T_PESQUEIRO_MER_PAF_ID_SEQ'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(EP.TEMPOATEPESQ*60, '999999')::INTERVAL,  DISTMARISCO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM LIKE '%Mergulho%' AND EP.PESQUEIRO1 NOTNULL
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (MER_ID) MER_ID FROM T_MERGULHO ORDER BY MER_ID);

------> Especie Capturada    
INSERT INTO T_MERGULHO_HAS_T_ESPECIE_CAPTURADA (SPC_MER_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  MER_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT MER_ID FROM T_MERGULHO ORDER BY MER_ID) AS MER ON SP.COD_ENTREV = MER.MER_ID
ORDER BY SP.COD_ENTREV;

------> subamostra
CREATE OR REPLACE FUNCTION IMPORT_MERGULHO_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT MER_ID, TP_ID_ENTREVISTADO, MER_DHVOLTA, MER_SUBAMOSTRA FROM T_MERGULHO WHERE MER_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.MER_DHVOLTA );

    UPDATE T_MERGULHO SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE MER_ID = R.MER_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_MERGULHO_SUBAMOSTRA();

----> AVISTAMENTO
INSERT INTO T_MERGULHO_HAS_T_AVISTAMENTO (MER_ID, AVS_ID)
SELECT MER.MER_ID, AV.AVS_ID
FROM T_MERGULHO AS MER
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || MER.MER_AVISTOU || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY MER.MER_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t t_mergulho_HAS_T_PESQUEIRO -t t_mergulho_HAS_T_ESPECIE_CAPTURADA -t  t_mergulho_HAS_T_AVISTAMENTO -t t_mergulho > /tmp/01.sql

/// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////


-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="manzuá"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, [Ficha diária].Data, Entrev_Pesca.Pesqueiro1, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;

-- alter table T_manzua alter column  mre_id drop not null;

-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP group by EP.TIPOMARISCAGEM;
-- 
-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Manzu%' OR EP.TIPOMARISCAGEM = '11' group by EP.TIPOMARISCAGEM;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET MANZUA=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Manzu%' OR EP.TIPOMARISCAGEM = '11'
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

--------------------------------------------------------------------------------------------
--Monitoramentos de Manzua
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 11,  FD.MANZUA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE  EP.TIPOMARISCAGEM like '%Manzu%' OR EP.TIPOMARISCAGEM = '11' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE  FD.MANZUA > 0 ORDER BY FD.COD_FICHA;

INSERT INTO T_manzua (
	man_id, man_embarcada, bar_id, tte_id, tp_id_entrevistado, man_quantpescadores, man_dhsaida, man_dhvolta, man_tempogasto, 
	man_avistamento, man_subamostra, sa_id, man_numarmadilhas, man_obs, mnt_id, mre_id, man_mreviva, man_motor, man_destino
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	case EP.MESTRE when 131 then null else ep.mestre end, 
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	ep.n_armadilhas, 
	EP.OBS,
	MNT.MNT_ID,
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE (EP.TIPOMARISCAGEM like '%Manzu%' OR EP.TIPOMARISCAGEM = '11') AND FD.MANZUA > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO T_MANZUA_HAS_T_PESQUEIRO (MAN_PAF_ID, MAN_ID, PAF_ID,  T_TEMPOAPESQUEIRO,  T_DISTAPESQUEIRO)
SELECT NEXTVAL('T_MANZUA_HAS_T_PESQUEIRO_MAN_PAF_ID_SEQ'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(EP.TEMPOATEPESQ*60, '999999')::INTERVAL,  DISTMARISCO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE (EP.TIPOMARISCAGEM like '%Manzu%' OR EP.TIPOMARISCAGEM = '11') AND EP.PESQUEIRO1 NOTNULL
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (MAN_ID) MAN_ID FROM T_MANZUA ORDER BY MAN_ID);


    ------> Especie Capturada    
INSERT INTO T_MANZUA_HAS_T_ESPECIE_CAPTURADA (SPC_MAN_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  MAN_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT MAN_ID FROM T_MANZUA ORDER BY MAN_ID) AS MAN ON SP.COD_ENTREV = MAN.MAN_ID
ORDER BY SP.COD_ENTREV;


------> subamostra
CREATE OR REPLACE FUNCTION IMPORT_MANZUA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT MAN_ID, TP_ID_ENTREVISTADO, MAN_DHVOLTA, MAN_SUBAMOSTRA FROM T_MANZUA WHERE MAN_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.MAN_DHVOLTA );

    UPDATE T_MANZUA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE MAN_ID = R.MAN_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_MANZUA_SUBAMOSTRA();

----> AVISTAMENTO
INSERT INTO T_MANZUA_HAS_T_AVISTAMENTO (MAN_ID, AVS_ID)
SELECT MAN.MAN_ID, AV.AVS_ID
FROM T_MANZUA AS MAN
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || MAN.MAN_AVISTAMENTO || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY MAN.MAN_ID, AV.AVS_ID, AV.AVS_DESCRICAO;


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t t_manzua_HAS_T_PESQUEIRO -t t_manzua_HAS_T_ESPECIE_CAPTURADA -t  t_manzua_HAS_T_AVISTAMENTO -t t_manzua > /tmp/01.sql

/// //////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////

-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="ratoeira"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;


-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP group by EP.TIPOMARISCAGEM;
-- 
-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Ratoeira%' group by EP.TIPOMARISCAGEM;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET RATOEIRA=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE TIPOMARISCAGEM like '%Ratoeira%'
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

-- alter table T_ratoeira alter column  mre_id drop not null;

--------------------------------------------------------------------------------------------
--Monitoramentos de Ratoeira
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 12,  FD.RATOEIRA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Ratoeira%' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE  FD.RATOEIRA > 0 ORDER BY FD.COD_FICHA;


INSERT INTO T_ratoeira (
	rat_id, rat_embarcada, bar_id, tte_id, tp_id_entrevistado, rat_quantpescadores, rat_dhsaida, rat_dhvolta, rat_tempogasto, 
	rat_avistamento, rat_subamostra, sa_id, rat_numarmadilhas, rat_obs, mnt_id, mre_id, rat_mreviva, rat_motor, rat_destino
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	ep.mestre, 
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	ep.n_armadilhas, 
	EP.OBS,
	MNT.MNT_ID,
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM like '%Ratoeira%' AND FD.RATOEIRA > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO T_ratoeira_HAS_T_PESQUEIRO (rat_PAF_ID, rat_ID, PAF_ID,  T_TEMPOAPESQUEIRO,  T_DISTAPESQUEIRO)
SELECT NEXTVAL('t_ratoeira_has_t_pesqueiro_rat_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(EP.TEMPOATEPESQ*60, '999999')::INTERVAL,  DISTMARISCO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Ratoeira%' AND EP.PESQUEIRO1 NOTNULL
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (rat_ID) rat_ID FROM T_ratoeira ORDER BY rat_ID);

    ------> Especie Capturada    
INSERT INTO T_ratoeira_HAS_T_ESPECIE_CAPTURADA (SPC_rat_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  rat_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT RAT_ID FROM T_RATOEIRA ORDER BY RAT_ID) AS RAT ON SP.COD_ENTREV = RAT.RAT_ID
ORDER BY SP.COD_ENTREV;    

------> subamostra
CREATE OR REPLACE FUNCTION IMPORT_RATOEIRA_SUBAMOSTRA() RETURNS INT4 AS $$
DECLARE R RECORD;
DECLARE RET INT4;
BEGIN
FOR R IN SELECT RAT_ID, TP_ID_ENTREVISTADO, RAT_DHVOLTA, RAT_SUBAMOSTRA FROM T_RATOEIRA WHERE RAT_SUBAMOSTRA=TRUE
LOOP
    INSERT INTO T_SUBAMOSTRA (SA_ID,  SA_PESCADOR,  SA_DATACHEGADA )
        VALUES (NEXTVAL('T_SUBAMOSTRA_SA_ID_SEQ'), R.TP_ID_ENTREVISTADO, R.RAT_DHVOLTA );

    UPDATE T_RATOEIRA SET SA_ID = CURRVAL('T_SUBAMOSTRA_SA_ID_SEQ') WHERE RAT_ID = R.RAT_ID;

END LOOP;
RETURN RET;
END;
$$ LANGUAGE PLPGSQL;

SELECT IMPORT_RATOEIRA_SUBAMOSTRA();

----> AVISTAMENTO
INSERT INTO T_RATOEIRA_HAS_T_AVISTAMENTO (RAT_ID, AVS_ID)
SELECT RAT.RAT_ID, AV.AVS_ID
FROM T_RATOEIRA AS RAT
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || RAT.rat_avistamento || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY RAT.RAT_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t t_ratoeira_HAS_T_PESQUEIRO -t t_ratoeira_HAS_T_ESPECIE_CAPTURADA -t  t_ratoeira_HAS_T_AVISTAMENTO -t t_ratoeira > /tmp/01.sql


/// //////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="ciripóia"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;

-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP group by EP.TIPOMARISCAGEM;
-- 
-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Cirip%' group by EP.TIPOMARISCAGEM;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET CIRIPOIA=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE TIPOMARISCAGEM like '%Cirip%'
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

-- alter table T_siripoia alter column  mre_id drop not null;


-- UPDATE access.entrev_pesca
--    SET tipomariscagem=7
--  WHERE tipomariscagem='Tarrafa';

--------------------------------------------------------------------------------------------
--Monitoramentos de Siripóia
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 10,  FD.CIRIPOIA,  TRUE, FD.COD_FICHA
FROM ACCESS.FICHA_DIARIA AS FD
INNER JOIN (
    SELECT DISTINCT ON (EP.COD_FICHADIARIA) COD_FICHADIARIA,  EP.ARTE, EP.CODIGO 
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%Cirip%' ORDER BY EP.COD_FICHADIARIA
) AS EP ON EP.COD_FICHADIARIA = FD.COD_FICHA
WHERE  FD.CIRIPOIA > 0 ORDER BY FD.COD_FICHA;

INSERT INTO T_siripoia (
	sir_id, sir_embarcada, bar_id, tte_id, tp_id_entrevistado, sir_quantpescadores, sir_dhsaida, sir_dhvolta, sir_tempogasto, 
	sir_avistamento, sir_subamostra, sa_id, sir_numarmadilhas, sir_obs, mnt_id, mre_id, sir_mreviva, sir_motor, sir_destino
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	ep.mestre, 
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	ep.n_armadilhas, 
	EP.OBS,
	MNT.MNT_ID,
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM like '%Cirip%' AND FD.CIRIPOIA > 0 ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO T_siripoia_HAS_T_PESQUEIRO (sir_PAF_ID, sir_ID, PAF_ID,  T_TEMPOAPESQUEIRO,  T_DISTAPESQUEIRO)
SELECT NEXTVAL('t_siripoia_has_t_pesqueiro_sir_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(EP.TEMPOATEPESQ*60, '999999')::INTERVAL,  DISTMARISCO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like'%Cirip%' AND EP.PESQUEIRO1 NOTNULL
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (sir_ID) sir_ID FROM T_siripoia ORDER BY sir_ID);

    
        ------> Especie Capturada    
INSERT INTO T_siripoia_HAS_T_ESPECIE_CAPTURADA (SPC_sir_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  sir_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT SIR_ID FROM T_siripoia ORDER BY sir_ID) AS sir ON SP.COD_ENTREV = sir.sir_ID
ORDER BY SP.COD_ENTREV; 

------> subamostra Nenhuma

----> AVISTAMENTO Nenhuma
INSERT INTO T_SIRIPOIA_HAS_T_AVISTAMENTO (SIR_ID, AVS_ID)
SELECT SIR.SIR_ID, AV.AVS_ID
FROM T_siripoia AS sir
    INNER JOIN T_AVISTAMENTO AS AV ON(';' || sir.sir_avistamento || ';' LIKE '%;' || AV.AVS_DESCRICAO || ';%')
ORDER BY sir.sir_ID, AV.AVS_ID, AV.AVS_DESCRICAO;

-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t t_siripoia_HAS_T_PESQUEIRO -t t_siripoia_HAS_T_ESPECIE_CAPTURADA -t  t_siripoia_HAS_T_AVISTAMENTO -t t_siripoia > /tmp/01.sql


---------------------------------------------------------------------------------------------

/// //////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////
-- SELECT Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas
-- FROM Espécies INNER JOIN ((PortoDesemb INNER JOIN ([Ficha diária] INNER JOIN Entrev_Pesca ON [Ficha diária].[Cod Ficha] = Entrev_Pesca.Cod_fichadiaria) ON PortoDesemb.Código = [Ficha diária].[Porto de Desembarque]) INNER JOIN Sp_cap ON Entrev_Pesca.Código = Sp_cap.Cod_entrev) ON Espécies.Código = Sp_cap.Cod_sp
-- WHERE (((Entrev_Pesca.TipoMariscagem)="ciripóia"))
-- GROUP BY Entrev_Pesca.Código, PortoDesemb.PDesmb, Entrev_Pesca.TipoMariscagem, Entrev_Pesca.Mestre, Entrev_Pesca.Pesqueiro1, [Ficha diária].Data, Entrev_Pesca.n_pesc, Entrev_Pesca.n_armadilhas;

-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP group by EP.TIPOMARISCAGEM;
-- 
-- select count (*),  EP.TIPOMARISCAGEM from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%anual%' group by EP.TIPOMARISCAGEM;
-- 

-- select * from ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%anual%' order by ep.codigo;
-- 
-- UPDATE ACCESS.FICHA_DIARIA SET CIRIPOIA=CNT.NENTREV FROM 
-- ( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE TIPOMARISCAGEM like '%anual%'
-- GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT
-- WHERE COD_FICHA=CNT.COD_FICHADIARIA;

-- alter table T_COLETAMANUAL alter column  mre_id drop not null;

--------------------------------------------------------------------------------------------
--Monitoramentos de Manual
--Monitoradas
INSERT INTO T_MONITORAMENTO (MNT_ID,  MNT_ARTE, MNT_QUANTIDADE, MNT_MONITORADO,  FD_ID)
SELECT NEXTVAL('T_MONITORAMENTO_MNT_ID_SEQ'), 13,  CNT.NENTREV,  TRUE, cnt.COD_FICHADIARIA from 
( SELECT COUNT(*) NENTREV,  EP.COD_FICHADIARIA FROM ACCESS.ENTREV_PESCA AS EP WHERE TIPOMARISCAGEM like '%anual%'
GROUP BY EP.COD_FICHADIARIA ORDER BY EP.COD_FICHADIARIA ) AS CNT order by cnt.COD_FICHADIARIA;

INSERT INTO  T_COLETAMANUAL (
	cml_id, cml_embarcada, bar_id, tte_id, tp_id_entrevistado, cml_quantpescadores, cml_dhsaida, cml_dhvolta, cml_tempogasto, 
	cml_avistamento, cml_subamostra, sa_id, cml_obs, mnt_id, mre_id, cml_mreviva, cml_motor, cml_destino
)( SELECT
	DISTINCT ON (EP.CODIGO) CODIGO,
	CASE (COALESCE(LEFT(TP_BARCO, 1), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END,
	CAST(EP.BARCO AS INT4),
	CASE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) WHEN 0 THEN NULL ELSE CAST(LEFT(EP.TP_BARCO,  1) AS INT4) END AS TP_BARCO,
	ep.mestre, 
	EP.N_PESC,
	TO_TIMESTAMP((EP.DATASAIDA ||' '|| TO_CHAR(EP.HORASAIDA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_TIMESTAMP((EP.DATACHEGADA ||' '|| TO_CHAR(EP.HORACHEGADA, 'HH24:MI') ),  'DD-MM-YYYY HH24:MI'),
	TO_CHAR(EP.TEMPOMARISCANDO*60, '999999')::INTERVAL,
	
	EP.AVIST,
	CASE EP.SUBAMOSTRA WHEN 0 THEN FALSE ELSE TRUE END AS SUBAMOSTRA,
	NULL AS ID_SUBAMOSTRA,
	EP.OBS,
	MNT.MNT_ID,
	NULL AS MRE_ID, --> MRE_ID
	CASE EP.MARE WHEN 'Viva' THEN TRUE ELSE FALSE END, 
	CASE (COALESCE(SUBSTRING(EP.TP_BARCO,  8, 8), 'FALSE')) WHEN 'FALSE' THEN FALSE ELSE TRUE END AS MOTOR,
	EP.DESTINO
	
FROM ACCESS.ENTREV_PESCA AS EP
INNER JOIN ACCESS.FICHA_DIARIA AS FD ON EP.COD_FICHADIARIA = FD.COD_FICHA
INNER JOIN T_MONITORAMENTO AS MNT ON EP.COD_FICHADIARIA = MNT.FD_ID
WHERE EP.TIPOMARISCAGEM like '%anual%' ORDER BY EP.CODIGO,  FD.COD_FICHA );

-----> Pesqueiro
INSERT INTO T_coletamanual_HAS_T_PESQUEIRO (cml_PAF_ID, cml_ID, PAF_ID,  T_TEMPOAPESQUEIRO,  T_DISTAPESQUEIRO)
SELECT NEXTVAL('t_coletamanual_has_t_pesqueiro_cml_paf_id_seq'), EP.CODIGO AS CODIGO, CAST(EP.PESQUEIRO1 AS INT8) AS PESQUEIRO,  TO_CHAR(EP.TEMPOATEPESQ*60, '999999')::INTERVAL,  DISTMARISCO
    FROM ACCESS.ENTREV_PESCA AS EP WHERE EP.TIPOMARISCAGEM like '%anual%' AND EP.PESQUEIRO1 NOTNULL
    AND EP.COD_FICHADIARIA IN (SELECT DISTINCT ON (FD_ID) FD_ID FROM T_MONITORAMENTO)
    AND EP.CODIGO IN (SELECT DISTINCT ON (cml_id) cml_id FROM T_COLETAMANUAL ORDER BY cml_id);

    
        ------> Especie Capturada    
INSERT INTO T_coletamanual_HAS_T_ESPECIE_CAPTURADA (SPC_cml_ID,  SPC_QUANTIDADE,  SPC_PESO_KG,  SPC_PRECO,  ESP_ID,  cml_ID)
SELECT CODIGO, QUANTIDADE,  CAST(PESO_KG AS FLOAT ) ,  CAST (VALOR_KG AS FLOAT ),  COD_SP,  COD_ENTREV  FROM ACCESS.SP_CAP AS SP
INNER JOIN (SELECT cml_id FROM T_COLETAMANUAL ORDER BY cml_id) AS cml ON SP.COD_ENTREV = cml.cml_id
ORDER BY SP.COD_ENTREV; 

------> subamostra Nenhuma

----> AVISTAMENTO Nenhuma


-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_MONITORAMENTO -t T_SUBAMOSTRA > /tmp/00.sql
-- pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_COLETAMANUAL_HAS_T_PESQUEIRO -t T_COLETAMANUAL_HAS_T_ESPECIE_CAPTURADA -t  T_COLETAMANUAL_HAS_T_AVISTAMENTO -t T_COLETAMANUAL > /tmp/01.sql


---------------------------------------------------------------------------------------------

-----------------> Linha de fundo Vazio.


------> destino do pescado
select destino from access.entrev_pesca group by destino order by destino;  