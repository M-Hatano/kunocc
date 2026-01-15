<?php get_header('120'); ?>


  <!-- ====================
       ページヘッダー
  ==================== -->
  <main class="c-main">
  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">
        News <span>ニュース</span>
      </h1>
    </div>
  </div>



  <div class="c-column">

    <h2 class="c-head6">
      <?php echo esc_html(get_query_var('year')); ?>年の記事一覧
      <span>News</span>
    </h2>

    <div class="news-box">

      <!-- ====================
           左カラム（記事一覧）
      ==================== -->
      <div class="news-box__left">

        <ul class="news-box__list">
          <?php
          /* --------------------------------
           * 基本設定
           * -------------------------------- */
          $paged          = max(1, (int) get_query_var('paged'));
          $year           = (int) get_query_var('year');
          $posts_per_page = 10;

          /* --------------------------------
           * 共通 tax_query（news のみ）
           * -------------------------------- */
          $tax_query_news = [
            [
              'taxonomy' => 'category',
              'field'    => 'slug',
              'terms'    => ['news'],
            ],
          ];

          /* --------------------------------
           * ページネーション専用クエリ
           * Sticky を無視して総件数を管理
           * -------------------------------- */
          $paging_args = [
            'post_type'           => 'post',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
            'ignore_sticky_posts' => true,
            'tax_query'           => $tax_query_news,
          ];
          if ($year) {
            $paging_args['year'] = $year;
          }
          $paging_q = new WP_Query($paging_args);

          /* --------------------------------
           * 年別ページは「固定表示しない」方針のため
           * Sticky 処理は行わない（通常の投稿日順で表示）
           * -------------------------------- */
          $shown_ids = []; // 互換のため残す（空のまま）

          /* --------------------------------
           * 通常記事（Stickyも通常順で混ぜる）
           * -------------------------------- */
          $normal_args = [
            'post_type'           => 'post',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
            'ignore_sticky_posts' => true, // ★固定を無効化して通常順
            'tax_query'           => $tax_query_news,
          ];
          if ($year) {
            $normal_args['year'] = $year;
          }

          $normal_q = new WP_Query($normal_args);

          if ($normal_q->have_posts()) :
            while ($normal_q->have_posts()) :
              $normal_q->the_post();

              $news_file = get_field('news_file');
              if (get_field('link_url')) {
                $href = esc_url(get_field('link_url'));
              } elseif ($news_file && get_field('direct_link')) {
                $href = esc_url($news_file);
              } else {
                $href = get_permalink();
              }
          ?>
              <li>
                <a href="<?php echo $href; ?>">
                  <span class="news-box__time">
                    <?php echo esc_html(get_the_date('Y.m.d')); ?>
                  </span>
                  <?php the_title(); ?>
                </a>
              </li>
          <?php
            endwhile;
          else :
            echo '<li>現在お知らせはありません。</li>';
          endif;

          wp_reset_postdata();
          ?>
        </ul>

        <!-- ページネーション -->
        <ul class="c-pagenation">
          <?php custom_pagination($paging_q); ?>
        </ul>

      </div><!-- /.news-box__left -->

      <!-- ====================
           右カラム（Sidebar）
      ==================== -->
      <div class="news-box__right">

        <h3 class="c-head5">Archive</h3>

        <div class="news-box__right--box">

          <!-- 新着記事 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
              <?php
              $recent_q = new WP_Query([
                'posts_per_page'      => 5,
                'post_type'           => 'post',
                'ignore_sticky_posts' => true,
                'tax_query'           => $tax_query_news,
              ]);

              while ($recent_q->have_posts()) :
                $recent_q->the_post();

                $news_file = get_field('news_file');
                if (get_field('link_url')) {
                  $href = esc_url(get_field('link_url'));
                } elseif ($news_file && get_field('direct_link')) {
                  $href = esc_url($news_file);
                } else {
                  $href = get_permalink();
                }
              ?>
                <li>
                  <a href="<?php echo $href; ?>">
                    <?php the_title(); ?>
                  </a>
                </li>
              <?php endwhile;
              wp_reset_postdata(); ?>
            </ul>
          </div>

          <!-- 年度別 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
              <?php
              global $wpdb;

              $years = $wpdb->get_results("
                SELECT YEAR(p.post_date) AS y, COUNT(*) AS cnt
                FROM {$wpdb->posts} AS p
                INNER JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
                INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                WHERE p.post_type = 'post'
                  AND p.post_status = 'publish'
                  AND t.slug = 'news'
                GROUP BY YEAR(p.post_date)
                HAVING y IS NOT NULL
                ORDER BY y DESC
              ");

              foreach ($years as $row) :
              ?>
                <li>
                  <a href="<?php echo esc_url(home_url("/news/{$row->y}/")); ?>">
                    <?php echo esc_html($row->y); ?>年
                    （<?php echo esc_html($row->cnt); ?>）
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        </div><!-- /.news-box__right--box -->
      </div><!-- /.news-box__right -->

    </div><!-- /.news-box -->

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('/news/')); ?>">ニュース</a></li>
      <li><?php echo esc_html(get_query_var('year')); ?>年</li>
    </ul>

  </div><!-- /.c-column -->

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
