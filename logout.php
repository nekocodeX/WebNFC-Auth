<?php
session_start();
include "include/config.php";
$page_title = "Logout | " . SITE_NAME;
include "include/header.php";

session_destroy();
unset($_SESSION["user_loginid"]);
echo "<div class=\"ui icon positive message\"><i class=\"check circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
echo "[INFO] " . "ログアウトが完了しました";
echo "</div><p>";
echo 3 . "秒後にトップページへ移動します。";
echo "</p></div></div>";
echo "<script>setTimeout(function(){window.location=\"index.php\"}, " . 3 . "*1000)</script>";

$mysqli->close();

include "include/footer.php";
