create or replace view "v_endereco" ("te_id", "te_logradouro", "te_numero", "te_cep", "te_bairro", "te_comp", "tmun_id", 
"tmun_municipio", "tuf_sigla", "tuf_nome") as
select 
  "t_endereco"."te_id", 
  "t_endereco"."te_logradouro", 
  "t_endereco"."te_numero", 
  "t_endereco"."te_cep", 
  "t_endereco"."te_bairro", 
  "t_endereco"."te_comp", 
  "t_municipio"."tmun_id", 
  "t_municipio"."tmun_municipio", 
  "t_uf"."tuf_sigla", 
  "t_uf"."tuf_nome"
from 
  "t_endereco", 
  "t_municipio", 
  "t_uf"
where 
  "t_endereco"."tmun_id" = "t_municipio"."tmun_id" and
  "t_municipio"."tuf_sigla" = "t_uf"."tuf_sigla";

create or replace view "v_monitoramentobyficha" ("mnt_id", "mnt_arte", "mnt_quantidade", "mnt_monitorado", "fd_id") as
select 
  "t_monitoramento"."mnt_id", 
  "t_monitoramento"."mnt_arte", 
  "t_monitoramento"."mnt_quantidade", 
  "t_monitoramento"."mnt_monitorado", 
  "t_fichadiaria"."fd_id" 
from 
  "t_monitoramento", 
  "t_ficha_diaria"
where 
  "t_monitoramento"."fd_id" = "t_ficha_diaria"."fd_id";

create or replace view "v_usuario" ("tu_id", "tu_nome", "tu_sexo", "tu_cpf", "tu_rg", "tu_email", "tu_usuariodeletado", 
"tl_id", "tl_login", "tl_ultimoacesso", "tp_id", "tp_perfil", "te_id", "te_logradouro", "te_numero", "te_cep", "te_bairro", 
"te_comp", "tmun_id", "tmun_municipio", "tuf_sigla", "tuf_nome") as
select 
  "t_usuario"."tu_id", 
  "t_usuario"."tu_nome", 
  "t_usuario"."tu_sexo", 
  "t_usuario"."tu_cpf", 
  "t_usuario"."tu_rg", 
  "t_usuario"."tu_email", 
  "t_usuario"."tu_usuariodeletado", 
  "t_login"."tl_id", 
  "t_login"."tl_login", 
  "t_login"."tl_ultimoacesso", 
  "t_perfil"."tp_id", 
  "t_perfil"."tp_perfil", 
  "v_endereco"."te_id", 
  "v_endereco"."te_logradouro", 
  "v_endereco"."te_numero", 
  "v_endereco"."te_cep", 
  "v_endereco"."te_bairro", 
  "v_endereco"."te_comp", 
  "v_endereco"."tmun_id", 
  "v_endereco"."tmun_municipio", 
  "v_endereco"."tuf_sigla", 
  "v_endereco"."tuf_nome"
from 
  "t_usuario", 
  "v_endereco", 
  "t_perfil", 
  "t_login"
where 
  "t_usuario"."tl_id" = "t_login"."tl_id" and
  "t_usuario"."tp_id" = "t_perfil"."tp_id" and
  "t_usuario"."te_id" = "v_endereco"."te_id";


create or replace view "v_colonia" ("tc_id", "tc_nome", "tc_especificidade", "tcom_id", "tcom_nome", "te_id", "te_logradouro", 
"te_numero", "te_cep", "te_bairro", "te_comp", "tmun_id", "tmun_municipio", "tuf_sigla", "tuf_nome") as
select 
  "t_colonia"."tc_id", 
  "t_colonia"."tc_nome", 
  "t_colonia"."tc_especificidade", 
  "t_comunidade"."tcom_id", 
  "t_comunidade"."tcom_nome", 
  "v_endereco"."te_id", 
  "v_endereco"."te_logradouro", 
  "v_endereco"."te_numero", 
  "v_endereco"."te_cep", 
  "v_endereco"."te_bairro", 
  "v_endereco"."te_comp", 
  "v_endereco"."tmun_id", 
  "v_endereco"."tmun_municipio", 
  "v_endereco"."tuf_sigla", 
  "v_endereco"."tuf_nome"
from 
  "t_colonia", 
  "t_comunidade", 
  "v_endereco"
where 
  "t_colonia"."tcom_id" = "t_comunidade"."tcom_id" and
  "t_colonia"."te_id" = "v_endereco"."te_id";


create or replace view "v_usuariohastelefone" ("tu_id", "ttcont_id", "ttcont_ddd", "ttcont_telefone", "ttel_id", "ttel_desc") as
select 
  "t_usuario_has_t_telefonecontato"."tu_id", 
  "t_telefonecontato"."ttcont_id", 
  "t_telefonecontato"."ttcont_ddd", 
  "t_telefonecontato"."ttcont_telefone", 
  "t_tipotel"."ttel_id", 
  "t_tipotel"."ttel_desc"
from 
  "t_telefonecontato", 
  "t_tipotel", 
  "t_usuario_has_t_telefonecontato"
where 
  "t_telefonecontato"."ttel_id" = "t_tipotel"."ttel_id" and
  "t_usuario_has_t_telefonecontato"."ttcont_id" = "t_telefonecontato"."ttcont_id";

create or replace view "v_pescador" ("tp_id", "tp_nome", "tp_sexo", "tp_matricula", "tp_apelido", "tp_filiacaopai", 
"tp_filiacaomae", "tp_ctps", "tp_pis", "tp_inss", "tp_nit_cei", "tp_rg", "tp_cma", "tp_rgb_maa_ibama", "tp_cir_cap_porto",
"tp_cpf", "tp_datanasc", "te_id", "te_logradouro", "te_numero", "te_bairro", "te_cep", "te_comp", "tmun_municipio", "tmun_id", 
"tuf_sigla", "tuf_nome", "tmun_id_natural") as
select 
  "t_pescador"."tp_id", 
  "t_pescador"."tp_nome", 
  "t_pescador"."tp_sexo", 
  "t_pescador"."tp_matricula", 
  "t_pescador"."tp_apelido", 
  "t_pescador"."tp_filiacaopai", 
  "t_pescador"."tp_filiacaomae", 
  "t_pescador"."tp_ctps", 
  "t_pescador"."tp_pis", 
  "t_pescador"."tp_inss", 
  "t_pescador"."tp_nit_cei", 
  "t_pescador"."tp_rg", 
  "t_pescador"."tp_cma", 
  "t_pescador"."tp_rgb_maa_ibama", 
  "t_pescador"."tp_cir_cap_porto", 
  "t_pescador"."tp_cpf", 
  "t_pescador"."tp_datanasc", 
  "t_endereco"."te_id", 
  "t_endereco"."te_logradouro", 
  "t_endereco"."te_numero", 
  "t_endereco"."te_bairro", 
  "t_endereco"."te_cep", 
  "t_endereco"."te_comp", 
  "t_municipio"."tmun_municipio", 
  "t_municipio"."tmun_id", 
  "t_uf"."tuf_sigla", 
  "t_uf"."tuf_nome", 
  "t_pescador"."tmun_id_natural"
from 
  "t_pescador", 
  "t_endereco", 
  "t_municipio", 
  "t_uf"
where 
  "t_pescador"."te_id" = "t_endereco"."te_id" and
  "t_endereco"."tmun_id" = "t_municipio"."tmun_id" and
  "t_municipio"."tuf_sigla" = "t_uf"."tuf_sigla";