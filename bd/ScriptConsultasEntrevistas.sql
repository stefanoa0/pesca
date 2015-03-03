--Quantidade total de dias
Select distinct fd_data from t_ficha_diaria order by fd_data;
--Quantidade de dias por porto
Select distinct count(t_ficha_diaria.fd_data), t_porto.pto_nome from t_ficha_diaria 
Inner join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id group by t_porto.pto_nome order by t_porto.pto_nome;

Select distinct t_ficha_diaria.fd_data, t_porto.pto_nome from t_ficha_diaria 
Inner Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id order by t_ficha_diaria.fd_data;

--Quantidade de entrevistas por arte de pesca
Select count(af_id) from t_arrastofundo;
Select count(cal_id) from t_calao;
Select count(cml_id) from t_coletamanual;
Select count(em_id) from t_emalhe;
Select count(grs_id) from t_grosseira;
Select count(jre_id) from t_jerere;
Select count(lin_id) from t_linha;
Select count(lf_id) from t_linhafundo;
Select count(man_id) from t_manzua;
Select count(mer_id) from t_mergulho;
Select count(rat_id) from t_ratoeira;
Select count(sir_id) from t_siripoia;
Select count(tar_id) from t_tarrafa;
Select count(vp_id) from t_varapesca;

--Quantidade de monitoramentos total
Select sum(mnt_quantidade) From t_monitoramento Where mnt_monitorado = TRUE;

--Quantidade de monitoramentos não monitorados total
Select sum(mnt_quantidade) From t_monitoramento Where mnt_monitorado = FALSE;

--Quantidade de Subamostras
Select count(sa_id) From t_subamostra;

--Quantidade de entrevistas por porto
Create or Replace View v_consultas_padrao As
Select 'Arrasto de Fundo' as consulta,count(t_arrastofundo.af_id) as quantidade, t_porto.pto_nome, null From t_arrastofundo 
Inner Join t_monitoramento on t_arrastofundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL

Select 'Calão',count(t_calao.cal_id), t_porto.pto_nome, null From t_calao 
Inner Join t_monitoramento on t_calao.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Coleta Manual',count(t_coletamanual.cml_id), t_porto.pto_nome, null From t_coletamanual 
Inner Join t_monitoramento on t_coletamanual.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Emalhe',count(t_emalhe.em_id), t_porto.pto_nome, null From t_emalhe 
Inner Join t_monitoramento on t_emalhe.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Grosseira',count(t_grosseira.grs_id), t_porto.pto_nome, null From t_grosseira
Inner Join t_monitoramento on t_grosseira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Jereré',count(t_jerere.jre_id), t_porto.pto_nome, null From t_jerere
Inner Join t_monitoramento on t_jerere.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Linha',count(t_linha.lin_id), t_porto.pto_nome, null From t_linha
Inner Join t_monitoramento on t_linha.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome 
Union ALL
Select 'Linha de Fundo',count(t_linhafundo.lf_id), t_porto.pto_nome, null From t_linhafundo
Inner Join t_monitoramento on t_linhafundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome 
Union ALL
Select 'Manzuá',count(t_manzua.man_id), t_porto.pto_nome, null From t_manzua
Inner Join t_monitoramento on t_manzua.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Mergulho',count(t_mergulho.mer_id), t_porto.pto_nome, null From t_mergulho
Inner Join t_monitoramento on t_mergulho.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Ratoeira',count(t_ratoeira.rat_id), t_porto.pto_nome, null From t_ratoeira
Inner Join t_monitoramento on t_ratoeira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Siripóia',count(t_siripoia.sir_id), t_porto.pto_nome, null From t_siripoia
Inner Join t_monitoramento on t_siripoia.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Tarrafa',count(t_tarrafa.tar_id), t_porto.pto_nome, null From t_tarrafa
Inner Join t_monitoramento on t_tarrafa.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union ALL
Select 'Vara de Pesca',count(t_varapesca.vp_id), t_porto.pto_nome, null From t_varapesca
Inner Join t_monitoramento on t_varapesca.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome
Union All
Select 'Monitoradas',sum(mnt_quantidade), NULL, null From t_monitoramento Where mnt_monitorado = TRUE
Union All
--Quantidade de monitoramentos não monitorados total
Select 'Não monitorados',sum(mnt_quantidade), NULL, null From t_monitoramento Where mnt_monitorado = FALSE
Union All
--Quantidade de Subamostras
Select 'Subamostras',count(sa_id), NULL, null From t_subamostra
Union all
Select 'Quantidade de Fichas',count(t_ficha_diaria.fd_data), t_porto.pto_nome, null from t_ficha_diaria 
Inner join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id group by t_porto.pto_nome;



--Entrevists
Create View v_relatorio_mensal as
Select 'Portos' as nome,Count(pto_id) as quantidade from t_porto
Union All
Select 'Pesqueiros',Count(paf_id) from t_pesqueiro_af
Union All
Select 'Usuários',Count(tu_id) from t_usuario
Union All
Select 'Barcos',Count(bar_id) from t_barco
Union All
Select 'Pescadores',Count(tp_id) from t_pescador where tp_pescadordeletado=false
Union All
Select 'Fichas Diárias',Count(fd_id) from t_ficha_diaria
Union All
Select 'Entrevistas Arrasto de Fundo',count(af_id) from t_arrastofundo
Union All
Select 'Entrevistas Calão',count(cal_id) from t_calao
Union All
Select 'Entrevistas ColetaManual',count(cml_id) from t_coletamanual
Union All
Select 'Entrevistas Emalhe',count(em_id) from t_emalhe
Union All
Select 'Entrevistas Grosseira',count(grs_id) from t_grosseira
Union All
Select 'Entrevistas Jereré',count(jre_id) from t_jerere
Union All
Select 'Entrevistas Linha',count(lin_id) from t_linha
Union All
Select 'Entrevistas LinhaFundo',count(lf_id) from t_linhafundo
Union All
Select 'Entrevistas Manzua',count(man_id) from t_manzua
Union All
Select 'Entrevistas Mergulho',count(mer_id) from t_mergulho
Union All
Select 'Entrevistas Ratoeira',count(rat_id) from t_ratoeira
Union All
Select 'Entrevistas Siripoia',count(sir_id) from t_siripoia
Union All
Select 'Entrevistas Tarrafa',count(tar_id) from t_tarrafa
Union All
Select 'Entrevistas Vara de Pesca',count(vp_id) from t_varapesca
Union All
Select 'Espécies',count(esp_id) from t_especie
Union All
Select 'Esp.Capturadas Arrasto de fundo',count(spc_af_id) from t_arrastofundo_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Calão',count(spc_cal_id) from t_calao_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Coleta Manual',count(spc_cml_id) from t_coletamanual_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Emalhe',count(spc_em_id) from t_emalhe_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Groseira',count(spc_grs_id) from t_grosseira_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Jereré',count(spc_jre_id) from t_jerere_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Linha',count(spc_lin_id) from t_linha_has_t_especie_capturada
Union All
Select 'Esp.Capturadas LinhaFundo',count(spc_lf_id) from t_linhafundo_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Manzuá',count(spc_man_id) from t_manzua_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Mergulho',count(spc_mer_id) from t_mergulho_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Ratoeira',count(spc_rat_id) from t_ratoeira_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Siripoia',count(spc_sir_id) from t_siripoia_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Tarrafa',count(spc_tar_id) from t_tarrafa_has_t_especie_capturada
Union All
Select 'Esp.Capturadas Vara de Pesca',count(spc_vp_id) from t_varapesca_has_t_especie_capturada;

zf create db-table VRelatorioMensal v_relatorio_mensal;

--IMPORTAR -----------------
Create or Replace View v_consulta_portosbydata As
Select 'Arrasto de Fundo' as consulta,count(t_arrastofundo.af_id) as quantidade, t_porto.pto_nome, to_char( date_trunc('month', af_dhvolta),'MM/YYYY') as data_ficha From t_arrastofundo 
Inner Join t_monitoramento on t_arrastofundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', af_dhvolta)
Union All
Select 'Calão',count(t_calao.cal_id), t_porto.pto_nome, to_char( date_trunc('month', cal_data),'MM/YYYY') From t_calao 
Inner Join t_monitoramento on t_calao.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', cal_data)
Union ALL
Select 'Coleta Manual',count(t_coletamanual.cml_id), t_porto.pto_nome, to_char( date_trunc('month', cml_dhvolta),'MM/YYYY') From t_coletamanual 
Inner Join t_monitoramento on t_coletamanual.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', cml_dhvolta)
Union ALL
Select 'Emalhe',count(t_emalhe.em_id), t_porto.pto_nome, to_char( date_trunc('month', em_dhrecolhimento),'MM/YYYY') From t_emalhe 
Inner Join t_monitoramento on t_emalhe.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', em_dhrecolhimento)
Union ALL
Select 'Grosseira',count(t_grosseira.grs_id), t_porto.pto_nome, to_char( date_trunc('month', grs_dhvolta),'MM/YYYY') From t_grosseira
Inner Join t_monitoramento on t_grosseira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', grs_dhvolta)
Union ALL
Select 'Jereré',count(t_jerere.jre_id), t_porto.pto_nome, to_char( date_trunc('month', jre_dhvolta),'MM/YYYY') From t_jerere
Inner Join t_monitoramento on t_jerere.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', jre_dhvolta)
Union ALL
Select 'Linha',count(t_linha.lin_id), t_porto.pto_nome, to_char( date_trunc('month', lin_dhvolta),'MM/YYYY') From t_linha
Inner Join t_monitoramento on t_linha.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', lin_dhvolta)
Union ALL
Select 'Linha de Fundo',count(t_linhafundo.lf_id), t_porto.pto_nome, to_char( date_trunc('month', lf_dhvolta),'MM/YYYY') From t_linhafundo
Inner Join t_monitoramento on t_linhafundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', lf_dhvolta)
Union ALL
Select 'Manzuá',count(t_manzua.man_id), t_porto.pto_nome, to_char( date_trunc('month', man_dhvolta),'MM/YYYY') From t_manzua
Inner Join t_monitoramento on t_manzua.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', man_dhvolta)
Union ALL
Select 'Mergulho',count(t_mergulho.mer_id), t_porto.pto_nome, to_char( date_trunc('month', mer_dhvolta),'MM/YYYY') From t_mergulho
Inner Join t_monitoramento on t_mergulho.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', mer_dhvolta)
Union ALL
Select 'Ratoeira',count(t_ratoeira.rat_id), t_porto.pto_nome, to_char( date_trunc('month', rat_dhvolta),'MM/YYYY') From t_ratoeira
Inner Join t_monitoramento on t_ratoeira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', rat_dhvolta)
Union ALL
Select 'Siripóia',count(t_siripoia.sir_id), t_porto.pto_nome, to_char( date_trunc('month', sir_dhvolta),'MM/YYYY') From t_siripoia
Inner Join t_monitoramento on t_siripoia.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', sir_dhvolta)
Union ALL
Select 'Tarrafa',count(t_tarrafa.tar_id), t_porto.pto_nome, to_char( date_trunc('month', tar_data),'MM/YYYY') From t_tarrafa
Inner Join t_monitoramento on t_tarrafa.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', tar_data)
Union ALL
Select 'Vara de Pesca',count(t_varapesca.vp_id), t_porto.pto_nome, to_char( date_trunc('month', vp_dhvolta),'MM/YYYY') From t_varapesca
Inner Join t_monitoramento on t_varapesca.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('month', vp_dhvolta) Order By consulta, pto_nome;


Create view v_entrevista_porto_pesqueiro as
Select t_porto.pto_nome, 'Arrasto de Fundo' as consulta, paf.paf_pesqueiro From t_arrastofundo 
Inner Join t_monitoramento on t_arrastofundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_arrastofundo_has_t_pesqueiro as entpaf On t_arrastofundo.af_id = entpaf.af_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union All
Select t_porto.pto_nome, 'Calão' as consulta, paf.paf_pesqueiro From t_calao 
Inner Join t_monitoramento on t_calao.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_calao_has_t_pesqueiro as entpaf On t_calao.cal_id = entpaf.cal_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Coleta Manual' as consulta, paf.paf_pesqueiro From t_coletamanual 
Inner Join t_monitoramento on t_coletamanual.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_coletamanual_has_t_pesqueiro as entpaf On t_coletamanual.cml_id = entpaf.cml_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Emalhe' as consulta, paf.paf_pesqueiro From t_emalhe 
Inner Join t_monitoramento on t_emalhe.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_emalhe_has_t_pesqueiro as entpaf On t_emalhe.em_id = entpaf.em_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Grosseira' as consulta, paf.paf_pesqueiro From t_grosseira
Inner Join t_monitoramento on t_grosseira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_grosseira_has_t_pesqueiro as entpaf On t_grosseira.grs_id = entpaf.grs_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Jereré' as consulta, paf.paf_pesqueiro From t_jerere
Inner Join t_monitoramento on t_jerere.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_jerere_has_t_pesqueiro as entpaf On t_jerere.jre_id = entpaf.jre_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Linha' as consulta, paf.paf_pesqueiro From t_linha
Inner Join t_monitoramento on t_linha.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_linha_has_t_pesqueiro as entpaf On t_linha.lin_id = entpaf.lin_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Linha de Fundo' as consulta, paf.paf_pesqueiro From t_linhafundo
Inner Join t_monitoramento on t_linhafundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_linhafundo_has_t_pesqueiro as entpaf On t_linhafundo.lf_id = entpaf.lf_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Manzuá' as consulta, paf.paf_pesqueiro From t_manzua
Inner Join t_monitoramento on t_manzua.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_manzua_has_t_pesqueiro as entpaf On t_manzua.man_id = entpaf.man_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Mergulho' as consulta, paf.paf_pesqueiro From t_mergulho
Inner Join t_monitoramento on t_mergulho.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_mergulho_has_t_pesqueiro as entpaf On t_mergulho.mer_id = entpaf.mer_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Ratoeira' as consulta, paf.paf_pesqueiro From t_ratoeira
Inner Join t_monitoramento on t_ratoeira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_ratoeira_has_t_pesqueiro as entpaf On t_ratoeira.rat_id = entpaf.rat_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Siripoia' as consulta, paf.paf_pesqueiro From t_siripoia
Inner Join t_monitoramento on t_siripoia.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_siripoia_has_t_pesqueiro as entpaf On t_siripoia.sir_id = entpaf.sir_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Tarrafa' as consulta, paf.paf_pesqueiro From t_tarrafa
Inner Join t_monitoramento on t_tarrafa.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_tarrafa_has_t_pesqueiro as entpaf On t_tarrafa.tar_id = entpaf.tar_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id
Union ALL
Select t_porto.pto_nome, 'Vara de Pesca' as consulta, paf.paf_pesqueiro From t_varapesca
Inner Join t_monitoramento on t_varapesca.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Left Join t_varapesca_has_t_pesqueiro as entpaf On t_varapesca.vp_id = entpaf.vp_id
Left Join t_pesqueiro_af as paf On entpaf.paf_id = paf.paf_id;



Drop view v_entrevistas_by_hora;

Create view v_entrevistas_by_hora as
Select 'Arrasto de Fundo' as consulta,count(t_arrastofundo.af_id) as quantidade, t_porto.pto_nome, to_char( date_trunc('hour', af_dhvolta),'HH24:MI') as hora_chegada, to_char( date_trunc('month', af_dhvolta),'MM/YYYY') as mes From t_arrastofundo 
Inner Join t_monitoramento on t_arrastofundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', af_dhvolta),date_trunc('month', af_dhvolta)
Union All
Select 'Calão',count(t_calao.cal_id), t_porto.pto_nome, to_char( date_trunc('hour', cal_data),'HH24:MI'),to_char( date_trunc('month', cal_data),'MM/YYYY') From t_calao 
Inner Join t_monitoramento on t_calao.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', cal_data), date_trunc('month', cal_data)
Union ALL
Select 'Coleta Manual',count(t_coletamanual.cml_id), t_porto.pto_nome, to_char( date_trunc('hour', cml_dhvolta),'HH24:MI'),to_char( date_trunc('month', cml_dhvolta),'MM/YYYY') From t_coletamanual 
Inner Join t_monitoramento on t_coletamanual.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', cml_dhvolta),date_trunc('month', cml_dhvolta)
Union ALL
Select 'Emalhe',count(t_emalhe.em_id), t_porto.pto_nome, to_char( date_trunc('hour', em_dhrecolhimento),'HH24:MI'),to_char( date_trunc('month', em_dhrecolhimento),'MM/YYYY') From t_emalhe 
Inner Join t_monitoramento on t_emalhe.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', em_dhrecolhimento), date_trunc('month', em_dhrecolhimento)
Union ALL
Select 'Grosseira',count(t_grosseira.grs_id), t_porto.pto_nome, to_char( date_trunc('hour', grs_dhvolta),'HH24:MI'), to_char( date_trunc('month', grs_dhvolta),'MM/YYYY') From t_grosseira
Inner Join t_monitoramento on t_grosseira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', grs_dhvolta),date_trunc('month', grs_dhvolta)
Union ALL
Select 'Jereré',count(t_jerere.jre_id), t_porto.pto_nome, to_char( date_trunc('hour', jre_dhvolta),'HH24:MI'), to_char( date_trunc('month', jre_dhvolta),'MM/YYYY') From t_jerere
Inner Join t_monitoramento on t_jerere.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', jre_dhvolta),date_trunc('month', jre_dhvolta)
Union ALL
Select 'Linha',count(t_linha.lin_id), t_porto.pto_nome, to_char( date_trunc('hour', lin_dhvolta),'HH24:MI'), to_char( date_trunc('month', lin_dhvolta),'MM/YYYY') From t_linha
Inner Join t_monitoramento on t_linha.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', lin_dhvolta),date_trunc('month', lin_dhvolta)
Union ALL
Select 'Linha de Fundo',count(t_linhafundo.lf_id), t_porto.pto_nome, to_char( date_trunc('hour', lf_dhvolta),'HH24:MI'), to_char( date_trunc('month', lf_dhvolta),'MM/YYYY') From t_linhafundo
Inner Join t_monitoramento on t_linhafundo.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', lf_dhvolta),date_trunc('month', lf_dhvolta)
Union ALL
Select 'Manzuá',count(t_manzua.man_id), t_porto.pto_nome, to_char( date_trunc('hour', man_dhvolta),'HH24:MI'), to_char( date_trunc('month', man_dhvolta),'MM/YYYY') From t_manzua
Inner Join t_monitoramento on t_manzua.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', man_dhvolta),date_trunc('month', man_dhvolta)
Union ALL
Select 'Mergulho',count(t_mergulho.mer_id), t_porto.pto_nome, to_char( date_trunc('hour', mer_dhvolta),'HH24:MI'), to_char( date_trunc('month', mer_dhvolta),'MM/YYYY') From t_mergulho
Inner Join t_monitoramento on t_mergulho.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', mer_dhvolta),date_trunc('month', mer_dhvolta)
Union ALL
Select 'Ratoeira',count(t_ratoeira.rat_id), t_porto.pto_nome, to_char( date_trunc('hour', rat_dhvolta),'HH24:MI'), to_char( date_trunc('month', rat_dhvolta),'MM/YYYY') From t_ratoeira
Inner Join t_monitoramento on t_ratoeira.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', rat_dhvolta),date_trunc('month', rat_dhvolta)
Union ALL
Select 'Siripóia',count(t_siripoia.sir_id), t_porto.pto_nome, to_char( date_trunc('hour', sir_dhvolta),'HH24:MI'), to_char( date_trunc('month', sir_dhvolta),'MM/YYYY') From t_siripoia
Inner Join t_monitoramento on t_siripoia.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', sir_dhvolta),date_trunc('month', sir_dhvolta)
Union ALL
Select 'Tarrafa',count(t_tarrafa.tar_id), t_porto.pto_nome, to_char( date_trunc('hour', tar_data),'HH24:MI'), to_char( date_trunc('month', tar_data),'MM/YYYY')  From t_tarrafa
Inner Join t_monitoramento on t_tarrafa.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', tar_data),date_trunc('month', tar_data)
Union ALL
Select 'Vara de Pesca',count(t_varapesca.vp_id), t_porto.pto_nome, to_char( date_trunc('hour', vp_dhvolta),'HH24:MI'), to_char( date_trunc('month', vp_dhvolta),'MM/YYYY') From t_varapesca
Inner Join t_monitoramento on t_varapesca.mnt_id = t_monitoramento.mnt_id 
Inner Join t_ficha_diaria On t_monitoramento.fd_id = t_ficha_diaria.fd_id 
Right Join t_porto On t_ficha_diaria.pto_id = t_porto.pto_id
Group by t_porto.pto_nome, date_trunc('hour', vp_dhvolta),date_trunc('month', vp_dhvolta) 
Order By consulta, pto_nome;