      <?php get_header('120'); ?>

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/errorpage/page-header.jpg">
          <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">404 ERROR
              <span>ページが見つかりません。</span>
            </h1>
          </div>
        </div>

        <section class="_mtl">
          <div class="c-column-s">
            <?php 
              $http = is_ssl() ? 'https://' : 'http://';
              $url = esc_html($http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            ?>
            <p>入力されたURL：<span> <?php echo $url; ?> </span></p>
            <p>指定されたページまたはファイルは、一時的にアクセス出来ない状態か、<br>削除または別の場所に移動した可能性があります。</p>
            <p>ブックマークを登録されている場合は、お手数ですが設定の変更をお願いいたします。</p>

          </div>
        </section>

        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="">ページが見つかりません。</a></li>
          </ul>
        </div>
       
        </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

      <?php wp_footer(); ?>

    </body>

    </html>