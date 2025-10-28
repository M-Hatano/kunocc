
    <?php
      /*
      Template Name: お問い合わせ
      */
      ?>

      <?php
      // キャッシュ無効化
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
        $home_url = rtrim(get_home_url(), '/').'/';

        $parsed_url = parse_url($home_url);
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : 'https://';
        $host   = $parsed_url['host'];

        //「ホームURL」と「www. + ホスト名」の 2パターン許可する
        $allowed_domains = [
            $scheme . $host . '/',
            $scheme . 'www.' . $host . '/'
        ];

        // エラーページ
        function error_page($title, $message) {
          echo '<!DOCTYPE html>';
          echo '<html lang="ja">';
          echo '<head>';
          echo '<meta charset="UTF-8">';
          echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
          echo '<title>エラーページ | 富士平原ゴルフクラブ</title>';
          
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

        // HTTPSチェック
        if ($_SERVER['HTTPS'] !== 'on') {
          error_page('不正な送信元ドメインです。', 'ページが正常に動作しませんでした。');
        }

        //トークン生成
        $token = sha1(uniqid(mt_rand(), true));
        $_SESSION['token'] = $token;
        
        //エスケープ
        function h($s){
            return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
        }
      ?>



      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header changeArea" style="background: url(<?php echo get_template_directory_uri(); ?>/img/contact/page-header.jpg) center / cover no-repeat;">
          <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">Contact
              <span>- お問い合わせ -</span>
            </h1>
          </div>
        </div>

        <div class="c-column-s">
          <p class="c-form__lead">お問い合わせ内容について、以下の入力フォームからお問い合わせください。</p>
          <form action="<?php echo esc_url(home_url('contact/confirm')); ?>" method="post" class="c-form">
            <dl class="c-form__list">
              <dt>氏名<span class="c-form__required">必須</span></dt>
              <dd>
                <input type="text" name="name-kanji" placeholder="富士 花子">
              </dd>
            </dl>
            <dl class="c-form__list">
              <dt>フリガナ<span class="c-form__required">必須</span></dt>
              <dd>
                <input type="text" name="name-kana" placeholder="フジ ハナコ">
              </dd>
            </dl>
            <dl class="c-form__list">
              <dt>電話番号<span class="c-form__required">必須</span></dt>
              <dd>
                <input type="tel" name="tel-number" placeholder="00000000000">
              </dd>
            </dl>
            <dl class="c-form__list">
              <dt>メールアドレス<span class="c-form__required">必須</span></dt>
              <dd>
                <input type="email" name="mail" placeholder="example.fujiheigen-gc.com">
              </dd>
            </dl>
            <dl class="c-form__list">
              <dt>お問い合わせ内容<span class="c-form__required">必須</span></dt>
              <dd>
                <textarea name="comment" id="" cols="30" rows="10"></textarea>
              </dd>
            </dl>

            <div class="c-form__ckbox">
              <p class="c-form__bttxt"><a href="<?php echo esc_url(home_url('')); ?>/privacy/" target="_blank">プライバシーポリシー</a>をお読みいただき、ご同意頂ける場合は以下の<br class="c-brpc">「個人情報の取り扱いに同意する」ボタンにチェックを入れてください。</p>
              <div class="checkbox-area">
                <p><label><input type="checkbox" class="checkboxbtn">個人情報の取り扱いに同意する</label></p>
                <input type="hidden" name="agreement" value="個人情報の取り扱いに同意する">
              </div>
            </div>

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="c-form__ckbtn">
              <input type="submit" class="formbtn" name="check" value="入力内容を確認する" disabled="disabled">
            </div>

          </form>
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="/">お問い合わせ</a></li>
          </ul>
        </div>
              
        </main>
              
              <!--  フッタ読込 -->
              <?php get_footer('120'); ?>
                <!--  フッタ読込 -->

                  <?php wp_footer(); ?>

                </body>

        </html>