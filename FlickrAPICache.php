<?php

/**
 * Custom db cache for Flickr API calls
 *
 * @author Ike Hecht
 */
class FlickrAPICache {
	const TABLE = 'FlickrAPI';

	/**
	 * Get this call from db cache
	 *
	 * @param string $reqhash
	 * @return string|boolean
	 */
	public static function getCache( $reqhash ) {
		$dbr = wfGetDB( DB_SLAVE );
		$conds = array( 'request' => $reqhash, 'CURRENT_TIMESTAMP < expiration' );
		$result = $dbr->select( self::TABLE, 'response', $conds, __METHOD__ );

		$row = $result->fetchObject();
		if ( $row ) {
			return ( $row->response );
		} else {
			return false;
		}
	}

	/**
	 * Store this call in cache
	 *
	 * @param string $reqhash
	 * @param string $response
	 * @param integer $cache_expire
	 * @return boolean
	 * @throws MWException
	 */
	public static function setCache( $reqhash, $response, $cache_expire ) {
		$dbw = wfGetDB( DB_MASTER );
		$data = array(
			'request' => $reqhash,
			'response' => $response,
			'expiration' => $dbw->encodeExpiry( wfTimestamp( TS_MW, time() + $cache_expire ) )
		);
		$result = $dbw->upsert( self::TABLE, $data, array( 'request' ), $data, __METHOD__ );
		if ( !$result ) {
			throw new MWException( 'Set Cache failed' );
		}

		return $result;
	}
}
