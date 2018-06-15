<?php declare(strict_types=1);

/**
 * Class User
 */
class User {

	/** @var int $id */
	public $id;
	/** @var int $yritys_id */
	public $yritys_id;
	/** @var string $salasana Hashed & salted */
	private $salasana;
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
	public function __construct( DByhteys $db = null, int $user_id = null ) {
		if ( $user_id !== null ) { // Varmistetaan parametrin oikeellisuus
			$sql = "select kayttaja.id, yritys.id, salasana, salasana_vaihdettu, salasana_uusittava,
						viime_kirjautuminen, kayttaja.aktiivinen, yritys.yllapitaja 			  		
					from kayttaja 
						join yritys on kayttaja.yritys_id = yritys.id
					where kayttaja.id = ? AND kayttaja.aktiivinen = 1
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
	 * @param DByhteys|null $db
	 * @param int $user_id
	 * @param string $password_old
	 * @param string $password_new
	 * @param string $password_new_check
	 * @return bool
	 */
	public function setPassword( DByhteys $db = null, string $password_old, string $password_new, string $password_new_check ) : bool {
		if ( !password_verify( $password_old, $this->salasana ) ) {
			return false;
		}
		elseif ( $password_new != $password_new_check ) {
			return false;
		}
		$password_hash = password_hash($password_new, PASSWORD_DEFAULT);
		$sql = "update kayttaja 
				set kayttaja.salasana = ?, kayttaja.salasana_vaihdettu = NOW(),
					kayttaja.salasana_uusittava = NOW() + INTERVAL ? DAY
				WHERE kayttaja.id = ?";
		//TODO: SalasanaUusittava -> config
		$db->query($sql, [ $password_hash, 180, $this->id ]);
		return true;
	}

	public function setUserInfos( DByhteys $db = null, int $user_id, array $values ) {
		$sql = "update kayttaja 
				set kayttaja.id = kayttaja.id
				WHERE kayttaja.id = ?";
	}

	/**
	 * @param string $password
	 * @return bool
	 */
	public function verifyPassword( string $password ) : bool {
		if ( password_verify( $password, $this->salasana ) ) {
			return true;
		}
		return false;
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

class UserInit{
	public static function createUser( DByhteys $db, int $yritys_id, string $kayttajatunnus, $salasana ) {
		$salasana_hash = password_hash($salasana, PASSWORD_DEFAULT);
		$sql = "insert into kayttaja (yritys_id, kayttajatunnus, salasana, salasana_uusittava)
				values(?,?,?,1)";
		$db->query($sql, [$yritys_id, $kayttajatunnus, $salasana_hash]);
	}

	public static function deleteUser( DByhteys $db, int $user_id ) {
		$sql = "update kayttaja set aktiivinen = 0 where id = ?";
		$db->query($sql, [$user_id]);
	}
}
