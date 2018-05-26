<?php declare(strict_types=1);
session_start();
$config = parse_ini_file( "./cfg/config.ini.php" );

/**
 * Tarkistetaan onko kyseessä uudelleenohjaus, ja tulostetaan viesti sen mukaan.
 */
if ( !empty($_GET['redir']) || !empty($_SESSION['id']) ) {

	$mode = !empty( $_SESSION[ 'id' ] ) ? 99 : $_GET[ "redir" ];

	/**
	 * @var array <p> Pitää sisällään käyttäjälle sisälle tulostettavan viestin.
	 * GET-arvona saatava $mode määrittelee mikä index tulostetaan.
	 */
	$modes_array = [
		1 => array(
			"otsikko" => "Väärät kirjautumistiedot",
			"teksti" => "Varmista, että kirjoitit tiedot oikein.",
			"style" => "error" ),
		2 => array(
			"otsikko" => "Väärä yritystunnus",
			"teksti" => "Ditto",
			"style" => "error" ),
		3 => array(
			"otsikko" => "Väärät käyttäjätunnus",
			"teksti" => "Ditto",
			"style" => "error" ),
		4 => array(
			"otsikko" => "Väärä salasana",
			"teksti" => "Ditto",
			"style" => "error" ),
		5 => array(
			"otsikko" => "Käyttäjätili de-aktivoitu",
			"teksti" => "Ylläpitäjä on poistanut käyttöoikeutesi palveluun.",
			"style" => "error" ),
		10 => array(
			"otsikko" => "Et ole kirjautunut sisään",
			"teksti" => "Sinun pitää kirjautua sisään ennen kuin voit käyttää sivustoa.",
			"style" => "error" ),
		20 => array(
			"otsikko" => "Kirjaudutaan ulos",
			"teksti" => "Olet onnistuneesti kirjautunut ulos.",
			"style" => "info" ),

		98 => array(
			"otsikko" => " Error ",
			"teksti" => 'Jotain meni vikaan',
			"style" => "error" ),
		99 => array(
			"otsikko" => "Olet jo kirjautunut sisään.",
			"teksti" => '<p><a href="etusivu.php">Linkki etusivulle</a>
						<p><a href="logout.php">Kirjaudu ulos</a>',
			"style" => "info" ),
	];
}
$css_version = filemtime( 'css/login.css' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="icon" type="image/jpg" href="img/favicon.jpg"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" type="text/css" href="css/login.css?v=<?= $css_version ?>">
</head>
<body>
<main class="login_container">
	<img src="img/kassax_logo.jpg" alt="Kassax">

	<noscript>
		<div class="error">
			<span style="font-weight:bold;">Sivusto vaatii javascriptin toimiakseen.</span> <hr>
			Juuri nyt käyttämässäsi selaimessa ei ole javascript päällä.
			Ohjeet miten javascriptin saa päälle selaimessa (englanniksi):
			<a href="http://www.enable-javascript.com/" target="_blank">
				instructions how to enable JavaScript in your web browser</a>.
		</div>
	</noscript>

	<?php if ( !empty( $mode ) && !empty( $modes_array ) && array_key_exists( $mode, $modes_array ) ) : ?>
		<div class="<?= $modes_array[ $mode ][ 'style' ] ?>">
			<span style="font-weight:bold;display: block;"> <?= $modes_array[ $mode ][ 'otsikko' ] ?> </span>
			<hr>
			<?= $modes_array[ $mode ][ 'teksti' ] ?>
		</div>
	<?php endif;
	if ( $config[ 'update' ] ) : ?>
		<div class="warning">
			<?= $config[ 'update_txt' ] ?>
		</div>
	<?php endif;
	if ( $config[ 'indev' ] ) : ?>
		<div class="warning">
			<?= $config[ 'indev_txt' ] ?>
		</div>
	<?php endif; ?>

	<fieldset><legend>Sisäänkirjautuminen</legend>
		<form action="login_check.php" method="post" accept-charset="utf-8">

			<label>Yritystunnus:
				<input type="text" name="yritys" placeholder="Yrityksen kirjautumistunnus" id="login_yritys"
				       required autofocus disabled>
			</label>

			<label>Käyttäjätunnus:
				<input type="text" name="kayttaja" placeholder="Käyttäjätunnus" id="login_user"
				       required>
			</label>

			<label>Salasana:
				<input type="password" name="salasana" placeholder="Salasana" pattern=".{5,255}$" required>
			</label>

			<input type="hidden" name="mode" value="login">
			<input type="submit" value="Kirjaudu sisään" id="login_submit" disabled>

		</form>
	</fieldset>

	<fieldset><legend>Kieli / Language <i class="material-icons">language</i> </legend>

	</fieldset>
</main>

<footer class="footer">
	<span>
		Kassax
	</span>
</footer>

<script>
	let update = 0;
	update = <?= $config['update'] ?>;
	if ( update < 2 ) {
		document.getElementById('login_yritys').removeAttribute('disabled');
		document.getElementById('login_submit').removeAttribute('disabled');
	}
	window.history.pushState('login', 'Title', 'index.php'); //Poistetaan GET URL:sta
</script>

</body>
</html>
