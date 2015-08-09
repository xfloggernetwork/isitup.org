<?php

require("settings.php");
require("functions.php");

// Destroy cookie, if ?clear.
if (isset($_GET["clear"]))
{
    remove_cookies("input");

    header("Location: http://" . $setting["host"], true, 303);
    exit();
};

// Set cookie, if ?save.
if (isset($_GET["save"]) && isset($_GET["d"]))
{
    set_cookie("input", $_GET["d"]);
};

// Set $domain["remote"].
if (isset($_GET["d"]))
{
    $domain["remote"] = preg_replace("/[^A-Za-z0-9-\/\.\: ]/", "", trim($_GET["d"]));
}
else if (isset($_COOKIE["input"]))
{
    $domain["remote"] = preg_replace("/[^A-Za-z0-9-\/\.\: ]/", "", trim($_COOKIE["input"]));
}
else
{
    $domain["remote"] = null;
};

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Is it up?</title>

    <!-- Meta Info -->
    <meta name="description" content="A simple tool to check if a website or ip address is up or down." />
    <meta name="wot-verification" content="c533868b214acabc1bc6" />
    <meta name="theme-color" content="#ECECEC"/>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="/static/img/icon.png" />

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" media="all" href="/static/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/static/css/style.css" />

    <!--[if lt IE 8]>
    <style type="text/css">
        #submit {
            position: relative;
            top: 8px;
        }
    </style>
    <![endif]-->

    <!-- Mobile Browser Stuff -->
    <meta name="viewport" content="width=device-width" />

    <!-- OpenSearch -->
    <link rel="search" type="application/opensearchdescription+xml" title="Is it up?" href="/static/xml/search.xml" />

    <!-- Javascript Resources -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/static/js/homepage.js"></script>
    <script>
        // Initialize the homepage
        $(document).ready(function () {
            homepage("<?php echo get_jsdomain($domain['remote'], $setting['default']); ?>");
        });
    </script>
</head>
<body>
<div id="container">
    <noscript>
        <p class="warning"><img src="/static/img/exclamation.png" width="16" height="16" alt="" />Please don't enter "http://" or a trailing slash, as you do not seem to be using javascript.</p>
        <p class="warning">For example type in <code>example.com</code> instead of <code>http://<u>example.com</u>/test/ing.html</code></p>
    </noscript>

<?php if ( isset($_GET["save"]) && empty($_GET["d"]) ) : ?>
    <p class="warning"><img src="/static/img/exclamation.png" width="16" height="16" alt="" /><i>Error:</i> a domain needs to be selected, e.g. <code>http://isitup.org/save/<u>example.com</u></code>.</p>
<?php elseif ( isset($_GET["save"]) ): ?>
    <p class="save"><img src="/static/img/accept.png" width="16" height="16" alt="" /><b><?php echo get_domain($domain["remote"], $setting["default"]); ?></b> is now your default domain. Click on <i>Clear</i> to restore the original.</p>
<?php endif; ?>

    <form method="get" action="/check.php" id="form">
        <p>is <input type="text" name="domain" id="input" value="<?php echo get_domain($domain["remote"], $setting["default"]); ?>" accesskey="4" /> <input type="submit" id="submit" value="up?" accesskey="s" /></p>
    </form>
</div>

<div id="footer">
    <ul>
        <?php if( show_clear() ): ?><li><a href="/clear" title="Reset to the default settings">Clear</a></li><?php endif; ?>
    </ul>
</div>

<div id="buysellads">
   
</div>
</body>
</html>
