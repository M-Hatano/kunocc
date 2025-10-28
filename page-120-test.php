    <?php
      /*
      Template Name: 埋め込みテスト
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
      <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/header/page-header2.jpg">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Test
            <span>埋め込みテスト</span>
          </h1>
        </div>
      </div>

      <section class="_mtl">
          <div class="c-column-s">
            







          <div class="kwrbn-news">
            <h2>新着情報</h2>
            <?php
              $category_id = 4;
              $rss_url     = 'https://fujiheigen-gc.sakura.ne.jp/?feed=rss2&cat=' . $category_id;

              if ( $rss = @simplexml_load_file( $rss_url ) ) {
                  echo '<dl class="line">';
                  $max_items = 10;      // 最大表示件数
                  $count     = 0;
                  foreach ( $rss->channel->item as $item ) {
                      if ( $count >= $max_items ) {
                          break;         // 10件を超えたらループを終了
                      }
                      $date  = date( 'Y.n.j', strtotime( (string) $item->pubDate ) );
                      $link  = esc_url( (string) $item->link );
                      $title = esc_html( (string) $item->title );
                      printf(
                          '<dt>%s</dt><dd><a href="%s" target="_blank">%s</a></dd>',
                          $date,
                          $link,
                          $title
                      );
                      $count++;
                  }
                  echo '</dl>';
              } else {
                  echo '<p>フィードの取得に失敗しました。</p>';
              }
            ?>
            <p class="btn"><a href="https://fujiheigen-gc.sakura.ne.jp/kawaraban/">かわら版ニュース一覧へ</a></p>
            <style>
              .kwrbn-news .line{
                display: flex;
                flex-wrap:wrap;
              }
              .kwrbn-news .line dt{
                width:150px;
                margin-top:15px;
                font-weight:bold;
              }
              .kwrbn-news .line dd{
                width:calc(100% - 150px);
                margin-top:15px;
              }
              .kwrbn-news .btn {
                width:300px;
                height:50px;
                margin-top:30px;
              }
              .kwrbn-news .btn a{
                display: flex;
                align-items: center;
                justify-content: center;
                width:100%;
                height:100%;
                background:linear-gradient(90deg, #0077B6 0%, #00B4D8 100%);
                color:#fff;
                font-weight:bold;
              }
              @media screen and (max-width: 767px){
                .kwrbn-news .line dt{
                  width:100%;
                }
                .kwrbn-news .line dd{
                  width:100%;
                  margin-top:0;
                }
              }
            </style>
        </div>












          </div>
    </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

    