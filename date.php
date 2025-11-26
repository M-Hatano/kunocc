<?php
/**
 * 年別アーカイブ振り分け用 date.php
 */

$uri = trim($_SERVER['REQUEST_URI'], '/');

/* -----------------------------
 * ① 会員系（member）なら date-member.php
 * ----------------------------- */
if (preg_match('#^kunocc/cms/member/#', $uri)) {
    // 会員お知らせ・営業案内・くすのき会をまとめて判定
    include locate_template('date-member.php');
    exit;
}

/* -----------------------------
 * ② それ以外（一般ニュース）→ date-news.php
 * ----------------------------- */
include locate_template('date-news.php');
exit;
