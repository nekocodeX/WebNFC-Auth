<?php
define("DB_HOST","");
define("DB_USER", "");
define("DB_PASSWD", "");
define("DB_NAME", "");
define("ORIGIN_TRIALS_TOKEN", "");
define("G_RECAPTCHA_SITEKEY", "");
define("G_RECAPTCHA_SECRETKEY", "");

define("SITE_NAME", "WebNFC-Auth");
define("LOGO_IMAGE", "asset/image/logo.png");
define("FAVICON_IMAGE", "asset/image/favicon.ico");


$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

if (!$mysqli) die("[ERROR] DB connect error: " . mysqli_connect_error());
