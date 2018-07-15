<?php
/**
 * Class Companies
 */

class Companies
{
	/**
	 * @param DByhteys $db
	 * @param string $y_tunnus
	 * @param string $yritystunniste
	 * @param string $nimi
	 * @return bool
	 */
	public static function createCompany( DByhteys $db, string $y_tunnus, string $yritystunniste, string $nimi ) : bool {
		if ( self::checkForDuplicateIdentifiers($db, $y_tunnus, $yritystunniste) ) {
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
	public static function deleteCompany( DByhteys $db, int $yritys_id ) : bool {
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
	public static function CompanyExists( DByhteys $db, string $y_tunnus, string $yritystunniste ) : bool {
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
	public static function checkForDuplicateIdentifiers( DByhteys $db, string $y_tunnus, string $yritystunniste ) : bool {
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
	public static function getCompanyIdByCompanyLoginName( DByhteys $db, string $yritystunniste ) : int {
		$sql = "select id from yritys where yritystunniste = ? limit 1";
		$result = $db->query($sql, [$yritystunniste]);
		return $result ? $result->id : -1;
	}
}