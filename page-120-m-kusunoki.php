    <?php
    /*
      Template Name: くすのき会お知らせ
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
            <span>くすのき会</span>
          </h1>
        </div>
      </div>
      <ul class="m-list">
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員様お知らせ</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-sales/">営業案内</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-kusunoki/">くすのき会</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-partner/">提携コース</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-calendar/">ビジター様料金</a></li>
        <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-registration/">コンペ申込</a></li>
      </ul>

      <div class="c-column">
        <div class="news-box">
          <div class="news-box__left">
            <h2 class="c-head6">くすのき会お知らせ<span>News</span></h2>
            <ul class="news-box__list">
              <?php
              /* -------------------------------------------------
            * 基本設定
            * ------------------------------------------------*/
              // ── 年度別ソート＆ページネーション用パラメータ取得 ──
              $paged          = max(1, get_query_var('paged'));
              $year           = intval(get_query_var('year'));  // ← 追加
              $posts_per_page = 10;


              /* -------------------------------------------------
            * ① Sticky（ニュースカテゴリ）1 ページ目限定
            * ------------------------------------------------*/
              $sticky_ids  = [];
              $shown_ids   = [];      // 表示済み ID を格納

              if ($paged === 1) {
                $all_sticky = get_option('sticky_posts');
                if ($all_sticky) {
                  $sticky_ids = get_posts([
                    'post_type'      => 'post',
                    'post__in'       => $all_sticky,
                    'category_name'  => 'news',
                    'fields'         => 'ids',
                    'posts_per_page' => -1,
                    'year'           => $year,        // ← 年度フィルタを追加
                  ]);
                  // Sticky が 10 件超なら先頭 10 件だけ表示
                  $sticky_ids = array_slice($sticky_ids, 0, $posts_per_page);
                }

                /* Sticky 出力 */
                if ($sticky_ids) :
                  $sticky_q = new WP_Query([
                    'post_type' => 'post',
                    'post__in'  => $sticky_ids,
                    'orderby'   => 'post__in',
                  ]);
                  while ($sticky_q->have_posts()) : $sticky_q->the_post();
                    $shown_ids[] = get_the_ID(); ?>
                    <li>
                      <a href="<?php
                                $news_file = get_field('news_file');
                                if (get_field('link_url')) {
                                  echo esc_url(get_field('link_url'));
                                } elseif ($news_file && get_field('direct_link')) {
                                  echo esc_url($news_file);
                                } else {
                                  the_permalink();
                                } ?>">
                        <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                        <?php the_title(); ?>
                      </a>
                    </li>
                  <?php
                  endwhile;
                  wp_reset_postdata();
                endif;
              }

              /* -------------------------------------------------
            * ② 通常ニュース記事（Sticky 除外）
            * ------------------------------------------------*/
              $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;
              $remain = max(0, $remain);   // マイナスにならないよう補正

              $normal_q = new WP_Query([
                'post_type'           => 'post',
                'paged'               => $paged,
                'posts_per_page'      => $remain,
                'category_name'       => 'news',
                'post__not_in'        => array_merge($shown_ids, $post__not_in ?? []),
                'ignore_sticky_posts' => true,
                'year'                => $year,     // ← 年度フィルタを追加
              ]);

              if ($normal_q->have_posts()) :
                while ($normal_q->have_posts()) : $normal_q->the_post(); ?>
                  <li>
                    <a href="<?php
                              $news_file = get_field('news_file');
                              if (get_field('link_url')) {
                                echo esc_url(get_field('link_url'));
                              } elseif ($news_file && get_field('direct_link')) {
                                echo esc_url($news_file);
                              } else {
                                the_permalink();
                              } ?>">
                      <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                      <?php the_title(); ?>
                    </a>
                  </li>
              <?php
                endwhile;
                wp_reset_postdata();
              elseif (empty($shown_ids)) :
                echo '<li>現在お知らせはありません。</li>';
              endif;

              /* -------------------------------------------------
            * ③ ニュース全件をカウント（ページネーション用）
            * ------------------------------------------------*/
              $count_q = new WP_Query([
                'post_type'           => 'post',
                'year'                => $year,        // ← 追加
                'posts_per_page'      => 1,
                'paged'               => $paged,
                'posts_per_page'      => 10,
                'category_name'       => 'news',
                'ignore_sticky_posts' => true,
                'fields'              => 'ids',
              ]);
              ?>
            </ul>

            <!-- ページネーション -->
            <ul class="c-pagenation">
              <?php custom_pagination($normal_q); ?> <!-- ← $normal_q を渡す -->
            </ul>
          </div>

          <?php
          // サイドバー：Archive リンク
          $years = fhg_get_news_years();  // news カテゴリ限定の年リスト
          if (! empty($years)) :
            $base = home_url('news'); // ベース URL
          ?>
            <div class="news-box__right">
              <h3 class="c-head5">Archive</h3>
              <div class="news-box__right--box">
                <!-- ★ ①ここから：新着記事ボックス -->
                <div class="recent-posts-box">
                  <h3>新着記事</h3>
                  <ul>
                    <?php
                    // テンプレートごとに大カテゴリを切り替えてください
                    $cat = 'news';
                    $recent_q = new WP_Query([
                      'posts_per_page'      => 5,
                      'category_name'       => $cat,
                      'ignore_sticky_posts' => true,
                    ]);
                    if ($recent_q->have_posts()):
                      while ($recent_q->have_posts()): $recent_q->the_post();
                    ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php
                      endwhile;
                      wp_reset_postdata();
                    endif;
                    ?>
                  </ul>
                </div>
                <!-- ★ ①ここまで：新着記事ボックス -->

                <div>
                  <h3>年度別</h3>
                  <ul class="news-box__right--list">
                    <?php foreach ($years as $y) :
                      // 各年の投稿数を取得
                      $count = count(get_posts([
                        'post_type'           => 'post',
                        'posts_per_page'      => -1,
                        'fields'              => 'ids',
                        'category_name'       => 'news',
                        'year'                => $y,
                        'ignore_sticky_posts' => true,
                      ]));
                    ?>
                      <li>
                        <a href="<?php echo esc_url("{$base}/{$y}/"); ?>">
                          <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php endif; ?>

        </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員サイト</a></li>
          <li><a href="">くすのき会</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>