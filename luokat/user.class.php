<?php declare(strict_types=1);

/**
 * Class User
 */
class User {

	/** @var int $id */
	public $id;
	/** @var int $yritys_id */
	public $yritys_id;
	/** @var string $salasana_hajautus */
	public $salasana_hajautus;
	/** @var string $salasana_vaihdettu DateTime muodossa */
	public $salasana_vaihdettu;
	/** @var bool $salasana_uusittava */
	public $salasana_uusittava;
	/** @var string $viime_kirjautuminen DateTime muodossa */
	public $viime_kirjautuminen;
	/** @var bool $aktiivinen */
	public $aktiivinen;
	/** @var bool $yllapitaja */
	public $yllapitaja;
	/** @var int $kieli */
	public $kieli;

	/**
	 * Käyttäjä-luokan konstruktori.
	 * Jos annettu parametrit, Hakee käyttäjän tiedot tietokannasta. Muuten ei tee mitään.
	 * Jos ei löydä käyttäjää ID:llä, niin kaikki olion arvot pysyvät default arvoissaan.
	 * Testaa löytyikö käyttäjä isValid-metodilla.
	 * @param DByhteys $db      [optional]
	 * @param int      $user_id [optional]
	 */
	function __construct( DByhteys $db = null, int $user_id = null ) {
		if ( $user_id !== null ) { // Varmistetaan parametrin oikeellisuus
			$sql = "select kayttaja.id, yritys.id, salasana_vaihdettu, salasana_uusittava, viime_kirjautuminen,
				  		kayttaja.aktiivinen, yritys.yllapitaja 			  		
					from kayttaja 
						join yritys on kayttaja.yritys_id = yritys.id
					where kayttaja.id = ?
					limit 1";
			$row = $db->query( $sql, [ $user_id ] );

			if ( $row ) { // Varmistetaan, että jokin asiakas löytyi
				foreach ( $row as $property => $propertyValue ) {
					$this->{$property} = $propertyValue;
				}
			}
		}
	}

	/**
	 * Palauttaa TRUE jos käyttäjä on ylläpitäjä, ja false muussa tapauksessa.
	 * @return bool <p> Ylläpitäjä-arvon tarkistuksen tulos
	 */
	public function isAdmin(): bool {
		return ($this->yllapitaja === 1);
	}

	/**
	 * Palauttaa, onko olio käytettävissä (ei NULL).
	 * @return bool
	 */
	public function isValid(): bool {
		return ($this->id !== null);
	}
}
