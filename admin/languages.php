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
			<div class="tab-content" id="nav-tabDBContent" style="border-top: 1px solid #2f5cad">

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
					<div class="tab-content" id="nav-tabDB_adCl_Content" style="border-top: 1px solid #2f5cad">

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
							<div class="tab-content" id="nav-tabDBpageContent">

								<?php foreach ( $sivut[ $a_c ] as $s ) : ?>
								<div class="tab-pane fade bg-white"
								     id="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>"
								     role="tabpanel"
								     aria-labelledby="nav-db-<?= $k->lang ?>-<?= $a_c ?>-<?= $s->sivu ?>-tab">

									<?php foreach (
										$lang_strings[ $k->lang ][ $a_c ][ $s->sivu ] as $ss ) :
										?>

									<form method="post">
										<div class="form-group">
											<label>
												<?= $ss->tyyppi ?>

												<?php if ( count( $ss->tyyppi ) < 20 ) : ?>
												<input type="text" placeholder=" <?= $ss->tyyppi ?> "
												       class="form-control d-block" minlength="1"
												       maxlength="255">
												<?php else : ?>
												<textarea wrap="soft" rows="3" class="form-control">
												<?= $ss->teksti ?>
												</textarea>
												<?php endif; ?>

											</label>
											<input type="submit" value="Päivitä">
										</div>
									</form>
									<?php endforeach; ?>

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
							<label class="w-100"><?= $lang->LABEL ?>
								<textarea wrap="soft" rows="20"
								          class="d-block w-100"><?= $json_files[ $k->lang ] ?></textarea>
							</label>
							<input type="submit" value="<?= $lang->SAVE ?>"
							       class="btn-primary d-block w-100 lang-json-submit">
						</form>
					</div>
				<?php endforeach; ?>

			</div>
		</div>

	</div>


</main>

<?php require 'html_footer.php'; ?>

<script>
</script>

</body>
</html>
