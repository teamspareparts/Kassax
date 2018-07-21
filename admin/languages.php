<?php declare(strict_types=1);
require '_start.php';
/**
 * @var $db   DByhteys
 * @var $user User
 * @var $lang Language
 */

tarkista_feedback_POST();

$kielet = LanguageController::getLanguages( $db );
$ad_cl = [ 'ad' => 'Admin' , 'cl' => 'Client' ];
$sivut = [
	'ad' => LanguageController::getAdminSivut( $db ) ,
	'cl' => LanguageController::getClientSivut( $db )
];

$json_files = array();
foreach ( $kielet as $k ) {
	$json_files[ $k->lang ] = file_get_contents( "../lang/{$k->lang}.json" );
}

$lang_strings = LanguageController::getKaikkiTekstit( $db , $kielet , $ad_cl , $sivut );
?>

<!DOCTYPE html>
<html lang="fi">

<?php require 'html_head.php'; ?>

<body>

<?php require 'html_header.php'; ?>

<main class="main_body_container .container-fluid">

	<!-- TOP MOST NAV TABS :: DB / JSON -->
	<nav>
		<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active"
			   data-toggle="tab"
			   href="#nav-db"
			   role="tab" aria-controls="nav-db" aria-selected="true">
				DB
			</a>
			<a class="nav-item nav-link"
			   data-toggle="tab"
			   href="#nav-json"
			   role="tab" aria-controls="nav-profile" aria-selected="false">
				JSON
			</a>
		</div>
	</nav>

	<!-- TOP MOST NAV TABS CONTENT :: DB / JSON -->
	<div class="tab-content h-100" id="nav-tabContent">

		<!-- DB TAB CONTENT -->
		<div class="tab-pane fade bg-white show active h-100" id="nav-db" role="tabpanel" aria-labelledby="nav-db-tab">
			<!-- DB LANG TABS :: FIN / ENG / ... -->
			<nav>
				<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
					<?php foreach ( $kielet as $k ) : ?>
					<a class="nav-item nav-link"
					   id="nav-db-<?= $k->lang ?>-tab"
					   data-toggle="tab"
					   href="#nav-db-<?= $k->lang ?>"
					   role="tab" aria-controls="nav-db-<?= $k->lang ?>" aria-selected="true">
						<?= $k->lang ?>
					</a>
					<?php endforeach; ?>
				</div>
			</nav>

			<!-- DB LANG TAB CONTENTS -->
			<div class="tab-content" style="border-top: 1px solid #2f5cad">

				<?php foreach ( $kielet as $k ) : ?>
				<div class="tab-pane fade bg-white" id="nav-db-<?= $k->lang ?>"
				     role="tabpanel" aria-labelledby="nav-db-<?= $k->lang ?>-tab">

					<!-- DB LANG ADMIN/CLIENT TABS -->
					<nav>
						<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
							<?php foreach ( $ad_cl as $a_c => $value ) : ?>
								<a class="nav-item nav-link"
								   id="nav-db-<?= $k->lang ?>-<?= $a_c ?>-tab"
								   data-toggle="tab"
								   href="#nav-db-<?= $k->lang ?>-<?= $a_c ?>"
								   role="tab" aria-controls="nav-db-<?= $k->lang ?>-<?= $a_c ?>"
								   aria-selected="true">
									<?= $value ?>
								</a>
							<?php endforeach; ?>
						</div>
					</nav>

					<!-- DB LANG ADMIN/CLIENT TAB CONTENTS -->
					<div class="tab-content" style="border-top: 1px solid #2f5cad">

						<?php foreach ( $ad_cl as $a_c => $value ) : ?>
						<div class="tab-pane fade bg-white" id="nav-db-<?= $k->lang ?>-<?= $a_c ?>"
						     role="tabpanel" aria-labelledby="nav-db-<?= $k->lang ?>-<?= $a_c ?>-tab">

							<!-- PAGES TABS :: _common / index / ... -->
							<nav>
								<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
									<?php foreach ( $sivut[ $a_c ] as $s ) : ?>
									<a class="nav-item nav-link"
									   id="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>-tab"
									   data-toggle="tab"
									   href="#nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>"
									   role="tab"
									   aria-controls="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>"
									   aria-selected="true">
										<?= $s->sivu ?>
									</a>
									<?php endforeach; ?>
								</div>
							</nav>

							<!-- PAGES TAB CONTENTS -->
							<div class="tab-content">

								<?php foreach ( $sivut[ $a_c ] as $s ) : ?>
								<div class="tab-pane fade bg-white"
								     id="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>"
								     role="tabpanel"
								     aria-labelledby="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>-tab">

									<?php foreach ( $lang_strings[ $k->lang ][ $a_c ][ $s->sivu ] as $txt ) : ?>
									<form method="post" style="padding: .5em">
										<input type="hidden" name="lang" value="<?= $k->lang ?>">
										<input type="hidden" name="admin" value="<?= $a_c ?>">
										<input type="hidden" name="page" value="<?= $s->sivu ?>">
										<input type="hidden" name="type" value="<?= $txt->tyyppi ?>">

										<div class="d-flex flex-row">
											<div class="d-flex flex-column" style="padding: .5em; min-width: 20%">
												<span><?= $txt->tyyppi ?></span>
												<button type="submit">
													<i class="material-icons">autorenew</i>
												</button>
											</div>

											<div class="d-flex flex-fill">
												<textarea wrap="soft" rows="2" minlength="1"
												          class="form-control" title="<?= $txt->tyyppi ?>"><?=
													$txt->teksti
												?></textarea>
											</div>
										</div>

									</form>
									<?php endforeach; ?>

									<button type="submit" class="btn-primary w-100"
									        style="height: 2.5em">
										<i class="material-icons">add</i>
									</button>

								</div>
								<?php endforeach; ?>

							</div>

						</div>
						<?php endforeach; ?>
					</div>

				</div>
				<?php endforeach; ?>

			</div>
		</div>

		<!-- JSON TAB CONTENT -->
		<div class="tab-pane fade bg-white" id="nav-json" role="tabpanel" aria-labelledby="nav-json-tab">
			<!-- JSON LANG TABS :: FIN / ENG / other -->
			<nav>
				<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">

					<?php foreach ( $kielet as $k ) : ?>
						<a class="nav-item nav-link"
						   id="nav-json-<?= $k->lang ?>-tab"
						   data-toggle="tab"
						   href="#nav-json-<?= $k->lang ?>"
						   role="tab" aria-controls="nav-json-<?= $k->lang ?>" aria-selected="true">
							<?= $k->lang ?>
						</a>
					<?php endforeach; ?>

				</div>
			</nav>

			<!-- JSON LANG TAB CONTENTS -->
			<div class="tab-content" id="nav-tabJSONContent">

				<?php foreach ( $kielet as $k ) : ?>
					<div class="tab-pane fade bg-white" id="nav-json-<?= $k->lang ?>"
					     role="tabpanel" aria-labelledby="nav-json-<?= $k->lang ?>-tab">
						<form>
							<textarea wrap="soft" rows="20" class="d-block w-100" title="JSON file text"><?=
								$json_files[ $k->lang ]
							?></textarea>

							<button type="submit" class="btn-primary w-100" style="height: 2.5em">
								<i class="material-icons">save</i>
							</button>
						</form>
					</div>
				<?php endforeach; ?>

			</div>
		</div>

	</div>


</main>

<?php require 'html_footer.php'; ?>

<script>
	$(document).on('submit', 'form', function(e) {
		e.preventDefault();

		console.log(e);
		console.log(e.target);

		return false;
	});
</script>

</body>
</html>
