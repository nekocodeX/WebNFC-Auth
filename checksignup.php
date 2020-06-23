<?php
include "include/config.php";
$page_title = "Checking... | " . SITE_NAME;
include "include/header.php";
define("LOGINID_PATTERN", "/^[a-zA-Z0-9_-]{3,15}$/u");
define("SN_PATTERN", "/^[a-fA-F0-9]{2}(:[a-fA-F0-9]{2})+$/u");
define("DB_INSERT_ERROR_PATTERN", "/^Duplicate entry \'/u");

if (
    isset($_POST["user_mail"]) &&
    $_POST["user_mail"] !== "" &&
    isset($_POST["user_loginid"]) &&
    $_POST["user_loginid"] !== "" &&
    isset($_POST["user_sn"]) &&
    $_POST["user_sn"] !== "" &&
    filter_var($_POST["user_mail"], FILTER_VALIDATE_EMAIL) &&
    preg_match(LOGINID_PATTERN, $_POST["user_loginid"]) &&
    preg_match(SN_PATTERN, $_POST["user_sn"])
) {
    // 要求された内容が問題なかった場合
    $date = new DateTime();
    $date = $date->format("Y-m-d H:i:s");
    if ($mysqli->query("INSERT INTO `users` (`user_loginid`, `user_mail`, `user_sn`, `user_created`) VALUES
                    ('" . $_POST["user_loginid"] . "', '" . $_POST["user_mail"] . "', '" . password_hash($_POST["user_sn"], PASSWORD_DEFAULT) . "', '" . $date . "');")) {
        echo "<div class=\"ui icon positive message\"><i class=\"check circle outline icon\"></i><div class=\"content\"><div class=\"header\">";
        echo "[INFO] " . "登録が完了しました!!";
        echo "</div><p>";
        echo 3 . "秒後にログインページへ移動します。";
        echo "</p></div></div>";
        echo "<script>setTimeout(function(){window.location=\"index.php\"}, " . 3 . "*1000)</script>";
    } else {
        $temp = $mysqli->error;
        if (preg_match(DB_INSERT_ERROR_PATTERN, $temp)) {
            if (preg_match("/user_loginid/",$temp)) $error[] = "登録に失敗しました: " . "Login IDが既に使用されています";
            if (preg_match("/user_mail/", $temp)) $error[] = "登録に失敗しました: " . "Mail addressが既に使用されています";
        } else {
            $error[] = "不明なエラーにより登録が失敗しました: " . $temp;
        }
    }
} else {
    if (!isset($_POST["user_mail"]) || !isset($_POST["user_loginid"]) || !isset($_POST["user_sn"])) {
        // 直接アクセスされた場合トップページへ
        echo "<script>window.location=\"index.php\"</script>";
        die();
    }
    if ($_POST["user_mail"] === "") $error[] = "Mail addressが空です";
    if ($_POST["user_loginid"] === "") $error[] = "Login IDが空です";
    if ($_POST["user_sn"] === "") $error[] = "NFC SerialNumberが空です";
    if (!filter_var($_POST["user_mail"], FILTER_VALIDATE_EMAIL)) $error[] = "Mail addressの形式が不正です";
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
    echo 3 + count($error) . "秒後に戻ります…。";
    echo "</p></div></div>";
    echo "<script>setTimeout(function(){window.location=\"signup.php\"}, " . (3 + count($error)) . "*1000)</script>";
}
?>


<?php
$mysqli->close();

include "include/footer.php";
?>