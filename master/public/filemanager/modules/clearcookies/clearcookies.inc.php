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

function net2ftp_module_sendHttpHeaders() {

// --------------
// This function sends HTTP headers
// --------------

// Consent cookies
// Set by net2ftp login, login_small and browse modules, and removed by net2ftp clearcookies module
	setcookie("net2ftpcookie_consent_necessary",           "", 1);
	setcookie("net2ftpcookie_consent_preferences",         "", 1);
	setcookie("net2ftpcookie_consent_statistics",          "", 1);
	setcookie("net2ftpcookie_consent_personalized_ads",    "", 1);
	setcookie("net2ftpcookie_consent_nonpersonalized_ads", "", 1);
	setcookie("net2ftpcookie_user_email",                  "", 1);
	for ($i=1; $i<=10; $i++) {
		setcookie("net2ftpcookie_privacy" . $i,          "", 1);
	} // end for

// Necessary cookies
// e.g. for Google Captcha

// Preferences
// Set by net2ftp browse module, and removed by net2ftp clearcookies module
	setcookie("net2ftpcookie_skin",                        "", 1);
	setcookie("net2ftpcookie_language",                    "", 1);
	setcookie("net2ftpcookie_ftpserver",                   "", 1);
	setcookie("net2ftpcookie_ftpserverport",               "", 1);
	setcookie("net2ftpcookie_ftpserverport_ftp",           "", 1);
	setcookie("net2ftpcookie_ftpserverport_ssh",           "", 1);
	setcookie("net2ftpcookie_ftpserverport_ssl",           "", 1);
	setcookie("net2ftpcookie_username",                    "", 1);
	setcookie("net2ftpcookie_directory",                   "", 1);
	setcookie("net2ftpcookie_protocol",                    "", 1);
	setcookie("net2ftpcookie_ftpmode",                     "", 1);
	setcookie("net2ftpcookie_passivemode",                 "", 1);
	setcookie("net2ftpcookie_viewmode",                    "", 1);
	setcookie("net2ftpcookie_sort",                        "", 1);
	setcookie("net2ftpcookie_sortorder",                   "", 1);

// Statistics
// e.g. for Google Analytics

// Personalized ads
// e.g. for Google Adsense

// Nonpersonalized ads
// e.g. for Google Adsense

	header("Location: index.php");
	
} // end net2ftp_sendHttpHeaders

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************


?>