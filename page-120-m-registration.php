    <?php
    /*
      Template Name: コンペ申し込み
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-member">
      <span class="deco _01"><span></span></span>
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Member
            <span>コンペ申し込み</span>
          </h1>
        </div>
      </div>
      <ul class="m-list">
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員様お知らせ</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-sales/">営業案内</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-kusunoki/">くすのき会</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-partner/">提携コース</a></li>
        <li><a href="">ビジター様料金</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-registration/">コンペ申込</a></li>
      </ul>

      <div class="c-column">
        <h2 class="c-head6 m_head">コンペ申し込み<span>Registration</span></h2>
        <p>コンペのご予約については以下よりお送りください。</p>
        <div class="box-pat">
          <div class="apply">
            <p>お申込み方法</p>
          </div>

          <p>WEB上でご入力をされないお客様は、以下にご予約連絡フォーム（エクセル形式・PDF形式）をそれぞれご用意しております。</p>
          <ul>
            <li><a href="" target="_blank"><span>2025年 9月19日(金)</span>2025年秋季くすのき会会員懇親ゴルフコンペ</a></li>
            <li><a href="" target="_blank"><span>2026年 3月19日(木)</span>2026年春季くすのき会会員懇親ゴルフコンペ</a></li>
          </ul>

          <p class="regi_send">ご入力後のファイルは以下アドレス、またはFAXにて送信をお願いいたします。<br>（手書きで持参いただくことも可能です。）</p>

          <a href="mailto:info@kunocc.co.jp"><span></span>info@kunocc.co.jp</a>
        </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員サイト</a></li>
          <li><a href="">コンペ申し込み</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>