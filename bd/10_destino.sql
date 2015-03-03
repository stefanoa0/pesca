select count(*), destino from access.entrev_pesca group by destino order by destino;

update access.entrev_pesca set destino='Colônia Z-19' where destino='Z-19' or destino='peixaria Z-19'
or destino='colonia z-19'or destino='Colonia z-19'or destino='Colonia Z-19'
or destino='colônia z-19'or destino='Colônia Z - 19' or destino='Vender na Colônia Z-19'
 or destino='PEIXARIA Z-19';

update access.entrev_pesca set destino='Colônia Z-34' where destino='Z- 34'or destino='Colonia Z-34'
or destino='colônia z-34'or destino='Colônia Z -34'or destino='Colônia Z- 34'
or destino=' Colônia Z-34 e Ponta da Tulha.'or destino='Z-34';

update access.entrev_pesca set destino='Colônia Z-18' where destino='colônia z-18' or destino='Peixaria da Z-18' 
or destino='Zolônia Z-18'
or destino='Colônia Z - 18, peixe Piranema qtd 25, 11 kg, R$ 3,'or destino='colônia -18'or destino='Colônia 2-18'
or destino='colonia z - 18'
or destino='colonia z-18'or destino='colonia z- 18'or destino='colonia Z - 18'or destino='colônia z- 18'
or destino='Colonia Z-18'or destino='Colônia - Z-18'
or destino='Colônia Z -18'or destino='Colônia Z - 18'or destino='Colônia Z-18'
or destino='Colônia Z-18, 3 lances, tempo total gasto 2h'or destino='colônia Z-18'or destino='colonio z- 18'
or destino='z-18'or destino='Z-18';

update access.entrev_pesca set destino='Colônia' where destino='colonia' or destino='Colônia de pescadores'or destino='colônia' or destino='Colônia de pescador'or destino='Colônia de pescador'
or destino='colônia'or destino='Foi para colonia de pescadores';



update access.entrev_pesca set destino='Atravessador' where destino='Venda para os atravessadores' 
or destino='Atravaessadores' or destino='Revendedora' or
destino='Revendedor Zé Piriquito' or destino='Vendeu para atravessadores' or destino='revendedores' 
or destino='J. M. Camarões' or destino='atravessador'
or destino='atrassadores'or destino='Atravessador.'or destino='atravessadores'or destino='Atravessadores'
or destino='Atravessadores.'or destino='Atravessadores de Barra'
or destino='Atravessadores. Mero Jambu cadastrado como Badejo'or destino='Atravessador, Peixe pegador 1, 0,89 kg.'
or destino='Atravessores'or destino='Atressadores' or destino='revendedora'
or destino='Comércio-Atravessadores / Sirí p/consumo'or destino='Vendido para ravendedor (Dola)' 
or destino like '%travessador%' or destino='revendedor' or destino='Revendedor'
 or destino='VENDER PARA ATRAVESSADORES' or destino='Robalo vendido ao revendedor.'
  or destino='VENDA PARA ATRAVESSADORES';

 
 
update access.entrev_pesca set destino='Venda por unidade' where destino='Venda por unidade.' 
or destino='Preço por unidade.' or
destino='Vendido por unidade.' or destino='Venda. Preço da unidade.' or destino='Vendido a unidade.'
or destino='O bagre foi vendido a unidade por R$ 5,00'
or destino='Preço da unidade do bagre R$ 7,00 os três foram vendidos por R$ 12,00' 
or destino='Preço da dúzia. Vendido a unidade.'or destino='Comercialização (preço da unidade)'
 or destino='O xaréu foi vendido inteiro (tratado) na praia a R$ 30.'
  or destino='Preço da unidade' or destino='Preço da unidade.' or destino='Preço da unidade R$ 1,00' or destino='Preço por unidade';



update access.entrev_pesca set destino='Venda por peso' where destino='Peixe pegador 2, 3kg , R$ 10' 
or destino='O peso total foi 6kg e o preço por quilo foi R$ 15'
or destino=' Comércio, foram realizados cálculos para estabelecer o valor do quilo do camarão, já que ele vende o \"litro\" de 800g por R$ 15,'
 or destino='Vender por Kg no \"mim vale\"' or destino='Vendidos por corda a R$ 15,00 e as cordas dão mais de 1kg.';



update access.entrev_pesca set destino='Venda por duzia/litro' where destino='Preço da dúzia = 24' or destino='Preço da dúzia = R$ 24,00'
 or destino='Preço da dúzia = R$ 24,00, a unidade é vendida por R$ 2,00' or destino='Preço da dúzia = R$ 24,00, vendido a unidade por R$ 2,00'
  or destino='Preço por dúzia.' or destino='Preço por \"litro\"' or destino='Preço do litro. Qtd presente na ficha.'
   or destino='Venda, peixes vendido no saco por R$ 5,0' or destino='Venda. Preço médio. Registro de 3 valores: R$ 2,0 ; 2,5 ; 3,0';

 
 
update access.entrev_pesca set destino='Vitória (ES)' where destino='Vitória'or destino='Vitória (ES)';



update access.entrev_pesca set destino='Venda' where destino='VENDer' or destino='Venda 1,' or destino='vendeu' 
or destino='Vendido.'
or destino='Venda local' or destino='Vender' or destino='Comercializa no próprio \"Bar\"' or destino='Vende' 
or destino='Vende na localidade'
or destino='vende' or destino='venda.' or destino='VENDA'  or destino='Vendeu'or destino='Comercializa.'
or destino='Comercialização.'or destino='Comercializado em \"casa\"'
or destino='Comercio'or destino='comércio'or destino='Comércio'or destino='Comércio.'or destino='COMÉRCIO'
or destino='Para o comércio'or destino='Para vender'
or destino='vendidos'or destino='vendido no local'or destino='Vendeu para as catadeiras'or destino='Vendeu na rua'
or destino='vendeu na rua' or
destino='Venda.' or destino='Venda a turista e bares' or destino='Venda de acordo com o tamanho'
 or destino='venda em serra grande' or destino='Venda em Serra Grande.' or destino='venda local' or destino='venda'
 or destino='vanda'or destino='vender para catadeiras'
 or destino='Vender para catadeiras'or destino='vender para catadores'or destino='vender'or destino='vender.'
 or destino='Vender.'or destino='VENDER'
 or destino='VENDER na banca de cerveja mais próxima' or destino='vender na cabana'
 or destino='vender na ponta do ramo'or destino='Vender no \"Mim Vale\". Total dos pescados = 30kg'
 or destino='calambau vendeu'or destino='calambau vendeu, moreia e baiacu foram devolvidos para o rio.'
 or destino='Comércio. (Vendido no próprio rio). Peixe registrado na ficha CARAPEBA'
  or destino='Preço do filé do siri = R$ 20' or destino='Preço do file do siri = R$ 20,00'
   or destino='Preço médio. Registro de 3 valores: R$ 1,5 ; 2,0 ; 2,5' or destino='Vendido na Vila de Mamoã'
    or destino='vender em serra grande' or destino='Vende na rua.' or destino='Venda na praia e em sua residência.'
     or destino='Vende em casa' or destino='Vende.' or destino='Vende na cabana' or destino='Venda na rua'
      or destino='Venda na rua.' or destino='Venda nos portos de desembarque'
       or destino='Total dos pescados 30 kg , vendidos no \"Mim Vale\"';

 
 
 update access.entrev_pesca set destino='Venda na Praia do Malhadinho' where destino='Comércio, pesqueiro praia do Malhadinho.'
 or destino='Comércio,  pesqueiro Praia do Malhadinho.';
 
 
 
 
update access.entrev_pesca set destino='Venda na Feira' where destino='venda na feira' or destino='Feira livre.'
or destino='Vende na feira.' or
destino='Vender na feira.' or destino='Duas caixas de Mivale. Feira livre'or destino='feira livre'
or destino='Feira livre'or destino='Feira Livre'
or destino='Feira livre e moréia para consumo'or destino='Feira'or destino='Feira.'or destino='Feira Ilhéus.'
or
destino like '%eira' or destino like '%eira.' or destino='VENDER NA FEIRA' or destino='VENDER NA FEIRA';




update access.entrev_pesca set destino='Feira do Malhado' where destino='feira malhado' 
or destino='para feira do malhado' or
destino='Vende na feira do malhado' or destino='Vende na Feira do Malhado' or destino='Vende na Feira do Malhado.'
or
destino='Feira do Malhado.' or destino='Malhado' or destino='feira do malhado' or destino='Venda na feira do Malhado.'
or destino='Feira de abastecimento.'
or destino='Feira do Malhado\r\nFeira do Malhado'or destino='foi para feira do malhado' or
destino like '%Malhado%' or destino like '%malhado%' or
destino='vender na feira do malhdo'or destino='Vendido na feira de abatecimento';



update access.entrev_pesca set destino='Vende para catadeiras' where destino='Venda para as catadeira de camarão.'
 or destino='venda para as catadeiras' or destino='Venda para as catadeiras' or destino='Venda para as catadeiras.'
  or destino='Venda para as catadeiras de camarão.' or destino='Venda para catadeiras.' or destino='Venda para catadeiras de camarão.'
   or destino='Catadores';



update access.entrev_pesca set destino='Feira da Guanabara' where destino='Feira do Guanabara'
or destino='feira guanabara'or destino='Feira Guanabara' or destino='Tonho do peixe (feira guanabara)';



update access.entrev_pesca set destino='Consumo' where destino='O total dos pescados foi 1kg para consumo.'
or destino='comer' or
destino='Para consumo próprio' or destino='Consumo próprio. Peso total dos pescados 5kg' 
or destino='Consumo Próprio' or destino='Para consumo' or
destino='Consumo.'or destino='Casa'or destino='Casa.'or destino='consumo'or destino='consumo.'
or destino='Consmuo'or destino=' Consumo.'or destino='CONSUMO'or destino='Consumo próprio'
or destino='Consumo próprio.'
or destino='consumo próprio.'or destino='consumo proprio'or destino='Consumo, piranha Qtd 2, Peso 0,09'
or destino='Consumo pessoal'or destino='Consumo. Pesqueiro Rio Almada'or destino=' Consumo próprio'
or destino='consumo próprio'or destino='consumo proprio e isca.'or destino='Cosumo'or destino='para consumo'
or destino='Para consumo.'or destino='Moréia para consumo.'or destino='Moréia para consumo próprio'
or destino=' Moréia consumo próprio'or destino='Deu para consumo.'or destino='Deu pra consumo.'
or destino='Dividido entre os pescadores.' or destino='O pescado foi distribudo para os colegas e amigos do poescador'
 or destino='Para o próprio consumo.' or destino='Pescado - Soropó = 1, pesca consumo.' or destino='Pesca para consumo'
  or destino='Pesca para consumo próprio' or destino='Pesca para consumo próprio.' or destino='Peso total 0,98 kg, para consumo.'
   or destino='Peso total 2,5kg, para consumo.' or destino='Peso total do pescado: 2,5kg. Para consumo.' or destino='Peso total dos pescados: 4,8'
    or destino='Total 700g para consumo.';



update access.entrev_pesca set destino='Consumo/Venda' where destino='consumo e comércio'
or destino='Consumo e comércio'or destino='consumo e venda'or destino='Consumo e Venda'or destino='Consumo e Venda.'
or destino='CONSUMO E VENDA'or destino='Consumo e peixaria'or destino='comercio e consumo'
or destino='comércio e consumo'or destino='comércio e consumo.'or destino='Comércio e consumo'
or destino='Comércio e Consumo'or destino='Consumo, venda.'or destino='Consumo, Venda'
or destino='calambau = comércio, os demais = consumo' or
destino like '%enda e consu%' or destino like '%enda e Consu%' or destino like 'Venda%consumo.' 
or destino like '%eira%consumo%' or destino like '%ende%consumo%' or destino='vender e consumir'
or destino='A tilápia e o baricu foram consumidos e o camarão foi vendido.'
or destino='Baricu, qtd 4. Moreia e baricu utilizados como isca ou consumidos.'
or destino='Camarão vendido por \"litro\" e carapeba para consumo.' or destino='Gaiamum preço médio por unidade. Robalo para consumo.'
 or destino='Venda , Consumo' or destino='vende o calambau e consume a morea' or destino='Venda e para isca.'
  or destino='Venda na Praia e Isca';



update access.entrev_pesca set destino='Ilhéus' where destino='Ilhéus. Não foi possível estimar o nº de dourados e vermelhos.';



update access.entrev_pesca set destino='Frete' where destino='Frete.' or destino='Frete. Pescado Aratuba Kg 8';


update access.entrev_pesca set destino='Proprietário Embarcação' where destino='entrega para o dono do barco'
 or destino='Venda para o dono do barco.' or destino='Vende para o dono do barco';



update access.entrev_pesca set destino='Barra Grande' where destino='Entrega em Barra Grande' or destino='Barra';
 

update access.entrev_pesca set destino='Associação' where destino='Entrega na associação' 
or destino='associação das marisqueiras' or
destino='entrega na associação' or destino='Entrega na Associação de Pescadores';



update access.entrev_pesca set destino='ASPERI' where destino='asperi' or destino='Entregar na Asperi'
or destino='Entrega na  ASPERI' 
or destino='Asperi' or destino='ASPERI, Bagre  para consumo.' or destino='Associação Asperi'
or destino='entrega na asperi'or destino='entrega na Asperi'or destino='entrega na ASPERI'
or destino='Entrega na ASPERI'or destino='Entrega na ASPERI.'or destino='Entrega na Asperi Associação';



update access.entrev_pesca set destino='COOPERIO' where destino='entrega Cooperio'or destino='cooperrio'
or destino='Cooperrio'or destino='entraga na cooperrio'
or destino='Entrega na COOPERIO'or destino='Entrega na Cooperrio' or destino='COOPERRIO'
or destino='entrega no Cooperio'; 



update access.entrev_pesca set destino='Vende na comunidade' where destino='vendeu na comunidade'
or destino='venderna comunidade' or destino='calambal vendidos na comunidade' 
 or destino='Vende na conunidade.'or destino='vendido na própria comunidade' or
 destino like '%ende na comunid%' or destino like '%omunidade' or destino like 'Vender na comunidade%'
  or destino='Venda na comunidade.' or destino='Vende na localidade.';

 
 
update access.entrev_pesca set destino='Vende na praia' where destino='vende na praia mesmo'
or destino='Vende na praia.' or destino='Venda na praia.' or
destino like '%praia' or destino like '%Praia' or
destino='vender na praia.'or destino='Vender na praia.'or destino='vender na praia de serra grande'
 or destino='vender na praia em Serra Grande.' or destino='Venda na Praia.' or destino='Venda na praia e na própria residência.';

 
 
update access.entrev_pesca set destino='Vende para turista' where destino='Venda a turistas.'
or destino='turistas'or destino='vendido para turistas' or destino='vender para turistas'
 or destino='Turistas.' or destino='Turistas, bares.' or destino='Turistas e cabanas'
  or destino='Turistas' or destino='Venda para turistas.'; 



update access.entrev_pesca set destino='Peixaria' where destino='entrega na peixaria' 
or destino='Peixaria de Mario' or destino='Entrga na peixaria.' or
destino='peixaria Brena' or destino='Peixaria de Adriana' or destino='peixaria de Adriano.' 
or destino='Peixaria Encontro das águas' 
or destino='peixaria de mário' or destino='Vende na peixaria'  or destino='Peixaria de Adriano' 
or destino='peixaria de adriano' or destino='entrega na peixaria.'
 or destino='Peixaria.'  or destino='Entregues na peixaria.'or destino='Entrega na peixaria'
 or destino='Entrega na peixaria.'or destino='Entregana peixaria'or destino='Entrega na Peixaria'
 or destino='Entrega na Peixaria.'or destino='ENTREGA NA PEIXARIA'
 or destino='Entrega na peixaria . Obs: O Xaréu não foi vendido, os pescadores levaram para casa.'
 or destino='entregar na peixaria'
 or destino='entregue na peixaria'; 
update access.entrev_pesca set destino='Peixaria' where destino like '%xaria%'
 or destino='PEIXARIA' or destino='PEIXARIA DE ADRIANO' or destino='peixria';



update access.entrev_pesca set destino='Banca' where destino='VENDER NA BANCA MAIS PRÓXIMO' 
or destino='Vender na banca de peixes mais próxima.' or
destino='vender na bancade peixe mais próxima' or destino='Vender na banca mais próximo' 
or destino='vender na banca de peixe mais próximo'
or destino='vendeu na banca de peixe'or destino='vendeu na banca de peixe da cidade nova'
or destino='Vendeu na banca de peixe da cidade nova'or 
destino='vendeu na banca de peixe mais próxima'or destino='Vendeu na banca de peixe mais próximo'
or destino like '%ender na banca%' or destino='banca do Raimundo' or destino='Banca do Raimundo'
 or destino='Banca' or destino='Venda na banca mais próxima' or destino='Venda na banca mais próxima.';

 
 
update access.entrev_pesca set destino='Bares/Cabanas/Restaurantes' where destino='Bares' 
or destino='Bares.' or destino='Bares de Mamoã' or destino='Bares e turistas' or destino='Bares, turistas.';



update access.entrev_pesca set destino='Isca' where destino='Para Isca.' or destino='Para ser feito de isca.'
or destino='Isca para pegar robalo'or destino='para isca.' or destino='peixe usado para isca.';



update access.entrev_pesca set destino='Defumador do Nito' where destino='defumador de nito'
or destino='Defumador de Nito'or destino='defumador do nito'
or destino='Defumador do Nito'or destino='Defumaria de Nito' or destino like'Foi para o defumador%' 
or destino like 'foi para o def%'or destino='Para defumador de Nito.'or destino='Para do defumador de Nito'
 or destino='Para o defumador de Nito';



update access.entrev_pesca set destino='Itabuna' where destino='Feira de Itabuna' 
or destino='Feira de Itabuna e moamba doada para as marisqueiras.'or destino='foi para Itabuna'
or destino='itabuna'or destino='Itabuna.' or destino like '%tabuna' or destino like '%tabuma' 
or destino like '%tabuna.' or destino='Vende em Itabuna o "litro" (Já torrado) a R$ 8'
or destino='Vende em Itabuna já tratado' or destino='Vende em Itabuna já torrado';



update access.entrev_pesca set destino='Sambaituba' where destino like '%ambaituba%' 
or destino like '%Sambaitub' or destino like '%sambaiituba';


update access.entrev_pesca set destino='Valença' where destino = 'valença'  or destino='Valença.'
 or destino='velença';



update access.entrev_pesca set destino='Ponta da Tulha' where destino like '%onta da tulh%' 
or destino like '%onta da Tulh%' or destino='PONTA DA TULHA';



update access.entrev_pesca set destino= NULL where destino='1 Cação Martelo, 0,53g, R$ 15 e Sororoca e 6kg de moamba primeiro lance, 7kg de moamba segundo lance. (Guaricema, manjuba, bicuda, maçambê, castanha, roncador, barbudo,boca-torta, corre-costa, lula, garapau)'
or destino='1 cx de mivale'or destino='3 = litros a 10 R$ cada litro.'or destino='4 cx de moamba vendidas cada uma a R$ 50. Peso (pelos últimos registros) aproximadamente 30 kg'
or destino='Bagre Aluminio qtd 4 24kg, R$ 6'or destino='Ela cata o siri e vende o catado'
 or destino='moamba = boca-torta, chatinha, samucana, pititinga, peixe-galo, bicuda, e pescada branca. ! Caçonete 0,210 kg'
  or destino='Moamba= rocandor, peixe-galo e bicudinha.' or destino='Moamba: Roncador, bicudinha, lulas, pititinga, peixe-galo e cascuda.'
   or destino='Moamba: Roncador, mançanbê, manjuba, bicudinha, peixe-galo.' or destino='Moamba: roncando, peixe-galo, bicuda, garapau, manjuba, corre-costa'
    or destino='Monitor não registrou preço dos pescados.' or destino='Monitor não sabe o valor dos pescados.'
     or destino='Na ficha existe a separação de dois lances, as espécies foram somadas.' or destino='Obs: O barco porto do céu só é apropriado para arraia'
      or destino='Os maias I 31/01/2014' or destino='Peixe Baricu qtd 1' or destino='Peixe Caranha qtd 1, 3 kg' or destino='Peixe, carapicum - qtd 30, 6Kg'
       or destino='Peixe\"cozinheira\" 3, peso 0,2KG' or destino='Peixe joão gorosa' or destino='Peixe miudo-bicuda, boca torta, rocandor, chatinha, peixe galo.'
        or destino='Peixe Piau Qtd 1, peso 0,04' or destino='Pesagem dos pescados que consta na ficha. Atenão para os dias de ida e volta do mar.'
         or destino='Pesagem dos pescados que consta na ficha. Atenção para o dia que saiu e o dia que voltou da pesca.'
          or destino='Registrado o preço que, segundo o monitor é vendido o catado.'
           or destino='Sem distanatário' or destino='Sem captura' or destino='Sem captura.'
            or destino='Sem registro de pescado na ficha de entrevista.' or destino='Sem registro de pescados.'
             or destino='Sem registro de peso e preço dos outros pescados.' or destino='Sem registro de peso e valor.'
              or destino='Sem registro de quantidade.' or destino='Sem registro de pescado.' or destino='Total 500g'
               or destino='Tubias Barreto';






 
------------> criação da tabela t_destinopescado (arquivo 01)
------------> inserir os tipos classifidos da entrev_pesca para tabela t_destinopescado
 INSERT INTO T_DESTINOPESCADO (DP_ID,  DP_DESTINO)
 SELECT NEXTVAL('t_destinopescado_dp_id_seq'),  destino from access.entrev_pesca group by destino order by destino;
 
 
------> criar/chave estrangeira t_arrastofundo
 alter table t_arrastofundo add column dp_id integer null;
 alter table t_arrastofundo add foreign key (dp_id) references t_destinopescado(dp_id);

 alter table T_CALAO add column dp_id integer null;
 alter table T_CALAO add foreign key (dp_id) references t_destinopescado(dp_id);
 
 alter table T_EMALHE add column dp_id integer null;
 alter table T_EMALHE add foreign key (dp_id) references t_destinopescado(dp_id);

  alter table T_TARRAFA add column dp_id integer null;
 alter table T_TARRAFA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_JERERE add column dp_id integer null;
 alter table T_JERERE add foreign key (dp_id) references t_destinopescado(dp_id);
 
 alter table T_LINHA add column dp_id integer null;
 alter table T_LINHA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_grosseira add column dp_id integer null;
 alter table T_grosseira add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_VARAPESCA add column dp_id integer null;
 alter table T_VARAPESCA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_MERGULHO add column dp_id integer null;
 alter table T_MERGULHO add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_MANZUA add column dp_id integer null;
 alter table T_MANZUA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_RATOEIRA add column dp_id integer null;
 alter table T_RATOEIRA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_SIRIPOIA add column dp_id integer null;
 alter table T_SIRIPOIA add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_COLETAMANUAL add column dp_id integer null;
 alter table T_COLETAMANUAL add foreign key (dp_id) references t_destinopescado(dp_id);
 
  alter table T_LINHAFUNDO add column dp_id integer null;
 alter table T_LINHAFUNDO add foreign key (dp_id) references t_destinopescado(dp_id);

 
-------> criando tabela temporária
Create temp table destino as
SELECT EP.CODIGO, EP.DESTINO,  DP.DP_ID, DP.DP_DESTINO
FROM ACCESS.ENTREV_PESCA AS EP
    INNER JOIN T_DESTINOPESCADO as DP ON(';' || EP.DESTINO || ';' LIKE '%;' || DP.DP_DESTINO || ';%')
ORDER BY EP.CODIGO, DP.DP_ID, DP.DP_DESTINO;

---------> atualizando campo dp_id (alguns podem ficar em branco,  visto que foram retirados os que continham informações)
UPDATE T_ARRASTOFUNDO SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE AF_ID = DES.CODIGO;

UPDATE T_CALAO SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE cal_ID = DES.CODIGO;

UPDATE T_EMALHE SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE em_ID = DES.CODIGO;

UPDATE T_TARRAFA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE tar_ID = DES.CODIGO;

UPDATE T_JERERE SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE jre_ID = DES.CODIGO;

UPDATE T_LINHA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE lin_ID = DES.CODIGO;

UPDATE T_grosseira SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE grs_ID = DES.CODIGO;

UPDATE T_VARAPESCA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE vp_ID = DES.CODIGO;

UPDATE T_MERGULHO SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE mer_ID = DES.CODIGO;

UPDATE T_MANZUA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE man_ID = DES.CODIGO;

UPDATE T_RATOEIRA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE rat_ID = DES.CODIGO;

UPDATE T_SIRIPOIA SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE sir_ID = DES.CODIGO;

UPDATE T_COLETAMANUAL SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE cml_ID = DES.CODIGO;

UPDATE T_LINHAFUNDO SET DP_ID=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE lf_ID = DES.CODIGO;

UPDATE access.entrev_pesca as ep SET destino=DES.DP_ID FROM
(SELECT CODIGO, DESTINO, DP_ID, DP_DESTINO FROM DESTINO ORDER BY CODIGO) AS DES
WHERE ep.codigo = DES.CODIGO;

alter table T_ARRASTOFUNDO   drop column af_destino;
alter table t_linhafundo   drop column lf_destino;
alter table T_COLETAMANUAL    drop column cml_destino;
alter table T_SIRIPOIA  drop column sir_destino;
alter table T_RATOEIRA   drop column rat_destino;
alter table T_MANZUA   drop column man_destino;
alter table T_MERGULHO   drop column mer_destino;
alter table T_VARAPESCA   drop column vp_destino;
alter table T_grosseira   drop column grs_destino;
alter table T_LINHA   drop column lin_destino;
alter table T_JERERE   drop column jre_destino;
alter table T_TARRAFA   drop column tar_destino;
alter table T_EMALHE   drop column em_destino;
alter table T_CALAO   drop column cal_destino;

pg_dump -U mohonda DB_Pesca --column-inserts --inserts --schema=public -a -t T_ARRASTOFUNDO -t t_linhafundo -t  T_COLETAMANUAL -t T_SIRIPOIA -t T_RATOEIRA -t T_MANZUA -t T_MERGULHO -t T_VARAPESCA -t T_grosseira -t T_LINHA -t T_JERERE -t T_TARRAFA -t T_EMALHE -t T_CALAO -t T_DESTINOPESCADO > /tmp/01.sql