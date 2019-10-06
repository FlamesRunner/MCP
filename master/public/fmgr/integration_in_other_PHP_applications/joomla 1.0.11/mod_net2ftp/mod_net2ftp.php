<?php

// ------------------------------------------------------------------------
// Set your parameters here
// ------------------------------------------------------------------------

// Enter the directory where net2ftp is located on the webserver's filesystem (without ending /)
// On Windows, use double backslashes like for example "C:\\path\\to\\net2ftp"
	define("NET2FTP_APPLICATION_ROOTDIR", "/path/to/net2ftp");

// Enter the URL where net2ftp can be accessed (without ending /)
	define("NET2FTP_APPLICATION_ROOTDIR_URL", "http://www.mywebsite.com/net2ftp");

// ------------------------------------------------------------------------
// Nothing has to be changed below (unless you know what you're doing!)
// ------------------------------------------------------------------------























// Ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// If the component is used, do not show the module
if (isset($_GET["option"]) == true && $_GET["option"] == "com_net2ftp") {
	echo "This net2ftp login form is deactivated, as the net2ftp component is currently active.";
	return true;
}

// Get the Itemid of the net2ftp component from the database
//$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_net2ftp'");
//$_REQUEST['Itemid'] = $database->loadResult();   
//$Itemid = intval( mosgetParam( $_REQUEST, 'Itemid') );


// ------------------------------------------------------------------------
// 1. Set global constants and include the net2ftp library file main.inc.php
// ------------------------------------------------------------------------

// Global variables
global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

// Include the net2ftp library file main.inc.php
require_once(NET2FTP_APPLICATION_ROOTDIR . "/main.inc.php");


// ------------------------------------------------------------------------
// 2. Execute net2ftp($action)
// Global variables are stored in net2ftp_globals
// ------------------------------------------------------------------------
net2ftp("sendHttpHeaders");
net2ftp("printJavascript");
net2ftp("printCss");

$net2ftp_globals["action_url"] = $net2ftp_globals["PHP_SELF"] . "?option=com_net2ftp&amp;Itemid=$Itemid";
net2ftp("printBody");


// ------------------------------------------------------------------------
// 3. Check the result and print out an error message
//    This can be done using a template, or by accessing the $net2ftp_result variable directly
// ------------------------------------------------------------------------

if ($net2ftp_result["success"] == false) {
	require_once($net2ftp_globals["application_rootdir"] . "/skins/mambo/error.template.php");
}

?>