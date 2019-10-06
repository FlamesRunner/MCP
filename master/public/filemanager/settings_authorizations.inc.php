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
// Geoblocking 
// ----------------------------------------------------------------------------------

// Database table ip2location_db1 must be loaded with the IP to country information
// This can be downloaded from ip2location.com (free version available)
$net2ftp_settings["use_geoblocking"] = "no";

// Geoblocked countries (27 EU + Britain, Croatia, Iceland, Liechtenstein, Norway, Switzerland)
// The geoblock is applied both for users and FTP servers
$net2ftp_settings["geoblock"][1] = "AU";  // Austria
$net2ftp_settings["geoblock"][2] = "BE";  // Belgium
$net2ftp_settings["geoblock"][3] = "BG";  // Bulgaria
$net2ftp_settings["geoblock"][4] = "HR";  // Croatia
$net2ftp_settings["geoblock"][5] = "CY";  // Cyprus
$net2ftp_settings["geoblock"][6] = "CZ";  // Czech Republic
$net2ftp_settings["geoblock"][7] = "DK";  // Denmark
$net2ftp_settings["geoblock"][8] = "EE";  // Estonia
$net2ftp_settings["geoblock"][9] = "FI";  // Finland
$net2ftp_settings["geoblock"][10] = "FR"; // France
$net2ftp_settings["geoblock"][11] = "DE"; // Germany
$net2ftp_settings["geoblock"][12] = "GR"; // Greece
$net2ftp_settings["geoblock"][13] = "HU"; // Hungary
$net2ftp_settings["geoblock"][14] = "IS"; // Iceland
$net2ftp_settings["geoblock"][15] = "IE"; // Ireland
$net2ftp_settings["geoblock"][16] = "IT"; // Italy
$net2ftp_settings["geoblock"][17] = "LV"; // Latvia
$net2ftp_settings["geoblock"][18] = "LI"; // Liechtenstein
$net2ftp_settings["geoblock"][19] = "LT"; // Lithuania
$net2ftp_settings["geoblock"][20] = "LU"; // Luxembourg
$net2ftp_settings["geoblock"][21] = "MT"; // Malta
$net2ftp_settings["geoblock"][22] = "NL"; // Netherlands
$net2ftp_settings["geoblock"][23] = "NO"; // Norway
$net2ftp_settings["geoblock"][24] = "PL"; // Poland
$net2ftp_settings["geoblock"][25] = "PT"; // Portugal
$net2ftp_settings["geoblock"][26] = "RO"; // Romania
$net2ftp_settings["geoblock"][27] = "SK"; // Slovakia
$net2ftp_settings["geoblock"][28] = "SI"; // Slovenia
$net2ftp_settings["geoblock"][29] = "ES"; // Spain
$net2ftp_settings["geoblock"][30] = "SE"; // Sweden
$net2ftp_settings["geoblock"][31] = "GB"; // UK
//$net2ftp_settings["geoblock"][32] = "CH"; // Switzerland

// ----------------------------------------------------------------------------------
// Allowed FTP servers
// Either set it to ALL, or else provide a list of allowed servers
// This will automatically change the layout of the login page:
//    - if ALL is entered, then the FTP server input field will be free text
//    - if only 1 entry is entered, then the FTP server input field will not be shown
//    - if more than 1 entry is entered, then the FTP server will have to be chosen from a drop-down list
// ----------------------------------------------------------------------------------

$net2ftp_settings["allowed_ftpservers"][1] = "ALL";
//$net2ftp_settings["allowed_ftpservers"][1] = "localhost";
//$net2ftp_settings["allowed_ftpservers"][2] = "192.168.1.1";
//$net2ftp_settings["allowed_ftpservers"][3] = "ftp.mydomain2.org";


// ----------------------------------------------------------------------------------
// Banned FTP servers
// Set the first entry to NONE, or enter a list of banned servers
// ----------------------------------------------------------------------------------

$net2ftp_settings["banned_ftpservers"][1] = "NONE";
//$net2ftp_settings["banned_ftpservers"][1] = "127.0.0.1";
//$net2ftp_settings["banned_ftpservers"][2] = "192.168.1.2";
//$net2ftp_settings["banned_ftpservers"][3] = "192.168.1.3";


// ----------------------------------------------------------------------------------
// Allowed FTP server port
// Set it either to ALL, or to a fixed number
// ----------------------------------------------------------------------------------

$net2ftp_settings["allowed_ftpserverport"] = "ALL";
//$net2ftp_settings["allowed_ftpserverport"] = "21";


// ----------------------------------------------------------------------------------
// Allowed IP addresses or IP address ranges from which a user can connect
// Set the first entry to ALL, or enter a list of allowed IP addresses or IP address ranges
// ----------------------------------------------------------------------------------

$net2ftp_settings["allowed_addresses"][1] = "ALL";
//$net2ftp_settings["allowed_addresses"][1] = "127.0.0.1";                // Single IP address
//$net2ftp_settings["allowed_addresses"][2] = "192.168.1.1-192.168.1.25"; // IP address range in from-to notation
//$net2ftp_settings["allowed_addresses"][3] = "192.168.1.0/30";           // IP address range in CIDR notation


// ----------------------------------------------------------------------------------
// Banned IP addresses or IP address ranges from which a user may not connect
// Set the first entry to NONE, or enter a list of banned IP addresses or IP address ranges
// ----------------------------------------------------------------------------------

$net2ftp_settings["banned_addresses"][1] = "NONE";
//$net2ftp_settings["banned_addresses"][1] = "127.0.0.1";                 // Single IP address
//$net2ftp_settings["banned_addresses"][2] = "192.168.1.1-192.168.1.25";  // IP address range in from-to notation
//$net2ftp_settings["banned_addresses"][3] = "192.168.1.0/30";            // IP address range in CIDR notation


// ----------------------------------------------------------------------------------
// Banned directory and filename keywords
// Set the first entry to NONE, or enter a list of banned keywords
// ----------------------------------------------------------------------------------

//$net2ftp_settings["banned_keywords"][1] = "NONE";
$net2ftp_settings["banned_keywords"][1] = "paypal";
$net2ftp_settings["banned_keywords"][2] = "ebay";
$net2ftp_settings["banned_keywords"][3] = "wachoviabank";
$net2ftp_settings["banned_keywords"][4] = "wellsfargo";
$net2ftp_settings["banned_keywords"][5] = "bankwest";
$net2ftp_settings["banned_keywords"][6] = "hsbc";
$net2ftp_settings["banned_keywords"][7] = "halifax-online";
$net2ftp_settings["banned_keywords"][8] = "lloydstsb";
$net2ftp_settings["banned_keywords"][9] = "egg.com";
?>