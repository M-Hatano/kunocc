<?php
/*
      Template Name: 一人予約
      */
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/solo/page-header.jpg">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Solo Reservation
        <span>一人予約</span>
      </h1>
    </div>
  </div>




  <section class="c-column _mtm">
    <h3 class="c-head3">一人でも気軽にラウンド！</h3>
    <p class="_mts c-tac">富士平原ゴルフクラブでは、<br class="c-brsp">お一人でも、<br>他の参加者とマッチングされ、<br class="c-brsp">気軽にラウンドにご参加いただけます。<br>もちろん、<br class="c-brsp">プレー当日までは匿名で安心。<br class="c-brsp">初めての方でもスムーズに<br class="c-brsp">ご利用いただけます。</p>
    <p class="_mts c-tac">ご予約は会員サイトより承っております。<br class="c-brsp">お気軽に登録し、ご利用ください。</p>
    <p class="_mtm c-tac"><a href="https://pp-web2.jp/calendars/fujiheigen/calendar?planType=soloRsvn" class="c-btn" target="_blank">会員サイトで予約</a></p>
    
  </section>



  <div class="c-column">
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
      <li><a href="https://pp-web2.jp/calendars/fujiheigen/calendar?planType=soloRsvn" target="_blank">一人予約</a></li>
    </ul>
  </div>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>