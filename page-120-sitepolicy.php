    <?php
      /*
      Template Name: サイトポリシー
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
      <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/sitepolicy/page-header.jpg">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Sitepolicy
            <span>サイトポリシー</span>
          </h1>
        </div>
      </div>

      <section class="_mtl">
        <div class="c-column-s">
          <p>
          北の杜カントリー倶楽部ホームページ (以下「本ホームページ」) は、北の杜カントリー倶楽部(以下「当ゴルフ場」) が運営しています。<br>本ホームページのご利用に際しては、以下のご利用条件をお読みいただき、これらの条件にご同意の上ご利用ください。
          </p>
          <ul class="c-list">
            <li><span>※</span>なお、サイトポリシーおよび関連する規定類は、予告なく内容を変更させていただく場合がございますので、あらかじめご了承ください。</li>
          </ul>

          <h2 class="c-head3 _mtm">クッキー</h2>
          <p>
          本ホームページでは、より良いサービスを目的に「Cookie（クッキー）」と呼ばれる仕組みを利用したページがある事がございます。<br>それはお客様の個人情報を特定や収集を目的に行うものではなく、あくまでもWEBサービスの提供の為のみに利用されています。
          </p>

          <h2 class="c-head3 _mtm">SSL</h2>
          <p>
          本ホームページでは、WEB予約やWEB会員登録などお客さまの個人情報をお預かりする際、「SSL」という暗号化通信機能により保護しております。
          </p>

        </div>
      </section>

      <div class="c-column">
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
          <li><a href="">サイトポリシー</a></li>
        </ul>
      </div>

    </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

    