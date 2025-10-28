    <?php
      /*
      Template Name: サイトマップ
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
      <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/header/page-header7.jpg">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Sitemap
            <span>サイトマップ</span>
          </h1>
        </div>
      </div>

      <section class="_mtl">
        <div class="c-column-s">
          <h3 class="sitemap-home"><a href="<?php echo esc_url(home_url('')); ?>/">ホーム</a></h3>
          <div class="page-links">
            <div class="page-links-half">
              <!-- <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/club/">（要確認）当倶楽部について</a></h3>
              </section> -->
              <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/news/">ニュース</a></h3>
              </section>

              <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/course/">コース案内</a></h3>
              </section>

              <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/facility/">施設案内</a></h3>
              </section>

              <section>
                <h3 class="title-sitemap">ご利用案内</h3>
                <ul class="page-link">
                  <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-member">- プレー料金</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-twilight">- 練習場</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">- レストラン</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-rental">- ご予約について</a></li>
                </ul>
              </section>

            </div>

            <div class="page-links-half">

              <section>
                  <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a></h3>
              </section>

              <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/access/">アクセス</a></h3>
              </section>

              <section>
              <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/privacypolicy/">プライバシーポリシー</a></h3>
              </section>

              <!-- <section>
                <h3 class="title-sitemap"><a href="<?php echo esc_url(home_url('')); ?>/links/">リンク集</a></h3>
              </section> -->

              <section>
                <h3 class="title-sitemap"><a href="https://docs.google.com/forms/d/e/1FAIpQLSdGGDErtO1ZTQLWl9yCv5Vm7N-vBBwSTNbAtkpgTDZNk3up1g/viewform" target="_blank">お問い合わせ</a></h3>
              </section>

            </div>
          </div>

        </div>

      </section>
      <div class="c-column">
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
          <li><a href="">サイトマップ</a></li>
        </ul>
      </div>

    </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

    