<?php declare(strict_types=1);
error_reporting(E_ERROR);
ini_set('display_errors', "1");

/**
 * For debugging. Tulostaa kaikki tiedot muuttujasta käyttäen print_r()- ja var_dump()-funktioita.
 * @param mixed $var
 * @param bool  $var_dump
 */
function debug($var,bool$var_dump=false){
	echo"<br><pre>Print_r ::<br>";print_r($var);echo"</pre>";
	if($var_dump){echo"<br><pre>Var_dump ::<br>";var_dump($var);echo"</pre><br>";};
}

/**
 * Tulostaa numeron muodossa 1.000[,00 [€]]
 * @param mixed $number     <p> Tulostettava numero/luku/hinta
 * @param int   $dec_count  [optional] default=2 <p> Kuinka monta desimaalia. Jos nolla, ei €-merkkiä.
 * @param bool  $ilman_euro [optional] default=FALSE <p> Tulostetaanko float-arvo ilman €-merkkiä
 * @return string
 */
function format_number( $number, int $dec_count = 2, bool $ilman_euro = false ) : string {
	if ( $dec_count == 0 ) {
		return number_format( (float)$number, 0, ',', '.' );
	} else {
		return number_format( (float)$number, $dec_count, ',', '.' )
			. ( $ilman_euro ? '' : ' €' );
	}
}

/**
 * Tarkistetaan feedback, ja estetään formin uudelleenlähetys.
 * @return string $feedback
 */
function tarkista_feedback_POST() {
	// Estää formin uudellenlähetyksen
	if ( !empty($_POST) ){
		header("Location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
	// Tarkistaa onko SESSION-datassa feedbackia tulostettavana sivulle.
	$feedback = isset($_SESSION["feedback"]) ? $_SESSION["feedback"] : "";
	unset($_SESSION["feedback"]);
	return $feedback;
}

/*
 * Luokat ladataan jatkossa tarpeen mukaan. PHP etsii tarvittavan luokan automaattisesti luokat-kansiosta
 */
set_include_path(get_include_path().PATH_SEPARATOR.'../luokat/');
spl_autoload_extensions('.class.php');
spl_autoload_register();

/*
 * Aloitetaan sessio.
 * Sessio käyttäjän ID ja sähköposti, ja yrityksen ID.
 */
session_start();

/*
 * Luodaan tarvittava oliot
 * Näitä tarvitaan joka sivulla, joten ne luodaan jo tässä vaiheessa.
 */
$db = new DByhteys();
$user = new User( $db, $_SESSION['id'] );

/*
 * Tarkistetaan, että käyttäjä on olemassa, ja oikea, ja kirjautunut sisään.
 */
if ( !$user->isValid() ) {
	$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
	header( 'Location: ../logout.php?redir=10' );
	exit;
}

if ( !$user->isAdmin() ) {
	header("Location: client/index.php");
	exit();
}

/*
 * Lisäksi tarkistetaan EULA, jotta käyttäjä ei pysty käyttämään sivustoa ilman hyväksyntää.
 */
//elseif ( !$user->eulaHyvaksytty() ) {
//	$_SESSION['feedback'] .= "<p class='warning'>Eula ei hyväksytty</p>";
//	//$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
//    //header( 'Location: eula.php' ); exit;
//}

/*
 * Haetaan kieli viimeisenä, ensinnäkin koska se vaatii validin käyttäjän,
 * ja toiseksi, koska se saattaa hakea aika paljon tietokannasta.(?)
 */
$lang = Language::fetch(
	$db, $user->kieli, $user->isAdmin(), basename( $_SERVER[ 'SCRIPT_NAME' ] , '.php' )
);
