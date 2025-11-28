<?php
/*
 * Template Name: 会員ログイン画面
 */
?>

<?php get_header('120'); ?>

<main class="c-member">

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

  <div class="c-column">

    <h2 class="c-head6 m_head">会員ログイン<span>Member Login</span></h2>
    <p>会員専用ページにアクセスするにはログインしてください。</p>

    <?php
    // ◆ ログイン失敗時のメッセージ
    if (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
      <p style="color:red; font-weight:bold;">ログインID または パスワードが正しくありません。</p>
    <?php endif; ?>

    <?php
    // ◆ redirect_to の取得
    //   空のままだと WordPress が TOP に飛ばすため必ず補完する
    if (!empty($_GET['redirect_to'])) {
        // 外部URL判定を消すため raw を使用
        $redirect_to = esc_url_raw($_GET['redirect_to']);
    } else {
        // 直接ログインの場合は /member/
        $redirect_to = home_url('/member/');
    }

    // HTML の value に安全に入れる
    $redirect_to_attr = htmlspecialchars($redirect_to, ENT_QUOTES, 'UTF-8');
    ?>

    <div class="c-form box-pat">

        <form method="post" action="<?php echo esc_url( site_url('wp-login.php', 'login_post') ); ?>">

        <!-- redirect_to（必須） -->
        <input type="hidden" name="redirect_to" value="<?php echo $redirect_to_attr; ?>">

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

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
