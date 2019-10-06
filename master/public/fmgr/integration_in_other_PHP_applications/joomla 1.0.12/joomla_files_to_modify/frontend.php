<?php
/**
* @version $Id: frontend.php 5928 2006-12-06 00:49:07Z friesengeist $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_VALID_MOS' ) or die( 'Restricted access' );
/**
* Displays the capture output of the main element
*/
function mosMainBody() {
	global $mosConfig_live_site;
	// message passed via the url
	$mosmsg = stripslashes( strval( mosGetParam( $_REQUEST, 'mosmsg', '' ) ) );

	$popMessages = false;

	// Browser Check
	$browserCheck = 0;
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && isset( $_SERVER['HTTP_REFERER'] ) && strpos($_SERVER['HTTP_REFERER'], $mosConfig_live_site) !== false ) {
		$browserCheck = 1;
	}

	// Session Check
	$sessionCheck = 0;
	// Session Cookie `name`
	$sessionCookieName 	= mosMainFrame::sessionCookieName();
	// Get Session Cookie `value`
	$sessioncookie 		= mosGetParam( $_COOKIE, $sessionCookieName, null );
	if ( (strlen($sessioncookie) == 32 || $sessioncookie == '-') ) {
		$sessionCheck = 1;
	}

	// limit mosmsg to 150 characters
	if ( strlen( $mosmsg ) > 150 ) {
		$mosmsg = substr( $mosmsg, 0, 150 );
	}

	// mosmsg outputed within html
	if ($mosmsg && !$popMessages && $browserCheck && $sessionCheck) {
		echo "\n<div class=\"message\">$mosmsg</div>";
	}

	echo $GLOBALS['_MOS_OPTION']['buffer'];

	// mosmsg outputed in JS Popup
	if ($mosmsg && $popMessages && $browserCheck && $sessionCheck) {
		echo "\n<script language=\"javascript\">alert('" . addslashes( $mosmsg ) . "');</script>";
	}
}
/**
* Utility functions and classes
*/
function mosLoadComponent( $name ) {
	// set up some global variables for use by frontend components
	global $mainframe, $database, $my, $acl;
	global $task, $Itemid, $id, $option, $gid;

	include( $mainframe->getCfg( 'absolute_path' )."/components/com_$name/$name.php" );
}
/**
* Cache some modules information
* @return array
*/
function &initModules() {
	global $database, $my, $Itemid;

	if (!isset( $GLOBALS['_MOS_MODULES'] )) {
		$Itemid 		= intval($Itemid);
		$check_Itemid 	= '';
		if ($Itemid) {
			$check_Itemid = "OR mm.menuid = " . (int) $Itemid;
		}

		$query = "SELECT id, title, module, position, content, showtitle, params"
		. "\n FROM #__modules AS m"
		. "\n INNER JOIN #__modules_menu AS mm ON mm.moduleid = m.id"
		. "\n WHERE m.published = 1"
		. "\n AND m.access <= ". (int) $my->gid
		. "\n AND m.client_id != 1"
		. "\n AND ( mm.menuid = 0 $check_Itemid )"
		. "\n ORDER BY ordering";

		$database->setQuery( $query );
		$modules = $database->loadObjectList();

		foreach ($modules as $module) {
			$GLOBALS['_MOS_MODULES'][$module->position][] = $module;
		}
	}
	return $GLOBALS['_MOS_MODULES'];
}
/**
* @param string THe template position
*/
function mosCountModules( $position='left' ) {
	global $database, $my, $Itemid;

	$tp = intval( mosGetParam( $_GET, 'tp', 0 ) );
	if ($tp) {
		return 1;
	}

	$modules =& initModules();
	if (isset( $GLOBALS['_MOS_MODULES'][$position] )) {
		return count( $GLOBALS['_MOS_MODULES'][$position] );
	} else {
		return 0;
	}
}
/**
* @param string The position
* @param int The style.  0=normal, 1=horiz, -1=no wrapper
*/
function mosLoadModules( $position='left', $style=0 ) {
	global $mosConfig_gzip, $mosConfig_absolute_path, $database, $my, $Itemid, $mosConfig_caching;

	$tp = intval( mosGetParam( $_GET, 'tp', 0 ) );
	if ($tp) {
		echo '<div style="height:50px;background-color:#eee;margin:2px;padding:10px;border:1px solid #f00;color:#700;">';
		echo $position;
		echo '</div>';
		return;
	}
	$style = intval( $style );
	$cache =& mosCache::getCache( 'com_content' );

	require_once( $mosConfig_absolute_path . '/includes/frontend.html.php' );

	$allModules =& initModules();
	if (isset( $GLOBALS['_MOS_MODULES'][$position] )) {
		$modules = $GLOBALS['_MOS_MODULES'][$position];
	} else {
		$modules = array();
	}

	if (count( $modules ) < 1) {
		$style = 0;
	}
	if ($style == 1) {
		echo "<table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n";
		echo "<tr>\n";
	}
	$prepend = ($style == 1) ? "<td valign=\"top\">\n" : '';
	$postpend = ($style == 1) ? "</td>\n" : '';

	$count = 1;
	foreach ($modules as $module) {
		$params = new mosParameters( $module->params );

		echo $prepend;

		if ((substr("$module->module",0,4))=='mod_') {
		// normal modules
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
			// module caching
				$cache->call('modules_html::module2', $module, $params, $Itemid, $style, $my->gid  );
			} else {
				modules_html::module2( $module, $params, $Itemid, $style, $count );
			}
		} else {
		// custom or new modules
			if ($params->get('cache') == 1 && $mosConfig_caching == 1) {
			// module caching
				$cache->call('modules_html::module', $module, $params, $Itemid, $style, 0, $my->gid );
			} else {
				modules_html::module( $module, $params, $Itemid, $style );
			}
		}

		echo $postpend;

		$count++;
	}
	if ($style == 1) {
		echo "</tr>\n</table>\n";
	}
}
/**
* Assembles head tags
*/
function mosShowHead() {
	global $database, $option, $my, $mainframe, $_VERSION, $task, $id;
	global $mosConfig_MetaDesc, $mosConfig_MetaKeys, $mosConfig_live_site, $mosConfig_sef, $mosConfig_absolute_path, $mosConfig_sitename, $mosConfig_favicon;

	$mainframe->appendMetaTag( 'description', $mosConfig_MetaDesc );
	$mainframe->appendMetaTag( 'keywords', $mosConfig_MetaKeys );
	$mainframe->addMetaTag( 'Generator', $_VERSION->PRODUCT . ' - ' . $_VERSION->COPYRIGHT);
	$mainframe->addMetaTag( 'robots', 'index, follow' );

	// cache activation
	if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$cache =& mosCache::getCache('com_content');
		echo $cache->call('mainframe->getHead', @$_SERVER['QUERY_STRING'], $id);
	} else {
		echo $mainframe->getHead();
	}

	if ( isset($mosConfig_sef) && $mosConfig_sef ) {
		echo "<base href=\"$mosConfig_live_site/\" />\r\n";
	}

	if ($my->id || $mainframe->get( 'joomlaJavascript' )) {
		?>
		<script src="<?php echo $mosConfig_live_site;?>/includes/js/joomla.javascript.js" type="text/javascript"></script>
		<?php
	}

	$row = new mosComponent( $database );
	$query = "SELECT a.*"
	. "\n FROM #__components AS a"
	. "\n WHERE ( a.admin_menu_link = 'option=com_syndicate' OR a.admin_menu_link = 'option=com_syndicate&hidemainmenu=1' )"
	. "\n AND a.option = 'com_syndicate'"
	;
	$database->setQuery( $query );
	$database->loadObject( $row );

	// get params definitions
	$syndicateParams = new mosParameters( $row->params, $mainframe->getPath( 'com_xml', $row->option ), 'component' );

	// needed to reduce query
	$GLOBALS['syndicateParams'] = $syndicateParams;

	$live_bookmark = $syndicateParams->get( 'live_bookmark', 0 );

	// and to allow disabling/enabling of selected feed types
	switch ( $live_bookmark ) {
		case 'RSS0.91':
			if ( !$syndicateParams->get( 'rss091', 1 ) ) {
				$live_bookmark = 0;
			}
			break;

		case 'RSS1.0':
			if ( !$syndicateParams->get( 'rss10', 1 ) ) {
				$live_bookmark = 0;
			}
			break;

		case 'RSS2.0':
			if ( !$syndicateParams->get( 'rss20', 1 ) ) {
				$live_bookmark = 0;
			}
			break;

		case 'ATOM0.3':
			if ( !$syndicateParams->get( 'atom03', 1 ) ) {
				$live_bookmark = 0;
			}
			break;
	}

	// support for Live Bookmarks ability for site syndication
	if ($live_bookmark) {
		$show = 1;

		$link_file 	= $mosConfig_live_site . '/index2.php?option=com_rss&feed='. $live_bookmark .'&no_html=1';

		// xhtml check
		$link_file = ampReplace( $link_file );

		// security chcek
		$check = $syndicateParams->def( 'check', 1 );
		if($check) {
			// test if rssfeed module is published
			// if not disable access
			$query = "SELECT m.id"
			. "\n FROM #__modules AS m"
			. "\n WHERE m.module = 'mod_rssfeed'"
			. "\n AND m.published = 1"
			;
			$database->setQuery( $query );
			$check = $database->loadResultArray();
			if(empty($check)) {
				$show = 0;
			}
		}
		// outputs link tag for page
		if ($show) {
			// test if security check is enbled
			?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo $mosConfig_sitename; ?>" href="<?php echo $link_file; ?>" />
			<?php
		}
	}

	// favourites icon
	if ( !$mosConfig_favicon ) {
		$mosConfig_favicon = 'favicon.ico';
	}
	$icon = $mosConfig_absolute_path .'/images/'. $mosConfig_favicon;
	// checks to see if file exists
	if ( !file_exists( $icon ) ) {
		$icon = $mosConfig_live_site .'/images/favicon.ico';
	} else {
		$icon = $mosConfig_live_site .'/images/' .$mosConfig_favicon;
	}

	// outputs link tag for page
	?>
	<link rel="shortcut icon" href="<?php echo $icon;?>" />
	<?php
// -------------------------------------------------------------------------
// NET2FTP MODIFICATION START
	if (isset($_GET["option"]) == true && $_GET["option"] == "com_net2ftp") {
		net2ftp("printJavascript");
		net2ftp("printCss");
	}
// NET2FTP MODIFICATION END
// -------------------------------------------------------------------------
}
?>