create database ComercioBL;

use ComercioBL;

create table cliente(
	codcli int primary key,
    apecli varchar(15) not null,
    nomcli varchar(15) not null,
    dnicli int not null
);

create table comprobante(
	nrocom int primary key,
    tipoco varchar(2) not null,
    fecemi date not null,
    codcli int not null,
    importe int not null,
    foreign key(codcli) references cliente(codcli)
);

insert into cliente(codcli, apecli, nomcli, dnicli)
values(1, 'Bances', 'Leonardo', 75514471),
	  (2, 'Bances', 'Jose', 84958495),
      (3, 'Espinoza', 'Ana', 84748474),
      (4, 'Bances', 'Fabiana', 74859612),
      (5, 'Bances', 'Manuel', 84958495);

select * from cliente;

insert into comprobante(nrocom, tipoco, fecemi, codcli, importe)
values(0001, 'BV', '2023-05-01', 1, 750),
	  (0002, 'BV', '2023-05-02', 2, 1000),
      (0003, 'BV', '2023-06-03', 3, 7500),
      (0004, 'BV', '2023-07-08', 4, 75),
      (0005, 'BV', '2023-07-08', 5, 8440);
      
select * from comprobante;