<?php
require '_start.php'; global $db, $user;

require 'html_head.php';
require 'html_header.php';

if ( isset($_POST['add']) ) {
	$tiedot = [
		$_POST['katuosoite'],
		$_POST['postinumero'],
		$_POST['postitoimipaikka'],
		$_POST['maa'],
		$_POST['puhelinnumero'],
		$_POST['www'],
		$_POST['email'],
		$_POST['logo']
	];
	if ( !Companies::createCompany($db, $_POST['y-tunnus'], $_POST['yritystunniste'], $_POST['nimi']) ) {
		// FAIL
	} else {
		$id = Companies::getCompanyIdByCompanyLoginName($db, $_POST['yritystunniste']);
		$company = new Company($db, $id);
		$company->updateCompany($db, $tiedot, []);
		// Success
	}
}

?>

<div class="container">
	<form method="post" class="needs-validation" id="xxx" novalidate>

		<!-- div changed to label, changed CSS to make block element -->
		<label class="form-group">
			<!-- label to span, added CSS: label (inline-block & margin-bottom) & required (red *) -->
			<span class="label required">Nimi</span>
			<!-- Input not changed -->
			<input type="text" name="nimi" class="form-control" id="nimi" placeholder="Nimi">
		</label>

		<label class="form-group">
			<!-- You can also leave the label there, because apparently label inside label is just fine ¯\_(ツ)_/¯ -->
			<!-- But for="" here is still mandatory, koska muuten hiiren klikkaus suoraan labelin päällä ei toimi -->
			<label for="ytun" class="required">Y-tunnus</label>
			<input type="text" name="y-tunnus" class="form-control" id="ytun" placeholder="Y-tunnus"
			       pattern="[0-9]{6,7}-[0-9]" required>

			<!-- feedback div changed to span, seems to make no difference.
				Block elements not alloved inside label -->
			<span class="invalid-feedback">
				<?php //TODO : Feedback string from db
					echo "invalid"
				?>
			</span>
		</label>

		<label class="form-group">
			<span class="label required">Yritystunniste</span>
			<input type="text" name="yritystunniste" class="form-control" placeholder="Yritystunniste" minlength="3" required>
			<span class="invalid-feedback">
				<?php //TODO : Feedback string from db
					echo "Min length: 3"
				?>
			</span>
		</label>

		<label class="form-group">
			<span class="label">Katuosoite</span>
			<input type="text" name="katuosoite" class="form-control" placeholder="Katuosoite">
		</label>

		<div class="row">
			<div class="col-sm">
				<label class="form-group">
					<label for="postinumero">Postinumero</label>
					<input type="text" name="postinumero" class="form-control" id="postinumero" placeholder="Postinumero">
				</label>
			</div>
			<div class="col-sm">
				<label class="form-group">
					<label for="postitoimipaikka">Postitoimipaikka</label>
					<input type="text" name="postitoimipaikka" class="form-control" id="postitoimipaikka" placeholder="Postitoimipaikka">
				</label>
			</div>
			<div class="col-sm">
				<label class="form-group">
					<label for="maa">Maa</label>
					<input type="text" name="maa" class="form-control" id="maa" placeholder="Maa">
				</label>
			</div>
		</div>
		<label class="form-group">
			<label for="puhelinnumero">Puhelinnumero</label>
			<input type="text" name="puhelinnumero" class="form-control" id="puhelinnumero" placeholder="Puhelinnumero">
		</label>
		<label class="form-group">
			<label for="www">www-osoite</label>
			<input type="text" name="www" class="form-control" id="www" placeholder="www-osoite">
		</label>
		<label class="form-group">
			<label for="email">Sähköpostiosoite</label>
			<input type="text" name="email" class="form-control" id="email" placeholder="Sähköpostiosoite">
		</label>
		<label class="form-group">
			<label for="logo">Logotiedosto</label>
			<input type="text" name="logo" class="form-control" id="logo" placeholder="tiedosto tai url">
		</label>
		<button type="submit" name="add" class="btn btn-primary">Submit</button>
	</form>
</div>

<script>
	function submit(form) {
	    alert();
	}

	// Prevent submit if invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            let forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            let validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }
                    else {
                        submit(form);
                    }
                }, false);
            });
        }, false);
    })();
</script>
