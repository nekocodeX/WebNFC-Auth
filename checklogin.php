<?php
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
    foreach ($error as $temp) echo "[ERROR] " . $temp . "<br>";
    echo 3 + count($error) . "秒後に戻ります…。";
    echo "<script>setTimeout(function(){window.location=\"signup.php\"}, " . (3 + count($error)) . "*1000)</script>";
}
?>


<?php
$mysqli->close();

include "include/footer.php";
?>