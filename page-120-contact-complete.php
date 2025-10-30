<?php
/*
      Template Name: お問い合わせ-完了
      */
?>

<?php
// キャッシュ取得をなしにする
session_cache_limiter('none');

// セキュアフラグのないクッキーを防ぐ
session_name('');
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => $_SERVER['HTTP_HOST'],
  'secure' => true,
  'httponly' => true,
  'samesite' => 'Strict'
]);

session_start();


//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//XSSフィルタ機能を強制的に有効
header("X-XSS-Protection: 1; mode=block");

//sniffing防止
header("X-Content-Type-Options: nosniff");

// 許可するリファラーのドメイン
$home_url = rtrim(get_home_url(), '/') . '/';

$parsed_url = parse_url($home_url);
$scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : 'https://';
$host   = $parsed_url['host'];

//「ホームURL」と「www. + ホスト名」の 2パターン許可する
$allowed_domains = [
  $scheme . $host . '/',
  $scheme . 'www.' . $host . '/'
];

// エラーページ
function error_page($title, $message)
{
  echo '<!DOCTYPE html>';
  echo '<html lang="ja">';
  echo '<head>';
  echo '<meta charset="UTF-8">';
  echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
  echo '<title>エラーページ | 久能カントリー倶楽部</title>';

  echo '<style>
          body.error-page {
              background-color: #ececec;
              color: #333;
              font-family: "Noto Serif JP", serif;
              text-align: center;
              padding: 0px 20px;
              min-height: 80vh;
              display: flex;
              flex-direction: column;
              justify-content: center;
              align-items: center;
          }
      
          body.error-page h1 {
              font-size: 30px;
              color: #03045E;
              margin-bottom: 20px;
          }
      
          body.error-page p {
              font-size: 18px;
              color: #333;
              line-height: 1.6;
              margin-bottom: 30px;
          }
      
          body.error-page a {
              display: inline-block;
              padding: 10px 20px;
              font-size: 16px;
              color: #fff;
              background-color: #03045E;
              border-radius: 5px;
              text-decoration: none;
              transition: background-color 0.3s ease;
          }
      
          body.error-page a:hover {
              background-color: #8b8b8b;
          }
      
          @media (max-width: 768px) {
              body.error-page h1 {
                  font-size: 24px;
              }
              body.error-page p {
                  font-size: 16px;
              }
              body.error-page a {
                  font-size: 14px;
                  padding: 8px 15px;
              }
          }
          </style>';

  echo '</head>';
  echo '<body class="error-page">';
  echo '<h1>' . $title . '</h1>';
  echo '<p>' . $message . '</p>';
  echo '<p><a href="javascript:history.back();">戻る</a></p>';
  echo '</body>';
  echo '</html>';
  exit();
}

// リファラチェック
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$valid_referer = false;
foreach ($allowed_domains as $domain) {
  if (strpos($referer, $domain) === 0) {
    $valid_referer = true;
    break;
  }
}
if (!$valid_referer) {
  error_page('不正な送信元ドメインです。', 'ページが正常に動作しませんでした。');
}

// トークン確認
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
  error_page('トークン不正な操作が行われました。', 'ページが正常に動作しませんでした。');
}

// POST確認
if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
  error_page('ポスト不正な操作が行われました。', 'ページが正常に動作しませんでした。');
}

// HTTPSチェック
if ($_SERVER['HTTPS'] !== 'on') {
  error_page('不正な送信元ドメインです。', 'ページが正常に動作しませんでした。');
}

// エスケープ関数
function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}


//設定==================================================================================================
//管理者アドレス
// $adm_mail = 'info@fujiheigen-gc.com';
$adm_mail = 'hp-order@create-golf.co.jp';

//入力者宛てメール 本文
//日時取得
date_default_timezone_set('Asia/Tokyo');

$text1 = '';
$text1 .= $_SESSION['formated_name_kanji'];
$text1 .= "様\n\n";
$text1 .= "この度はお問い合わせいただき、誠にありがとうございました。\n\n";
$text1 .= "このメールは、受付完了および入力内容のご確認のために\n送信しております。\n\n";
$text1 .= "[日時]：" . date("Y-m-d H:i") . "\n";
$text1 .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
$text1 .= "【氏名】" . $_SESSION['formated_name_kanji'] . "\n\n";
$text1 .= "【フリガナ】" . $_SESSION['formated_name_kana'] . "\n\n";
$text1 .= "【メールアドレス】" . $_SESSION['formated_mail'] . "\n\n";
$text1 .= "【電話番号】" . $_SESSION['formated_tel_number'] . "\n\n";
$text1 .= "【お問い合わせ内容】\n";
if ($_SESSION['formated_comment'] != '') {
  $text1 .= $_SESSION['formated_comment'] . "\n\n";
}
$text1 .= "【個人情報の取り扱い】" . $_SESSION['formated_agreement'] . "\n\n";
$text1 .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
$text1 .= "====================================================\n";
$text1 .= "久能カントリー倶楽部 \n\n";
$text1 .= "〒286-0203 千葉県富里市久能722 \n";
$text1 .= "　TEL：0476-93-9000 \n";
$text1 .= "　FAX：0476-92-5063 \n";
$text1 .= "====================================================\n";

//管理者宛てメール 本文	
$text2 = '';
$text2 .= "久能カントリー倶楽部　お問い合わせご担当者様\n\n";
$text2 .= "以下の内容でHPからお問い合わせがありました。\n\n";
$text2 .= "[日時]：" . date("Y-m-d H:i") . "\n";
$text2 .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
$text2 .= "【氏名】" . $_SESSION['formated_name_kanji'] . "\n\n";
$text2 .= "【フリガナ】" . $_SESSION['formated_name_kana'] . "\n\n";
$text2 .= "【メールアドレス】" . $_SESSION['formated_mail'] . "\n\n";
$text2 .= "【電話番号】" . $_SESSION['formated_tel_number'] . "\n\n";
$text2 .= "【お問い合わせ内容】\n";
if ($_SESSION['formated_comment'] != '') {
  $text2 .= $_SESSION['formated_comment'] . "\n\n";
}
$text2 .= "【個人情報の取り扱い】" . $_SESSION['formated_agreement'] . "\n\n";
$text2 .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

//入力者宛てメール 本文以外	
$title1 = '【久能カントリー倶楽部】お問い合わせのご確認';
$header1 = 'From:' . $adm_mail;
$text1 = h($text1, ENT_QUOTES, 'UTF-8');
mb_language('ja');
mb_internal_encoding('UTF-8');

//管理者宛てメール 本文以外	
$title2 = '【久能カントリー倶楽部】HPからお問い合わせがありました';
$header2 = 'From:' . $adm_mail;
$text2 = h($text2, ENT_QUOTES, 'UTF-8');
mb_language('ja');
mb_internal_encoding('UTF-8');

mb_send_mail($_SESSION['formated_mail'], $title1, $text1, $header1);
mb_send_mail($adm_mail, $title2, $text2, $header2);
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header changeArea">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Contact
        <span>- お問い合わせ -</span>
      </h1>
    </div>
  </div>

  <div class="c-column">
    <div class="c-form__bx">
      <span class="deco _01"><span></span></span>
      <div class="for_deco">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <p class="c-form__done">お問い合わせの送信が完了いたしました。</p>
      <p>この度は、お問い合わせいただきありがとうございます。<br>お問い合わせいただいた内容については、<br>ご確認の上、後日担当者がご連絡させていただきます。</p>
    </div>
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('')); ?>/contact/">お問い合わせ</a></li>
    </ul>
  </div>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>