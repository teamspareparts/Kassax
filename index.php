<?php declare(strict_types=1);

require './luokat/language.class.php';
require './luokat/dbyhteys.class.php';

session_start();

$config = parse_ini_file( "./cfg/config.ini.php" );
$db = new DByhteys( $config );

$GET_lang = !empty($_GET['lang']) ? $_GET['lang'] : 'fin';
$lang = new Language( $db, $GET_lang, false, 'login' );

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
			"otsikko" => $lang->ERR1_FS_LEGEND,
			"teksti" => $lang->ERR1_FS_TEXT,
			"style" => "error" ),
		2 => array(
			"otsikko" => $lang->ERR2_FS_LEGEND,
			"teksti" => $lang->ERR2_FS_TEXT,
			"style" => "error" ),
		3 => array(
			"otsikko" => $lang->ERR3_FS_LEGEND,
			"teksti" => $lang->ERR3_FS_TEXT,
			"style" => "error" ),
		4 => array(
			"otsikko" => $lang->ERR4_FS_LEGEND,
			"teksti" => $lang->ERR4_FS_TEXT,
			"style" => "error" ),
		5 => array(
			"otsikko" => $lang->ERR5_FS_LEGEND,
			"teksti" => $lang->ERR5_FS_TEXT,
			"style" => "error" ),
		10 => array(
			"otsikko" => $lang->ERR10_FS_LEGEND,
			"teksti" => $lang->ERR10_FS_TEXT,
			"style" => "error" ),
		20 => array(
			"otsikko" => $lang->ERR20_FS_LEGEND,
			"teksti" => $lang->ERR20_FS_TEXT,
			"style" => "info" ),

		98 => array(
			"otsikko" => " Error ",
			"teksti" => 'Jotain meni vikaan',
			"style" => "error" ),
		99 => array(
			"otsikko" => $lang->ERR99_FS_LEGEND,
			"teksti" => "<p><a href='login_check.php?redir_to_frontpage'>{$lang->ERR99_FS_TEXT1}</a>
						<p><a href='logout.php'>{$lang->ERR99_FS_TEXT2}</a>",
			"style" => "info" ),
	];
}
$css_version = filemtime( 'css/login.css' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?= $lang->HTML_TITLE ?></title>
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

	<fieldset><legend><?= $lang->LOGIN_FS_LEGEND ?></legend>
		<form action="login_check.php" method="post" accept-charset="utf-8">

			<label><?= $lang->LOGIN_YRIT ?>:
				<input type="text" name="yritys" placeholder="<?= $lang->LOGIN_YRIT_PH ?>" id="login_yritys"
				       required autofocus disabled>
			</label>

			<label><?= $lang->LOGIN_USER ?>:
				<input type="text" name="kayttaja" placeholder="<?= $lang->LOGIN_USER_PH ?>" id="login_user"
				       required>
			</label>

			<label><?= $lang->LOGIN_PASS ?>:
				<input type="password" name="salasana" placeholder="<?= $lang->LOGIN_PASS_PH ?>" pattern=".{5,255}$" required>
			</label>

			<input type="hidden" name="mode" value="login">
			<input type="submit" value="<?= $lang->LOGIN_BUTTON ?>" id="login_submit" disabled>

		</form>
	</fieldset>

	<fieldset>
		<legend>
			<?= $lang->LANG_FS_LEGEND ?> <?= ($lang->lang != 'eng') ? '/ Language' : '' ?>
			<i class="material-icons">language</i>
		</legend>

		<p><a href="?lang=eng">English</a></p>
		<p><a href="?lang=fin">Finnish</a></p>
	</fieldset>
</main>

<footer class="footer">
	<span class="centered">
		Kassax
	</span>
	<!-- Failed attempt to include language dropup menu to footer --JJ 180702
	<div class="footer-settings">
		<span><i class="material-icons">language</i></span>
		<div class="dropdown-content">
			<p>Hello world!</p>
		</div>
	</div>
	-->
</footer>

<script>
	let update = 0;
	update = <?= $config['update'] ?>;
	if ( update < 2 ) {
		document.getElementById('login_yritys').removeAttribute('disabled');
		document.getElementById('login_submit').removeAttribute('disabled');
	}
</script>

</body>
</html>
