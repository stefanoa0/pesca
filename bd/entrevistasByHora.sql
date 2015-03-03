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