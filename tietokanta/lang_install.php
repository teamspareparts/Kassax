<?php declare(strict_types=1);

require '../luokat/dbyhteys.class.php';

function debugC($var,bool$var_dump=false){
	echo"\r\nPrint_r ::\r\n";print_r($var);if($var_dump){echo"Var_dump ::\r\n";var_dump($var);echo"\r\n";};}

$db = new DByhteys( [], '../cfg/config.ini.php');


$languages = [ 'fin' , 'eng' ];

foreach ( $languages as $lang ) {

	$values = [];
	$lang_json = json_decode( file_get_contents( "../lang/{$lang}.json" ) );

	foreach ( $lang_json as $objName => $obj ) {
		foreach ( $obj as $page ) {
			foreach ( $page->strings as $property => $propertyValue ) {
				$values[] = $lang;
				$values[] = ($objName === 'admin');
				$values[] = $page->page;
				$values[] = $property;
				$values[] = $propertyValue;
			}
		}
	}

	$sql = "
		insert into lang ( lang, admin, sivu, tyyppi, teksti )
		values ( ?,?,?,?,? )
	";

	$kysymysmerkit = str_repeat(',(?,?,?,?,?)', (int)((count($values)/5)-1));

	$sql .= $kysymysmerkit;

	$sql .= "on duplicate key update teksti=values(teksti)";

	$db->query( $sql, $values );
}
?>

<html>
<body style="font-size: 2em; padding: 2em 0 0 2em;">
	<p>
		Kielet asennettu onnistuneesti.
	</p>
	<p>
		Linkit takaisin:
	</p>
	<p>
		<a href="../admin/">Etusivu</a>
	</p>
	<p>
		<a href="../admin/languages.php">Language settings</a>
	</p>
	<?php if (!empty($_GET['redir'])) : ?>
	<p>
		<a href="../admin/<?= $_GET['redir'] ?>">Redirect edelliselle sivulle</a>
	</p>
	<?php endif; ?>
</body>
</html>
