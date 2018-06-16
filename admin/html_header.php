<?php declare(strict_types=1); ?>

<noscript>
	<meta http-equiv="refresh" content="0; url=index.php">
</noscript>

<style>
	#css-headertop { background-color: white; }
</style>

<header>

	<section class="d-flex flex-row align-items-center" id="css-headertop">
		<div>
			<a href="./index.php"> <img src="./../img/kassax_logo.jpg"> </a>
		</div>
		<div class="container" id="head_info">
			WIP HEADER TESTING
		</div>
	</section>

	<nav class="navbar navbar-expand-md navbar-light bg-light">
		<!-- Brand & hamburger-icon -->
		<a class="navbar-brand" href="./index.php">
			<img src="./../img/kassax_logo.jpg" style="height: 27px;">
<!--			<i class="material-icons" style="margin-top: -3px;">home</i>-->
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".collapse"
		        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<!-- Left -->
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="#">Asiakkaat</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Raportit</a>
				</li>
			</ul>
		</div>
		<!-- Right -->
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="./../logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<hr>

	<nav class="navigationbar" id="navbar">
		<ul>
			<li><a href='./index.php' style="padding-left:15px; padding-right: 15px;">
					<i class="material-icons" style="margin-top: -3px;">home</i></a>
			</li>

			<li><a href='#'>Asiakkaat</a></li>
			<li><a href='#'>Raportit</a></li>

			<li class="last">
				<a href="../logout.php?redir=5">Kirjaudu ulos <i class="material-icons">exit_to_app</i></a>
			</li>
		</ul>
	</nav>

</header>
