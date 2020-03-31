<?php
# Debugging
error_reporting( -1 );
ini_set( 'display_errors', 1 );
# This file was automatically generated by the MediaWiki 1.33.1
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
  exit;
}


## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "Jamboree21";
$wgMetaNamespace = "Meta";

# Allow DISPLAYTITLE to contain anything, default is to restrict it to only format-changes.
$wgRestrictDisplayTitle = false;

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";
$wgArticlePath = "/$1";
$wgUsePathInfo = true;
$wgScriptExtension = ".php";

## The protocol and server name to use in fully-qualified URLs
$wgServer = getenv('MEDIAWIKI_BASE_URL');

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = '/logo.png';

## UPO means: this is also a user preference option

$wgEnableEmail = false;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = getenv('MEDIAWIKI_EMAIL');
$wgPasswordSender = getenv('MEDIAWIKI_EMAIL');

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = getenv("MEDIAWIKI_DB_TYPE");
$wgDBserver = getenv("MEDIAWIKI_DB_HOST");
$wgDBname = getenv("MEDIAWIKI_DB_NAME");
$wgDBuser = getenv("MEDIAWIKI_DB_USER");
$wgDBpassword = getenv("MEDIAWIKI_DB_PASSWORD");

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = true;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "sv";

$wgSecretKey = getenv("MEDIAWIKI_SECRET_KEY");

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = getenv("MEDIAWIKI_UPGRADE_KEY");

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = true;
$wgWhitelistRead = array(
  "Main Page", "MediaWiki:Common.css", "MediaWiki:Common.js", "Special:Skapa_konto", "Huvudsida", "Special:CreateAccount"
);
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['read'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );


# Enabled extensions. Most of the extensions are enabled by adding
# wfLoadExtensions('ExtensionName');
# to LocalSettings.php. Check specific extension documentation for more details.
# The following extensions were automatically enabled:
wfLoadExtension( 'MultimediaViewer' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'WikiEditor' );

# Visual Editor
wfLoadExtension( 'VisualEditor' );
$wgDefaultUserOptions['visualeditor-enable'] = 1;
$wgDefaultUserOptions['visualeditor-enable-experimental'] = 1;
$wgDefaultUserOptions['visualeditor-editor'] = "visualeditor";
# We can't use RESTBase, so: (ref.
# https://www.mediawiki.org/wiki/Extension:VisualEditor#Switching_between_Wikitext_Editing_and_VisualEditor)
$wgVisualEditorAllowLossySwitching=false;
$wgVirtualRestConfig['modules']['parsoid'] = [
	// URL to the Parsoid instance - use port 8142 if you use the Debian package - the parameter 'URL' was first used but is now deprecated (string)
	'url' => getenv('MEDIAWIKI_BASE_URL') . '/parsoid',
	// Parsoid "domain" (string, optional) - MediaWiki >= 1.26
	'domain' => 'jamboree21',
	// Forward cookies in the case of private wikis (string or false, optional)
	'forwardCookies' => true,
	// request timeout in seconds (integer or null, optional)
	'timeout' => null,
	// Parsoid HTTP proxy (string or null, optional)
	'HTTPProxy' => null,
	// whether to parse URL as if they were meant for RESTBase (boolean or null, optional)
	'restbaseCompat' => false,
];


# End of automatically generated settings.
# Add more configuration options below.
wfLoadExtension( 'MobileFrontend' );
# wfLoadExtension( 'PluggableAuth' );
# wfLoadExtension( 'SimpleSAMLphp' );
wfLoadSkin( 'MinervaNeue' );
$wgMFDefaultSkinClass = 'SkinMinerva';

# MORE DEBUGGING
$wgDebugLogFile = "/var/log/mediawiki/debug-{$wgDBname}.log";

# Configure user rights
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['user']['edit'] = true;
$wgGroupPermissions['*']['createaccount'] = true;
$wgGroupPermissions['*']['autocreateaccount'] = true;

# Config simplesamlphp

$wgSimpleSAMLphp_InstallDir = 'simplesamlphp';
$wgSimpleSAMLphp_AuthSourceId = 'default-sp';
$wgSimpleSAMLphp_UsernameAttribute = [
	'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname',
	'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname'
];
$wgSimpleSAMLphp_EmailAttribute = 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name';
$wgSimpleSAMLphp_RealNameAttribute = [
        'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname',
        'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname'
];

# Config pluggableauth

$wgPluggableAuth_EnableAutoLogin = false;
$wgPluggableAuth_EnableLocalLogin = false;
$wgPluggableAuth_EnableLocalProperties = true;
$wgPluggableAuth_ButtonLabelMessage = 'Logga in';
$wgPluggableAuth_Class = 'SimpleSAMLphp';
