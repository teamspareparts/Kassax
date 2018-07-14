<?php declare(strict_types=1); ?>

<footer class="footer">

	<!-- Kassax text -->
	<span class="centered">
		<?= $lang->FOOTER_CENTER ?>
	</span>

	<!-- Settings dropdown, language selector -->
	<div class="footer-settings dropup">

		<button class="centered dropdown-toggle btn btn-sm"
		        type="button" id="dropdownMenuButton" data-toggle="dropdown"
		        aria-haspopup="true" aria-expanded="false">
			<i class="material-icons">settings</i>
		</button>

		<div class="dropdown-menu dropdown-menu-right">

			<p class="dropdown-item">Hello world!</p>
			<hr>
			<a class="dropdown-item" href="../tietokanta/lang_install.php">Language install</a>
			<a class="dropdown-item" href="./languages.php">Language settings</a>
			<hr>

		</div>

	</div>

</footer>
