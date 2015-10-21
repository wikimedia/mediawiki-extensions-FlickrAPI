<?php

/**
 * Custom db cache for Flickr API calls
 *
 * @author Ike Hecht
 */
class FlickrAPICache {

	/**
	 * Get this call from db cache
	 *
	 * @param string $reqhash
	 * @return string|boolean
	 */
	public static function getCache( $reqhash ) {
		$cache = wfGetCache( CACHE_ANYTHING );
		$key = wfMemcKey( 'flickrapi', $reqhash );
		$cached = $cache->get( $key );
		wfDebugLog( "FlickrAPI", __METHOD__ . ": got " . var_export( $cached, true ) .
			" from cache." );
		return $cached;
	}

	/**
	 * Store this call in cache
	 *
	 * @param string $reqhash
	 * @param string $response
	 * @param integer $cache_expire
	 * @return boolean
	 */
	public static function setCache( $reqhash, $response, $cache_expire ) {
		$cache = wfGetCache( CACHE_ANYTHING );
		$key = wfMemcKey( 'flickrapi', $reqhash );
		wfDebugLog( "FlickrAPI",
			__METHOD__ . ": caching " . var_export( $response, true ) .
			" from Flickr." );
		return $cache->set( $key, $response, $cache_expire );
	}
}
