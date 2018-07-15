<?php

/**
 * Class Company
 */
class Company {

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
	/** @var bool $yllapitaja Firman ylläpitäjän id.*/
	public $yllapitaja;


	/**
	 * Yritys-luokan konstruktori.<p>
	 * Jos annettu parametrit, hakee yrityksen tiedot tietokannasta. Muuten ei tee mitään.
	 * Jos ei löydä yritystä ID:llä, niin kaikki olion arvot pysyvät default arvoissaan.
	 * Testaa, löytyikö yritys metodilla <code>->isValid()</code>.
	 * @param DByhteys $db        [optional]
	 * @param int      $yritys_id [optional]
	 */
	public function __construct( DByhteys $db = null, int $yritys_id = null ) {
		if ( $db !== null and $yritys_id !== null ) {
			$sql = "select id, y_tunnus, yritystunniste, nimi, katuosoite, postinumero, 
						postitoimipaikka, maa, puhelin, www_url, email, logo, aktiivinen, yllapitaja
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
	 * @param DByhteys $db
	 * @param array $tiedot
	 * @param array $pankkitilit
	 * @return bool
	 */
	public function updateCompany( DByhteys $db, array $tiedot, array $pankkitilit ) : bool {
		array_push($tiedot, $this->id);
		$sql = "update yritys
				set katuosoite = ?, postinumero = ?, postitoimipaikka = ?, maa = ?,
					puhelin = ?, www_url = ?, email = ?, logo = ?
				where id = ?";
		$result = $db->query($sql, array_values($tiedot));
		if ( !$result ) {
			return false;
		}
		$result = $this->updateCompanyBankAccounts($db, $pankkitilit);
		if ( !$result ) {
			return false;
		}
		return true;
	}

	/**
	 * @param DByhteys $db
	 * @param array $pankkitilit
	 * @return bool
	 */
	private function updateCompanyBankAccounts( DByhteys $db, array $pankkitilit ) : bool {
		$sql = "delete from yritys_pankkitili where yritys_id = ?";
		$db->query($sql, [$this->id]);
		foreach ( $pankkitilit as $pankkitili ) {
			$sql = "insert into yritys_pankkitili (yritys_id, pankkitili) 
					VALUES(?,?)";
			$result = $db->query($sql, [$this->id, $pankkitili]);
			if ( !$result ) {
				return false;
			}
		}
		return true;
	}

	private function updateCompanyAdmin( DByhteys $db, int $user_id ) {
		$sql = "update yritys set yllapitaja = ? where id = ?";
		$db->query($sql, [$user_id, $this->id]);
	}

	/**
	 * @param DByhteys $db
	 * @param string $kayttajatunnus
	 * @param string $salasana
	 * @return bool
	 */
	public function createUser( DByhteys $db, string $kayttajatunnus, string $salasana, bool $yllapitaja ) : bool {
		if ( $this->userExists($db, $kayttajatunnus) ) {
			return false;
		}
		$salasana_hash = password_hash($salasana, PASSWORD_DEFAULT);
		$sql = "insert into kayttaja (yritys_id, kayttajatunnus, salasana, salasana_uusittava) values(?,?,?,1)";
		$db->query($sql, [$this->id, $kayttajatunnus, $salasana_hash]);
		if ( $yllapitaja ) {
			$user_id = $this->getUserIdByUsername($db, $kayttajatunnus);
			$this->updateCompanyAdmin($db, $user_id);
		}
		return true;
	}

	/**
	 * @param DByhteys $db
	 * @param int $user_id
	 * @return bool
	 */
	public function deleteUser( DByhteys $db, int $user_id ) : bool {
		$sql = "update kayttaja set aktiivinen = 0 and salasana_uusittava = 1 where id = ? and yritys_id = ?";
		$result = $db->query($sql, [$user_id, $this->id]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param string $kayttajatunnus
	 * @return bool
	 */
	private function userExists( DByhteys $db, string $kayttajatunnus ) : bool {
		$sql = "select id from kayttaja where yritys_id = ? and kayttajatunnus = ? limit 1";
		$result = $db->query($sql, [$this->id, $kayttajatunnus]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param $yritystunniste
	 * @return int|null
	 */
	private function getUserIdByUsername( DByhteys $db, $kayttajatunnus ) {
		$sql = "select id from kayttaja where kayttajatunnus = ? and yritys_id = ?";
		return $db->query($sql, [$kayttajatunnus, $this->id]);
	}

	/**
	 * Palauttaa, onko olio käytettävissä, eikä NULL.
	 * @return bool
	 */
	public function isValid() {
		return (($this->id !== null) && ($this->aktiivinen != 0));
	}

	/**
	 * Palauttaa TRUE jos käyttäjä on ylläpitäjä, ja false muussa tapauksessa.
	 * @return bool <p> Ylläpitäjä-arvon tarkistuksen tulos
	 */
	public function isAdmin() : bool {
		return ($this->yllapitaja == true);
	}
}
