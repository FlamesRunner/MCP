<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/consent.template.php begin -->

<form id="<?php echo $formname; ?>" action="<?php echo $net2ftp_globals["action_url"]; ?>" <?php echo $enctype; ?> method="post">
<input type="hidden"   name="state"                       value="login" />
<input type="hidden"   name="consent_necessary"           value="1"  />
<input type="hidden"   name="consent_nonpersonalized_ads" value="1" />


<?php // From https://www.cookiebot.com/en/gdpr-cookies/ ?>

<div id="consent">

<h6>This website uses cookies</h6>

We use cookies to personalise content and ads, to provide social media features and to analyse our traffic.
We also share information about your use of our site with our social media, advertising and analytics partners who may combine it with other information that you've provided to them or that they've collected from your use of their services. 
You consent to our cookies if you continue to use this website. <br />

<br />

<input type="checkbox" name="consent_necessary"           value="1" checked="checked" disabled="disabled" style="width: 15px;" /> 
	Necessary            <br />
<input type="checkbox" name="consent_preferences"         value="1" checked="checked"                     style="width: 15px;" />
	Preferences          <br />
<input type="checkbox" name="consent_statistics"          value="1" checked="checked"                     style="width: 15px;" />
	Statistics           <br />
<input type="checkbox" name="consent_personalized_ads"    value="1"                                       style="width: 15px;" title="Google considers ads to be personalized when they are based on previously collected or historical data to determine or influence ad selection, including a user's previous search queries, activity, visits to sites or apps, demographic information, or location. Specifically, this would include, for example: demographic targeting, interest category targeting, remarketing, targeting Customer Match lists, and targeting audience lists uploaded in Display & Video 360 or Campaign Manager." /> 
	Personalized ads<br />
<input type="checkbox" name="consent_nonpersonalized_ads" value="1" checked="checked" disabled="disabled" style="width: 15px;" title="Non-personalized ads are ads that are not based on a user’s past behavior. They are targeted using contextual information, including coarse (such as city-level, but not ZIP/postal code) geo-targeting based on current location, and content on the current site or app or current query terms. Although non-personalized ads don’t use cookies or mobile ad identifiers for ad targeting, they do still use cookies or mobile ad identifiers for frequency capping, aggregated ad reporting, and to combat fraud and abuse." /> 
	Non-personalized ads<br />

<br />

<input type="submit" id="LoginButton1" name="Save" value="Save cookie choice" alt="Save cookie choice" style="width: 80%; margin-left: 10%; margin-right: 10%;" />
</div>

</form>
<!-- Template /skins/shinra/consent.template.php end -->