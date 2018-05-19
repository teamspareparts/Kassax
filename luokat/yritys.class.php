<?php

/**
 * Class Yritys
 */
class Yritys {

	/** @var int $id */
	public $id;
	/** @var string $y_tunnus */
	public $y_tunnus;
	/** @var string $y_tunnus Kirjatumista varten. */
	public $yritystunniste;
	/** @var string $nimi */
	public $nimi;
	/** @var string $katuosoite */
	public $katuosoite;
	/** @var string $postinumero */
	public $postinumero;
	/** @var string $postitoimipaikka */
	public $postitoimipaikka;
	/** @var string $maa */
	public $maa;
	/** @var string $puhelin */
	public $puhelin;
	/** @var string $www_url */
	public $www_url;
	/** @var string $email */
	public $email;
	/** @var string $logo Tiedosto-polku */
	public $logo;
	/** @var boolean $aktiivinen */
	public $aktiivinen;
	/** @var bool $yllapitaja */
	public $yllapitaja;

	/**
	 * Yritys-luokan konstruktori.<p>
	 * Jos annettu parametrit, hakee yrityksen tiedot tietokannasta. Muuten ei tee mitään.
	 * Jos ei löydä yritystä ID:llä, niin kaikki olion arvot pysyvät default arvoissaan.
	 * Testaa, löytyikö yritys metodilla <code>->isValid()</code>.
	 * @param DByhteys $db        [optional]
	 * @param int      $yritys_id [optional]
	 */
	function __construct( DByhteys $db = null, int $yritys_id = null ) {
		if ( $db !== null and $yritys_id !== null ) {
			$sql = "select id, y_tunnus, yritystunniste, nimi, katuosoite, postinumero, 
						postitoimipaikka, maa, puhelin, www_url, email, logo, aktiivinen
					from yritys 
					where yritys.id = ? 
					limit 1";
			$row = $db->query( $sql, [ $yritys_id ] );

			if ( $row ) {
				foreach ( $row as $property => $propertyValue ) {
					$this->{$property} = $propertyValue;
				}
			}
		}
	}

	/**
	 * Palauttaa, onko olio käytettävissä, eikä NULL.
	 * @return bool
	 */
	public function isValid() {
		return (($this->id !== null) && ($this->aktiivinen != 0));
	}
}
