    <?php
    /*
      Template Name: ニュース
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main">
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">News
            <span>ニュース</span>
          </h1>
        </div>
      </div>

      <div class="c-column">
        <h2 class="c-head6">記事一覧<span>News</span></h2>
        <div class="news-box">
          <div class="news-box__left">
          <ul class="news-box__list">
            <?php
            /* -------------------------------------------------
            * 基本設定
            * ------------------------------------------------*/
            $paged          = max(1, get_query_var('paged'));
            $year           = intval(get_query_var('year'));
            $posts_per_page = 10;

            /* -------------------------------------------------
            * ① Sticky（1ページ目限定）
            * ------------------------------------------------*/
            $sticky_ids  = [];
            $shown_ids   = [];

            if ($paged === 1) {

                // Sticky取得
                $all_sticky = get_option('sticky_posts');
                if ($all_sticky) {
                    $sticky_ids = get_posts([
                        'post_type'      => 'post',
                        'post__in'       => $all_sticky,
                        'category_name'  => 'news',
                        'fields'         => 'ids',
                        'posts_per_page' => -1,
                        'year'           => $year,
                    ]);

                    // 最大10件
                    $sticky_ids = array_slice($sticky_ids, 0, $posts_per_page);
                }

                // Sticky出力
                if ($sticky_ids) :
                    $sticky_q = new WP_Query([
                        'post_type' => 'post',
                        'post__in'  => $sticky_ids,
                        'orderby'   => 'post__in',
                    ]);

                    while ($sticky_q->have_posts()) : $sticky_q->the_post();
                        $shown_ids[] = get_the_ID();
            ?>
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
            * ② 通常ニュース
            * ------------------------------------------------*/
            $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;
            $remain = max(0, $remain);

            $normal_q = new WP_Query([
                'post_type'           => 'post',
                'paged'               => $paged,
                'posts_per_page'      => $remain,
                'category_name'       => 'news',
                'post__not_in'        => $shown_ids,
                'ignore_sticky_posts' => true,
                'year'                => $year,
            ]);

            if ($normal_q->have_posts()) :
                while ($normal_q->have_posts()) : $normal_q->the_post();
            ?>
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
            else :
                if (empty($shown_ids)) echo '<li>現在お知らせはありません。</li>';
            endif;
            wp_reset_postdata();
            ?>
            </ul>

            <!-- ページネーション -->
            <ul class="c-pagenation">
                <?php custom_pagination($normal_q); ?>
            </ul>
          </div>

          <?php
          // サイドバー：Archive リンク
          $all_years = fhg_get_all_years();  // 全年取得
          ?>
            <div class="news-box__right">
            <h3 class="c-head5">Archive</h3>
            <div class="news-box__right--box">

              <!-- 新着5件 -->
              <div class="recent-posts-box">
                <h3>新着記事</h3>
                <ul>
                  <?php
                  $recent_q = new WP_Query([
                    'posts_per_page'      => 5,
                    'category_name'       => 'news',
                    'ignore_sticky_posts' => true,
                  ]);
                  while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                  <?php endwhile; wp_reset_postdata(); ?>
                </ul>
              </div>

              <!-- 年度別 -->
              <div>
                <h3>年度別</h3>
                <ul class="news-box__right--list">
                  <?php
                  $all_years = fhg_get_all_years(); // 全年取得
                  $years = [];

                  // news カテゴリに投稿がある年だけ抽出
                  foreach ($all_years as $y) {
                      $count = count(get_posts([
                        'post_type'      => 'post',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'category_name'  => 'news',
                        'year'           => $y,
                      ]));
                      if ($count > 0) $years[$y] = $count;
                  }

                  foreach ($years as $y => $count) : ?>
                    <li>
                      <a href="<?php echo esc_url(home_url("/news/{$y}/")); ?>">
                        <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

            </div>
          </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="">ニュース一覧</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>