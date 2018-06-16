<?php declare(strict_types=1);
require '_start.php';
/**
 * @var $db DByhteys
 * @var $user User
 * @var $lang Language
 */

tarkista_feedback_POST();
?>

<!DOCTYPE html>
<html lang="fi">

<?php require 'html_head.php'; ?>

<body>

<?php require 'html_header.php'; ?>

<main class="main_body_container">

	<h1>OTSIKKO</h1>

	<hr>

	<p class="hidden">Some text</p>

	<table style="width: 100%;">
		<thead>
			<tr><th colspan="6" class="center" style="background-color:#1d7ae2;">Testi table</th></tr>
			<tr><th>Yritys</th>
				<th>Y-tunnus</th>
				<th>Osoite</th>
				<th>Maa</th>
				<th class="smaller_cell">Poista</th>
				<th class=smaller_cell></th></tr>
		</thead>
		<tbody>
			<tr>
				<td>Yritys nimi</td>
				<td>Y-tunnus</td>
				<td>Katuosoite<br>80100 Joensuu</td>
				<td>Suomi</td>
				<td>[]</td>
				<td>
					<a href="#"><span class="nappi">Muokkaa</span></a>
				</td>
			</tr>
		</tbody>
	</table>

</main>

<?php require 'html_footer.php'; ?>

<script>
</script>

</body>
</html>
