<?php
include "include/config.php";
TRUE ? $page_title = "Login | " . SITE_NAME : $page_title = "Hello!! | " . SITE_NAME;
include "include/header.php";
?>
<?php if (TRUE) : ?>
    <div class="ui middle aligned center aligned grid">
        <div class="column" style="text-align: left;">
            <div class="ui segment">
                <h2 class="ui teal image header">
                    <img src="<?= LOGO_IMAGE ?>">
                    <div class="content">
                        <?= $page_title ?>
                    </div>
                </h2>
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
                            <input type="password" pattern="^[a-fA-F0-9]{2}(:[a-fA-F0-9]{2})+$" name="user_sn" id="get_nfc_sn" placeholder="[読み取り開始] を押してNFCを端末にかざしてください"" tabindex=" -1" readonly-mod required>
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
<?php else : ?>
    <div class="ui middle aligned center aligned grid">
        <div class="column" style="text-align: left;">
            <div class="ui segment">
                <h2 class="ui teal image header">
                    <img src="<?= LOGO_IMAGE ?>">
                    <div class="content">
                        <?= $page_title ?>
                    </div>
                </h2>
                <div class="ui relaxed divided list">
                    <div class="item">
                        <i class="big teal user outline icon"></i>
                        <div class="content">
                            <a class="header">Login ID</a>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal envelope outline icon"></i>
                        <div class="content">
                            <a class="header">Mail address</a>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal calendar alternate outline icon"></i>
                        <div class="content">
                            <a class="header">最終ログイン日時</a>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal calendar times outline icon"></i>
                        <div class="content">
                            <a class="header">最終ログイン失敗日時</a>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="item">
                        <i class="big teal history icon"></i>
                        <div class="content">
                            <a class="header">登録日時</a>
                            <div class="description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php
$mysqli->close();

include "include/footer.php";
?>