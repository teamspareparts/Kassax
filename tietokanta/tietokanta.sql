CREATE TABLE IF NOT EXISTS yritys (
  id smallint UNSIGNED NOT NULL AUTO_INCREMENT, -- PK
  y_tunnus varchar(9) NOT NULL,  -- UK
  yritystunniste varchar(50) NOT NULL COMMENT 'Kirjautumista varten', -- UK
  nimi varchar(255) NOT NULL,
  katuosoite VARCHAR(255),
  postinumero varchar(10),
  postitoimipaikka VARCHAR(255),
  maa VARCHAR(255),
  puhelin varchar(20),
  www_url VARCHAR(255) COMMENT 'Yrityksen WWW-osoite',
  email VARCHAR(255),
  logo VARCHAR(255) COMMENT 'Tiedosto-polku',
  PRIMARY KEY (id),
  UNIQUE KEY (y_tunnus),
  UNIQUE KEY (yritystunniste)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS yritys_pankkitili (
  yritys_id smallint UNSIGNED NOT NULL, -- PK, FK
  pankkitili VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (yritys_id), UNIQUE KEY (yritys_id, pankkitili),
  CONSTRAINT fk_yritysPankkitili_yritys FOREIGN KEY (yritys_id) REFERENCES yritys(id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 COMMENT 'Yrityksen pankkitili';


CREATE TABLE IF NOT EXISTS toimittaja (
  id smallint UNSIGNED NOT NULL AUTO_INCREMENT, -- PK
  nimi varchar(255) NOT NULL,
  katuosoite VARCHAR(255),
  postinumero varchar(10),
  postitoimipaikka VARCHAR(255),
  maa VARCHAR(255),
  www_url VARCHAR(255) COMMENT 'Yrityksen WWW-osoite',
  tl_www_url VARCHAR(255) COMMENT 'Tuoteluettelo WWW-URL',
  tl_tunnus VARCHAR(255) COMMENT 'Tuoteluettelo käyttäjätunnus',
  tl_salasana VARCHAR(255) COMMENT 'Tuoteluettelo salasana',
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS toimittaja_pankkitili (
  toimittaja_id smallint UNSIGNED NOT NULL, -- PK, FK
  pankkitili VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (toimittaja_id), UNIQUE KEY (toimittaja_id, pankkitili),
  CONSTRAINT fk_toimittajaPankkitili_yritys FOREIGN KEY (toimittaja_id) REFERENCES toimittaja(id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 COMMENT 'Toimittajan pankkitili; One-to-Many';

/**
Taulu joka linkittää yrityksiä jotenkin? KAi
 */

CREATE TABLE IF NOT EXISTS kayttaja (
  id smallint UNSIGNED NOT NULL AUTO_INCREMENT, -- PK
  yritys_id smallint UNSIGNED NOT NULL, -- FK
  PRIMARY KEY (id),
  CONSTRAINT fk_kayttaja_yritys FOREIGN KEY (yritys_id) REFERENCES yritys(id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS tuote (
  id smallint UNSIGNED NOT NULL AUTO_INCREMENT, -- PK
  tuotekoodi varchar(255) NOT NULL,
  nimi varchar(255),
  toimittaja_tuoteryhma tinyint,
  toimittaja_aleryhma tinyint,
  toimittaja_svh decimal(11,4) comment 'Suositusvähittäishinta',
  toimittaja_nto decimal(11,4) comment 'nettohinta, tuotteen ostohinta',
  myynti_yksikko varchar(10) comment 'litra, kg, kpl, metri...',
  EAN_koodi varchar(255),
  ostotarjoushinta decimal(11,4),
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS toimittaja_nto (
  tuote_id smallint UNSIGNED NOT NULL, -- PK FK
  yritys_id smallint UNSIGNED NOT NULL, -- PK FK
  toimittaja_nto smallint UNSIGNED NOT NULL, -- FK
  PRIMARY KEY (tuote_id, yritys_id),
  CONSTRAINT fk_toimittajaNTO_yritys FOREIGN KEY (yritys_id) REFERENCES yritys(id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS tuote_ostotarjoushinta (
  tuote_id smallint UNSIGNED NOT NULL, -- FK
  yritys_id smallint UNSIGNED NOT NULL, -- FK
  ostotarjoushinta decimal(11,4),
  pvm_alkaa timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pvm_loppuu timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP + INTERVAL 6 MONTH,
  PRIMARY KEY (tuote_id, yritys_id),
  CONSTRAINT fk_tuoteOstotarjoushinta_yritys FOREIGN KEY (yritys_id) REFERENCES yritys(id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1;

/*
ColumnType  | Max Value (signed/unsigned)

  TINYINT   |   127 / 255
 SMALLINT   |   32767 / 65535
MEDIUMINT   |   8388607 / 16777215
      INT   |   2147483647 / 4294967295
   BIGINT   |   9223372036854775807 / 18446744073709551615
*/
