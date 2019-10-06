<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2017 by David Gartner                         |
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the GNU General Public License                   |
//  | as published by the Free Software Foundation; either version 2                |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//   -------------------------------------------------------------------------------





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function timer() {

// --------------
// This function calculates the time between starttime and endtime in seconds
// --------------

	global $net2ftp_globals;
	$time_taken = ($net2ftp_globals["endtime"] - $net2ftp_globals["starttime"]);

	return $time_taken; // in seconds

} // End function timer

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function mytime() {

	$datetime = date("Y-m-d H:i:s");
	return $datetime;
}

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function mytime_short() {

	$datetime = date("H:i");
	return $datetime;
}

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function getBrowser($what) {

// --------------
// This function returns the browser name, version and platform using the http_user_agent string
// --------------

// Original code comes from http://www.phpbuilder.com/columns/tim20000821.php3?print_mode=1
// Written by Tim Perdue, and released under the GPL license
//
// SourceForge: Breaking Down the Barriers to Open Source Development
// Copyright 1999-2000 (c) The SourceForge Crew
// http://sourceforge.net
//
// $Id: tim20000821.php3,v 1.2 2001/05/22 19:22:47 tim Exp $


// -------------------------------------------------------------------------
// If no information is available, return ""
// -------------------------------------------------------------------------
	if (isset($_SERVER["HTTP_USER_AGENT"]) == false) { return ""; }

// -------------------------------------------------------------------------
// Remove XSS code
// -------------------------------------------------------------------------
	$http_user_agent = validateGenericInput($_SERVER["HTTP_USER_AGENT"]);

// -------------------------------------------------------------------------
// Determine browser and version
// -------------------------------------------------------------------------
	if ($what == "version" || $what == "agent") {

// !!! If a new browser is added, add is also in the plugin properties
// Else, functionality will be broken when loading the plugin in printTextareaSelect().

		if (preg_match("/^MSIE ([0-9].[0-9]{1,2})/", $http_user_agent, $regs) == 1) {
			$BROWSER_VERSION = $regs[1];
			$BROWSER_AGENT = 'IE';
		}
		elseif (preg_match("/^Chrome\/([0-9]{1,2}.[0-9]{1,4}.[0-9]{1,4}.[0-9]{1,4})/", $http_user_agent, $regs)) {
			$BROWSER_VERSION = $regs[1];
			$BROWSER_AGENT = 'Chrome';
		}
		elseif (preg_match("/^Safari\/([0-9].[0-9]{1,2})/", $http_user_agent, $regs)) {
			$BROWSER_VERSION = $regs[1];
			$BROWSER_AGENT = 'Safari';
		}
		elseif (preg_match("/^Opera ([0-9].[0-9]{1,2})/", $http_user_agent, $regs)) {
			$BROWSER_VERSION = $regs[1];
			$BROWSER_AGENT = 'Opera';
		}
		elseif (preg_match("/^Mozilla\/([0-9].[0-9]{1,2})/", $http_user_agent, $regs)) {
			$BROWSER_VERSION = $regs[1];
			$BROWSER_AGENT = 'Mozilla';
		}
		else {
			$BROWSER_VERSION = 0;
			$BROWSER_AGENT = 'Other';
		}

		if ($what == "version") { return $BROWSER_VERSION; }
		elseif ($what == "agent")   { return $BROWSER_AGENT; }

	} // end if

// -------------------------------------------------------------------------
// Determine platform
// -------------------------------------------------------------------------

	elseif ($what == "platform") {

		if (	stripos($http_user_agent,"iPod") 	||
			stripos($http_user_agent,"iPhone") 	||
			stripos($http_user_agent,"iPad") 	||
			stripos($http_user_agent,"Android")	||
			stripos($http_user_agent,"webOS")) {
			$BROWSER_PLATFORM = 'Mobile';
		}
		elseif (strstr($http_user_agent, 'Win')) {
			$BROWSER_PLATFORM = 'Win';
		}
		else if (strstr($http_user_agent, 'Mac')) {
			$BROWSER_PLATFORM = 'Mac';
		}
		else if (strstr($http_user_agent, 'Linux')) {
			$BROWSER_PLATFORM = 'Linux';
		}
		else if (strstr($http_user_agent, 'Unix')) {
			$BROWSER_PLATFORM = 'Unix';
		}
		else {
			$BROWSER_PLATFORM = 'Other';
		}

		return $BROWSER_PLATFORM;

	} // end if elseif

} // End function getBrowser

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

?>