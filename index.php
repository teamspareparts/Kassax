<?php declare(strict_types=1);
$css_version = filemtime( 'css/login.css' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/login.css?v=<?= $css_version ?>">
	<title>Login</title>
</head>
<body>
<main class="login_container">
	<img src="img/kassax_logo.jpg" alt="Kassax">

	<fieldset><legend>Sisäänkirjautuminen</legend>
		<form action="login_check.php" method="post" accept-charset="utf-8">
			<label>Sähköposti:
				<input type="email" name="email" placeholder="Nimi @ Email.com" pattern=".{8,255}$" id="login_email"
				       required autofocus disabled>
			</label>
			<br><br>
			<label>Salasana:
				<input type="password" name="password" placeholder="Salasana" pattern=".{5,255}$" required>
			</label>
			<br><br>
			<input type="hidden" name="mode" value="login">
			<input type="submit" value="Kirjaudu sisään" id="login_submit" disabled>
		</form>
	</fieldset>

	<fieldset><legend>Unohditko salasanasi?</legend>
		<form action="login_check.php" method="post" accept-charset="utf-8">
			<label>Sähköposti:
				<input type="email" name="email" placeholder="Nimi @ Email.com" pattern=".{3,255}$"
					   required autofocus>
			</label>
			<br><br>
			<input type="hidden" name="mode" value="password_reset">
			<input type="submit" value="Uusi salasana">
		</form>
	</fieldset>
</main>

<script>
	let update = 0;
	if ( update < 2 ) {
		document.getElementById('login_email').removeAttribute('disabled');
		document.getElementById('login_submit').removeAttribute('disabled');
	}
	window.history.pushState('login', 'Title', 'index.php'); //Poistetaan GET URL:sta
</script>

</body>
</html>
