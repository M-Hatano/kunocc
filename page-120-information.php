    <?php
    /*
      Template Name: 会員営業案内
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
            <span>営業案内</span>
          </h1>
        </div>
      </div>

      <!-- 共通メニュー -->
      <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
      <!-- 共通メニュー -->

      <div class="c-column">
        <div class="news-box">
          <div class="news-box__left">
            <h2 class="c-head6">営業案内<span>News</span></h2>
            <ul class="news-box__list">
            <?php
        /*
         * 基本設定
         */
        $paged = max(1, get_query_var('paged'));
        $year  = intval(get_query_var('year'));
        $ppp   = 10;

        /*
         * 営業案内一覧 → カテゴリ information のみ取得
         */
        $kusunoki_q = new WP_Query([
          'post_type'           => 'post',
          'posts_per_page'      => $ppp,
          'paged'               => $paged,
          'category_name'       => 'information',
          'year'                => $year,
          'ignore_sticky_posts' => true,
        ]);

        if ($kusunoki_q->have_posts()):
          while ($kusunoki_q->have_posts()):
            $kusunoki_q->the_post();
        ?>
          <li>
            <a href="<?php
              $file = get_field('news_file');
              if (get_field('link_url')) {
                echo esc_url(get_field('link_url'));
              } elseif ($file && get_field('direct_link')) {
                echo esc_url($file);
              } else {
                the_permalink();
              }
            ?>">
              <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
              <?php the_title(); ?>
            </a>
          </li>
        <?php
          endwhile;
        else:
          echo '<li>現在お知らせはありません。</li>';
        endif;

        wp_reset_postdata();
        ?>

        </ul>

            <!-- ページネーション -->
            <ul class="c-pagenation">
              <?php custom_pagination($kusunoki_q); ?>
            </ul>
          </div>

          <?php
          // サイドバー：Archive リンク
          $years = fhg_get_all_years();  // 全年取得
          $base = home_url('member/information');  // 営業案内のベースURL
          ?>
            <div class="news-box__right">
              <h3 class="c-head5">Archive</h3>
              <div class="news-box__right--box">
                <div class="recent-posts-box">
                  <h3>新着記事</h3>
                  <ul>
                    <?php
                    $recent_q = new WP_Query([
                      'posts_per_page'      => 5,
                      'category_name'       => 'information',
                      'ignore_sticky_posts' => true,
                    ]);

                    while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                  </ul>
                </div>
                <!-- ★ ①ここまで：新着記事ボックス -->

                <div>
                  <h3>年度別</h3>
                  <ul class="news-box__right--list">
                    <?php foreach ($years as $y):
                      $count = count(get_posts([
                        'post_type'      => 'post',
                        'fields'         => 'ids',
                        'category_name'  => 'information',
                        'year'           => $y,
                        'posts_per_page' => -1,
                      ]));

                      if ($count <= 0) continue;
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
        </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="<?php echo esc_url(home_url('')); ?>/member/">会員サイト</a></li>
          <li><a href="">営業案内</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>