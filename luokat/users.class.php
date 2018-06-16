<?php
/**
 * Class Users
 */

class Users
{
	/**
	 * @param DByhteys $db
	 * @param int $yritys_id
	 * @param string $kayttajatunnus
	 * @param $salasana
	 * @return bool
	 */
	public static function createUser( DByhteys $db, int $yritys_id, string $kayttajatunnus, $salasana ) : bool {
		if ( self::userExists($db, $yritys_id, $kayttajatunnus) ) {
			return false;
		}
		$salasana_hash = password_hash($salasana, PASSWORD_DEFAULT);
		$sql = "insert into kayttaja (yritys_id, kayttajatunnus, salasana, salasana_uusittava) values(?,?,?,1)";
		$db->query($sql, [$yritys_id, $kayttajatunnus, $salasana_hash]);
		return true;
	}

	/**
	 * @param DByhteys $db
	 * @param int $user_id
	 * @return bool
	 */
	public static function deleteUser( DByhteys $db, int $user_id ) : bool {
		$sql = "update kayttaja set aktiivinen = 0 and salasana_uusittava = 1 where id = ?";
		$result = $db->query($sql, [$user_id]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param int $ysritys_id
	 * @param string $kayttajatunnus
	 * @return bool
	 */
	public static function userExists( DByhteys $db, int $ysritys_id, string $kayttajatunnus ) : bool {
		$sql = "select id from kayttaja where yritys_id = ? and kayttajatunnus = ? limit 1";
		$result = $db->query($sql, [$ysritys_id, $kayttajatunnus]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param $yritystunniste
	 * @return array|bool|int|stdClass
	 */
	public static function getUserIdByIdentifier( DByhteys $db, $yritystunniste ) {
		$sql = "select id from kayttaja where kayttajatunnus = ?";
		return $db->query($sql, [$yritystunniste]);
	}
}