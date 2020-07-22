<?php
session_start();
include "include/config.php";
$page_title = "Checking... | " . SITE_NAME;
include "include/header.php";
define("LOGINID_PATTERN", "/^[a-zA-Z0-9_-]{3,15}$/u");
define("SN_PATTERN", "/^[a-fA-F0-9]{2}(:[a-fA-F0-9]{2})+$/u");

if (
    isset($_POST["user_loginid"]) &&
    $_POST["user_loginid"] !== "" &&
    isset($_POST["user_sn"]) &&
    $_POST["user_sn"] !== "" &&
    preg_match(LOGINID_PATTERN, $_POST["user_loginid"]) &&
    preg_match(SN_PATTERN, $_POST["user_sn"])
) {
    // 要求された内容が問題なかった場合
    $date = new DateTime();
    $date = $date->format("Y-m-d H:i:s");
    $result = $mysqli->query("SELECT * FROM `users` WHERE `user_loginid`='" . $_POST["user_loginid"] . "';");
    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $hashed_user_sn = $row["user_sn"];
        }

        if (password_verify($_POST["user_sn"], $hashed_user_sn)) {
            $mysqli->query("UPDATE `users` SET `user_lastlogin`='" . $date . "' WHERE `user_loginid`='" . $_POST["user_loginid"] . "';");
            $_SESSION["user_loginid"] = $_POST["user_loginid"];
            echo "<div class=\"ui icon positive message\"><i class=\"check circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
            echo "[INFO] " . "ログインが完了しました!!";
            echo "</div><p>";
            echo 3 . "秒後にユーザページへ移動します。";
            echo "</p></div></div>";
            echo "<script>setTimeout(function(){window.location=\"index.php\"}, " . 3 . "*1000)</script>";
        } else {
            // NFCシリアルナンバーが違う場合
            $mysqli->query("UPDATE `users` SET `user_lastlogin_failure`='" . $date . "' WHERE `user_loginid`='" . $_POST["user_loginid"] . "';");
            $error[] = "ログインに失敗しました";
        }
    } else {
        // ユーザIDが存在しない場合
        $error[] = "ログインに失敗しました";
    }
} else {
    if (!isset($_POST["user_loginid"]) || !isset($_POST["user_sn"])) {
        // 直接アクセスされた場合トップページへ
        echo "<script>window.location=\"index.php\"</script>";
        die();
    }
    if ($_POST["user_loginid"] === "") $error[] = "Login IDが空です";
    if ($_POST["user_sn"] === "") $error[] = "NFC SerialNumberが空です";
    if (!preg_match(LOGINID_PATTERN, $_POST["user_loginid"])) $error[] = "Login ID形式が不正です<ul>
                                                                                                <li>3文字以上15文字以下</li>
                                                                                                <li>半角英数字 (大文字、小文字区別)</li>
                                                                                                <li>記号 _(アンダーバー) -(ハイフン)</li>
                                                                                            </ul>のみ使用可能";
    if (!preg_match(SN_PATTERN, $_POST["user_sn"])) $error[] = "NFC SerialNumberの形式が不正です";
}

if (isset($error)) {
    echo "<div class=\"ui icon negative message\"><i class=\"times circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
    foreach ($error as $temp) echo "[ERROR] " . $temp . "<br>";
    echo "</div><p>";
    echo 2 + count($error) . "秒後に戻ります…。";
    echo "</p></div></div>";
    echo "<script>setTimeout(function(){window.location=\"index.php\"}, " . (2 + count($error)) . "*1000)</script>";
}
?>


<?php
$mysqli->close();

include "include/footer.php";
?>