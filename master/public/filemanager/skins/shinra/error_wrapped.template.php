<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="<?php echo __("en"); ?>" dir="<?php echo __("ltr"); ?>">
<head>
<meta http-equiv="Content-type" content="text/html;charset=<?php echo __("iso-8859-1"); ?>" />
<meta name="keywords" content="net2ftp, web, ftp, based, web-based, xftp, client, PHP, SSL, SSH, SSH2, password, server, free, gnu, gpl, gnu/gpl, net, net to ftp, netftp, connect, user, gui, interface, web2ftp, edit, editor, online, code, php, upload, download, copy, move, delete, zip, tar, unzip, untar, recursive, rename, chmod, syntax, highlighting, host, hosting, ISP, webserver, plan, bandwidth" />
<meta name="description" content="net2ftp is a web based FTP client. It is mainly aimed at managing websites using a browser. Edit code, upload/download files, copy/move/delete directories recursively, rename files and directories -- without installing any software." />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="apple-touch-icon" href="favicon.png"/>
<title>net2ftp - a web based FTP client</title>
<?php if ($net2ftp_globals["language"] == "he" || $net2ftp_globals["language"] == "ar") { $stylesheet = "style.rtl.css"; }
	else { $stylesheet = "style.ltr.css"; }
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $net2ftp_globals["application_rootdir_url"] . "/skins/shinra/css/" . $stylesheet . "\" media=\"screen\" />\n"; ?>
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $net2ftp_globals["application_rootdir_url"] . "/skins/shinra/skins/glossy/style.css\" media=\"screen\" />\n"; ?>
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $net2ftp_globals["application_rootdir_url"] . "/skins/shinra/js/poshytip-1.0/src/tip-twitter/tip-twitter.css\" />\n"; ?>
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $net2ftp_globals["application_rootdir_url"] . "/skins/shinra/js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css\" />\n"; ?>
</head>
<body>

	<!-- WRAPPER -->
	<div id="wrapper">

		<!-- HEADER -->
		<div id="header">
			<img id="logo" src="skins/shinra/img/logo.png" alt="net2ftp" />
		</div>
		<!-- ENDS HEADER -->
			
		<!-- MAIN -->
		<div id="main">

			<!-- content -->
			<div id="content">
				
				<!-- title -->
				<div id="page-title"><span class="title"><?php echo $net2ftp_globals["ftpserver"]; ?></span></div>

<?php
if ($net2ftp_result["success"] == false) {
	require_once($net2ftp_globals["application_rootdir"] . "/skins/" . $net2ftp_globals["skin"] . "/error.template.php");
}
?>
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/footer.template.php"); ?>
</body>
</html>