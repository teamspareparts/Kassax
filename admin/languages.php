<?php declare(strict_types=1);
require '_start.php';
/**
 * @var $db DByhteys
 * @var $user User
 * @var $lang Language
 */

tarkista_feedback_POST();

$kielet = LanguageController::getLanguages( $db );
$sivut = LanguageController::getSivut( $db );

$json_files = array();
foreach ( $kielet as $k ) {
	$json_files[$k->lang] = file_get_contents( "../lang/{$k->lang}.json" );
}
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
			<div class="tab-content" id="nav-tabDBContent">

				<?php foreach ( $kielet as $k ) : ?>
					<div class="tab-pane fade bg-white" id="nav-db-<?= $k->lang ?>"
					     role="tabpanel" aria-labelledby="nav-db-<?= $k->lang ?>-tab">

						<!-- PAGES TABS :: _common / index / ... -->
						<nav>
							<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
								<?php foreach ( $sivut as $s ) : ?>
									<a class="nav-item nav-link" id="nav-db-<?= $k->lang ?>-<?= $s->sivu ?>-tab"
									   data-toggle="tab"
									   href="#nav-db-<?= $k->lang ?>-<?= $s->sivu ?>"
									   role="tab"
									   aria-controls="nav-db-<?= $k->lang ?>-<?= $s->sivu ?>" aria-selected="true">
										<?= $s->sivu ?>
									</a>
								<?php endforeach; ?>
							</div>
						</nav>

						<!-- PAGES TAB CONTENTS -->
						<div class="tab-content" id="nav-tabDBpageContent">

							<?php foreach ( $sivut as $s ) : ?>
								<div class="tab-pane fade bg-white" id="nav-db-<?= $k->lang ?>-<?= $s->sivu ?>"
								     role="tabpanel" aria-labelledby="nav-db-<?= $k->lang ?>-<?= $s->sivu ?>-tab">

									<form>
										<label><?= $k->lang ?>
											<input type="text" placeholder=" <?= $s->sivu ?> ">
										</label>
									</form>

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
								          class="d-block w-100"><?= $json_files[$k->lang] ?></textarea>
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
