<?php
const DB_HOST = "";
const DB_USER = "";
const DB_PASSWD = "";
const DB_NAME = "";
const G_RECAPTCHA_SITEKEY = "";

$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

if (!$mysqli) {
    die("[ERROR] DB Connect Error: " . mysqli_connect_error());
}
