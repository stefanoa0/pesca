select Count(fd_id), t_usuario.tu_nome, null from t_ficha_diaria 
Inner Join t_usuario on t_ficha_diaria.t_estagiario_tu_id = t_usuario.tu_id 
group by t_usuario.tu_nome order by t_usuario.tu_nome;

select count(*), t_usuario.tu_nome, t_pescador.tp_dta_cad from t_pescador
Inner Join t_usuario on t_pescador.tp_resp_lan = t_usuario.tu_id 
group by t_usuario.tu_nome, t_pescador.tp_dta_cad order by t_usuario.tu_nome;



