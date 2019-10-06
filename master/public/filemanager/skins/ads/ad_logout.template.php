<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/ads/ad_logout.template.php begin -->
<?php if ($net2ftp_settings["show_ads"] == "yes" && $net2ftp_settings["ad_logout"] == "yes") { ?>

<?php 	$random_ad = rand(1, 2); ?>

<?php //=============================================================== ?>

<?php 	if ($random_ad == 1) { ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ad_logout -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5170524795218203"
     data-ad-slot="4770745763"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php 	} // end if random ad 1 ?>

<?php //=============================================================== ?>

<?php 	if ($random_ad == 2) { ?>
<h6>Looking for a better web hosting company?</h6>

<div style="font-size: 120%; margin-bottom: 10px;">
	<a href="https://www.infomaniak.com/goto/en/hosting.web?utm_term=5b06ec508edda">
		Check out this offer from the web host of net2ftp.com, starting at 11 USD per month.
		Satisfaction guaranteed or your money back within 30 days!
	</a>
</div>

<div class="lists-star"><ul>
	<li class="cat-item">100 GB disk space on fast SSD drives</li>
	<li class="cat-item">Unlimited traffic over an ultra-fast connection (60 Gbps total bandwidth)</li>
	<li>Unlimited email storage space</li>
	<li>Multisite, multidomain management</li>
	<li>Wordpress with <a href="https://www.infomaniak.com/goto/en/my-easy-site?utm_term=5b06ec508edda">80 premium themes</a> offered free of charge</li>
	<li>Drupal, Joomla, Prestashop and over 120 CMS</li>
	<li>Professional newsletter tool</li>
	<li>Professional video & audio on demand platform (10 GB included)</li>
	<li>Automatically install a free Let's Encrypt SSL certificate </li>
	<li>SSH access</li>
</ul></div>

<div style="position: absolute; left: 625px; top: 10px;">
	<a href="https://www.infomaniak.com/goto/en/home?utm_term=5b06ec508edda"><img src="https://storage-master.infomaniak.ch/promotional/banners/square_bannersite-general_en.png"></a>
</div>

<iframe width="560" height="315" src="https://www.youtube.com/embed/6GMpHiAfMV8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><br />
<?php 	} // end if random ad 2 ?>

<?php //=============================================================== ?>

<?php } // end if ?>
<!-- Template /skins/ads/ad_logout.template.php end -->