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























// ------------------------------------------------------------------------
// XOOPS
// ------------------------------------------------------------------------
include '../../mainfile.php';


// ------------------------------------------------------------------------
// 1. Set global constants and include the net2ftp library file main.inc.php
// ------------------------------------------------------------------------

// Global variables
global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

// Check if the directory and URL entered above have a trailing / or \
if (substr($application_rootdir, -1, 1) == "/" || substr($application_rootdir, -1, 1) == "\\") {
	$application_rootdir = substr($application_rootdir, 0, strlen($application_rootdir)-1);
}
if (substr($application_rootdir_url, -1, 1) == "/" || substr($application_rootdir_url, -1, 1) == "\\") {
	$application_rootdir_url = substr($application_rootdir_url, 0, strlen($application_rootdir_url)-1);
}

// Enter the directory where net2ftp is located on the webserver's filesystem (without ending /)
// On Windows, use double backslashes like for example "C:\\web\\net2ftp"
define("NET2FTP_APPLICATION_ROOTDIR", $application_rootdir);

// Enter the URL where net2ftp can be accessed (without ending /)
define("NET2FTP_APPLICATION_ROOTDIR_URL", $application_rootdir_url);

// Include the net2ftp library file main.inc.php
require_once(NET2FTP_APPLICATION_ROOTDIR . "/main.inc.php");


// ------------------------------------------------------------------------
// XOOPS
// ------------------------------------------------------------------------
include XOOPS_ROOT_PATH . "/header.php";


// ------------------------------------------------------------------------
// 2. Execute net2ftp($action)
// Global variables are stored in net2ftp_globals
// ------------------------------------------------------------------------

net2ftp("sendHttpHeaders");
net2ftp("printJavascript");
net2ftp("printCss");
net2ftp("printBody");


// ------------------------------------------------------------------------
// 3. Check the result and print out an error message
//    This can be done using a template, or by accessing the $net2ftp_result variable directly
// ------------------------------------------------------------------------

if ($net2ftp_result["success"] == false) {
	require_once($net2ftp_globals["application_rootdir"] . "/skins/mambo/error.template.php");
}


// ------------------------------------------------------------------------
// XOOPS
// ------------------------------------------------------------------------
include XOOPS_ROOT_PATH . "/footer.php";

?>