<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/login_small.template.php begin -->
<form id="<?php echo $formname; ?>" action="<?php echo $net2ftp_globals["action_url"]; ?>" <?php echo $enctype; ?> method="post" onsubmit="return CheckInput(this);">

<?php	printLoginInfo(); ?>
<input type="hidden" name="state"           value="<?php echo $go_to_state;  ?>" />
<input type="hidden" name="state2"          value="<?php echo $go_to_state2; ?>" />
<input type="hidden" name="directory"       value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
<input type="hidden" name="entry"           value="<?php echo $net2ftp_globals["entry_html"]; ?>" />
<input type="hidden" name="screen"          value="<?php echo $net2ftp_globals["screen_html"]; ?>" />
<input type="hidden" name="command"         value="<?php echo htmlEncode2($command); ?>" />
<input type="hidden" name="protocol2"       value="<?php echo htmlEncode2($protocol2); ?>" />
<input type="hidden" name="ftpserver2"      value="<?php echo htmlEncode2($ftpserver2); ?>" />
<input type="hidden" name="ftpserverport2"  value="<?php echo htmlEncode2($ftpserverport2); ?>" />
<input type="hidden" name="sshfingerprint2" value="<?php echo htmlEncode2($sshfingerprint2); ?>" />
<input type="hidden" name="username2"       value="<?php echo htmlEncode2($username2); ?>" />
<input type="hidden" name="password2"       value="<?php echo htmlEncode2($password2); ?>" />
<input type="hidden" name="newNames"        value="<?php echo htmlEncode2($newNames); ?>" />
<input type="hidden" name="textareaType"    value="<?php echo htmlEncode2($textareaType);  ?>" />
<input type="hidden" name="text"            value="<?php echo htmlEncode2($text); ?>" />
<input type="hidden" name="text_splitted"   value="<?php echo htmlEncode2($text_splitted); ?>" />
<input type="hidden" name="url"             value="<?php echo htmlEncode2($url); ?>" />

<?php if (is_array($searchoptions) == true) { ?>
<?php		while (list($key, $value) = each($searchoptions)) { ?>
<input type="hidden" name="searchoptions[<?php echo htmlEncode2($key); ?>]" value="<?php echo htmlEncode2($value); ?>" />
<?php		} // end while ?>
<?php	} // end if ?>

<?php if (is_array($text_splitted) == true) { ?>
<?php		while (list($key, $value) = each($text_splitted)) { ?>
<input type="hidden" name="text_splitted[<?php echo htmlEncode2($key); ?>]" value="<?php echo htmlEncode2($value); ?>" />
<?php		} // end while ?>
<?php	} // end if ?>

<?php if (is_array($zipactions) == true) { ?>
<?php		while (list($key, $value) = each($zipactions)) { ?>
<input type="hidden" name="zipactions[<?php echo htmlEncode2($key); ?>]" value="<?php echo htmlEncode2($value); ?>" />
<?php		} // end while ?>
<?php	} // end if ?>

<?php if (is_array($zipactions) == true) { ?>
<?php 	for ($i=1; $i<=sizeof($list["all"]); $i++) { ?>
<?php 		while (list($key, $value) = each($list["all"][$i])) { ?>
<input type="hidden" name="list[<?php echo $i; ?>][<?php echo htmlEncode2($key); ?>]" value="<?php echo htmlEncode2($value); ?>" />
<?php			} // end while ?>
<?php 	} // end for ?>
<?php	} // end if ?>

<div style="border: 1px solid black; background-color: #DDDDDD; width: 60%; margin-<?php echo __("left"); ?>: auto; margin-<?php echo __("right"); ?>: auto; margin-top:50px; padding: 10px;">

<?php echo $message; ?><br />

<?php if ($errormessage != "") { ?>
<span style="color: red;"><?php echo $errormessage; ?></span><br />
<?php } // end if ?>

<br />

<table border="0" cellspacing="0" cellpadding="0" style="width: 90%; margin-left: auto; margin-right: auto;">
	<tr style="vertical-align: middle;">
<?php	if ($net2ftp_settings["use_captcha"] == "yes") { $rowspan = "5"; } else { $rowspan = "4"; } ?>
		<td rowspan="<?php echo $rowspan; ?>" style="width: 15%;"><?php printTitleIcon(); ?></td>
		<td><?php echo __("Username"); ?></td>
		<td>
			<input type="text"     class="input" name="<?php echo $username_fieldname; ?>" value="<?php echo $username_value; ?>" />
		</td>
	</tr>
	<tr style="vertical-align: middle;">
		<td><?php echo __("Password"); ?></td>
		<td>
			<input type="password" class="input" name="<?php echo $password_fieldname; ?>" value="<?php echo $password_value; ?>" />
		</td>
	</tr>
	<tr style="vertical-align: middle;">
		<td colspan="2">

<?php /* ----- Email and privacy policies ----- */ ?>
										<div style="color: #9F6000; background-color: #FEEFB3;  border: 1px solid; margin: 15px 0px 15px 0px; padding: 15px; font-size: 80%;">

											<div style="text-decoration: underline;"><?php echo __("Privacy notices"); ?></div>

											<?php echo __("Please enter your email address as identifier to give you the right of access and erasure:"); ?> <br /><br />

											<input type="text" name="user_email" value="<?php echo $user_email; ?>" maxlength="254" class="form-poshytip" title="<?php echo __("Enter your email address"); ?>" /> <br />

<?php 										if (isset($net2ftp_settings["privacy_policy_1"]) && $net2ftp_settings["privacy_policy_1"] != "") { ?>
											<div style="display: block; margin-top: 10px;">
												<input name="privacy1" value="1" onclick="" type="checkbox" style="width: 25px;" /> <?php echo $net2ftp_settings["privacy_policy_1"]; ?>
											</div>
<?php 										} // end if ?>

<?php 										if (isset($net2ftp_settings["privacy_policy_2"]) && $net2ftp_settings["privacy_policy_2"] != "") { ?>
											<div style="display: block; margin-top: 0px;">
												<input name="privacy2" value="1" onclick="" type="checkbox" style="width: 15px;" /> <?php echo $net2ftp_settings["privacy_policy_2"]; ?>
											</div>
<?php 										} // end if ?>

<?php 										if (isset($net2ftp_settings["privacy_policy_3"]) && $net2ftp_settings["privacy_policy_3"] != "") { ?>
											<div style="display: block; margin-top: 0px;">
												<input name="privacy3" value="1" onclick="" type="checkbox" style="width: 15px;" /> <?php echo $net2ftp_settings["privacy_policy_3"]; ?>
											</div>
<?php 										} // end if ?>

<?php 										if (isset($net2ftp_settings["privacy_policy_4"]) && $net2ftp_settings["privacy_policy_4"] != "") { ?>
											<div style="display: block; margin-top: 0px;">
												<input name="privacy4" value="1" onclick="" type="checkbox" style="width: 15px;" /> <?php echo $net2ftp_settings["privacy_policy_4"]; ?>
											</div>
<?php 										} // end if ?>

<?php 										if (isset($net2ftp_settings["privacy_policy_5"]) && $net2ftp_settings["privacy_policy_5"] != "") { ?>
											<div style="display: block; margin-top: 0px;">
												<input name="privacy5" value="1" onclick="" type="checkbox" style="width: 15px;" /> <?php echo $net2ftp_settings["privacy_policy_5"]; ?>
											</div>
<?php 										} // end if ?>

										</div>
		</td>
	</tr>

<?php	if ($net2ftp_settings["use_captcha"] == "yes") { ?>
	<tr style="vertical-align: middle;">
		<td></td>
		<td>
			<div id="recaptcha1"></div>
		</td>
	</tr>
<?php	} ?>
	<tr style="vertical-align: middle;">
		<td colspan="2" >
			<input type="submit" id="LoginButton1" name="Login" value="<?php echo $button_text; ?>" alt="<?php echo $button_text; ?>" />
		</td>
	</tr>
</table>
</div>
</form>
<script type="text/javascript"><!--
  document.forms['<?php echo $formname; ?>'].<?php echo $focus; ?>.focus();
//--></script>
<!-- Template /skins/shinra/login_small.template.php end -->
