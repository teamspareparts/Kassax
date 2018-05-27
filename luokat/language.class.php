<?php declare(strict_types=1);

/**
 * @class Language
 */
class Language {

	/**
	 * @param DByhteys $db
	 * @param string   $lang Three character language code ISO 639-2/T
	 * @param string   $page Sivu jonka käännökset haetaan
	 */
	function __construct( DByhteys $db, string $lang, string $page ) {

		$sql = "select tyyppi, teksti 
				from lang
				where lang = ? 
				  and (sivu = ? or sivu is null)";
		$rows = $db->query( $sql, [ $lang, $page ], DByhteys::FETCH_ALL );

		foreach ( $rows as $row ) {
			$this->{$row->tyyppi} = $row->teksti;
		}

	}

	/**
	 * @param DByhteys $db
	 * @param string   $lang Three character language code ISO 639-2/T
	 * @param string   $page Sivu jonka käännökset haetaan
	 *
	 * @return stdClass
	 */
	static function fetch( DByhteys $db, string $lang, string $page ) : stdClass {

		$sql = "select tyyppi, teksti 
				from lang
				where lang = ? 
				  and (sivu = ? or sivu is null)";
		$rows = $db->query( $sql, [ $lang, $page ], DByhteys::FETCH_ALL );

		$new_lang_object = new stdClass();

		$new_lang_object->lang = $lang;

		foreach ( $rows as $row ) {
			$new_lang_object->{$row->tyyppi} = $row->teksti;
		}
		return $new_lang_object;
	}

}
