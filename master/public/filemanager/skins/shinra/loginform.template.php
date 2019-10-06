<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/loginform.php begin -->
						<div id="accordion" class="accordion">
<?php	// The height of the Basic form must be smaller than the height of the Advanced form, ?>
<?php	// for this to be possible, set "autoHeight:false" in /skins/shinra/js/jquery-ui-1.8.13.custom.min.js ?>

							<h6><a href="#"><?php echo __("Basic FTP login"); ?></a></h6>
							<div>
								<form id="LoginForm1" action="<?php echo $net2ftp_globals["action_url"]; ?>" method="post" onsubmit="return CheckInput(this);">
									<fieldset>
<?php /* ----- FTP server ----- */ ?>
										<div>
											<h7><?php echo __("FTP server"); ?></h7>
<?php											if ($ftpserver["inputType"] == "text") { ?>
												<input type="text" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Example"); ?>: ftp.server.com, 192.123.45.67" />
<?php											} elseif ($ftpserver["inputType"] == "select") { ?>
												<select name="ftpserver">
<?php												for ($i=1; $i<=sizeof($ftpserver["list"]); $i=$i+1) { ?>
													<option value="<?php echo $ftpserver["list"][$i]; ?>" <?php echo $ftpserver["list"][$i]["selected"]; ?>><?php echo $ftpserver["list"][$i]; ?></option>
<?php												} // end for ?>
												</select>
<?php											} elseif ($ftpserver["inputType"] == "hidden") { ?>
												<input type="hidden" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" />
												<b><?php echo $ftpserver["list"][1]; ?></b>
<?php											} ?>
<?php /* ----- FTP server port ----- */ ?>
											<h7b>
<?php											if ($ftpserverport["inputType"] == "text") { ?>
												<input type="text" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ftp"]; ?>" maxlength="5" style="width: 45px;" class="form-poshytip" title="<?php echo __("Enter the FTP server port (21 for FTP, 22 for FTP SSH or 990 for FTP SSL) - if you're not sure leave it to 21"); ?>" />

<?php											} else { ?>
												<input type="hidden" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ftp"]; ?>" />
<?php											} ?>
											</h7b>
										</div>
<?php /* ----- Username ----- */ ?>
										<div>
											<h7><?php echo __("Username"); ?></h7>
											<input type="text" name="username" value="<?php echo $username; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Enter your username"); ?>" />
										</div>

<?php /* ----- Password ----- */ ?>
										<div>
											<h7><?php echo __("Password"); ?></h7>
											<input type="password" name="password" value="<?php echo $password; ?>" class="form-poshytip" title="<?php echo __("Enter your password"); ?>" />
										</div>


<?php /* ----- Captcha ----- */ ?>
<?php										if ($net2ftp_settings["use_captcha"] == "yes") { ?>
											<div style="margin-top: 10px;">
												<div id="recaptcha1"></div>
											</div>
<?php 									} ?>

<?php /* ----- Login button ----- */ ?>
										<input type="submit" id="LoginButton1" name="Login" value="<?php echo __("Login"); ?>" alt="<?php echo __("Login"); ?>" style="margin-top: 10px;" />
									</fieldset>

									<input type="hidden" name="consent_necessary"           value="<?php echo $net2ftp_globals["consent_necessary"]; ?>" />
									<input type="hidden" name="consent_preferences"         value="<?php echo $net2ftp_globals["consent_preferences"]; ?>" />
									<input type="hidden" name="consent_statistics"          value="<?php echo $net2ftp_globals["consent_statistics"]; ?>" />
									<input type="hidden" name="consent_personalized_ads"    value="<?php echo $net2ftp_globals["consent_personalized_ads"]; ?>" />
									<input type="hidden" name="consent_nonpersonalized_ads" value="<?php echo $net2ftp_globals["consent_nonpersonalized_ads"]; ?>" />
									<input type="hidden" name="protocol"  value="FTP" />
									<input type="hidden" name="state"     value="browse" />
									<input type="hidden" name="state2"    value="main" />
									<input type="hidden" name="language"  value="<?php echo $net2ftp_globals["language"]; ?>" />
								</form>
							</div>





							<h6><a href="#"><?php echo __("Basic SSH login"); ?></a></h6>
							<div>
								<form id="LoginForm2" action="<?php echo $net2ftp_globals["action_url"]; ?>" method="post" onsubmit="return CheckInput(this);">
									<fieldset>
<?php /* ----- FTP server ----- */ ?>
										<div>
											<h7><?php echo __("SSH server"); ?></h7>
<?php											if ($ftpserver["inputType"] == "text") { ?>
												<input type="text" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Example"); ?>: ftp.server.com, 192.123.45.67" />
<?php											} elseif ($ftpserver["inputType"] == "select") { ?>
												<select name="ftpserver">
<?php												for ($i=1; $i<=sizeof($ftpserver["list"]); $i=$i+1) { ?>
													<option value="<?php echo $ftpserver["list"][$i]; ?>" <?php echo $ftpserver["list"][$i]["selected"]; ?>><?php echo $ftpserver["list"][$i]; ?></option>
<?php												} // end for ?>
												</select>
<?php											} elseif ($ftpserver["inputType"] == "hidden") { ?>
												<input type="hidden" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" />
												<b><?php echo $ftpserver["list"][1]; ?></b>
<?php											} ?>
<?php /* ----- FTP server port ----- */ ?>
											<h7b>
<?php								if ($ftpserverport["inputType"] == "text") { ?>
												<input type="text" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ssh"]; ?>" maxlength="5" style="width: 45px;" title="<?php echo __("Enter the FTP server port (21 for FTP, 22 for FTP SSH or 990 for FTP SSL) - if you're not sure leave it to 21"); ?>" />
<?php								} else { ?>
											</h7b>
												<input type="hidden" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ssh"]; ?>" />
<?php								} ?>
										</div>

<?php /* ----- Username ----- */ ?>
										<div>
											<h7><?php echo __("Username"); ?></h7>
											<input type="text" name="username" value="<?php echo $username; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Enter your username"); ?>" />
										</div>

<?php /* ----- Password ----- */ ?>
										<div>
											<h7><?php echo __("Password"); ?></h7>
											<input type="password" name="password" value="<?php echo $password; ?>" class="form-poshytip" title="<?php echo __("Enter your password"); ?>" />
										</div>


<?php /* ----- Check fingerprint ----- */ ?>
										<div>
											<h7><?php echo __("Check the SSH server's public key fingerprint"); ?></h7>
											<input type="text" name="sshfingerprint" value="<?php echo $sshfingerprint; ?>" class="form-poshytip" style="background-color: #f1f1f1;" title="<?php echo __("Get the SSH server's public key fingerprint before logging in to verify the server's identity"); ?>" readonly="readonly" />
											<h7b>
												<input type="button" id="smallbutton" name="<?php echo __("Get fingerprint"); ?>" value="<?php echo __("Get fingerprint"); ?>" alt="<?php echo __("Get fingerprint"); ?>" onclick="GetFingerprint(form);" />
											</h7b>
										</div>

<?php /* ----- Captcha ----- */ ?>
<?php										if ($net2ftp_settings["use_captcha"] == "yes") { ?>
											<div style="margin-top: 10px;">
												<div id="recaptcha2"></div>
											</div>
<?php 									} ?>

<?php /* ----- Login button ----- */ ?>
										<input type="submit" id="LoginButton2" name="Login" value="<?php echo __("Login"); ?>" alt="<?php echo __("Login"); ?>" />
									</fieldset>

									<input type="hidden" name="consent_necessary"           value="<?php echo $net2ftp_globals["consent_necessary"]; ?>" />
									<input type="hidden" name="consent_preferences"         value="<?php echo $net2ftp_globals["consent_preferences"]; ?>" />
									<input type="hidden" name="consent_statistics"          value="<?php echo $net2ftp_globals["consent_statistics"]; ?>" />
									<input type="hidden" name="consent_personalized_ads"    value="<?php echo $net2ftp_globals["consent_personalized_ads"]; ?>" />
									<input type="hidden" name="consent_nonpersonalized_ads" value="<?php echo $net2ftp_globals["consent_nonpersonalized_ads"]; ?>" />
									<input type="hidden" name="state"     value="browse" />
									<input type="hidden" name="state2"    value="main" />
									<input type="hidden" name="protocol"  value="FTP-SSH" />
									<input type="hidden" name="language"  value="<?php echo $net2ftp_globals["language"]; ?>" />
								</form>
							</div>





							<h6><a href="#"><?php echo __("Advanced login"); ?></a></h6>
							<div>
								<form id="LoginForm3" action="<?php echo $net2ftp_globals["action_url"]; ?>" method="post" onsubmit="return CheckInput(this);">
									<fieldset>

<?php /* ----- Protocol ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("Protocol"); ?></h7>
											<h7a>
												<select name="protocol" id="protocol" onchange="do_protocol(form);" style="width: 140px;" class="input_select">
<?php
for ($i=1; $i<=sizeof($protocol["list"]); $i++) {
	$selected = "";
	if ($i == 1) { $selected = "selected"; }
	echo "<option value=\"" . $protocol["list"][$i]["value"] . "\" $selected>" . $protocol["list"][$i]["name"] . "</option>\n";
} // end for
?>
											</select>
											</h7a>
										</div>
<?php /* ----- FTP server ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("FTP server"); ?></h7>
											<h7a>
<?php											if ($ftpserver["inputType"] == "text") { ?>
												<input type="text" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Example"); ?>: ftp.server.com, 192.123.45.67" />
<?php											} elseif ($ftpserver["inputType"] == "select") { ?>
												<select name="ftpserver">
<?php												for ($i=1; $i<=sizeof($ftpserver["list"]); $i=$i+1) { ?>
													<option value="<?php echo $ftpserver["list"][$i]; ?>" <?php echo $ftpserver["list"][$i]["selected"]; ?>><?php echo $ftpserver["list"][$i]; ?></option>
<?php												} // end for ?>
												</select>
<?php											} elseif ($ftpserver["inputType"] == "hidden") { ?>
												<input type="hidden" name="ftpserver" value="<?php echo $ftpserver["list"][1]; ?>" />
												<b><?php echo $ftpserver["list"][1]; ?></b>
<?php											} ?>
											</h7a>
<?php /* ----- FTP server port ----- */ ?>
											<h7b>
<?php								if ($ftpserverport["inputType"] == "text") { ?>
												<input type="text" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ftp"]; ?>" maxlength="5" style="width: 45px;" />
<?php								} else { ?>
											<input type="hidden" name="ftpserverport" value="<?php echo $ftpserverport["defaultvalue_ftp"]; ?>" />
<?php								} ?>
											</h7b>
										</div>

<?php /* ----- Username ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("Username"); ?></h7>
											<h7a>
												<input type="text" name="username" value="<?php echo $username; ?>" maxlength="254" class="form-poshytip" title="Enter your username" />
											</h7a>
										</div>
<?php /* ----- Password ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("Password"); ?></h7>
											<h7a>
												<input type="password" name="password" value="<?php echo $password; ?>" class="form-poshytip" title="Enter your password" />
											</h7a>
<?php /* ----- Anonymous checkbox ----- */ ?>
											<h7b><label>
												<input type="checkbox" name="anonymous" value="1" onclick="do_anonymous(form);" />
												<?php echo __("Anonymous"); ?>
											</label></h7b>
										</div>
<?php /* ----- Initial directory ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("Initial directory"); ?></h7>
											<h7a>
												<input type="text" name="directory" value="<?php echo $directory; ?>" class="form-poshytip" title="Enter the initial directory" />
											</h7a>
<?php /* ----- Passive mode ----- */ ?>
											<h7b><label>
												<input type="checkbox" name="passivemode" value="yes" <?php echo $passivemode["checked"]; ?> />
												<?php echo __("Passive mode"); ?>
											</label></h7b>
										</div>
<?php /* ----- FTP mode ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("FTP mode"); ?></h7>
											<h7a>
												<select name="ftpmode" id="ftpmode"  style="width:120px;" class="input_select">
													<option value="binary" selected="selected">Binary</option>
													<option value="automatic" ><?php echo __("Automatic"); ?></option>
												</select>
											</h7a>
										</div>


<?php /* ----- Check fingerprint ----- */ ?>
										<div style="margin-top: 10px;">
											<h7><?php echo __("Fingerprint"); ?></h7>
											<h7a>
												<input type="text" name="sshfingerprint" value="<?php echo $sshfingerprint; ?>" class="form-poshytip" style="background-color: #f1f1f1;" title="<?php echo __("Get the SSH server's public key fingerprint before logging in to verify the server's identity"); ?>" readonly="readonly" />
											</h7a>
											<h7b>
												<input type="button" id="smallbutton" name="<?php echo __("Get fingerprint"); ?>" value="<?php echo __("Get fingerprint"); ?>" alt="<?php echo __("Get fingerprint"); ?>" onclick="GetFingerprint(form);" />
											</h7b>
										</div>

<?php /* ----- Captcha ----- */ ?>
<?php										if ($net2ftp_settings["use_captcha"] == "yes") { ?>
											<div style="margin-top: 10px;">
												<div id="recaptcha3"></div>
											</div>
<?php 									} ?>
<?php /* ----- Login button ----- */ ?>
										<input type="submit" id="LoginButton3" name="Login" value="<?php echo __("Login"); ?>" alt="<?php echo __("Login"); ?>" />
										<br />
									</fieldset>
									<input type="hidden" name="consent_necessary"           value="<?php echo $net2ftp_globals["consent_necessary"]; ?>" />
									<input type="hidden" name="consent_preferences"         value="<?php echo $net2ftp_globals["consent_preferences"]; ?>" />
									<input type="hidden" name="consent_statistics"          value="<?php echo $net2ftp_globals["consent_statistics"]; ?>" />
									<input type="hidden" name="consent_personalized_ads"    value="<?php echo $net2ftp_globals["consent_personalized_ads"]; ?>" />
									<input type="hidden" name="consent_nonpersonalized_ads" value="<?php echo $net2ftp_globals["consent_nonpersonalized_ads"]; ?>" />
									<input type="hidden" name="state"     value="browse" />
									<input type="hidden" name="state2"    value="main" />
									<input type="hidden" name="language"  value="<?php echo $net2ftp_globals["language"]; ?>" />
								</form>
							</div>
						</div>

<script type="text/javascript"><!--
	document.forms['LoginForm1'].<?php echo $focus; ?>.focus();
//--></script>

<!-- Template /skins/shinra/loginform.php end -->
