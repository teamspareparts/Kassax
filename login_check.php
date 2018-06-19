<?php declare(strict_types=1);
set_include_path( get_include_path() . PATH_SEPARATOR . 'luokat/' );
spl_autoload_extensions( '.class.php' );
spl_autoload_register();

/**
 * Tarkistaa käyttäjän käyttöoikeuden sivustoon, keskitetysti yhdessä funktiossa.
 * Tarkistaa salasanan, aktiivisuuden, ja demo-tilanteen, siinä järjestyksessä.
 * @param User $user          <p> Käyttää salasana_hajautus-, aktiivinen-, demo-, ja voimassaolopvm-muuttujia
 * @param string   $user_password <p> käyttäjän antama salasana
 */
function beginning_user_checks( User $user, string $user_password ) {
	if ( !$user->verifyPassword($user_password) ) {
		header( "Location:index.php?redir=4" );
		exit;
	}
	if ( !$user->aktiivinen ) { // Tarkistetaan käyttäjän aktiivisuus
		header( "Location:index.php?redir=5" );
		exit;
	}

	/** Tarkistetaan salasanan voimassaoloaika */
	$salasanan_voimassaoloaika = 180;
	$date = new DateTime( $user->salasana_vaihdettu );
	$date->modify( "+{$salasanan_voimassaoloaika} days" );
	$now = new DateTime( 'today' );
	$diff = $now->diff( $date )->days;

	if ( $user->salasana_uusittava ) {
		$_SESSION[ 'feedback' ] = "<p class='error'>Salasana uusittava</p>";
	}
	elseif ( $date < $now ) {
		$_SESSION[ 'feedback' ] = "<p class='error'>Salasana vanhentunut.</p>";
	}
	elseif ( $diff <= 20 ) {
		$class = 'info';
		if ( $diff <= 10 ) {
			$class = 'warning';
		}

		$_SESSION[ 'feedback' ] .= "<p class='{$class}'>Salasana vanhenee {$diff} päivän päästä. 
				<a href='./omat_tiedot.php' style='text-decoration: underline;'>Vaihda salasana.</a></p>";
	}
}

if ( empty( $_POST[ "mode" ] ) ) {
	header( "Location:index.php?redir=10" );
	exit(); // Not logged in
}

$db = new DByhteys( [], './cfg/config.ini.php');
$mode = $_POST[ "mode" ];
$yritys = isset( $_POST[ "yritys" ] )
	? trim( $_POST[ "yritys" ] )
	: null;
$kayttaja = isset( $_POST[ "kayttaja" ] )
	? trim( $_POST[ "kayttaja" ] )
	: null;
$password = (isset( $_POST[ "salasana" ] ) && strlen( $_POST[ "salasana" ] ) < 300)
	? $_POST[ "salasana" ]
	: '';

if ( $mode === "login" ) {
	session_start();
	session_regenerate_id( true );

	// Haetaan käyttäjän tiedot
	$sql = "SELECT id, yritystunniste, yllapitaja
			FROM yritys 
			WHERE yritystunniste = ?
			LIMIT 1";
	/** @var Firm $yritys */
	$yritys = $db->query( $sql, [ $yritys ], false, 'Firm' );

	// Haetaan käyttäjän tiedot
	$sql = "SELECT id, yritys_id, salasana, salasana_vaihdettu, salasana_uusittava, kieli, aktiivinen
			FROM kayttaja 
			WHERE kayttajatunnus = ? AND yritys_id = ?
			LIMIT 1";
	/** @var User $user */
	$user = $db->query( $sql, [ $kayttaja, $yritys->id ], false, 'User' );

	if ( $yritys AND $user ) {
		beginning_user_checks( $user, $password );

		/*
		 * Kaikki OK, jatketaan sivustolle
		 */
		// Kirjataan ylös viimeisin kirjautumisaika ylläpitoa varten.
		$db->query( "UPDATE kayttaja SET viime_kirjautuminen = current_timestamp WHERE id = ? LIMIT 1",
					[ $user->id ] );

		// Kirjataan ylös käyttäjän ID, ja selain/OS
		// Mahdollistaa käytettyjen selaimien seurannan
		file_put_contents( "./cfg/log.txt", $user->id . '::' . $_SERVER[ 'HTTP_USER_AGENT' ] . '\r\n',
						   FILE_APPEND | LOCK_EX );

		$_SESSION[ 'id' ] = (int)$user->id;
		$_SESSION[ 'yritys_id' ] = (int)$user->yritys_id;

		$config = parse_ini_file( "./config/config.ini.php" );
		$_SESSION[ 'indev' ] = (bool)$config[ 'indev' ];

		$redirect_url = !empty( $_SESSION[ 'redirect_url' ] )
			? $_SESSION[ 'redirect_url' ]
			: ( ($yritys->yllapitaja)
				? './admin/'
				: './client/' );

		header( "Location:{$redirect_url}" );
		exit;

	}
	else {
		header( "Location:index.php?redir=1" );
		exit;
	}
}

header( "Location:index.php?redir=10" );
exit();
