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

//	global $net2ftp_settings, $net2ftp_globals, $net2ftp_messages, $net2ftp_result;
	
} // end net2ftp_sendHttpHeaders

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printJavascript() {

// --------------
// This function prints Javascript code and includes
// --------------

	global $net2ftp_settings, $net2ftp_globals;

// -------------------------------------------------------------------------
// Include the embed.js file for openlaszlo, and nothing else
// -------------------------------------------------------------------------
	if ($net2ftp_globals["skin"] == "openlaszlo") {
//		echo "<script type=\"text/javascript\" src=\"". $net2ftp_globals["application_rootdir_url"] . "/skins/openlaszlo/lps/includes/embed-compressed.js\"></script>\n";
	}

// -------------------------------------------------------------------------
// For the other skins, do print more Javascript functions
// -------------------------------------------------------------------------
	else {

// ------------------------------------
// Includes
// ------------------------------------

// Recaptcha (special code to allow 3 on the same page)
// http://mycodde.blogspot.ch/2014/12/multiple-recaptcha-demo-same-page.html
		if ($net2ftp_settings["use_captcha"] == "yes") {
			echo "<script src=\"https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit\" async defer></script>\n";
		}

// Detect adblocker
		if ($net2ftp_settings["show_ads"] == "yes") {
			echo "<script type=\"text/javascript\" src=\"". $net2ftp_globals["application_rootdir_url"] . "/skins/ads/adblocker_detect.js\"></script>\n";
		}

// ------------------------------------
// Code
// ------------------------------------

		echo "<script type=\"text/javascript\"><!--\n";	

// Recaptcha (special code to allow 3 on the same page)
// http://mycodde.blogspot.ch/2014/12/multiple-recaptcha-demo-same-page.html
		if ($net2ftp_settings["use_captcha"] == "yes") {
			echo "var recaptcha1, recaptcha2, recaptcha3;\n";
			echo "var myCallBack = function() {\n";
			echo "	recaptcha1 = grecaptcha.render('recaptcha1', {\n";
			echo "		'sitekey' : '" . $net2ftp_settings["recaptcha_sitekey"] . "',\n";
			echo "		'theme' : 'light'\n";
			echo "	});\n";
			echo "};\n";
		}

		echo "function CheckInput(form) {\n";
		echo "	if (form.username.value.length == 0) {\n";
		echo "		form.username.focus();\n";
		echo "		alert(\"" . __("Please enter a username.") . "\");\n";
		echo "		return false;\n";
		echo "	}\n";
		echo "	if (form.username.value.length > 254) {\n";
		echo "		form.username.focus();\n";
		echo "		alert(\"" . __("Username is too long; please enter less than 255 characters.") . "\");\n";
		echo "		return false;\n";
		echo "	}\n";

//		echo "	if (form.password.value.length == 0) {\n";
//		echo "		form.password.focus();\n";
//		echo "		alert(\"" . __("Please enter a password.") . "\");\n";
//		echo "		return false;\n";
//		echo "	}\n";

		echo "	if (form.user_email.value.length == 0) {\n";
		echo "		form.user_email.focus();\n";
		echo "		alert(\"" . __("Please enter your email address.") . "\");\n";
		echo "		return false;\n";
		echo "	}\n";
		echo "	if (form.user_email.value.length > 254) {\n";
		echo "		form.user_email.focus();\n";
		echo "		alert(\"" . __("Email is too long; please enter less than 255 characters.") . "\");\n";
		echo "		return false;\n";
		echo "	}\n";

		$privacy_check = "";
		for ($i=1; $i<=10; $i++) {
			if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") { 
				$privacy_check .= " || form.privacy" . $i . ".checked == false"; 
			} // end if
		} // end for
		$privacy_check = substr($privacy_check, 4, strlen($privacy_check)-4);

		echo "	if (" . $privacy_check . ") {\n";
		echo "		alert(\"" . __("Please agree to all privacy policies.") . "\");\n";
		echo "		return false;\n";
		echo "	}\n";

		echo "	return true;\n";
		echo "}\n";

		echo "//--></script>\n";

	} // end if else

} // end net2ftp_printJavascript

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printCss() {

// --------------
// This function prints CSS code and includes
// --------------

	global $net2ftp_settings, $net2ftp_globals;

// Include
//	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $net2ftp_globals["application_rootdir_url"] . "/skins/" . $net2ftp_globals["skin"] . "/css/main.css.php?ltr=" . __("ltr") . "&amp;image_url=" . urlEncode2($net2ftp_globals["image_url"]) . "\" />\n";

} // end net2ftp_printCssInclude

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printBodyOnload() {

// --------------
// This function prints the <body onload="" actions
// --------------

//	global $net2ftp_settings, $net2ftp_globals, $net2ftp_messages, $net2ftp_result;
//	echo "";

} // end net2ftp_printBodyOnload

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function net2ftp_module_printBody() {

// --------------
// This function prints the login screen
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_settings, $net2ftp_globals, $net2ftp_messages, $net2ftp_result, $net2ftp_output;

// The 2 go_to_state variables come from the bookmark, or from registerglobals.inc.php
	if (isset($_GET["go_to_state"]) == true)  { $go_to_state  = validateGenericInput($_GET["go_to_state"]); }
	else                                      { $go_to_state  = $net2ftp_globals["go_to_state"]; }
	if (isset($_GET["go_to_state2"]) == true) { $go_to_state2 = validateGenericInput($_GET["go_to_state2"]); }
	else                                      { $go_to_state2 = $net2ftp_globals["go_to_state2"]; }
	if (isset($_GET["errormessage"]) == true) { $errormessage = validateGenericInput($_GET["errormessage"]); }

// Most actions
	if (isset($_POST["list"]) == true) { $list = getSelectedEntries($_POST["list"]); }
	else                               { $list = ""; }

// Bookmark
	if (isset($_POST["url"]) == true)  { $url = validateGenericInput($_POST["url"]); }
	else                               { $url = ""; }
	if (isset($_POST["text"]) == true) { $text = validateGenericInput($_POST["text"]); }
	else                               { $text = ""; }

// Copy, move, delete
	if (isset($_POST["protocol2"]) == true)       { $net2ftp_globals["protocol2"]       = validateProtocol($_POST["protocol2"]); }
	else                                          { $net2ftp_globals["protocol2"]       = ""; }
	if (isset($_POST["ftpserver2"]) == true)      { $net2ftp_globals["ftpserver2"]      = validateFtpserver($_POST["ftpserver2"]); }
	else                                          { $net2ftp_globals["ftpserver2"]      = ""; }
	if (isset($_POST["ftpserverport2"]) == true)  { $net2ftp_globals["ftpserverport2"]  = validateFtpserverport($_POST["ftpserverport2"]); }
	else                                          { $net2ftp_globals["ftpserverport2"]  = ""; }
	if (isset($_POST["sshfingerprint2"]) == true) { $net2ftp_globals["sshfingerprint2"] = validateSshfingerprint($_POST["sshfingerprint2"]); }
	else                                          { $net2ftp_globals["sshfingerprint2"] = ""; }
	if (isset($_POST["username2"]) == true)       { $net2ftp_globals["username2"]       = validateUsername($_POST["username2"]); }
	else                                          { $net2ftp_globals["username2"]       = ""; }
	if (isset($_POST["password2"]) == true)       { $net2ftp_globals["password2"]       = validatePassword($_POST["password2"]); }
	else                                          { $net2ftp_globals["password2"]       = ""; }

// Edit
	if (isset($_POST["textareaType"]) == true)  { $textareaType = validateTextareaType($_POST["textareaType"]); }
	else                                        { $textareaType = ""; }
	if (isset($_POST["text"]) == true)          { $text = $_POST["text"]; }
	else                                        { $text = ""; }
	if (isset($_POST["text_splitted"]) == true) { $text_splitted = $_POST["text_splitted"]; }
	else                                        { $text_splitted = ""; }

// Find string
	if (isset($_POST["searchoptions"]) == true) { $searchoptions = $_POST["searchoptions"]; }

// New directory

// Rename
	if (isset($_POST["newNames"]) == true) { $newNames = validateEntry($_POST["newNames"]); }
	else                                   { $newNames = ""; }

// Raw FTP command
	if (isset($_POST["command"]) == true) { $command = $_POST["command"]; }
	else                                  { $command = "CWD $directory_html\nPWD\n"; }

// Zip
	if (isset($_POST["zipactions"]) == true) { $zipactions = $_POST["zipactions"]; }
	else                                     { $zipactions = ""; }

// -------------------------------------------------------------------------
// Variables for all screens
// -------------------------------------------------------------------------

	$formname = "LoginForm1";
	$enctype = "";

	if ($net2ftp_globals["state2"] == "admin") {
		$message = __("Please enter your Administrator username and password.");
		$button_text = __("Login");
		$username_fieldname = "input_admin_username";
		$password_fieldname = "input_admin_password";
		$username_value = "";
		$password_value = "";
		$focus = $username_fieldname;
	}
	elseif ($net2ftp_globals["state2"] == "bookmark") {
		$message = __("Please enter your username and password for FTP server <b>%1\$s</b>.", htmlEncode2($net2ftp_globals["ftpserver"]));
		$button_text = __("Login");
		$username_fieldname = "username";
		$password_fieldname = "password";
		$username_value = ""; 
		$password_value = "";
		if (isset($net2ftp_globals["username"]) == true) { 
			$username_value = htmlEncode2($net2ftp_globals["username"]); 
			$focus = $password_fieldname;
		}
		else { 
			$focus = $username_fieldname;
		}
		if (isset($net2ftp_globals["password_encrypted"]) == true) { 
			$password_value = htmlEncode2(decryptPassword($net2ftp_globals["password_encrypted"])); 
		}
	}
	elseif ($net2ftp_globals["state2"] == "session_expired") {
		$message = __("Your session has expired; please enter your password for FTP server <b>%1\$s</b> to continue.", htmlEncode2($net2ftp_globals["ftpserver"]));
		$button_text = __("Continue");
		$username_fieldname = "username";
		$password_fieldname = "password";
		if (isset($net2ftp_globals["username"]) == true) { 
			$username_value = htmlEncode2($net2ftp_globals["username"]); 
			$focus = $password_fieldname;
		}
		else { 
			$username_value = ""; 
			$focus = $username_fieldname;
		}
		$password_value = "";
	}
	elseif ($net2ftp_globals["state2"] == "session_ipchange") {
		$message = __("Your IP address has changed; please enter your password for FTP server <b>%1\$s</b> to continue.", htmlEncode2($net2ftp_globals["ftpserver"]));
		$button_text = __("Continue");
		$username_fieldname = "username";
		$password_fieldname = "password";
		if (isset($net2ftp_globals["username"]) == true) { 
			$username_value = htmlEncode2($net2ftp_globals["username"]); 
			$focus = $password_fieldname;
		}
		else { 
			$username_value = ""; 
			$focus = $username_fieldname;
		}
		$password_value = "";
	}

// -------------------------------------------------------------------------
// Print the output
// -------------------------------------------------------------------------
	require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/login_small.template.php");

} // End net2ftp_printBody

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

?>