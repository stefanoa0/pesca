-- -----------------------------------------------------
-- Data for table "T_UF"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('AC', 'Acre');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('AL', 'Alagoas');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('AM', 'Amazonas');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('AP', 'Amapá');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('BA', 'Bahia');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('CE', 'Ceará');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('DF', 'Distrito Federal');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('ES', 'Espírito Santo');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('GO', 'Goiás');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('MA', 'Maranhão');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('MG', 'Minas Gerais');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('MS', 'Mato Grosso do Sul');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('MT', 'Mato Grosso');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('PA', 'Pará');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('PB', 'Paraíba');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('PE', 'Pernambuco');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('PI', 'Piauí');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('PR', 'Paraná');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('RJ', 'Rio de Janeiro');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('RN', 'Rio Grande do Norte');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('RO', 'Rondônia');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('RR', 'Roraima');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('RS', 'Rio Grande do SUl');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('SC', 'Santa Catarina');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('SE', 'Sergipe');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('SP', 'São Paulo');
INSERT INTO "T_UF" ("TUF_Sigla", "TUF_Nome") VALUES ('TO', 'Tocantins');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_TipoTel"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_TipoTel" ("TTEL_Desc") VALUES ('Celular');
INSERT INTO "T_TipoTel" ("TTEL_Desc") VALUES ('Residencial');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_TipoDependente"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Conjugue ou Companheiro(a)');
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Filho(a) ou Enteado(a)');
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Irmão(ã), Neto(a) ou Bisneto(a)');
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Pais, Avós e Bisavós');
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Sogro(a)');
INSERT INTO "T_TipoDependente" ("TTP_TipoDependente") VALUES ('Incapaz');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_ArtePesca"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Arrasto');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Calão');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Espinhel/Groseira');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Linha');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Mariscagem');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Mergulho');
INSERT INTO "T_ArtePesca" ("TAP_ArtePesca") VALUES ('Rede');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_TipoEmbarcacao"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Barco');
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Bote');
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Canoa');
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Desembarcado');
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Jangada');
INSERT INTO "T_TipoEmbarcacao" ("TTE_TipoEmbarcacao") VALUES ('Lancha');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_AreaPesca"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_AreaPesca" ("TAreaP_AreaPesca") VALUES ('Estuário');
INSERT INTO "T_AreaPesca" ("TAreaP_AreaPesca") VALUES ('Mar');
INSERT INTO "T_AreaPesca" ("TAreaP_AreaPesca") VALUES ('Rio');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_EspecieCapturada"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_EspecieCapturada" ("TEC_Especie") VALUES ('Camarão');
INSERT INTO "T_EspecieCapturada" ("TEC_Especie") VALUES ('Marisco');
INSERT INTO "T_EspecieCapturada" ("TEC_Especie") VALUES ('Peixe');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_Perfil"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_Perfil" ("TP_Perfil") VALUES ('Administrador');
INSERT INTO "T_Perfil" ("TP_Perfil") VALUES ('Coordenador');
INSERT INTO "T_Perfil" ("TP_Perfil") VALUES ('Subcoordenador');
INSERT INTO "T_Perfil" ("TP_Perfil") VALUES ('Estagiário');
INSERT INTO "T_Perfil" ("TP_Perfil") VALUES ('Bamin');

COMMIT;

-- -----------------------------------------------------
-- Data for table "T_PorteEmbarcacao"
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO "T_PorteEmbarcacao" ("TPE_Porte") VALUES ('Pequeno');
INSERT INTO "T_PorteEmbarcacao" ("TPE_Porte") VALUES ('Médio');
INSERT INTO "T_PorteEmbarcacao" ("TPE_Porte") VALUES ('Grande');

COMMIT;
