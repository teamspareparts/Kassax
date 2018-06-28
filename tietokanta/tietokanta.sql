/*
ColumnType  | Max Value (signed/unsigned)

  TINYINT   |   127 / 255
 SMALLINT   |   32767 / 65535
MEDIUMINT   |   8388607 / 16777215
      INT   |   2147483647 / 4294967295
   BIGINT   |   9223372036854775807 / 18446744073709551615
*/

create table if not exists yritys (
	id               smallint unsigned not null auto_increment, -- PK
	y_tunnus         varchar(9)        not null, -- UK
	yritystunniste   varchar(50)       not null comment 'Kirjautumista varten', -- UK
	nimi             varchar(255)      not null,
	katuosoite       varchar(255),
	postinumero      varchar(10),
	postitoimipaikka varchar(255),
	maa              varchar(255),
	puhelin          varchar(20),
	www_url          varchar(255) comment 'Yrityksen WWW-osoite',
	email            varchar(255),
	logo             varchar(255) comment 'Tiedosto-polku',
	aktiivinen       boolean           not null  default true,
	yllapitaja       boolean           not null  default false,
	primary key (id),
	unique key (y_tunnus),
	unique key (yritystunniste)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists yritys_pankkitili (
	yritys_id  smallint unsigned not null, -- PK, FK
	pankkitili varchar(255)      not null
	comment '',
	primary key (yritys_id),
	unique key (yritys_id, pankkitili),
	constraint fk_yrityspankkitili_yritys foreign key (yritys_id) references yritys (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;


create table if not exists toimittaja (
	id               smallint unsigned not null auto_increment, -- PK
	nimi             varchar(255)      not null,
	katuosoite       varchar(255),
	postinumero      varchar(10),
	postitoimipaikka varchar(255),
	maa              varchar(255),
	www_url          varchar(255) comment 'Yrityksen WWW-osoite',
	tl_www_url       varchar(255) comment 'Tuoteluettelo WWW-URL',
	tl_tunnus        varchar(255) comment 'Tuoteluettelo käyttäjätunnus',
	tl_salasana      varchar(255) comment 'Tuoteluettelo salasana',
	primary key (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists toimittaja_pankkitili (
	toimittaja_id smallint unsigned not null, -- PK, FK
	pankkitili    varchar(255)      not null
	comment '',
	primary key (toimittaja_id),
	unique key (toimittaja_id, pankkitili),
	constraint fk_toimittajapankkitili_yritys foreign key (toimittaja_id) references toimittaja (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1
	comment 'Toimittajan pankkitili, One-to-Many';

/**
 *
 *  Taulu joka linkittää yrityksiä jotenkin? KAi
 *
 */

create table if not exists kayttaja (
	id                  smallint unsigned not null auto_increment, -- PK
	yritys_id           smallint unsigned not null, -- FK
	kayttajatunnus      varchar(255)      not null comment 'Kirjautumista varten',
  nimi                varchar(255)      null     default null,
	salasana            varchar(255)      not null comment 'Hashed & salted',
	salasana_vaihdettu  timestamp                  default CURRENT_TIMESTAMP
											comment 'Milloin viimeksi salasana vaihdettu',
	salasana_uusittava  boolean           not null default 0,
	viime_kirjautuminen timestamp         null     default null,
	kieli               varchar(3)        not null default 1 comment 'Three character language code ISO 639-2/T',
	aktiivinen          boolean           not null default true,
	yllapitaja          boolean           not null default false,
	primary key (id),
	constraint fk_kayttaja_yritys foreign key (yritys_id) references yritys (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists tuote (
	id                    smallint unsigned not null auto_increment, -- PK
	tuotekoodi            varchar(255)      not null,
	nimi                  varchar(255),
	toimittaja_tuoteryhma tinyint,
	toimittaja_aleryhma   tinyint,
	toimittaja_svh        decimal(11, 4) comment 'Suositusvähittäishinta',
	toimittaja_nto        decimal(11, 4) comment 'nettohinta, tuotteen ostohinta',
	myynti_yksikko        varchar(10) comment 'litra, kg, kpl, metri...',
	ean_koodi             varchar(255),
	ostotarjoushinta      decimal(11, 4),
	primary key (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists toimittaja_nto (
	tuote_id       smallint unsigned not null, -- PK FK
	toimittaja_id  smallint unsigned not null, -- PK FK
	toimittaja_nto smallint unsigned not null, -- FK
	primary key (tuote_id, toimittaja_id),
	constraint fk_toimittajanto_tuote foreign key (tuote_id) references tuote (id),
	constraint fk_toimittajanto_toimittaja foreign key (toimittaja_id) references toimittaja (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists tuote_ostotarjoushinta (
	tuote_id         smallint unsigned not null, -- PK, FK
	yritys_id        smallint unsigned not null, -- PK, FK
	ostotarjoushinta decimal(11, 4),
	pvm_alkaa        timestamp         not null default CURRENT_TIMESTAMP,
	pvm_loppuu       timestamp         not null default CURRENT_TIMESTAMP,
	primary key (tuote_id, yritys_id),
	constraint fk_tuoteostotarjoushinta_tuote foreign key (tuote_id) references tuote (id),
	constraint fk_tuoteostotarjoushinta_yritys foreign key (yritys_id) references yritys (id)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;

create table if not exists lang (
	lang   varchar(3)   not null comment 'Three character language code ISO 639-2/T', -- PK
	admin  boolean      not null comment 'Client vai admin puoli sivustosta', -- PK
	sivu   varchar(10)  not null comment 'Millä sivulla teksti on', -- PK
	tyyppi varchar(30)  not null comment 'Mikä teksti kyseessä', -- PK
	teksti varchar(255) not null,
	primary key (lang, admin, sivu, tyyppi)
)
	default charset = utf8
	collate = utf8_swedish_ci
	auto_increment = 1;
