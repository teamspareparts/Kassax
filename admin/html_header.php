<?php declare(strict_types=1); ?>

<noscript>
	<meta http-equiv="refresh" content="0; url=index.php">
</noscript>

<header>

	<section class="d-flex flex-row align-items-center hidden" style="background-color: white;">
		<div>
			<a href="./index.php">
				<img src="./../img/kassax_logo.jpg" height="30">
			</a>
		</div>
		<div class="container">
			<?= $lang->HEADER_WELCOME ?>
		</div>
	</section>


	<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #2f5cad;">

		<!-- Brand & hamburger-icon -->
<!--		<a class="navbar-brand" href="./index.php">-->
<!--			<img src="./../img/kassax_logo.jpg" style="height: 27px;">-->
<!--			<i class="material-icons" style="margin-top: -3px;">home</i>-->
<!--		</a>-->
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

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
					   aria-haspopup="true" aria-expanded="false">

						<i class="material-icons">
							more_vert
						</i>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
						<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
						<hr>
						<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
						<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
						<hr>
						<a class="dropdown-item" href="./company_add.php"><?= $lang->NAV_COMP_ADD ?></a>
					</div>
				</li>
			</ul>
		</div>

		<!-- Right -->
		<ul class="navbar-nav ml-auto">

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
				   aria-haspopup="true" aria-expanded="false">
					<i class="material-icons">
						account_box
					</i>
				</a>

				<div class="dropdown-menu dropdown-menu-right"
				     aria-labelledby="navbarDropdownMenuLink">

					<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
					<a class="dropdown-item" href="#"><?= $lang->NAV_TEST_0 ?></a>
					<hr>
					<a class="dropdown-item nav-logout" href="./../logout.php">
						<?= $lang->NAV_LOGOUT ?>
						<i class="material-icons">
							exit_to_app
						</i>
					</a>
				</div>
			</li>

			<li class="nav-item">
			</li>
		</ul>
	</nav>

</header>
