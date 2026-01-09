<?php
/*
Template Name: Member File Download
*/

// 未ログインならログイン画面へ
if (! is_user_logged_in()) {
    auth_redirect();
    exit;
}

// ?id=XXX
$attachment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (! $attachment_id) {
    wp_die('ファイルが指定されていません。');
}

// ファイル本体のパス
$file_path = get_attached_file($attachment_id);
if (! $file_path || ! file_exists($file_path)) {
    wp_die('ファイルが見つかりませんでした。');
}

// MIMEタイプ
$mime_type = get_post_mime_type($attachment_id);
if (! $mime_type) {
    $mime_type = 'application/octet-stream';
}

$filename = basename($file_path);

// PDFなどのファイルをそのまま出力
header('Content-Type: ' . $mime_type);
header('Content-Length: ' . filesize($file_path));
header('Content-Disposition: inline; filename="' . $filename . '"');

readfile($file_path);
exit;
