<?php
/**
 * Class Firms
 */

class Firms
{
	/**
	 * @param DByhteys $db
	 * @param string $y_tunnus
	 * @param string $yritystunniste
	 * @return bool
	 */
	public static function createFirm( DByhteys $db, string $y_tunnus, string $yritystunniste, string $nimi ) : bool {
		if ( self::firmExists($db, $y_tunnus, $yritystunniste) ) {
			return false;
		}
		$sql = "insert into yritys (y_tunnus, yritystunniste, nimi) values(?,?,?)";
		$db->query($sql, [$y_tunnus, $yritystunniste, $nimi]);
		return true;
	}

	/**
	 * @param DByhteys $db
	 * @param int $yritys_id
	 * @return bool
	 */
	public static function deleteFirm( DByhteys $db, int $yritys_id ) : bool {
		$sql = "update yritys set aktiivinen = 0 where id = ?";
		$result = $db->query($sql,  [$yritys_id]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param string $y_tunnus
	 * @param string $yritystunniste
	 * @return bool
	 */
	public static function firmExists( DByhteys $db, string $y_tunnus, string $yritystunniste ) : bool {
		$sql = "select id from yritys where y_tunnus = ? and yritystunniste = ? limit 1";
		$result = $db->query($sql , [$y_tunnus, $yritystunniste]);
		if ( $result ) {
			return true;
		}
		return false;
	}

	/**
	 * @param DByhteys $db
	 * @param string $y_tunnus
	 * @param string $yritystunniste
	 * @return bool
	 */
	public static function checkForDuplicates( DByhteys $db, string $y_tunnus, string $yritystunniste ) : bool {
		$sql = "select id from yritys where y_tunnus = ? or yritystunniste = ? limit 1";
		$result = $db->query($sql , [$y_tunnus, $yritystunniste]);
		if ( $result ) {
			return true;
		}
		return false;
	}
	/**
	 * @param DByhteys $db
	 * @param string $yritystunniste
	 * @return stdClass
	 */
	public static function getFirmIdByIdentifier( DByhteys $db, string $yritystunniste ) {
		$sql = "select id from yritys where yritystunniste = ?";
		return $db->query($sql, [$yritystunniste]);
	}
}