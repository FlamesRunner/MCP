<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2017 by David Gartner                         |
//  |                                                                               |
//   -------------------------------------------------------------------------------
//  |                                                                               |
//  |  Enter your settings and preferences below.                                   |
//  |                                                                               |
//  |  The structure of each line is like this:                                     |
//  |     $net2ftp_settings["setting_name"] = "setting_value";                      |
//  |                                                                               |
//  |  BE CAREFUL WHEN EDITING THE FILE: ONLY EDIT THE setting_value, AND DO NOT    |
//  |  ERASE THE " OR THE ; CHARACTERS.                                             |
//   -------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------
// Basic settings
// ----------------------------------------------------------------------------------

// Enter your email address; this is used as "from" address when sending files in attachment
$net2ftp_settings["email_feedback"] = "andrew@andrew-hong.me";

// Default language and skin (look in /languages and /skins to see which are available)
$net2ftp_settings["default_language"] = "en";
$net2ftp_settings["default_skin"]     = "shinra";

// PHP error reporting
//$net2ftp_settings["error_reporting"] = "NONE";
$net2ftp_settings["error_reporting"] = "standard";
//$net2ftp_settings["error_reporting"] = "ALL";

// MD5 salt and encryption string (change them to improve security)
$net2ftp_settings["encryption_string"] = "462E16CB7C3F369BD9F4DBEE0A926F8F14FFB3";

             
// ----------------------------------------------------------------------------------
// Login screen
// ----------------------------------------------------------------------------------

// Show a Google captcha on the login screens (to prevent robots from using net2ftp)
// Go to https://www.google.com/recaptcha/intro/ to create an account
$net2ftp_settings["use_captcha"] = "no"; // "yes" or "no"
$net2ftp_settings["recaptcha_sitekey"]   = "";
$net2ftp_settings["recaptcha_secretkey"] = "";

// Show privacy policies to which the user must agree before logging in
// Leave empty if you don't want to show anything
$net2ftp_settings["privacy_policy_1"] = "";
$net2ftp_settings["privacy_policy_2"] = "";
$net2ftp_settings["privacy_policy_3"] = "";
$net2ftp_settings["privacy_policy_4"] = "";
$net2ftp_settings["privacy_policy_5"] = "";
$net2ftp_settings["privacy_policy_6"] = "";
$net2ftp_settings["privacy_policy_7"] = "";
$net2ftp_settings["privacy_policy_8"] = "";
$net2ftp_settings["privacy_policy_9"] = "";
$net2ftp_settings["privacy_policy_10"] = "";


// ----------------------------------------------------------------------------------
// Browse screen
// ----------------------------------------------------------------------------------

// Show a message on top of the list of directories and files
$net2ftp_settings["message_browse"] = "";


// ----------------------------------------------------------------------------------
// A MySQL database is optional. It can be used for: logging the users, 
// checking the consumption of network and server resources (data transfer 
// volume and script execution time), and checking the user's home directory
// ----------------------------------------------------------------------------------

// MASTER SETTING that overrides the other settings below: use a database?
$net2ftp_settings["use_database"] = "no"; // "yes" or "no"

// Enter your MySQL settings
$net2ftp_settings["dbusername"] = "";
$net2ftp_settings["dbpassword"] = "";
$net2ftp_settings["dbname"]     = "";
$net2ftp_settings["dbserver"]   = "localhost"; // on many configurations, this is "localhost"

// Switch different types of logs on or off
$net2ftp_settings["log_access"] = "yes";
$net2ftp_settings["log_error"]  = "yes";

// Delete logs which are older than X months automatically
$net2ftp_settings["log_length_months"] = 2; // number of months


// ----------------------------------------------------------------------------------
// Logging to the system logger
// ----------------------------------------------------------------------------------

$net2ftp_settings["use_syslog"] = "no";
$net2ftp_settings["syslog_priority"] = LOG_NOTICE;
$net2ftp_settings["syslog_facility"] = LOG_MAIL;
$net2ftp_settings["syslog_ident"] = "net2ftp";


// ----------------------------------------------------------------------------------
// Files bigger than this limit will be excluded from:
// upload, download, copy, move, search, view, edit
// ----------------------------------------------------------------------------------

$net2ftp_settings["max_filesize"]  = "20000000";  // in Bytes, default 10 MB

// Note: IF YOU WANT TO ALLOW LARGE FILE UPLOADS, YOU MAY HAVE TO ADJUST
//       THE FOLLOWING PARAMETERS:
//       1 - in the file php.ini: upload_max_filesize, post_max_size,
//           max_execution_time, memory_limit
//       2 - in the file php.conf: LimitRequestBody


// ----------------------------------------------------------------------------------
// Server resource consumption settings
// ----------------------------------------------------------------------------------

// Switch consumption checking on or off (requires a database, see above)
$net2ftp_settings["check_consumption"] = "no";

// Maximum data transfer volume per day (in Bytes)
$net2ftp_settings["max_consumption_ipaddress_datatransfer"] = 250000000; // per IP address
$net2ftp_settings["max_consumption_ftpserver_datatransfer"] = 250000000; // per FTP server

// Maximum script execution time per day (in seconds)
$net2ftp_settings["max_consumption_ipaddress_executiontime"] = 100000; // per IP address
$net2ftp_settings["max_consumption_ftpserver_executiontime"] = 100000; // per FTP server


// ----------------------------------------------------------------------------------
// DO NOT CHANGE ANYTHING BELOW THIS LINE
// ----------------------------------------------------------------------------------

$net2ftp_settings["application_version"] = "1.3";
$net2ftp_settings["application_build_nr"] = "51";

// Is this net2ftp.com, or a net2ftp installation elsewhere
$net2ftp_settings["net2ftpdotcom"] = "no";

// Show advertisements
$net2ftp_settings["show_ads"]         = "no";
$net2ftp_settings["ad_login_corner"]  = "no";
$net2ftp_settings["ad_login_bottom"]  = "no";
$net2ftp_settings["ad_browse_list"]   = "no";
$net2ftp_settings["ad_browse_header"] = "no";
$net2ftp_settings["ad_logout"]        = "no";

?>
