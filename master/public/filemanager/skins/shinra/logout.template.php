<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/logout.php begin -->

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
				<div id="page-title">
					<span class="title">File Management (<?php echo $net2ftp_globals["ftpserver"]; ?>)</span>
				</div>
				<!-- ENDS title -->
		
				<!-- Posts -->
				<div id="posts">

					<!-- post -->
					<div class="post">
						<p>
							<p>Thank you for using the file management portal, powered by net2ftp. This window will automatically close shortly.</p>
						</p>
					</div>
					<!-- ENDS post -->

					<!-- post -->
					<div class="post">
<?php require_once($net2ftp_globals["application_skinsdir"] . "/ads/ad_logout.template.php"); ?>
					</div>
					<!-- ENDS post -->
			
				</div>
				<!-- ENDS Posts -->

<script>
    setTimeout(function () {
	window.open('','_self').close();
    }, 3000);
</script>

<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/footer.template.php"); ?>

<!-- Template /skins/shinra/logout.php end -->
