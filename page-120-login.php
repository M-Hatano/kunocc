<?php
/*
 * Template Name: 会員ログイン画面
 */
?>

<?php get_header('120'); ?>

<?php

$login_error = '';
if (isset($_GET['login']) && $_GET['login'] === 'failed') {
  $login_error = 'ログインID または パスワードが正しくありません。';
}

/*----------------------------------------
 * ▼ 2. redirect_to の初期設定
 ----------------------------------------*/
if (!empty($_GET['redirect_to'])) {
  $redirect_to = esc_url_raw($_GET['redirect_to']);
} else {
  $redirect_to = home_url('/member/');
}
?>

<main>

  <div class="for_deco">
    <span></span><span></span><span></span><span></span>
  </div>

  <!-- ページヘッダー -->
  <div class="c-page-header">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>会員ログイン</span>
      </h1>
    </div>
  </div>

  <section class="c-member">
    <div class="c-column">

      <p class="c-lead">会員専用ページにアクセスするにはログインしてください。</p>

      <?php if ($login_error): ?>
        <p style="color:red; font-weight:bold;text-align:center;margin:0 0 15px;"><?php echo esc_html($login_error); ?></p>
      <?php endif; ?>

      <div class="c-form box-pat _mtss">

        <form method="post">

          <!-- ▼ 独自ログイン処理フラグ -->
          <input type="hidden" name="member_login" value="1">

          <!-- ▼ ログイン後の遷移先 -->
          <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">

          <ul>
            <li>
              <label for="user_login">ログインID</label><br>
              <input type="text" id="user_login" name="log" required>
            </li>

            <li>
              <label for="user_pass">パスワード</label><br>
              <input type="password" id="user_pass" name="pwd" required>
            </li>
          </ul>

          <p><button type="submit">ログイン</button></p>
        </form>

      </div>

      <!-- パンくず -->
      <ul class="c-brd">
        <li><a href="<?php echo home_url(); ?>">TOP</a></li>
        <li>会員ログイン</li>
      </ul>

    </div>
  </section>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>

</html>