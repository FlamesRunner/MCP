<?php
/**
* @version $Id: index.php 6022 2006-12-18 22:30:07Z friesengeist $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Set flag that this is a parent file
define( '_VALID_MOS', 1 );

// checks for configuration file, if none found loads installation page
if (!file_exists( 'configuration.php' ) || filesize( 'configuration.php' ) < 10) {
	$self = rtrim( dirname( $_SERVER['PHP_SELF'] ), '/\\' ) . '/';
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "installation/index.php" );
	exit();
}

require( 'globals.php' );
require_once( 'configuration.php' );

// SSL check - $http_host returns <live site url>:<port number if it is 443>
$http_host = explode(':', $_SERVER['HTTP_HOST'] );
if( (!empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) != 'off' || isset( $http_host[1] ) && $http_host[1] == 443) && substr( $mosConfig_live_site, 0, 8 ) != 'https://' ) {
	$mosConfig_live_site = 'https://'.substr( $mosConfig_live_site, 7 );
}

require_once( 'includes/joomla.php' );

//Installation sub folder check, removed for work with SVN
if (file_exists( 'installation/index.php' ) && $_VERSION->SVN == 0) {
	define( '_INSTALL_CHECK', 1 );
	include ( $mosConfig_absolute_path .'/offline.php');
	exit();
}

// displays offline/maintanance page or bar
if ($mosConfig_offline == 1) {
	require( $mosConfig_absolute_path .'/offline.php' );
}

// load system bot group
$_MAMBOTS->loadBotGroup( 'system' );

// trigger the onStart events
$_MAMBOTS->trigger( 'onStart' );

if (file_exists( $mosConfig_absolute_path .'/components/com_sef/sef.php' )) {
	require_once( $mosConfig_absolute_path .'/components/com_sef/sef.php' );
} else {
	require_once( $mosConfig_absolute_path .'/includes/sef.php' );
}
require_once( $mosConfig_absolute_path .'/includes/frontend.php' );

// retrieve some expected url (or form) arguments
$option = strval( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );

if ($option == '') {
	if ($Itemid) {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype = 'mainmenu'"
		. "\n AND id = " . (int) $Itemid
		. "\n AND published = 1"
		;
		$database->setQuery( $query );
	} else {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype = 'mainmenu'"
		. "\n AND published = 1"
		. "\n ORDER BY parent, ordering"
		;
		$database->setQuery( $query, 0, 1 );
	}
	$menu = new mosMenu( $database );
	if ($database->loadObject( $menu )) {
		$Itemid = $menu->id;
	}
	$link = $menu->link;
	if (($pos = strpos( $link, '?' )) !== false) {
		$link = substr( $link, $pos+1 ). '&Itemid='.$Itemid;
	}
	parse_str( $link, $temp );
	/** this is a patch, need to rework when globals are handled better */
	foreach ($temp as $k=>$v) {
		$GLOBALS[$k] = $v;
		$_REQUEST[$k] = $v;
		if ($k == 'option') {
			$option = $v;
		}
	}
}
if ( !$Itemid ) {
// when no Itemid give a default value
	$Itemid = 99999999;
}

// mainframe is an API workhorse, lots of 'core' interaction routines
$mainframe = new mosMainFrame( $database, $option, '.' );
$mainframe->initSession();

// trigger the onAfterStart events
$_MAMBOTS->trigger( 'onAfterStart' );

// checking if we can find the Itemid thru the content
if ( $option == 'com_content' && $Itemid === 0 ) {
	$id 	= intval( mosGetParam( $_REQUEST, 'id', 0 ) );
	$Itemid = $mainframe->getItemid( $id );
}

/** do we have a valid Itemid yet?? */
if ( $Itemid === 0 ) {
	/** Nope, just use the homepage then. */
	$query = "SELECT id"
	. "\n FROM #__menu"
	. "\n WHERE menutype = 'mainmenu'"
	. "\n AND published = 1"
	. "\n ORDER BY parent, ordering"
	;
	$database->setQuery( $query, 0, 1 );
	$Itemid = $database->loadResult();
}

// patch to lessen the impact on templates
if ($option == 'search') {
	$option = 'com_search';
}

// loads english language file by default
if ($mosConfig_lang=='') {
	$mosConfig_lang = 'english';
}
include_once( $mosConfig_absolute_path .'/language/' . $mosConfig_lang . '.php' );

// frontend login & logout controls
$return 	= strval( mosGetParam( $_REQUEST, 'return', NULL ) );
$message 	= intval( mosGetParam( $_POST, 'message', 0 ) );
if ($option == 'login') {
	$mainframe->login();

	// JS Popup message
	if ( $message ) {
		?>
		<script language="javascript" type="text/javascript">
		<!--//
		alert( "<?php echo addslashes( _LOGIN_SUCCESS ); ?>" );
		//-->
		</script>
		<?php
	}

	if ( $return && !( strpos( $return, 'com_registration' ) || strpos( $return, 'com_login' ) ) ) {
	// checks for the presence of a return url
	// and ensures that this url is not the registration or login pages
		// If a sessioncookie exists, redirect to the given page. Otherwise, take an extra round for a cookiecheck
		if (isset( $_COOKIE[mosMainFrame::sessionCookieName()] )) {
			mosRedirect( $return );
		} else {
			mosRedirect( $mosConfig_live_site .'/index.php?option=cookiecheck&return=' . urlencode( $return ) );
		}
	} else {
		// If a sessioncookie exists, redirect to the start page. Otherwise, take an extra round for a cookiecheck
		if (isset( $_COOKIE[mosMainFrame::sessionCookieName()] )) {
			mosRedirect( $mosConfig_live_site .'/index.php' );
		} else {
			mosRedirect( $mosConfig_live_site .'/index.php?option=cookiecheck&return=' . urlencode( $mosConfig_live_site .'/index.php' ) );
		}
	}

} else if ($option == 'logout') {
	$mainframe->logout();

	// JS Popup message
	if ( $message ) {
		?>
		<script language="javascript" type="text/javascript">
		<!--//
		alert( "<?php echo addslashes( _LOGOUT_SUCCESS ); ?>" );
		//-->
		</script>
		<?php
	}

	if ( $return && !( strpos( $return, 'com_registration' ) || strpos( $return, 'com_login' ) ) ) {
	// checks for the presence of a return url
	// and ensures that this url is not the registration or logout pages
		mosRedirect( $return );
	} else {
		mosRedirect( $mosConfig_live_site.'/index.php' );
	}
} else if ($option == 'cookiecheck') {
	// No cookie was set upon login. If it is set now, redirect to the given page. Otherwise, show error message.
	if (isset( $_COOKIE[mosMainFrame::sessionCookieName()] )) {
		mosRedirect( $return );
	} else {
		mosErrorAlert( _ALERT_ENABLED );
	}
}

/** get the information about the current user from the sessions table */
$my = $mainframe->getUser();

// detect first visit
$mainframe->detect();

// set for overlib check
$mainframe->set( 'loadOverlib', false );

$gid = intval( $my->gid );

// gets template for page
$cur_template = $mainframe->getTemplate();
/** temp fix - this feature is currently disabled */

/** @global A places to store information from processing of the component */
$_MOS_OPTION = array();

// precapture the output of the component
require_once( $mosConfig_absolute_path . '/editor/editor.php' );

ob_start();

if ($path = $mainframe->getPath( 'front' )) {
	$task 	= strval( mosGetParam( $_REQUEST, 'task', '' ) );
	$ret 	= mosMenuCheck( $Itemid, $option, $task, $gid );

	if ($ret) {
		require_once( $path );
	} else {
		mosNotAuth();
	}
} else {
	header( 'HTTP/1.0 404 Not Found' );
	echo _NOT_EXIST;
}

$_MOS_OPTION['buffer'] = ob_get_contents();

ob_end_clean();

initGzip();

// -------------------------------------------------------------------------
// NET2FTP MODIFICATION START
if (isset($_GET["option"]) == true && $_GET["option"] == "com_net2ftp") {
// NET2FTP MODIFICATION END
// -------------------------------------------------------------------------
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
// -------------------------------------------------------------------------
// NET2FTP MODIFICATION START
}
// NET2FTP MODIFICATION END
// -------------------------------------------------------------------------

// display the offline alert if an admin is logged in
if (defined( '_ADMIN_OFFLINE' )) {
	include( $mosConfig_absolute_path .'/offlinebar.php' );
}

// loads template file
if ( !file_exists( $mosConfig_absolute_path .'/templates/'. $cur_template .'/index.php' ) ) {
	echo _TEMPLATE_WARN . $cur_template;
} else {
	require_once( $mosConfig_absolute_path .'/templates/'. $cur_template .'/index.php' );
	echo '<!-- '. time() .' -->';
}

// displays queries performed for page
if ($mosConfig_debug) {
	echo $database->_ticker . ' queries executed';
	echo '<pre>';
 	foreach ($database->_log as $k=>$sql) {
 		echo $k+1 . "\n" . $sql . '<hr />';
	}
	echo '</pre>';
}

doGzip();
?>