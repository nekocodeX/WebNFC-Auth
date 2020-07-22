<div align="center">

![Logo](https://user-images.githubusercontent.com/65624234/85921391-06c01900-b8b7-11ea-96e9-d88eb1835653.png)

</div>

# WebNFC-Auth

Web NFC API を用いたパスワードレスな認証システムのような何か  
（シリアルナンバーで認証しているのでセキュリティ上よろしくありません）

## ✅ 動作環境

### 🖥 サーバ

-   PHP 7.0 以降
-   MySQL

### 📱 クライアント

-   Android 版 Chrome 81 以降
-   NFC 搭載端末

### 🏷 NFC

-   ブランクカードが必要？（交通系 IC 等では動作確認できず）

## 👀 Demo

<div align="center">

![Demo](https://user-images.githubusercontent.com/65624234/85921579-155b0000-b8b8-11ea-85d5-4f45c044f5af.gif)

</div>

## 📦 インストール

1. リポジトリのファイル一式をダウンロードし、サーバへアップロード
2. `include/config.php` をエディタで開き

    - MySQL の接続情報
    - Web NFC API 用 Origin Trials のトークン（[取得ページ](https://developers.chrome.com/origintrials/#/view_trial/236438980436951041)）  
      (または)
    - `chrome://flags/#enable-experimental-web-platform-features` をクライアント側で有効にしてください
    - 必要に応じて `SITE_NAME`, `LOGO_IMAGE`, `FAVICON_IMAGE`

    の入力または変更を行ってください

3. `install.php` へブラウザからアクセスし、エラーがなければ DB へ `users` テーブルの作成が完了しています
4. `install.php` をサーバから削除してください
5. サイトへアクセスし、各機能が動作すればインストール完了です 🎉
