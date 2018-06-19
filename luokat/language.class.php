<?php declare(strict_types=1);

/**
 * @class Language
 */
class Language extends stdClass {

	/**
	 * @var string $lang Three character language code ISO 639-2/T
	 */
	public $lang;

	public $HTML_TITLE;
	public $HTML_FOOTER;

	/**
	 * @param DByhteys $db
	 * @param string   $lang Three character language code ISO 639-2/T
	 * @param bool     $admin
	 * @param string   $page Sivu jonka käännökset haetaan
	 */
	function __construct( DByhteys $db, string $lang, bool $admin, string $page ) {

		$sql = "select tyyppi, teksti
				from lang
				where lang = ? 
				  and admin = ?
				  and (sivu = ? or sivu is null)";
		$rows = $db->query( $sql, [ $lang, $admin, $page ], DByhteys::FETCH_ALL );

		foreach ( $rows as $row ) {
			$this->{$row->tyyppi} = $row->teksti;
		}

		$this->lang = $lang;
	}

	function __get( $name ) {
		if ( !isset($this->{$name}) ) {
			return "UNDEFINED {$name}";
		}

		return $this->{$name};
	}

}
