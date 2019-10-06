<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/homepage.template.php begin -->

	<!-- WRAPPER -->
	<div id="wrapper">

		<!-- HEADER -->
		<div id="header" style="height: 180px;">

			<img id="logo" src="skins/shinra/img/logo.png" alt="net2ftp" />

			<!-- Navigation -->
			<ul id="nav" class="sf-menu">
				<li><a href="index.php?state=login">HOME</a></li>
			<!-- ENDS Navigation -->
			
			<!-- Breadcrumb-->
			<div id="breadcrumbs">
				<a title="Home" href="index.php">Home</a>
				<?php echo $title; ?>
			</div>

			<!-- ENDS Breadcrumb-->	
				
		</div>
		<!-- ENDS HEADER -->
			
		<!-- MAIN -->
		<div id="main">
			
			<!-- content -->
			<div id="content">
				
				<!-- title -->
				<div id="page-title">
					<span class="title"><?php echo $title; ?></span>
					<span class="subtitle"><?php echo $subtitle; ?></span>
				</div>
				<!-- ENDS title -->

				<?php echo $content; ?>
				
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/footer.template.php"); ?>

<!-- Template /skins/shinra/homepage.template.php end -->
