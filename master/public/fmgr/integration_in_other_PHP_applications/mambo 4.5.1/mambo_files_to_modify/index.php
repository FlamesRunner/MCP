<?php
/**
* @version $Id: index.php,v 1.41 2004/09/23 23:09:23 rcastley Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Set flag that this is a parent file */
define( '_VALID_MOS', 1 );

// checks for configuration file, if none found loads installation page
if ( !file_exists( 'configuration.php' ) || filesize( 'configuration.php' ) < 10 ) {
	header( 'Location: installation/index.php' );
	exit();
}

include_once( 'globals.php' );
require_once( 'configuration.php' );

// displays offline page
if ( $mosConfig_offline == 1 ){
	include( 'offline.php' );
	exit();
}

require_once( 'includes/mambo.php' );
if (file_exists( 'components/com_sef/sef.php' )) {
	require_once( 'components/com_sef/sef.php' );
} else {
	require_once( 'includes/sef.php' );
}
require_once( 'includes/frontend.php' );

if (file_exists( 'installation/index.php' )) {
	include ('offline.php');
	exit();
}

/** retrieve some expected url (or form) arguments */
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();

if ($option == '') {
	if ($Itemid) {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype='mainmenu'"
		. "\n AND id = '$Itemid'"
		. "\n AND published = '1'"
		;
		$database->setQuery( $query );
	} else {
		$query = "SELECT id, link"
		. "\n FROM #__menu"
		. "\n WHERE menutype='mainmenu' AND published='1'"
		. "\n ORDER BY parent, ordering LIMIT 1"
		;
		$database->setQuery( $query );
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

/** do we have a valid Itemid yet?? */
if ( $Itemid === null ) {
	/** Nope, just use the homepage then. */
	$query = "SELECT id"
	. "\n FROM #__menu"
	. "\n WHERE menutype='mainmenu'"
	. "\n AND published='1'"
	. "\n ORDER BY parent, ordering"
	. "\n LIMIT 1"
	;
	$database->setQuery( $query );
	$Itemid = $database->loadResult();
}

/** patch to lessen the impact on templates */
if ($option == 'search') {
	$option = 'com_search';
}

/** mainframe is an API workhorse, lots of 'core' interaction routines */
$mainframe = new mosMainFrame( $database, $option, '.' );
$mainframe->initSession();

// loads english language file by default
if ( $mosConfig_lang == '' ) {
	$mosConfig_lang = 'english';
}
include_once ( 'language/'.$mosConfig_lang.'.php' );

// frontend login & logout controls
$return = mosGetParam( $_REQUEST, 'return', NULL );
$message = mosGetParam( $_POST, 'message', 0 );
if ($option == "login") {
	$mainframe->login();

	// JS Popup message
	if ( $message ) {
		?>
		<script> 
		<!--//
		alert( "<?php echo _LOGIN_SUCCESS; ?>" ); 
		//-->
		</script>
		<?php
	}

	if ($return) {
		mosRedirect( $return );
	} else {
		mosRedirect( 'index.php' );
	}

} else if ($option == "logout") {
	$mainframe->logout();

	// JS Popup message
	if ( $message ) {
		?>
		<script> 
		<!--//
		alert( "<?php echo _LOGOUT_SUCCESS; ?>" ); 
		//-->
		</script>
		<?php
	}

	if ($return) {
		mosRedirect( $return );
	} else {
		mosRedirect( 'index.php' );
	}
}

/** get the information about the current user from the sessions table */
$my = $mainframe->getUser();

/** detect first visit */
$mainframe->detect();

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
	$task = mosGetParam( $_REQUEST, 'task', '' );
	$ret = mosMenuCheck( $Itemid, $option, $task, $gid );
	if ($ret) {
		require_once( $path );
	} else {
		mosNotAuth();
	}
} else {
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

// loads template file
if ( !file_exists( 'templates/'. $cur_template .'/index.php' ) ) {
	echo _TEMPLATE_WARN . $cur_template;
} else {
	require_once( 'templates/'. $cur_template .'/index.php' );
	echo "<!-- ".time()." -->";
}

// displays queries performed for page
if ($mosConfig_debug) {
	echo $database->_ticker . ' queries executed';
	echo '<pre>';
 	foreach ($database->_log as $k=>$sql) {
 	    echo $k+1 . "\n" . $sql . '<hr />';
	}
}

doGzip();
?>