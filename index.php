<?php
session_start();
include "include/config.php";

$is_login = isset($_SESSION["user_loginid"]);
$is_login ? $page_title = "UserPage | " . SITE_NAME : $page_title = "Login | " . SITE_NAME;
include "include/header.php";

$result = $mysqli->query("SELECT * FROM `users` WHERE `user_loginid`='" . $_SESSION["user_loginid"] . "';");
while ($row = $result->fetch_assoc()) {
    $user_loginid = $row["user_loginid"];
    $user_mail = $row["user_mail"];
    $user_lastlogin = $row["user_lastlogin"];
    $user_lastlogin_failure = $row["user_lastlogin_failure"];
    $user_created = $row["user_created"];
}
if ($user_lastlogin === "0000-00-00 00:00:00") $user_lastlogin = "(記録なし)";
if ($user_lastlogin_failure === "0000-00-00 00:00:00") $user_lastlogin_failure = "(記録なし)";
if ($user_created === "0000-00-00 00:00:00") $user_created = "(記録なし)";
?>
<?php if ($is_login) : ?>
    <div class="ui middle aligned center aligned grid">
        <div class="column" style="text-align: left;">
            <h2 class="ui teal image header">
                <img src="<?= LOGO_IMAGE ?>" class="image">
                <div class="content">
                    <?= $page_title ?>
                </div>
            </h2>
            <div class="ui segment">
                <h2 class="ui center aligned icon header">
                    <i class="circular users icon"></i>
                    <p><?= $user_loginid ?></p>
                </h2>
                <div class="ui relaxed divided list">
                    <div class="item">
                        <i class="big teal envelope outline icon"></i>
                        <div class="content">
                            <div class="header">Mail address</div>
                            <div class="description"><?= $user_mail ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal calendar alternate outline icon"></i>
                        <div class="content">
                            <div class="header">最終ログイン日時</div>
                            <div class="description"><?= $user_lastlogin ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal calendar times outline icon"></i>
                        <div class="content">
                            <div class="header">最終ログイン失敗日時</div>
                            <div class="description"><?= $user_lastlogin_failure ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal history icon"></i>
                        <div class="content">
                            <div class="header">登録日時</div>
                            <div class="description"><?= $user_created ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 1em;">
                <a href="logout.php" class="ui fluid large button">ログアウト</a>
            </div>
            <div style="text-align: center;">
                <a href="https://github.com/nekocodeX/WebNFC-Auth" target="_blank" class="ui labeled icon button">
                    <i class="github icon"></i>
                    GitHub Repo
                </a>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="ui middle aligned center aligned grid">
        <div class="column" style="text-align: left;">
            <h2 class="ui teal image header">
                <img src="<?= LOGO_IMAGE ?>" class="image">
                <div class="content">
                    <?= $page_title ?>
                </div>
            </h2>
            <div class="ui segment">
                <form action="checklogin.php" method="post" class="ui form">
                    <div class="field">
                        <label><i class="user outline icon"></i>&nbsp;Login ID</label>
                        <div class="ui corner labeled input">
                            <input type="text" pattern="^[a-zA-Z0-9_-]{3,15}$" name="user_loginid" placeholder="Login ID" required>
                            <div class="ui corner label">
                                <i class="red asterisk icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label><i class="id card outline icon"></i>&nbsp;NFC SerialNumber</label>
                        <div class="ui corner labeled input">
                            <input type="password" pattern="^[a-fA-F0-9]{2}(:[a-fA-F0-9]{2})+$" name="user_sn" id="get_nfc_sn" placeholder="[読み取り開始] を押してNFCを端末にかざしてください" tabindex=" -1" readonly-mod required>
                            <div class="ui corner label">
                                <i class="red asterisk icon"></i>
                            </div>
                        </div>
                        <input type="button" id="start_nfc" value="読み取り開始" class="ui button">
                        <div class="ui slider checkbox">
                            <input type="checkbox" id="show_nfc_sn">
                            <label><i class="eye icon"></i>&nbsp;シリアルナンバーを確認</label>
                        </div>
                    </div>
                    <button type="submit" class="ui fluid large teal button">ログイン</button>
            </div>
            </form>
            <div class="ui message" style="text-align: center;">
                アカウントをお持ちでない場合:&nbsp;
                <a href="signup.php">Signup</a>
            </div>
            <div style="text-align: center;">
                <a href="https://github.com/nekocodeX/WebNFC-Auth" target="_blank" class="ui labeled icon button">
                    <i class="github icon"></i>
                    GitHub Repo
                </a>
            </div>
        </div>
    </div>
    <script>
        $("#start_nfc").on("click", function() {
            try {
                const reader = new NDEFReader()
                reader.scan().catch(function() {
                    alert("[ERROR] " + "NFCへアクセスする権限がありません")
                })

                reader.addEventListener("error", ({
                    message
                }) => {
                    switch (message) {
                        case "This tag is not supported.":
                            alert("[ERROR] このタグはサポートされていません")
                            break

                        default:
                            alert("[ERROR] " + message)
                            break
                    }
                })

                reader.addEventListener("reading", ({
                    serialNumber
                }) => {
                    $("#get_nfc_sn").val([serialNumber])
                })
            } catch (error) {
                alert("[ERROR] " + error)
            }
        })
        $("#show_nfc_sn").change(function() {
            if ($(this).prop("checked")) {
                $("#get_nfc_sn").attr("type", "text")
            } else {
                $("#get_nfc_sn").attr("type", "password")
            }
        })
    </script>
<?php endif; ?>


<?php
$mysqli->close();

include "include/footer.php";
?>