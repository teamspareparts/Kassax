<?php declare(strict_types=1);

/**
 * @class Language
 */
class LanguageController {

	static function db_addNewString( DByhteys $db, array $parametres ) {

		$sql = "
			insert into lang ( lang, admin, sivu, tyyppi, teksti )
			values ( ?, ?, ?, ?, ? )
		";

		$result = $db->query( $sql, $parametres );

		return $result;
	}

	static function db_updateString( DByhteys $db, array $parametres ) {

		$sql = "
			update lang
			set teksti = ?
			where lang = ?
				and admin = ?
				and sivu = ?
				and tyyppi = ?
			limit 1
		";

		$result = $db->query( $sql, $parametres );

		return $result;
	}

	static function db_deleteString( DByhteys $db, array $parametres ) {
		$sql = "
			delete from lang
			where lang = ?
				and admin = ?
				and sivu = ?
				and tyyppi = ?
			limit 1
		";

		$result = $db->query( $sql, $parametres );

		return $result;
	}

	static function json_updateFile( array $strings ) {

	}

	/**
	 * Palauttaa sivustolla käytetyt kielet.
	 * @param DByhteys $db
	 * @return stdClass[] - lista tietokantaan tallenetuista kielistä, as standard objects.
	 */
	static function getLanguages( DByhteys $db ) {
		$rows = $db->query(
			"select distinct lang from lang",
			[],
			FETCH_ALL
		);

		return $rows;
	}

	/**
	 * Lista kaikista sivuista, joilla on merkkijonoja tietokannassa.
	 * Huom. joillakin kielillä ei saata olla kaikkia sivuja.
	 * @param DByhteys $db
	 * @return stdClass[] - lista tietokantaan tallennetuista sivuista.
	 */
	static function getSivut( DByhteys $db ) {
		$rows = $db->query(
			"select distinct sivu from lang",
			[],
			FETCH_ALL
		);

		return $rows;
	}
}
