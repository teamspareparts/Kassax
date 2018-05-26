<?php declare(strict_types=1);
error_reporting(E_ERROR);
ini_set('display_errors', "1");
print("<pre>");

$config = parse_ini_file( "../cfg/config.ini.php", true);
require '../luokat/dbyhteys.class.php';

$db = new DByhteys( $config['Tietokanta'] );
$f = file('./tietokanta.sql', FILE_IGNORE_NEW_LINES); // Tietokannan taulut

// Poistetaan .sql-tiedoston kommentit
foreach ( $f as $k => $v ) {
	$f[$k] = strstr($v, '--', true) ?: $v;
}

// Muunnetaan jokainen query omaan indexiin
$db_file = explode( ";", implode("", $f) );
foreach ( $db_file as $sql ) {
	if ( !empty($sql) && strlen($sql) > 5 ) {
		$db->query( $sql );
	}
}

// Admin yritys
$db->query(
	"INSERT IGNORE INTO yritys
				(y_tunnus,yritystunniste,nimi,katuosoite,postinumero,postitoimipaikka,maa,puhelin,www_url,email,yllapitaja) 
			VALUES (?,?,?,?,?,?,?,?,?,?,1)",
	[   $config['Admin']['y_tunnus'],
		$config['Admin']['y_yritystunniste'],
		$config['Admin']['y_nimi'],
		$config['Admin']['y_katuosoite'],
		$config['Admin']['y_postinumero'],
		$config['Admin']['y_postitoimipaikka'],
		$config['Admin']['y_maa'],
		$config['Admin']['y_puhelin'],
		$config['Admin']['y_www_url'],
		$config['Admin']['y_sahkoposti'],
	]
);
// Admin käyttäjä
$db->query( "INSERT IGNORE INTO kayttaja (yritys_id, kayttajatunnus, salasana) VALUES (1, ?, ?)",
			[   $config['Admin']['kayttajatunnus'],
				password_hash( $config['Admin']['salasana'], PASSWORD_DEFAULT)
			]
	);

echo '<p>Tietokannan asennus on nyt suoritettu.</p>';
