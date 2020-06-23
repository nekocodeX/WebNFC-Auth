<?php
define("DB_HOST","");
define("DB_USER", "");
define("DB_PASSWD", "");
define("DB_NAME", "");
define("ORIGIN_TRIALS_TOKEN", "");
define("G_RECAPTCHA_SITEKEY", "");
define("G_RECAPTCHA_SECRETKEY", "");

define("SITE_NAME", "");
define("LOGO_IMAGE", "");
define("FAVICON_IMAGE", "");


$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

if (!$mysqli) die("[ERROR] DB connect error: " . mysqli_connect_error());
