  <?php
  /*
      Template Name: お問い合わせ-確認
      */
  ?>

  <?php
  session_cache_limiter('none');

  //セキュアフラグのないクッキーを防ぐ
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

  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: SAMEORIGIN');

  // XSSフィルタ機能を強制的に有効
  header("X-XSS-Protection: 1; mode=block");

  // sniffing防止
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


  // バリデーション
  $formated_name_kanji = preg_replace("/[^ぁ-んァ-ンーa-zA-Z一-龠\r]+/u", '', $_POST['name-kanji']);
  $formated_name_kana = preg_replace("/[^ァ-ンー\r]+/u", '', $_POST['name-kana']);
  $formated_tel_number = preg_replace("/[^0-9\r]+/u", '', $_POST['tel-number']);
  $formated_mail = preg_replace("/[^a-zA-Z0-9\-\@\.\_\r]+/u", '', $_POST['mail']);
  $formated_comment = preg_replace("/[^ぁ-んァ-ンーa-zA-Z0-9一-龠０-９,.、。?？()（）\r]+/u", '', $_POST['comment']);
  $formated_agreement = preg_replace("/[^ぁ-んァ-ン一-龠\r]+/u", '', $_POST['agreement']);

  // 必須が空の場合
  if ($formated_name_kanji == '' || $formated_name_kana == '' || $formated_tel_number == '' || $formated_mail == '' || $formated_comment == '' || $formated_agreement == '') {
    error_page('必須項目に入力されていない項目があります。', '一部の必須項目が未入力です。お手数ですが、戻ってご入力ください。');
  }

  ?>

  <?php
  // 確認ボタン押下時
  $_SESSION['formated_name_kanji'] = h($formated_name_kanji, ENT_QUOTES, 'UTF-8');
  $_SESSION['formated_name_kana'] = h($formated_name_kana, ENT_QUOTES, 'UTF-8');
  $_SESSION['formated_tel_number'] = h($formated_tel_number, ENT_QUOTES, 'UTF-8');
  $_SESSION['formated_mail'] = h($formated_mail, ENT_QUOTES, 'UTF-8');
  $_SESSION['formated_comment'] = h($formated_comment, ENT_QUOTES, 'UTF-8');
  $_SESSION['formated_agreement'] = h($formated_agreement, ENT_QUOTES, 'UTF-8');
  ?>



  <!--  header -->
  <?php get_header('120'); ?>
  <!--  header -->

  <main class="c-main">
    <div class="c-page-header changeArea">
      <div class="c-column c-page-header__inner">
        <h1 class="c-page-header__title _sub">Contact
          <span>- お問い合わせ -</span>
        </h1>
      </div>
    </div>

    <div class="c-column">
      <form action="<?php echo esc_url(home_url('contact/complete')); ?>" method="post" class="c-form">
        <div class="for_deco">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <p class="c-form__lead">お問い合わせの内容についてご確認ください。</p>
        <dl class="c-form__list">
          <dt>氏名</dt>
          <dd>
            <?php echo $_SESSION['formated_name_kanji']; ?>
          </dd>
        </dl>
        <dl class="c-form__list">
          <dt>フリガナ</dt>
          <dd>
            <?php echo $_SESSION['formated_name_kana']; ?>
          </dd>
        </dl>
        <dl class="c-form__list">
          <dt>電話番号</dt>
          <dd>
            <?php echo $_SESSION['formated_tel_number']; ?>
          </dd>
        </dl>
        <dl class="c-form__list">
          <dt>メールアドレス</dt>
          <dd>
            <?php echo $_SESSION['formated_mail']; ?>
          </dd>
        </dl>
        <dl class="c-form__list">
          <dt>お問い合わせ内容</dt>
          <dd>
            <?php echo $_SESSION['formated_comment'] ?>
          </dd>
        </dl>
        <dl class="c-form__list">
          <dt>プライバシーポリシー</dt>
          <dd>
            <?php echo $_SESSION['formated_agreement'] ?>
          </dd>
        </dl>
        <div class="c-form__ckbtn">
          <a href="javascript:void(0);" onclick="history.back()" class="c-form__ckbtn--back">入力画面へ戻る</a>
          <input type="hidden" name="token" value="<?php echo h($_POST['token'], ENT_QUOTES, 'UTF-8') ?>">
          <input type="submit" class="formbtn" name="check" value="送信する">
        </div>

      </form>
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