<?php declare(strict_types=1); ?>

<noscript>
	<meta http-equiv="refresh" content="0; url=index.php">
</noscript>

<header>

	<section class="d-flex flex-row align-items-center hidden"
		style="background-color: white;">
		<div>
			<a href="./index.php"> <img src="./../img/kassax_logo.jpg" height="30px"> </a>
		</div>
		<div class="container">
			<?= $lang->HEADER_WELCOME ?>
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
					<a class="nav-link" href="#"><?= $lang->NAV_ITEM_1 ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"><?= $lang->NAV_ITEM_2 ?></a>
				</li>
			</ul>
		</div>
		<!-- Right -->
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="./../logout.php"><?= $lang->NAV_LOGOUT ?></a>
				</li>
			</ul>
		</div>
	</nav>

</header>
