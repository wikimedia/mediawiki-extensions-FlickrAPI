<?php
/**
 * FlickrAPI extension
 *
 * For more info see http://mediawiki.org/wiki/Extension:FlickrAPI
 *
 * @file
 * @ingroup Extensions
 * @author Ike Hecht, 2015
 * @license GNU General Public Licence 2.0 or later
 */

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'FlickrAPI',
	'author' => array(
		'Ike Hecht',
	),
	'version' => '0.1.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FlickrAPI',
	'descriptionmsg' => 'flickrapi-desc',
);

/* Setup */

// Register files
$wgAutoloadClasses['FlickrAPIHooks'] = __DIR__ . '/FlickrAPI.hooks.php';
$wgAutoloadClasses['FlickrAPIUtils'] = __DIR__ . '/FlickrAPIUtils.php';
$wgAutoloadClasses['FlickrAPICache'] = __DIR__ . '/FlickrAPICache.php';
/** @todo Spit out better error message if phpflickr module doesn't exist */
$wgAutoloadClasses['phpFlickr'] = __DIR__ . '/modules/phpflickr/phpFlickr.php';

$wgMessagesDirs['FlickrAPI'] = __DIR__ . '/i18n';

// Register hooks
$wgHooks['ParserFirstCallInit'][] = function ( &$parser ) {
	$parser->setHook( 'flickr', 'FlickrAPIHooks::flickrAPITag' );
	return true;
};

$wgHooks['LoadExtensionSchemaUpdates'][] = function ( DatabaseUpdater $updater ) {
	$updater->addExtensionTable( FlickrAPICache::TABLE, __DIR__ . '/FlickrAPI.sql', true );
	return true;
};

/* Configuration */
$wgFlickrAPIKey = '';
$wgFlickrAPISecret = '';
$wgFlickrAPICache = ( $wgMainCacheType === CACHE_NONE ) ? false : true;
$wgFlickrAPIDefaults = array( 'type' => 'frameless', 'location' => 'right', 'size' => '-' );
