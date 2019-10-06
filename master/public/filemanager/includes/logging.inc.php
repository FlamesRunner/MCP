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

function logAccess() {

// --------------
// This function logs user accesses to the site
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

	if ($net2ftp_settings["log_access"] == "yes") {

// -------------------------------------------------------------------------
// Date and time
// -------------------------------------------------------------------------
		$date = date("Y-m-d");
		$time = date("H:i:s");

// -------------------------------------------------------------------------
// Logging to the database
// -------------------------------------------------------------------------

		if ($net2ftp_settings["use_database"] == "yes") {

// ----------------------------------------------
// Do not log accesses, errors and consumption while the logs are being rotated
// ----------------------------------------------
			$logStatus = getLogStatus();
			if ($net2ftp_result["success"] == false) { return false; }
			if ($logStatus != 0) { return true; }

// ----------------------------------------------
// Input checks
// ----------------------------------------------
// Add slashes to variables which are used in a SQL query, and which are
// potentially unsafe (supplied by the user).
			// id is defined by database
			// $date is calculated in this function (see above)
			// $time is calculated in this function (see above)
			$page_safe                = addslashes($net2ftp_globals["page"]);
			$state_safe               = addslashes($net2ftp_globals["state"]);
			$state2_safe              = addslashes($net2ftp_globals["state2"]);
			$screen_safe              = addslashes($net2ftp_globals["screen"]);
			$skin_safe                = addslashes($net2ftp_globals["skin"]);
			$language_safe            = addslashes($net2ftp_globals["language"]);
			$protocol_safe            = addslashes($net2ftp_globals["protocol"]);
			$ftpserver_safe           = addslashes($net2ftp_globals["ftpserver"]);
			$ftpserver_ipaddress_safe = addslashes($net2ftp_globals["ftpserver_ipaddress"]);
			$ftpserver_country_safe   = addslashes($net2ftp_globals["ftpserver_country"]);
			$ftpserverport_safe       = addslashes($net2ftp_globals["ftpserverport"]);
			$username_safe            = addslashes($net2ftp_globals["username"]); 
			$directory_safe           = addslashes($net2ftp_globals["directory"]);
			$entry_safe               = addslashes($net2ftp_globals["entry"]);
			$user_email_safe          = addslashes($net2ftp_globals["user_email"]);
			$user_ipaddress_safe      = addslashes($net2ftp_globals["REMOTE_ADDR"]);
			$user_country_safe        = addslashes($net2ftp_globals["user_country"]);
			$user_port_safe           = addslashes($net2ftp_globals["REMOTE_PORT"]);
			$user_http_user_agent_safe = addslashes($net2ftp_globals["user_http_user_agent"]);

			if (isset($net2ftp_globals["consumption_datatransfer"]) == true) {
				$consumption_datatransfer_safe  = addslashes($net2ftp_globals["consumption_datatransfer"]);
			}
			else {
				$consumption_datatransfer_safe  = "0";
			}
			if (isset($net2ftp_globals["consumption_executiontime"]) == true) {
				$consumption_executiontime_safe = addslashes($net2ftp_globals["consumption_executiontime"]);
			}
			else {
				$consumption_executiontime_safe = "0";
			}

// ----------------------------------------------
// Connect to the DB
// ----------------------------------------------
			net2ftp_connect_db();
			if ($net2ftp_result["success"] == false) { return false; }

// ----------------------------------------------
// Add record to the database table
// ----------------------------------------------
			$sqlquery1 = "INSERT INTO net2ftp_log_access VALUES(null, '$date', '$time', '$page_safe', '$state_safe', '$state2_safe', '$screen_safe', '$skin_safe', '$language_safe', '$protocol_safe', '$ftpserver_safe', '$ftpserver_ipaddress_safe', '$ftpserver_country_safe', '$ftpserverport_safe', '$username_safe', '$directory_safe', '$entry_safe', '$user_email_safe', '$user_ipaddress_safe', '$user_country_safe', '$user_port_safe', '$user_http_user_agent_safe', '$consumption_datatransfer_safe', '$consumption_executiontime_safe')";
			$result1 = mysqli_query($net2ftp_globals["mysqli_link"], $sqlquery1);
			if ($result1 == false) { 
				$errormessage = __("Unable to execute the SQL query.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			}

			$nrofrows1 = mysqli_affected_rows($net2ftp_globals["mysqli_link"]);

			$net2ftp_globals["log_access_id"] = mysqli_insert_id($net2ftp_globals["mysqli_link"]);

		} // end if use_database

// -------------------------------------------------------------------------
// Logging to the system log
// -------------------------------------------------------------------------

		if ($net2ftp_settings["use_syslog"] == "yes") {

// ----------------------------------------------
// Get consumption values
// ----------------------------------------------
			if (isset($net2ftp_globals["consumption_datatransfer"]) == true) {
				$consumption_datatransfer  = $net2ftp_globals["consumption_datatransfer"];
			}
			else {
				$consumption_datatransfer  = "0";
			}
			if (isset($net2ftp_globals["consumption_executiontime"]) == true) {
				$consumption_executiontime = $net2ftp_globals["consumption_executiontime"];
			}
			else {
				$consumption_executiontime = "0";
			}

// ----------------------------------------------
// Create message
// ----------------------------------------------
			$message2log = "$date $time " . $net2ftp_globals["REMOTE_ADDR"] . " " . $net2ftp_globals["REMOTE_PORT"] . " " . $net2ftp_globals["page"] . " " . $consumption_datatransfer . " " . $consumption_executiontime . " " . $net2ftp_globals["ftpserver"] . " " . $net2ftp_globals["username"] . " " . $net2ftp_globals["state"] . " " . $net2ftp_globals["state2"] . " " . $net2ftp_globals["screen"] . " " . $net2ftp_globals["directory"] . " " . $net2ftp_globals["entry"];
			$result2 = openlog($net2ftp_settings["syslog_ident"], 0, $net2ftp_settings["syslog_facility"]);
			if ($result2 == false) { 
				$errormessage = __("Unable to open the system log.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			}

// ----------------------------------------------
// Write message to system logger
// ----------------------------------------------
			$result3 = syslog($net2ftp_settings["syslog_priority"], $message2log);
			if ($result3 == false) { 
				$errormessage = __("Unable to write a message to the system log.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			}

		} // end if use_syslog

	} // end if log_access

} // end logAccess()

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function logError() {

// --------------
// This function logs user accesses to the site
//
// IMPORTANT: this function uses, but does not change the global $net2ftp_result[""] variables.
// It returns true on success, false on failure.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

	if ($net2ftp_settings["log_error"] == "yes") {

// -------------------------------------------------------------------------
// Take a copy of the $net2ftp_result
// If an error occurs within logError, logError will return false and reset the 
// $net2ftp_result variable to it's original value
// Also if no error occurs logError will return the variable to it's original value
// -------------------------------------------------------------------------
		$net2ftp_result_original = $net2ftp_result;
		setErrorVars(true, "", "", "", "");

// -------------------------------------------------------------------------
// Errormessage and debug backtrace
// -------------------------------------------------------------------------
		$errormessage = addslashes($net2ftp_result_original["errormessage"]);

		$debug_backtrace = "";
		$i = sizeof($net2ftp_result_original["debug_backtrace"])-1;
		if ($i > 0) {
			$debug_backtrace .= addslashes("function " . $net2ftp_result_original["debug_backtrace"][$i]["function"] . " (" . $net2ftp_result_original["debug_backtrace"][$i]["file"] . " on line " . $net2ftp_result_original["debug_backtrace"][$i]["line"] . ")\n");
			for ($j=0; $j<sizeof($net2ftp_result_original["debug_backtrace"][$i]["args"]); $j++) {
				$debug_backtrace .= addslashes("argument $j: " . $net2ftp_result_original["debug_backtrace"][$i]["args"][$j] . "\n");
			}
		}

// -------------------------------------------------------------------------
// Date and time
// -------------------------------------------------------------------------
		$date = date("Y-m-d");
		$time = date("H:i:s");

// -------------------------------------------------------------------------
// Logging to the database
// -------------------------------------------------------------------------
		if ($net2ftp_settings["use_database"] == "yes") {


// ----------------------------------------------
// Do not log accesses and errors while the logs are being rotated
// ----------------------------------------------
			$logStatus = getLogStatus();
			if ($net2ftp_result["success"] == false) { return false; }
			if ($logStatus != 0) { return true; }

// ----------------------------------------------
// Input checks
// ----------------------------------------------
// Add slashes to variables which are used in a SQL query, and which are
// potentially unsafe (supplied by the user).
			// id is defined by database
			// $date is calculated in this function (see above)
			// $time is calculated in this function (see above)
			$page_safe                = addslashes($net2ftp_globals["page"]);
			$state_safe               = addslashes($net2ftp_globals["state"]);
			$state2_safe              = addslashes($net2ftp_globals["state2"]);
			$screen_safe              = addslashes($net2ftp_globals["screen"]);
			$skin_safe                = addslashes($net2ftp_globals["skin"]);
			$language_safe            = addslashes($net2ftp_globals["language"]);
			$protocol_safe            = addslashes($net2ftp_globals["protocol"]);
			$ftpserver_safe           = addslashes($net2ftp_globals["ftpserver"]);
			$ftpserver_ipaddress_safe = addslashes($net2ftp_globals["ftpserver_ipaddress"]);
			$ftpserver_country_safe   = addslashes($net2ftp_globals["ftpserver_country"]);
			$ftpserverport_safe       = addslashes($net2ftp_globals["ftpserverport"]);
			$username_safe            = addslashes($net2ftp_globals["username"]); 
			$directory_safe           = addslashes($net2ftp_globals["directory"]);
			$entry_safe               = addslashes($net2ftp_globals["entry"]);
			$user_email_safe          = addslashes($net2ftp_globals["user_email"]);
			$user_ipaddress_safe      = addslashes($net2ftp_globals["REMOTE_ADDR"]);
			$user_country_safe        = addslashes($net2ftp_globals["user_country"]);
			$user_port_safe           = addslashes($net2ftp_globals["REMOTE_PORT"]);
			$user_http_user_agent_safe = addslashes($net2ftp_globals["user_http_user_agent"]);

			if (isset($net2ftp_globals["consumption_datatransfer"]) == true) {
				$consumption_datatransfer_safe  = addslashes($net2ftp_globals["consumption_datatransfer"]);
			}
			else {
				$consumption_datatransfer_safe  = "0";
			}
			if (isset($net2ftp_globals["consumption_executiontime"]) == true) {
				$consumption_executiontime_safe = addslashes($net2ftp_globals["consumption_executiontime"]);
			}
			else {
				$consumption_executiontime_safe = "0";
			}


// ----------------------------------------------
// Connect to the DB
// ----------------------------------------------
			net2ftp_connect_db();
			if ($net2ftp_result["success"] == false) { 
				setErrorVars($net2ftp_result_original["success"], $net2ftp_result_original["errormessage"], $net2ftp_result_original["debug_backtrace"], $net2ftp_result_original["file"], $net2ftp_result_original["line"]);
				return false; 
			}

// ----------------------------------------------
// Add record to the database table
// ----------------------------------------------
			$sqlquery1 = "INSERT INTO net2ftp_log_error VALUES(null, '$date', '$time', '$page_safe', '$state_safe', '$state2_safe', '$screen_safe', '$skin_safe', '$language_safe', '$protocol_safe', '$ftpserver_safe', '$ftpserver_ipaddress_safe', '$ftpserver_country_safe', '$ftpserverport_safe', '$username_safe', '$directory_safe', '$entry_safe', '$user_email_safe', '$user_ipaddress_safe',  '$user_country_safe', '$user_port_safe', '$user_http_user_agent_safe', '$consumption_datatransfer_safe', '$consumption_executiontime_safe', '$errormessage', '$debug_backtrace')";
			$result_mysqli_query = mysqli_query($net2ftp_globals["mysqli_link"], $sqlquery1);
			if ($result_mysqli_query == false) { 
				setErrorVars($net2ftp_result_original["success"], $net2ftp_result_original["errormessage"], $net2ftp_result_original["debug_backtrace"], $net2ftp_result_original["file"], $net2ftp_result_original["line"]);
				return false; 
			}

		} // end if use_database

// -------------------------------------------------------------------------
// Logging to the system log
// -------------------------------------------------------------------------
		if ($net2ftp_settings["use_syslog"] == "yes") {

// ----------------------------------------------
// Get consumption values
// ----------------------------------------------
			if (isset($net2ftp_globals["consumption_datatransfer"]) == true) {
				$consumption_datatransfer  = $net2ftp_globals["consumption_datatransfer"];
			}
			else {
				$consumption_datatransfer  = "0";
			}
			if (isset($net2ftp_globals["consumption_executiontime"]) == true) {
				$consumption_executiontime = $net2ftp_globals["consumption_executiontime"];
			}
			else {
				$consumption_executiontime = "0";
			}

// ----------------------------------------------
// Create message
// ----------------------------------------------
			$message2log = "$date $time " . $net2ftp_globals["ftpserver"] . " " . $net2ftp_globals["username"] . " " . $net2ftp_result["errormessage"] . " $debug_backtrace " . $net2ftp_globals["state"] . " " . $net2ftp_globals["state2"] . " " . $net2ftp_globals["directory"] . " " . $net2ftp_globals["REMOTE_ADDR"] . " " . $net2ftp_globals["user_http_user_agent"];
			$result2 = openlog($net2ftp_settings["syslog_ident"], 0, $net2ftp_settings["syslog_facility"]);
			if ($result2 == false) { 
				$errormessage = __("Unable to open the system log.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			}

// ----------------------------------------------
// Write message to system logger
// ----------------------------------------------
			$result3 = syslog($net2ftp_settings["syslog_priority"], $message2log);
			if ($result3 == false) { 
				$errormessage = __("Unable to write a message to the system log.");
				setErrorVars(false, $errormessage, debug_backtrace(), __FILE__, __LINE__);
				return false;
			}

		} // end if use_syslog

// -------------------------------------------------------------------------
// Reset the variable to it's original value
// -------------------------------------------------------------------------
		setErrorVars($net2ftp_result_original["success"], $net2ftp_result_original["errormessage"], $net2ftp_result_original["debug_backtrace"], $net2ftp_result_original["file"], $net2ftp_result_original["line"]);

	} // end if logErrors

} // end logError()

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function getLogStatus() {

// --------------
// This function reads the log rotation status from the database.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

// -------------------------------------------------------------------------
// Initial checks
// -------------------------------------------------------------------------

// Verify if a database is used. If not: don't continue.
	if ($net2ftp_settings["use_database"] != "yes") { return true; }

// -------------------------------------------------------------------------
// Determine current month and last month
// -------------------------------------------------------------------------
	$currentmonth = date("Ym"); // e.g. 201207
	$lastmonth = date("Ym", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

// -------------------------------------------------------------------------
// Connect to the database
// -------------------------------------------------------------------------
	net2ftp_connect_db();
	if ($net2ftp_result["success"] == false) { return false; }

// -------------------------------------------------------------------------
// Get log rotation status
// -------------------------------------------------------------------------
	$sqlquery1 = "SELECT status FROM net2ftp_log_status WHERE month = '$currentmonth';";

	$result1   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery1");
	if ($result1 == false) { 
		setErrorVars(false, "Unable to execute SQL SELECT query (getLogStatus > sqlquery1) <br /> $sqlquery1", debug_backtrace(), __FILE__, __LINE__);
		return false; 
	}

	$nrofrows1 = @mysqli_num_rows($result1);
	if     ($nrofrows1 == 0) { 
		$logStatus = 1;
	}
	elseif ($nrofrows1 == 1) { 
		$resultRow1 = mysqli_fetch_row($result1); 
		$logStatus  = $resultRow1[0];
	}
	else { 
		setErrorVars(false, __("Table net2ftp_log_status contains duplicate entries."), debug_backtrace(), __FILE__, __LINE__);
		return false; 
	}

// Return $logStatus
	return $logStatus;

} // End getLogStatus

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function putLogStatus($logStatus) {

// --------------
// This function writes the log rotation status to the database.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result;

// -------------------------------------------------------------------------
// Initial checks
// -------------------------------------------------------------------------

// Verify if a database is used. If not: don't continue.
	if ($net2ftp_settings["use_database"] != "yes") { return true; }

// -------------------------------------------------------------------------
// Determine current month and last month
// -------------------------------------------------------------------------
	$currentmonth = date("Ym"); // e.g. 201207
	$lastmonth = date("Ym", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
	$datetime = mytime();

// -------------------------------------------------------------------------
// Connect to the database
// -------------------------------------------------------------------------
	net2ftp_connect_db();
	if ($net2ftp_result["success"] == false) { return false; }

// -------------------------------------------------------------------------
// Put log rotation status
// -------------------------------------------------------------------------
	$sqlquery1 = "SELECT status, changelog FROM net2ftp_log_status WHERE month = '$currentmonth';";
	$result1   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery1");
	$nrofrows1 = @mysqli_num_rows($result1);

	if ($nrofrows1 == 1) { 
		$resultRow1 = mysqli_fetch_row($result1); 
		$logStatus_old  = $resultRow1[0];
		$changelog_old  = $resultRow1[1];
		$changelog_new  = $changelog_old . "From $logStatus_old to $logStatus on $datetime. ";
		$sqlquery2 = "UPDATE net2ftp_log_status SET status = '" . $logStatus . "', changelog = '" . $changelog_new . "' WHERE month = '$currentmonth';";
		$result2   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery2");
		$nrofrows2 = mysqli_affected_rows($net2ftp_globals["mysqli_link"]);
	}
// Don't check on the UPDATE nr of rows, because when the values in the variables and in the table are the same,
// the $nrofrows2 is set to 0. 
	elseif ($nrofrows1 == 0) { 
		$changelog_new  = "Set to $logStatus on $datetime. ";
		$sqlquery3 = "INSERT INTO net2ftp_log_status VALUES('$currentmonth', '" . $logStatus . "', '" . $changelog_new . "');";
		$result3   = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery3");
		$nrofrows3 = mysqli_affected_rows($net2ftp_globals["mysqli_link"]);
		if ($nrofrows3 != 1) { 
			setErrorVars(false, __("Table net2ftp_log_status could not be updated."), debug_backtrace(), __FILE__, __LINE__);
			return false; 
		}
	}
	else {
		setErrorVars(false, __("Table net2ftp_log_status contains duplicate entries."), debug_backtrace(), __FILE__, __LINE__);
		return false; 
	}

// -------------------------------------------------------------------------
// Return true
// -------------------------------------------------------------------------
	return true;

} // End putLogStatus

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function emptyLogs($datefrom, $dateto) {

// --------------
// This function deletes the log records for the dates between $datefrom
// and $dateto.
// The global variable $net2ftp_output["emptyLogs"] is filled with result messages.
// The function returns true on success, false on failure.
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_result, $net2ftp_output;

	$toreturn = true;

// -------------------------------------------------------------------------
// Connect to the database
// -------------------------------------------------------------------------
	net2ftp_connect_db();
	if ($net2ftp_result["success"] == false)  { return false; }

	$tables[1] = "net2ftp_log_access";
	$tables[2] = "net2ftp_log_error";
	$tables[3] = "net2ftp_log_consumption_ftpserver";
	$tables[4] = "net2ftp_log_consumption_ipaddress";

// -------------------------------------------------------------------------
// Execute the queries
// -------------------------------------------------------------------------
	for ($i=1; $i<=sizeof($tables); $i++) {
		$sqlquery_empty   = "DELETE FROM $tables[$i] WHERE date BETWEEN '$datefrom' AND '$dateto';";
		$result_empty[$i] = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery_empty");

		$sqlquery_optimize   = "OPTIMIZE TABLE `" . $tables[$i] . "`;";
		$result_optimize[$i] = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery_optimize");

		if ($result_empty[$i] == true)    { 
			$net2ftp_output["emptyLogs"][] = __("The table <b>%1\$s</b> was emptied successfully.", $tables[$i]); 
		}
		else { 
			$toreturn = false;
			$net2ftp_output["emptyLogs"][] = __("The table <b>%1\$s</b> could not be emptied.", $tables[$i]); 
		}
		if ($result_optimize[$i] == true) { 
			$net2ftp_output["emptyLogs"][] = __("The table <b>%1\$s</b> was optimized successfully.", $tables[$i]); 
		}
		else { 
			$toreturn = false;
			$net2ftp_output["emptyLogs"][] = __("The table <b>%1\$s</b> could not be optimized.", $tables[$i]); 
		}

	} // end for

	return $toreturn;

} // end emptyLogs()

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function rotateLogs() {

// --------------
// Rotate the tables
// net2ftp_log_access          = active table
// net2ftp_log_access_YYYYMM   = archive table with information of month MM and year YYYY
// net2ftp_log_access_template = template table (empty table)
//
// To avoid that the log rotation actions would be executed multiple times at 
// the end of the period, a "log rotation status" is used:
// 0 = no rotation needed
// 1 = step 1 not yet started (renaming active tables to archived tables)
// 2 = step 1 in progress
// 3 = step 2 not yet started (copying template tables to the active tables)
// 4 = step 2 in progress
// 5 = step 3 not yet started (dropping oldest archive tables)
// 6 = step 3 in progress
// --------------

// -------------------------------------------------------------------------
// Global variables
// -------------------------------------------------------------------------
	global $net2ftp_globals, $net2ftp_settings, $net2ftp_result, $net2ftp_output;

	$toreturn = true;

// -------------------------------------------------------------------------
// Verify if a database is used. If not: don't continue.
// -------------------------------------------------------------------------
	if ($net2ftp_settings["use_database"] != "yes") { return true; }

// -------------------------------------------------------------------------
// Check if the setting is within the allowed range; if not, set it to 12 months
// -------------------------------------------------------------------------
	if (!($net2ftp_settings["log_length_months"] > 1 && $net2ftp_settings["log_length_months"] < 99)) {
		$net2ftp_settings["log_length_months"] = 12;
	}

// -------------------------------------------------------------------------
// Current month, next month, previous month
// -------------------------------------------------------------------------
	$currentmonth = date("Ym"); // e.g. 201207
	$lastmonth = date("Ym", mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
	$nextmonth = date("Ym", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$dropmonth = date("Ym", mktime(0, 0, 0, date("m")-$net2ftp_settings["log_length_months"]-1, date("d"), date("Y")));

// -------------------------------------------------------------------------
// Connect to the database
// -------------------------------------------------------------------------
	net2ftp_connect_db();
	if ($net2ftp_result["success"] == false) { return false; }

// -------------------------------------------------------------------------
// Get the log rotation status
// -------------------------------------------------------------------------
	$logStatus = getLogStatus();
	if ($net2ftp_result["success"] == false) { return false; }

// No log rotation needed
	if ($logStatus === 0) { return true; }

// -------------------------------------------------------------------------
// Table names and SQL queries to create the tables
// -------------------------------------------------------------------------
	$tables[1]["name"] = "net2ftp_log_access";
	$tables[2]["name"] = "net2ftp_log_error";
	$tables[3]["name"] = "net2ftp_log_consumption_ftpserver";
	$tables[4]["name"] = "net2ftp_log_consumption_ipaddress";

// -------------------------------------------------------------------------
// step 1 of rotation: rename active tables to archived tables
// -------------------------------------------------------------------------
	if ($logStatus == 1) {

// Set the log status to indicate this step is in progress
		putLogStatus(2);
		if ($net2ftp_result["success"] == false) { return false; }

// Execute the step
		for ($i=1; $i<=sizeof($tables); $i++) {
			$table              = $tables[$i]["name"];        // Example: net2ftp_log_access
			$table_archive      = $table . "_" . $lastmonth;  // Example: net2ftp_log_access_201206
			$table_archive_drop = $table . "_" . $dropmonth;  // Example: net2ftp_log_access_201106

			$sqlquery_rename   = "RENAME TABLE $table TO $table_archive";
			$result_rename[$i] = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery_rename");

			if ($result_rename[$i] == true) { 
				$net2ftp_output["rotateLogs"][] = __("The log tables were renamed successfully."); 
			}
			else { 
				$toreturn = false;
				$net2ftp_output["rotateLogs"][] = __("The log tables could not be renamed."); 
			}
		} // end for

// Set the log status to indicate this step is in done and the next can start
		putLogStatus(3);
		if ($net2ftp_result["success"] == false) { return false; }
	} 

// -------------------------------------------------------------------------
// step 2 of rotation: copy template tables to the active
// -------------------------------------------------------------------------
	elseif ($logStatus == 3) {

// Set the log status to indicate this step is in progress
		putLogStatus(4);
		if ($net2ftp_result["success"] == false) { return false; }

// Execute the step
		for ($i=1; $i<=sizeof($tables); $i++) {
			$table              = $tables[$i]["name"];        // Example: net2ftp_log_access
			$table_archive      = $table . "_" . $lastmonth;  // Example: net2ftp_log_access_201206
			$table_archive_drop = $table . "_" . $dropmonth;  // Example: net2ftp_log_access_201106

			$sqlquery_copy   = "CREATE TABLE $table LIKE $table_archive";
			$result_copy[$i] = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery_copy");

			if ($result_copy[$i] == true) { 
				$net2ftp_output["rotateLogs"][] = __("The log tables were copied successfully."); 
			}
			else { 
				$toreturn = false;
				$net2ftp_output["rotateLogs"][] = __("The log tables could not be copied."); 
			}
		} // end for

// Set the log status to indicate this step is in done and the next can start
		putLogStatus(5);
		if ($net2ftp_result["success"] == false) { return false; }
	}

// -------------------------------------------------------------------------
// step 3 of rotation: drop oldest archive tables
// -------------------------------------------------------------------------
	elseif ($logStatus == 5) {

// Set the log status to indicate this step is in progress
		putLogStatus(6);
		if ($net2ftp_result["success"] == false) { return false; }

// Execute the step
		for ($i=1; $i<=sizeof($tables); $i++) {
			$table              = $tables[$i]["name"];        // Example: net2ftp_log_access
			$table_archive      = $table . "_" . $lastmonth;  // Example: net2ftp_log_access_201206
			$table_archive_drop = $table . "_" . $dropmonth;  // Example: net2ftp_log_access_201106

			$sqlquery_drop   = "DROP TABLE IF EXISTS $table_archive_drop;";
			$result_drop[$i] = mysqli_query($net2ftp_globals["mysqli_link"], "$sqlquery_drop");

			if ($result_drop[$i] == true) { 
				$net2ftp_output["rotateLogs"][] = __("The oldest log table was dropped successfully."); 
			}
			else { 
				$toreturn = false;
				$net2ftp_output["rotateLogs"][] = __("The oldest log table could not be dropped."); 
			}
		} // end for

// Set the log status to indicate this step is in done and the rotation is over
		putLogStatus(0);
		if ($net2ftp_result["success"] == false) { return false; }
	} 

	return $toreturn;

} // end rotateLogs()

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************


?>