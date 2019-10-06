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

// Make sure this file is included by net2ftp, not accessed directly

defined("NET2FTP") or die("Direct access to this location is not allowed.");
session_start();

// -------------------------------------------------------------------------
// Overview of the code
// 1   Replace \' by ' (remove_magic_quotes)
// 2   Register main variables
// 3   Register $_COOKIE variables
// 4   Determine the browser agent, version and platform
// -------------------------------------------------------------------------

// -------------------------------------------------------------------------
// 1 When a variable is submitted, quotes ' are replaced by backslash-quotes \'
// This function removes the extra backslash that is added
// -------------------------------------------------------------------------
if (get_magic_quotes_gpc() == 1) {
	remove_magic_quotes($_POST);
	remove_magic_quotes($_GET);
	remove_magic_quotes($_COOKIE);
}

// Do not add remove_magic_quotes for $GLOBALS because this would call the same
// function a second time, replacing \' by ' and \" by "


// -------------------------------------------------------------------------
// 2 Global variabes
// -------------------------------------------------------------------------

// ----------------------------------------------
// consent variables
// ----------------------------------------------
if (isset($_POST["consent_necessary"]) == true && $_POST["consent_necessary"] == 1) { $net2ftp_globals["consent_necessary"] = 1; }
else                                                                                { $net2ftp_globals["consent_necessary"] = 0; }

if (isset($_POST["consent_preferences"]) == true && $_POST["consent_preferences"] == 1) { $net2ftp_globals["consent_preferences"] = 1; }
else                                                                                    { $net2ftp_globals["consent_preferences"] = 0; }

if (isset($_POST["consent_statistics"]) == true && $_POST["consent_statistics"] == 1) { $net2ftp_globals["consent_statistics"] = 1; }
else                                                                                  { $net2ftp_globals["consent_statistics"] = 0; }

if (isset($_POST["consent_personalized_ads"]) == true && $_POST["consent_personalized_ads"] == 1) { $net2ftp_globals["consent_personalized_ads"] = 1; }
else                                                                                              { $net2ftp_globals["consent_personalized_ads"] = 0; }

if (isset($_POST["consent_nonpersonalized_ads"]) == true && $_POST["consent_nonpersonalized_ads"] == 1) { $net2ftp_globals["consent_nonpersonalized_ads"] = 1; }
else                                                                                                    { $net2ftp_globals["consent_nonpersonalized_ads"] = 0; }

// ----------------------------------------------
// user_email
// ----------------------------------------------
if     (isset($_POST["user_email"]) == true && checkEmailAddress($_POST["user_email"]) == true) { $net2ftp_globals["user_email"] = $_POST["user_email"]; }
elseif (isset($_GET["user_email"])  == true  && checkEmailAddress($_GET["user_email"]) == true) { $net2ftp_globals["user_email"] = $_GET["user_email"]; }
else   { $net2ftp_globals["user_email"] = "invalid_user_email"; }

// ----------------------------------------------
// user_ipadress
// ----------------------------------------------
if (isset($_SERVER["REMOTE_ADDR"]) == true)     { $net2ftp_globals["REMOTE_ADDR"]     = validateGenericInput($_SERVER["REMOTE_ADDR"]); }

// ----------------------------------------------
// user_port
// ----------------------------------------------
if (isset($_SERVER["REMOTE_PORT"]) == true)     { $net2ftp_globals["REMOTE_PORT"]     = validateGenericInput($_SERVER["REMOTE_PORT"]); }

// ----------------------------------------------
// user_http_user_agent
// ----------------------------------------------
if (isset($_SERVER["HTTP_USER_AGENT"]) == true) { $net2ftp_globals["user_http_user_agent"] = validateGenericInput($_SERVER["HTTP_USER_AGENT"]); }

// ----------------------------------------------
// privacy
// ----------------------------------------------
for ($i=1; $i<=10; $i++) {
	if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] !== "") {
		if     (isset($_POST["privacy" . $i]) && $_POST["privacy" . $i] == "1") { $net2ftp_globals["privacy" . $i] = "1"; }
		elseif (isset($_GET["privacy"  . $i]) && $_GET["privacy"  . $i] == "1") { $net2ftp_globals["privacy" . $i] = "1"; }
		else                                                                    { $net2ftp_globals["privacy" . $i] = "0"; }
	}
} // end for

// ----------------------------------------------
// page
// ----------------------------------------------
if     (isset($_SERVER["SCRIPT_NAME"]) == true) { $net2ftp_globals["page"]        = validateGenericInput($_SERVER["SCRIPT_NAME"]); }
elseif (isset($_SERVER["PHP_SELF"]) == true)    { $net2ftp_globals["page"]        = validateGenericInput($_SERVER["PHP_SELF"]); }
else                                            { $net2ftp_globals["page"]        = "index.php"; }
// Action URL
// Note that later on in this file parameters may be appended to the action_url (for Mambo and Drupal)
$net2ftp_globals["action_url"] = $net2ftp_globals["page"];

// ----------------------------------------------
// state
// ----------------------------------------------
 if     (isset($_POST["state"]) == true) { $net2ftp_globals["state"] = validateState($_POST["state"]); }
elseif (isset($_GET["state"]) == true)  { $net2ftp_globals["state"] = validateState($_GET["state"]); }
else                                    { $net2ftp_globals["state"] = validateState(""); } 
//$net2ftp_globals["state"] = validateState("browse");
$net2ftp_globals["state_html"] = htmlEncode2($net2ftp_globals["state"]);
$net2ftp_globals["state_url"]  = urlEncode2($net2ftp_globals["state"]);
$net2ftp_globals["state_js"]   = javascriptEncode2($net2ftp_globals["state"]);

// ----------------------------------------------
// state2
// ----------------------------------------------
if     (isset($_POST["state2"]) == true) { $net2ftp_globals["state2"] = validateState2($_POST["state2"]); }
elseif (isset($_GET["state2"]) == true)  { $net2ftp_globals["state2"] = validateState2($_GET["state2"]); }
else                                     { $net2ftp_globals["state2"] = validateState2(""); }
//$net2ftp_globals["state2"] = validateState("main");
$net2ftp_globals["state2_html"] = htmlEncode2($net2ftp_globals["state2"]);
$net2ftp_globals["state2_url"]  = urlEncode2($net2ftp_globals["state2"]);
$net2ftp_globals["state2_js"]   = javascriptEncode2($net2ftp_globals["state2"]);

// ----------------------------------------------
// screen
// ----------------------------------------------
if     (isset($_POST["screen"]) == true) { $net2ftp_globals["screen"] = validateScreen($_POST["screen"]); }
elseif (isset($_GET["screen"]) == true)  { $net2ftp_globals["screen"] = validateScreen($_GET["screen"]); }
else                                     { $net2ftp_globals["screen"] = validateScreen(""); }
$net2ftp_globals["screen_html"] = htmlEncode2($net2ftp_globals["screen"]);
$net2ftp_globals["screen_url"]  = urlEncode2($net2ftp_globals["screen"]);
$net2ftp_globals["screen_js"]   = javascriptEncode2($net2ftp_globals["screen"]);

// ----------------------------------------------
// language
// ----------------------------------------------
if     (isset($_POST["language"]) == true) { $net2ftp_globals["language"] = validateLanguage($_POST["language"]); }
elseif (isset($_GET["language"]) == true)  { $net2ftp_globals["language"] = validateLanguage($_GET["language"]); }
else                                       { $net2ftp_globals["language"] = validateLanguage(""); }
$net2ftp_globals["language_html"] = htmlEncode2($net2ftp_globals["language"]);
$net2ftp_globals["language_url"]  = urlEncode2($net2ftp_globals["language"]);
$net2ftp_globals["language_js"]   = javascriptEncode2($net2ftp_globals["language"]);

// ----------------------------------------------
// skin
// First determine language, then skin (because skin needs to know which is the language)
// ----------------------------------------------
if     (isset($_POST["skin"]) == true) { $net2ftp_globals["skin"] = validateSkin($_POST["skin"]); }
elseif (isset($_GET["skin"]) == true)  { $net2ftp_globals["skin"] = validateSkin($_GET["skin"]); }
else                                   { $net2ftp_globals["skin"] = validateSkin(""); }
$net2ftp_globals["skin_html"] = htmlEncode2($net2ftp_globals["skin"]);
$net2ftp_globals["skin_url"]  = urlEncode2($net2ftp_globals["skin"]);
$net2ftp_globals["skin_js"]   = javascriptEncode2($net2ftp_globals["skin"]);

$skinArray = getSkinArray();
$net2ftp_globals["image_url"] = $skinArray[$net2ftp_globals["skin"]]["image_url"];

// ----------------------------------------------
// protocol (FTP, FTP with SSL, FTP over SSH)
// ----------------------------------------------
/* if     (isset($_POST["protocol"]) == true) { $net2ftp_globals["protocol"] = validateProtocol($_POST["protocol"]); }
elseif (isset($_GET["protocol"]) == true)  { $net2ftp_globals["protocol"] = validateProtocol($_GET["protocol"]); }
else                                       { $net2ftp_globals["protocol"] = validateProtocol(""); } */
$net2ftp_globals["protocol"] = validateProtocol("FTP-SSH");
$net2ftp_globals["protocol_html"] = htmlEncode2($net2ftp_globals["protocol"]);
$net2ftp_globals["protocol_url"]  = urlEncode2($net2ftp_globals["protocol"]);
$net2ftp_globals["protocol_js"]   = javascriptEncode2($net2ftp_globals["protocol"]);

// ----------------------------------------------
// FTP or SSH server
// ----------------------------------------------
if (isset($_SESSION["host"]) == true) {
	 $net2ftp_globals["ftpserver"] = validateFtpserver($_SESSION["host"]);
} elseif     (isset($_POST["ftpserver"]) == true) { $net2ftp_globals["ftpserver"] = validateFtpserver($_POST["ftpserver"]); }
elseif (isset($_GET["ftpserver"]) == true)  { $net2ftp_globals["ftpserver"] = validateFtpserver($_GET["ftpserver"]); }
else                                        { $net2ftp_globals["ftpserver"] = validateFtpserver(""); }
$net2ftp_globals["ftpserver_html"] = htmlEncode2($net2ftp_globals["ftpserver"]);
$net2ftp_globals["ftpserver_url"]  = urlEncode2($net2ftp_globals["ftpserver"]);
$net2ftp_globals["ftpserver_js"]   = javascriptEncode2($net2ftp_globals["ftpserver"]);

// ----------------------------------------------
// FTP or SSH server port
// ----------------------------------------------
/*if     (isset($_POST["ftpserverport"]) == true) { $net2ftp_globals["ftpserverport"] = validateFtpserverport($_POST["ftpserverport"]); }
elseif (isset($_GET["ftpserverport"]) == true)  { $net2ftp_globals["ftpserverport"] = validateFtpserverport($_GET["ftpserverport"]); }
else                                            { $net2ftp_globals["ftpserverport"] = validateFtpserverport(""); } */
$net2ftp_globals["ftpserverport"] = validateFtpserverport("22");
$net2ftp_globals["ftpserverport_html"] = htmlEncode2($net2ftp_globals["ftpserverport"]);
$net2ftp_globals["ftpserverport_url"]  = urlEncode2($net2ftp_globals["ftpserverport"]);
$net2ftp_globals["ftpserverport_js"]   = javascriptEncode2($net2ftp_globals["ftpserverport"]);

// ----------------------------------------------
// username
// ----------------------------------------------
if (isset($_SESSION["username"]) == true) {
	$net2ftp_globals["username"] = validateUsername($_SESSION["username"]);
}
elseif     (isset($_POST["username"]) == true) { $net2ftp_globals["username"] = validateUsername($_POST["username"]); }
elseif (isset($_GET["username"]) == true)  { $net2ftp_globals["username"] = validateUsername($_GET["username"]); }
else                                       { $net2ftp_globals["username"] = validateUsername(""); }
$net2ftp_globals["username_html"] = htmlEncode2($net2ftp_globals["username"]);
$net2ftp_globals["username_url"]  = urlEncode2($net2ftp_globals["username"]);
$net2ftp_globals["username_js"]   = javascriptEncode2($net2ftp_globals["username"]);

// ----------------------------------------------
// password
// ----------------------------------------------
// From login form
if (isset($_SESSION["password"])) {
        $net2ftp_globals["password_encrypted"]  = encryptPassword(trim($_SESSION["password"]));
} elseif (isset($_POST["password"]) == true) {
	$net2ftp_globals["password_encrypted"]  = encryptPassword(trim($_POST["password"]));
}
// From most other screens
elseif (isset($_POST["password_encrypted"]) == true) {
	$net2ftp_globals["password_encrypted"]  = trim($_POST["password_encrypted"]);
}
// From the login_small form (from a bookmark)
elseif (isset($_GET["password_encrypted"]) == true) {
	$net2ftp_globals["password_encrypted"]  = validatePasswordEncrypted($_GET["password_encrypted"]);
}
else {
	$net2ftp_globals["password_encrypted"] = "";
}

if (isset($_SESSION["password"])) unset($_SESSION["password"]);

// ----------------------------------------------
// directory
// ----------------------------------------------
if     (isset($_POST["directory"]) == true) { $net2ftp_globals["directory"] = validateDirectory($_POST["directory"]); }
elseif (isset($_GET["directory"]) == true)  { $net2ftp_globals["directory"] = validateDirectory($_GET["directory"]); }
else                                        { $net2ftp_globals["directory"] = ""; }
$net2ftp_globals["directory_html"] = htmlEncode2($net2ftp_globals["directory"]);
$net2ftp_globals["directory_url"]  = urlEncode2($net2ftp_globals["directory"]);
$net2ftp_globals["directory_js"]   = javascriptEncode2($net2ftp_globals["directory"]);

// printdirectory
if ($net2ftp_globals["directory"] != "" && $net2ftp_globals["directory"] != "/") {
	$net2ftp_globals["printdirectory"] = $net2ftp_globals["directory"];
}
else { 
	$net2ftp_globals["printdirectory"] = "/"; 
}

// ----------------------------------------------
// entry
// ----------------------------------------------
if     (isset($_POST["entry"]) == true) { $net2ftp_globals["entry"] = validateEntry($_POST["entry"]); }
elseif (isset($_GET["entry"]) == true)  { $net2ftp_globals["entry"] = validateEntry($_GET["entry"]); }
else                                    { $net2ftp_globals["entry"] = ""; }
$net2ftp_globals["entry_html"] = htmlEncode2($net2ftp_globals["entry"]);
$net2ftp_globals["entry_url"]  = urlEncode2($net2ftp_globals["entry"]);
$net2ftp_globals["entry_js"]   = javascriptEncode2($net2ftp_globals["entry"]);

// ----------------------------------------------
// SSH server fingerprint
// ----------------------------------------------
if     (isset($_POST["sshfingerprint"]) == true) { $net2ftp_globals["sshfingerprint"] = validateSshfingerprint($_POST["sshfingerprint"]); }
elseif (isset($_GET["sshfingerprint"]) == true)  { $net2ftp_globals["sshfingerprint"] = validateSshfingerprint($_GET["sshfingerprint"]); }
else                                             { $net2ftp_globals["sshfingerprint"] = validateSshfingerprint(""); }
$net2ftp_globals["sshfingerprint_html"] = htmlEncode2($net2ftp_globals["sshfingerprint"]);
$net2ftp_globals["sshfingerprint_url"]  = urlEncode2($net2ftp_globals["sshfingerprint"]);
$net2ftp_globals["sshfingerprint_js"]   = javascriptEncode2($net2ftp_globals["sshfingerprint"]);

// ----------------------------------------------
// FTP mode
// ----------------------------------------------
if     (isset($_POST["ftpmode"]) == true) { $net2ftp_globals["ftpmode"] = validateFtpmode($_POST["ftpmode"]); }
elseif (isset($_GET["ftpmode"]) == true)  { $net2ftp_globals["ftpmode"] = validateFtpmode($_GET["ftpmode"]); }
else                                      { $net2ftp_globals["ftpmode"] = validateFtpmode(""); }
$net2ftp_globals["ftpmode_html"] = htmlEncode2($net2ftp_globals["ftpmode"]);
$net2ftp_globals["ftpmode_url"]  = urlEncode2($net2ftp_globals["ftpmode"]);
$net2ftp_globals["ftpmode_js"]   = javascriptEncode2($net2ftp_globals["ftpmode"]);

// ----------------------------------------------
// passive mode
// ----------------------------------------------
if     (isset($_POST["passivemode"]) == true) { $net2ftp_globals["passivemode"] = validatePassivemode($_POST["passivemode"]); }
elseif (isset($_GET["passivemode"]) == true)  { $net2ftp_globals["passivemode"] = validatePassivemode($_GET["passivemode"]); }
else                                          { $net2ftp_globals["passivemode"] = validatePassivemode(""); }
$net2ftp_globals["passivemode_html"] = htmlEncode2($net2ftp_globals["passivemode"]);
$net2ftp_globals["passivemode_url"]  = urlEncode2($net2ftp_globals["passivemode"]);
$net2ftp_globals["passivemode_js"]   = javascriptEncode2($net2ftp_globals["passivemode"]);

// ----------------------------------------------
// view mode
// ----------------------------------------------
if     (isset($_POST["viewmode"]) == true) { $net2ftp_globals["viewmode"] = validateViewmode($_POST["viewmode"]); }
elseif (isset($_GET["viewmode"]) == true)  { $net2ftp_globals["viewmode"] = validateViewmode($_GET["viewmode"]); }
else                                       { $net2ftp_globals["viewmode"] = validateViewmode(""); }
$net2ftp_globals["viewmode_html"] = htmlEncode2($net2ftp_globals["viewmode"]);
$net2ftp_globals["viewmode_url"]  = urlEncode2($net2ftp_globals["viewmode"]);
$net2ftp_globals["viewmode_js"]   = javascriptEncode2($net2ftp_globals["viewmode"]);

// ----------------------------------------------
// Sort
// ----------------------------------------------
if     (isset($_POST["sort"]) == true) { $net2ftp_globals["sort"] = validateSort($_POST["sort"]); }
elseif (isset($_GET["sort"]) == true)  { $net2ftp_globals["sort"] = validateSort($_GET["sort"]); }
else                                   { $net2ftp_globals["sort"] = validateSort(""); }
$net2ftp_globals["sort_html"] = htmlEncode2($net2ftp_globals["sort"]);
$net2ftp_globals["sort_url"]  = urlEncode2($net2ftp_globals["sort"]);
$net2ftp_globals["sort_js"]   = javascriptEncode2($net2ftp_globals["sort"]);

// ----------------------------------------------
// Sort order
// ----------------------------------------------
if     (isset($_POST["sortorder"]) == true) { $net2ftp_globals["sortorder"] = validateSortorder($_POST["sortorder"]); }
elseif (isset($_GET["sortorder"]) == true)  { $net2ftp_globals["sortorder"] = validateSortorder($_GET["sortorder"]); }
else                                        { $net2ftp_globals["sortorder"] = validateSortorder(""); }
$net2ftp_globals["sortorder_html"] = htmlEncode2($net2ftp_globals["sortorder"]);
$net2ftp_globals["sortorder_url"]  = urlEncode2($net2ftp_globals["sortorder"]);
$net2ftp_globals["sortorder_js"]   = javascriptEncode2($net2ftp_globals["sortorder"]);

// ----------------------------------------------
// MAMBO variables
// ----------------------------------------------
if (defined("_VALID_MOS") == true) {
	$option = validateGenericInput($_GET["option"]);
	$Itemid = validateGenericInput($_GET["Itemid"]);
	$net2ftp_globals["action_url"] .= "?option=$option&amp;Itemid=$Itemid";
}

// ----------------------------------------------
// DRUPAL variables
// ----------------------------------------------
if (defined("CACHE_PERMANENT") == true) {
	$q = validateGenericInput($_GET["q"]);
	$net2ftp_globals["action_url"] .= "?q=$q";
}



// -------------------------------------------------------------------------
// 3 COOKIE variabes
// -------------------------------------------------------------------------

// ----------------------------------------------
// Consent cookies
// Set by net2ftp login, login_small and browse modules, and removed by net2ftp clearcookies module
// ----------------------------------------------
if (isset($_COOKIE["net2ftpcookie_consent_necessary"]) == true && $_COOKIE["consent_necessary"] == 1)                      { $net2ftp_globals["cookie_consent_necessary"] = 1; }
else                                                                                                                       { $net2ftp_globals["cookie_consent_necessary"] = 0; }
if (isset($_COOKIE["net2ftpcookie_consent_preferences"]) == true && $_COOKIE["consent_preferences"] == 1)                  { $net2ftp_globals["cookie_consent_preferences"] = 1; }
else                                                                                                                       { $net2ftp_globals["cookie_consent_preferences"] = 0; }
if (isset($_COOKIE["net2ftpcookie_consent_statistics"]) == true && $_COOKIE["consent_statistics"] == 1)                    { $net2ftp_globals["cookie_consent_statistics"] = 1; }
else                                                                                                                       { $net2ftp_globals["cookie_consent_statistics"] = 0; }
if (isset($_COOKIE["net2ftpcookie_consent_personalized_ads"]) == true && $_COOKIE["consent_personalized_ads"] == 1)        { $net2ftp_globals["cookie_consent_personalized_ads"] = 1; }
else                                                                                                                       { $net2ftp_globals["cookie_consent_personalized_ads"] = 0; }
if (isset($_COOKIE["net2ftpcookie_consent_nonpersonalized_ads"]) == true && $_COOKIE["consent_nonpersonalized_ads"] == 1)  { $net2ftp_globals["cookie_consent_nonpersonalized_ads"] = 1; }
else                                                                                                                       { $net2ftp_globals["cookie_consent_nonpersonalized_ads"] = 0; }
if (isset($_COOKIE["net2ftpcookie_user_email"])== true && checkEmailAddress($_COOKIE["net2ftpcookie_user_email"]) == true) { $net2ftp_globals["cookie_user_email"] = $_COOKIE["net2ftpcookie_user_email"]; }
else                                                                                                                       { $net2ftp_globals["cookie_user_email"] = ""; }
for ($i=1; $i<=10; $i++) {
	if (isset($net2ftp_settings["privacy_policy_" . $i]) && $net2ftp_settings["privacy_policy_" . $i] != "") {
		if (isset($_COOKIE["net2ftpcookie_privacy" . $i]) == true && $_COOKIE["net2ftpcookie_privacy" . $i] == "1")    { $net2ftp_globals["cookie_privacy" . $i] = $_COOKIE["net2ftpcookie_privacy" . $i]; }
		else                                                                                                           { $net2ftp_globals["cookie_privacy" . $i] = "0"; }
	}
} // end for

// ----------------------------------------------
// Necessary cookies
// e.g. for Google Captcha
// ----------------------------------------------

// ----------------------------------------------
// Preferences
// Set by net2ftp browse module, and removed by net2ftp clearcookies module
// ----------------------------------------------

if (isset($_COOKIE["net2ftpcookie_protocol"])      == true)     { $net2ftp_globals["cookie_protocol"]          = validateProtocol($_COOKIE["net2ftpcookie_protocol"]); }
else                                                            { $net2ftp_globals["cookie_protocol"]          = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserver"])     == true)     { $net2ftp_globals["cookie_ftpserver"]         = validateFtpserver($_COOKIE["net2ftpcookie_ftpserver"]); }
else                                                            { $net2ftp_globals["cookie_ftpserver"]         = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserverport"]) == true)     { $net2ftp_globals["cookie_ftpserverport"]     = validateFtpserverport($_COOKIE["net2ftpcookie_ftpserverport"]); }
else                                                            { $net2ftp_globals["cookie_ftpserverport"]     = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserverport_ftp"]) == true) { $net2ftp_globals["cookie_ftpserverport_ftp"] = validateFtpserverport($_COOKIE["net2ftpcookie_ftpserverport_ftp"]); }
else                                                            { $net2ftp_globals["cookie_ftpserverport_ftp"] = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserverport_ssh"]) == true) { $net2ftp_globals["cookie_ftpserverport_ssh"] = validateFtpserverport($_COOKIE["net2ftpcookie_ftpserverport_ssh"]); }
else                                                            { $net2ftp_globals["cookie_ftpserverport_ssh"] = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserverport_ssl"]) == true) { $net2ftp_globals["cookie_ftpserverport_ssl"] = validateFtpserverport($_COOKIE["net2ftpcookie_ftpserverport_ssl"]); }
else                                                            { $net2ftp_globals["cookie_ftpserverport_ssl"] = ""; }
if (isset($_COOKIE["net2ftpcookie_sshfingerprint"])== true)     { $net2ftp_globals["cookie_sshfingerprint"]    = validateSshfingerprint($_COOKIE["net2ftpcookie_sshfingerprint"]); }
else                                                            { $net2ftp_globals["cookie_sshfingerprint"]    = ""; }
if (isset($_COOKIE["net2ftpcookie_username"])      == true)     { $net2ftp_globals["cookie_username"]          = validateUsername($_COOKIE["net2ftpcookie_username"]); }
else                                                            { $net2ftp_globals["cookie_username"]          = ""; }
// Don't store the password in a cookie
//
if (isset($_COOKIE["net2ftpcookie_language"])      == true) { $net2ftp_globals["cookie_language"]      = validateLanguage($_COOKIE["net2ftpcookie_language"]); }
else                                                        { $net2ftp_globals["cookie_language"]      = ""; }
if (isset($_COOKIE["net2ftpcookie_skin"])          == true) { $net2ftp_globals["cookie_skin"]          = validateSkin($_COOKIE["net2ftpcookie_skin"]); }
else                                                        { $net2ftp_globals["cookie_skin"]          = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpmode"])       == true) { $net2ftp_globals["cookie_ftpmode"]       = validateFtpmode($_COOKIE["net2ftpcookie_ftpmode"]); }
else                                                        { $net2ftp_globals["cookie_ftpmode"]       = ""; }
if (isset($_COOKIE["net2ftpcookie_passivemode"])   == true) { $net2ftp_globals["cookie_passivemode"]   = validatePassivemode($_COOKIE["net2ftpcookie_passivemode"]); }
else                                                        { $net2ftp_globals["cookie_passivemode"]   = ""; }
if (isset($_COOKIE["net2ftpcookie_viewmode"])      == true) { $net2ftp_globals["cookie_viewmode"]      = validateViewmode($_COOKIE["net2ftpcookie_viewmode"]); }
else                                                        { $net2ftp_globals["cookie_viewmode"]      = ""; }
if (isset($_COOKIE["net2ftpcookie_directory"])     == true) { $net2ftp_globals["cookie_directory"]     = validateDirectory($_COOKIE["net2ftpcookie_directory"]); }
else                                                        { $net2ftp_globals["cookie_directory"]     = ""; }
if (isset($_COOKIE["net2ftpcookie_sort"])          == true) { $net2ftp_globals["cookie_sort"]          = validateSort($_COOKIE["net2ftpcookie_sort"]); }
else                                                        { $net2ftp_globals["cookie_sort"]          = ""; }
if (isset($_COOKIE["net2ftpcookie_sortorder"])     == true) { $net2ftp_globals["cookie_sortorder"]     = validateSortorder($_COOKIE["net2ftpcookie_sortorder"]); }
else                                                        { $net2ftp_globals["cookie_sortorder"]     = ""; }

// ----------------------------------------------
// Statistics
// e.g. for Google Analytics
// ----------------------------------------------

// ----------------------------------------------
// Personalized ads
// e.g. for Google Adsense
// ----------------------------------------------

// ----------------------------------------------
// Nonpersonalized ads
// e.g. for Google Adsense
// ----------------------------------------------



// -------------------------------------------------------------------------
// 4 Get information about the browser and protocol
// -------------------------------------------------------------------------
$net2ftp_globals["browser_agent"]    = getBrowser("agent");
$net2ftp_globals["browser_version"]  = getBrowser("version");
$net2ftp_globals["browser_platform"] = getBrowser("platform");





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function remove_magic_quotes(&$x, $keyname="") {

	// http://www.php.net/manual/en/configuration.php#ini.magic-quotes-gpc (by the way: gpc = get post cookie)
	// if (magic_quotes_gpc == 1), then PHP converts automatically " --> \", ' --> \'
	// Has only to be done when getting info from get post cookie
	if (get_magic_quotes_gpc() == 1) {

		if (is_array($x)) {
			while (list($key,$value) = each($x)) {
				if ($value) { remove_magic_quotes($x[$key],$key); }
			}
		}
		else { 
			$quote = "'";
			$doublequote = "\"";
			$backslash = "\\";

			$x = str_replace("$backslash$quote", $quote, $x);
			$x = str_replace("$backslash$doublequote", $doublequote, $x);
			$x = str_replace("$backslash$backslash", $backslash, $x);
		}

	} // end if get_magic_quotes_gpc

	return $x;

} // end function remove_magic_quotes

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpserver($ftpserver) {

// --------------
// Input: " ftp://something.domainname.com:123/directory/file "
// Output: "something.domainname.com"
// --------------

// Remove invisible characters in the beginning and at the end
	$ftpserver = trim($ftpserver);

// Remove possible "ftp://"
	if (substr($ftpserver, 0, 6) == "ftp://") {
		$ftpserver = substr($ftpserver, 6);
	}

// Remove a possible port nr ":123"
	if (preg_match("/(.*)[:]{1}[0-9]+/", $ftpserver, $regs) == true) {
		$ftpserver = $regs[1];
	}

// Remove a possible trailing / or \ 
// Remove a possible directory and file "/directory/file"
	if (preg_match("/[\\/\\\\]*(.*)[\\/\\\\]{1,}.*/", $ftpserver, $regs) == true) {
		// Any characters like / or \
		// Anything
		// Followed by at least one / or \
		// Followed by any characters
		$ftpserver = $regs[1];
	}

// FTP server may only contain specific characters
	$ftpserver = preg_replace("/[^A-Za-z0-9._-]/", "", $ftpserver);

// FTP server must be maximum 254 characters
	if (strlen($ftpserver) > 254) { $ftpserver = left($ftpserver, 254); }

	return $ftpserver;

} // end validateFTPserver

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpserverport($ftpserverport) {

// --------------
// This function validates the FTP server port
// --------------

// Remove invisible characters in the beginning and at the end
	$ftpserverport = trim($ftpserverport);

// FTP server port must be numeric and > 0 and < 65536, else set it to 21
	if (is_numeric($ftpserverport) != true || $ftpserverport < 0 || $ftpserverport > 65536) {
		$ftpserverport = "";
	}	

	return $ftpserverport;

} // end validateFtpserverport

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSshfingerprint($sshfingerprint) {

// --------------
// This function validates the FTP SSH server fingerprint
// --------------

// Remove invisible characters in the beginning and at the end
//	$sshfingerprint = trim($sshfingerprint);

// Do extra checks	

	return $sshfingerprint;

} // end validateFtpserverport

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateUsername($username) {

// --------------
// This function validates the username
// --------------

// Remove invisible characters in the beginning and at the end
	$username = trim($username);

// Remove XSS code
//	$username = RemoveXSS($username);

// Username must be maximum 254 characters
	if (strlen($username) > 254) { $username = left($username, 254); }

	return $username;

} // end validateUsername

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePasswordEncrypted($password_encrypted) {

// --------------
// This function validates the encrypted password
// --------------

// Remove invisible characters in the beginning and at the end
	$password_encrypted = trim($password_encrypted);

// Encrypted password may only contain specific characters
	$password_encrypted = preg_replace("/[^A-Fa-f0-9]/", "", $password_encrypted);

	return $password_encrypted;

} // end validatePasswordEncrypted

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePassword($password) {

// --------------
// This function validates the plain password
// --------------

// Remove invisible characters in the beginning and at the end
	$password = trim($password);

// Remove XSS code
//	$password = RemoveXSS($password);

	return $password;

} // end validatePassword

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateLanguage($language) {

// --------------
// This function validates the language
// --------------

	global $net2ftp_settings;
	$languageArray = getLanguageArray();
	if (isset($languageArray[$language]) == true) {
		return $language;
	}
	elseif (isset($_COOKIE["net2ftpcookie_language"]) == true && isset($languageArray[$_COOKIE["net2ftpcookie_language"]]) == true) {
		return $_COOKIE["net2ftpcookie_language"];
	}
	elseif (isset($languageArray[$net2ftp_settings["default_language"]]) == true){
		return $net2ftp_settings["default_language"];
	}
	else {
		return "en";
	}

} // end validateLanguage

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSkin($skin) {

// --------------
// This function validates the skin
// --------------

	global $net2ftp_settings;
	$skinArray = getSkinArray();
	if (isset($skinArray[$skin]) == true) {
		return $skin;
	}
	elseif (isset($_COOKIE["net2ftpcookie_skin"]) == true && isset($skinArray[$_COOKIE["net2ftpcookie_skin"]]) == true) {
		return $_COOKIE["net2ftpcookie_skin"];
	}
	else {
		if (isset($skinArray[$net2ftp_settings["default_skin"]]) == true) { return $net2ftp_settings["default_skin"]; }
		else                                                              { return "shinra"; }
	}

} // end validateSkin

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpmode($ftpmode) {

// --------------
// This function validates the FTP mode
// --------------

	if ($ftpmode == "ascii" || $ftpmode == "binary" || $ftpmode == "automatic") {
		return $ftpmode;
	}
	elseif (isset($_COOKIE["net2ftpcookie_ftpmode"]) == true && ($_COOKIE["net2ftpcookie_ftpmode"] == "ascii" || $_COOKIE["net2ftpcookie_ftpmode"] == "binary" || $_COOKIE["net2ftpcookie_ftpmode"] == "automatic")) {
		return $_COOKIE["net2ftpcookie_ftpmode"];
	}
	else {
// Before PHP version 4.3.11, bug 27633 can cause problems in ASCII mode ==> use BINARY mode
// As from PHP version 4.3.11, bug 27633 is fixed ==> use Automatic mode
		if (version_compare(phpversion(), "4.3.11", "<")) { return "binary"; }
		else                                              { return "automatic"; }
	}

} // end validateFtpmode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePassivemode($passivemode) {

// --------------
// This function validates the passive mode
// --------------

	if ($passivemode != "yes") {
		$passivemode = "no";
	}
	return $passivemode;

} // end validatePassivemode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateProtocol($protocol) {

// --------------
// This function validates the protocol
// --------------

	global $net2ftp_globals;

	if ($protocol == "FTP" || $protocol == "FTP-SSL" || $protocol == "FTP-SSH") {
		return $protocol;
	}
	elseif (isset($net2ftp_globals["ftpserverport"]) == true) {
		if     ($net2ftp_globals["ftpserverport"] == 21)  { return "FTP"; }
		elseif ($net2ftp_globals["ftpserverport"] == 22)  { return "FTP-SSH"; }
		elseif ($net2ftp_globals["ftpserverport"] == 990) { return "FTP-SSL"; }
	}

} // end validateProtocol

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateViewmode($viewmode) {

// --------------
// This function validates the view mode
// --------------

	if ($viewmode != "icons") {
		$viewmode = "list";
	}
	return $viewmode;

} // end validateViewmode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSort($sort) {

// --------------
// This function validates the sorting criteria
// --------------

	if (	$sort != "" && 
		$sort != "dirfilename" && 
		$sort != "type" && 
		$sort != "size" && 
		$sort != "owner" && 
		$sort != "group" && 
		$sort != "permissions" && 
		$sort != "mtime") {
		$sort = "dirfilename";
	}
	return $sort;

} // end validateSort

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSortorder($sortorder) {

// --------------
// This function validates the sort order
// --------------

	if (	$sortorder != "" && 
		$sortorder != "descending") {
		$sortorder = "ascending";
	}
	return $sortorder;

} // end validateSortorder

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateState($state) {

// --------------
// This function validates the state variable
// --------------

	global $net2ftp_globals, $_COOKIE;

	$statelist[] = "admin";
	$statelist[] = "admin_createtables";
	$statelist[] = "admin_emptylogs";
	$statelist[] = "admin_viewlogs";
	$statelist[] = "advanced";
	$statelist[] = "advanced_ftpserver";
	$statelist[] = "advanced_parsing"; 
	$statelist[] = "advanced_webserver";
	$statelist[] = "bookmark";
	$statelist[] = "browse";
	$statelist[] = "calculatesize";
	$statelist[] = "chmod";
	$statelist[] = "clearcookies";
	$statelist[] = "consent";
	$statelist[] = "copymovedelete";
	$statelist[] = "downloadfile";
	$statelist[] = "downloadzip";
	$statelist[] = "edit";
	$statelist[] = "findstring";
	$statelist[] = "followsymlink";
	$statelist[] = "getcookies";
	$statelist[] = "gotopartner";
	$statelist[] = "homepage";
	$statelist[] = "install";
	$statelist[] = "jupload";
	$statelist[] = "login";
	$statelist[] = "login_small";
	$statelist[] = "logout";
	$statelist[] = "newdir";
	$statelist[] = "raw";
	$statelist[] = "rename";
	$statelist[] = "serverfingerprint";
	$statelist[] = "unzip";
	$statelist[] = "upload";
      $statelist[] = "view"; 
	$statelist[] = "zip";

	if (in_array($state, $statelist) == false) {
		if (isset($_COOKIE["net2ftpcookie_consent_necessary"]) == false && $net2ftp_globals["consent_necessary"] != 1) {
			$state = "consent";
		}
		else {
			$state = "login";
		}
	}

	return $state;

} // end validateState

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateState2($state2) {

// --------------
// This function validates the state2 variable
// --------------

	if ($state2 != "") {

// State2 may only contain specific characters
		$state2 = preg_replace("/[^A-Za-z0-9_-]/", "", $state2);
	}

	return $state2;

} // end validateState2

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateEntry($entry) {

// --------------
// This function validates the entry
// Remove the following characters \/:*?"<>|
// --------------

// Remove XSS code
//	$entry = RemoveXSS($entry);

// Remove \ / : * ? < > |
// Do not remove / or > otherwise the module "followsymlink" does not work
//	$entry = preg_replace("/[\\\\\\/\\:\\*\\?\\<\\>\\|]/", "", $entry);

	return $entry;

} // end validateEntry

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateScreen($screen) {

// --------------
// This function validates the screen variable
// --------------

	if ($screen != 1 && $screen != 2 && $screen != 3) {
		$screen = 1;
	}
	return $screen;

} // end validateScreen

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateDirectory($directory) {

// --------------
// Input: "/dir1/dir2/dir3/../../dir4/dir5"
// Output: "/dir1/dir4/dir5"
// Remove the following characters \/:*?"<>|
// --------------

// -------------------------------------------------------------------------
// Nothing to do if the directory is the root directory
// -------------------------------------------------------------------------
	if     ($directory == "")  { return ""; }
	elseif ($directory == "/") { return "/"; }

// -------------------------------------------------------------------------
// Remove XSS code
// -------------------------------------------------------------------------
//	$directory = RemoveXSS($directory);

// -------------------------------------------------------------------------
// Check if the directory contains ".."
// -------------------------------------------------------------------------
	if (strpos($directory, "..") === false) { 
		$directory = "/" . stripDirectory($directory);
	}
	else {
		$directory = stripDirectory($directory);

// Split down into parts
// directoryparts[0] contains the first part, directoryparts[1] the second,...
		$directoryparts = explode("/", $directory);

// Start from the end
// If you encounter N times a "..", do not take into account the next N parts which are not ".."
// Example: "/dir1/dir2/dir3/../../dir4/dir5"  ---->  "/dir1/dir4/dir5"
		$doubledotcounter = 0;
		$newdirectory = "";
		$sizeof_directoryparts = sizeof($directoryparts);
		for ($i=$sizeof_directoryparts-1; $i>=0; $i=$i-1) {
			if ($directoryparts[$i] == "..") { $doubledotcounter = $doubledotcounter + 1; }
			else {  
				if     ($doubledotcounter == 0) { $newdirectory = $directoryparts[$i] . "/" . $newdirectory; } // Add the new part in front
				elseif ($doubledotcounter > 0)  { $doubledotcounter = $doubledotcounter - 1; }                 // Don't add the part, and reduce the counter by 1
			}
		} // end for

		$directory = "/" . stripDirectory($newdirectory);

	} // end if else

// Remove : * ? " < > |
//	$directory = preg_replace("/[\\:\\*\\?\\\"\\<\\>\\|]/", "", $directory);

// Remove : * ? < > |
	$directory = preg_replace("/[\\:\\*\\?\\<\\>\\|]/", "", $directory);

	return $directory;

} // end validateDirectory

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateGenericInput($input) {

// --------------
// Remove the following characters <>
// --------------

// Remove XSS code
//	$input = RemoveXSS($input);

// Remove < >
	$input = preg_replace("/[\\<\\>]/", "", $input);

	return $input;

} // end validateGenericInput

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateTextareaType($textareaType) {

// --------------
// Remove the following characters <>
// --------------

	if (	$textareaType != "plain" && 
		$textareaType != "ckeditor" && 
		$textareaType != "tinymce" && 
		$textareaType != "ace") {
		$textareaType = "plain";
	}
	return $textareaType;

} // end validateTextareaType

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function RemoveXSS($val) {

// --------------
// This function removes malicious cross-site scripting (XSS) code from user input
// From http://quickwired.com/smallprojects/php_xss_filter_function.php
// --------------

	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
   
	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';

	for ($i = 0; $i < strlen($search); $i++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
   
		// &#x0040 @ search for the hex values
		$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      	// &#00064 @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	}
   
	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);

	$found = true; // keep replacing as long as the previous round replaced something
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
					$pattern .= ')?';
				}
				$pattern .= $ra[$i][$j];
			} // end for
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			} // end if
		} // end for
	} // end while

	return $val;

} // end RemoveXSS

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

?>
