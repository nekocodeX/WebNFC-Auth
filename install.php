<?php
include "include/config.php";
$page_title = "Install | " . SITE_NAME;
include "include/header.php";

// DB構築
if ($mysqli->query("CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_loginid` varchar(20) NOT NULL UNIQUE,
    `user_mail` varchar(255) NOT NULL UNIQUE,
    `user_sn` varchar(60) NOT NULL,
    `user_lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `user_lastlogin_failure` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `user_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;")) {
    echo "<div class=\"ui icon positive message\"><i class=\"check circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
    echo "[INFO] DB initialization is complete, please delete this file!!";
    echo "</div></div></div>";
} else {
    echo "<div class=\"ui icon negative message\"><i class=\"times circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
    echo "[ERROR] DB initialization failed";
    echo "</div></div></div>";
}

$mysqli->close();

include "include/footer.php";
