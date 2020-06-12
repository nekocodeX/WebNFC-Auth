<?php
include "include/config.php";
$page_title = "Install | WebNFC-Auth";
include "include/header.php";

// DB構築
if ($mysqli->query("CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_loginid` varchar(20) NOT NULL,
    `user_mail` varchar(255) NOT NULL,
    `user_sn` varchar(100) NOT NULL,
    `user_lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `user_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`user_id`)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;")) {
    echo "[INFO] DB initialization is complete, please delete this file!!";
} else {
    echo "[ERROR] DB initialization failed";
}

$mysqli->close();

include "include/footer.php";
