<?php
/*
  Template Name: ニュース
*/
?>

<?php get_header('120'); ?>

<main class="c-main">
  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">
        News <span>ニュース</span>
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
           * ① ニュース用カテゴリ制限（news のみ取得）
           * -------------------------------------------------*/
          $tax_query = [
            [
              'taxonomy' => 'category',
              'field'    => 'slug',
              'terms'    => ['news'],
            ],
          ];

          /* -------------------------------------------------
           * ② 基本設定
           * -------------------------------------------------*/
          $paged          = max(1, (int) get_query_var('paged'), (int) get_query_var('page')); // ★pageも見る
          $year           = (int) get_query_var('year');
          $posts_per_page = 10;

          /* -------------------------------------------------
           * 共通：リンク生成（直リンク/ファイル/通常）
           * -------------------------------------------------*/
          $make_href = function (): string {
            $news_file = get_field('news_file');
            $link_url  = get_field('link_url');
            $direct    = get_field('direct_link');

            if ($link_url) return esc_url($link_url);
            if ($news_file && $direct) return esc_url($news_file);
            return get_permalink();
          };

          /* -------------------------------------------------
           * ③ Sticky IDs（除外用）：毎ページ取得する（★重要）
           *   - WPの sticky_posts から、newsカテゴリのものだけ最大3件
           *   - 年別なら year で絞る
           *   - 表示は1ページ目のみ
           * -------------------------------------------------*/
          $shown_ids  = [];
          $sticky_ids = [];

          $all_sticky = (array) get_option('sticky_posts');
          if (!empty($all_sticky)) {

            $sticky_args = [
              'post_type'      => 'post',
              'post_status'    => 'publish',
              'post__in'       => $all_sticky,
              'fields'         => 'ids',
              'posts_per_page' => 3,
              'orderby'        => 'date',
              'order'          => 'DESC',
              'tax_query'      => $tax_query,
            ];
            if ($year) $sticky_args['year'] = $year;

            $sticky_ids = get_posts($sticky_args);
            $sticky_ids = array_slice((array) $sticky_ids, 0, 3);
          }

          /* -------------------------------------------------
           * ④ Sticky 表示（1ページ目のみ）
           * -------------------------------------------------*/
          if ($paged === 1 && !empty($sticky_ids)) {

            $sticky_q_args = [
              'post_type'     => 'post',
              'post_status'   => 'publish',
              'post__in'      => $sticky_ids,
              'orderby'       => 'post__in',
              'tax_query'     => $tax_query,
              'no_found_rows' => true,
            ];
            if ($year) $sticky_q_args['year'] = $year;

            $sticky_q = new WP_Query($sticky_q_args);

            while ($sticky_q->have_posts()) {
              $sticky_q->the_post();
              $shown_ids[] = get_the_ID();
              $href = $make_href();
              ?>
              <li class="is-sticky">
                <a href="<?php echo esc_url($href); ?>">
                  <span class="news-box__time"><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
                  <?php the_title(); ?>
                </a>
              </li>
              <?php
            }
            wp_reset_postdata();
          }

          /* -------------------------------------------------
           * ⑤ 通常記事（Sticky除外）
           *  - 1ページ目は「10 - sticky件数」
           *  - 2ページ目以降は offset を補正して “飛ばし/重複” を防ぐ
           * -------------------------------------------------*/
          $sticky_count_for_calc = min($posts_per_page, count($sticky_ids));  // 例：3
          $first_normal          = max(0, $posts_per_page - $sticky_count_for_calc); // 例：7

          if ($paged === 1) {
            $offset = 0;
            $limit  = $first_normal;
          } else {
            $offset = $first_normal + (($paged - 2) * $posts_per_page);
            $limit  = $posts_per_page;
          }
          $limit = max(0, (int) $limit);

          $exclude_ids = !empty($shown_ids) ? $shown_ids : $sticky_ids;

          $normal_args = [
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'offset'              => $offset,          // ★pagedではなくoffset
            'orderby'             => 'date',
            'order'               => 'DESC',
            'tax_query'           => $tax_query,
            'post__not_in'        => $exclude_ids,     // ★sticky除外（2ページ目以降にも効く）
            'ignore_sticky_posts' => true,
          ];
          if ($year) $normal_args['year'] = $year;

          $normal_q = new WP_Query($normal_args);

          if ($normal_q->have_posts()) {
            while ($normal_q->have_posts()) {
              $normal_q->the_post();
              $href = $make_href();
              ?>
              <li>
                <a href="<?php echo esc_url($href); ?>">
                  <span class="news-box__time"><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
                  <?php the_title(); ?>
                </a>
              </li>
              <?php
            }
          } else {
            if ($paged === 1 && empty($shown_ids)) {
              echo '<li>現在お知らせはありません。</li>';
            }
          }

          wp_reset_postdata();

          /* -------------------------------------------------
           * ⑥ ページネーション専用クエリ（総ページ数計算用）
           *  - “全件（sticky含む）” を 10件固定で計算（現状維持）
           * -------------------------------------------------*/
          $paging_args = [
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'tax_query'           => $tax_query,
            'ignore_sticky_posts' => true,
          ];
          if ($year) $paging_args['year'] = $year;

          $paging_q = new WP_Query($paging_args);
          ?>

        </ul>

        <!-- ページネーション -->
        <ul class="c-pagenation">
          <?php custom_pagination($paging_q); ?>
        </ul>

      </div><!-- /.news-box__left -->

      <!-- 右側サイドバー -->
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
                'post_type'           => 'post',
                'ignore_sticky_posts' => true,
                'tax_query'           => [
                  [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['news'],
                  ],
                ],
              ]);

              while ($recent_q->have_posts()) {
                $recent_q->the_post();
                $href = $make_href();
                ?>
                <li>
                  <a href="<?php echo esc_url($href); ?>">
                    <?php the_title(); ?>
                  </a>
                </li>
                <?php
              }
              wp_reset_postdata();
              ?>
            </ul>
          </div>

          <!-- 年度別 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
              <?php
              global $wpdb;
              $years = $wpdb->get_results("
                SELECT YEAR(post_date) AS y, COUNT(*) AS cnt
                FROM {$wpdb->posts} AS p
                INNER JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
                INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                WHERE p.post_type = 'post'
                  AND p.post_status = 'publish'
                  AND t.slug = 'news'
                GROUP BY YEAR(post_date)
                HAVING y IS NOT NULL
                ORDER BY y DESC
              ");

              foreach ($years as $row) :
                ?>
                <li>
                  <a href="<?php echo esc_url(home_url("/news/{$row->y}/")); ?>">
                    <?php echo esc_html($row->y); ?>年（<?php echo esc_html($row->cnt); ?>）
                  </a>
                </li>
                <?php
              endforeach;
              ?>
            </ul>
          </div>

        </div><!-- /.news-box__right--box -->

      </div><!-- /.news-box__right -->
    </div><!-- /.news-box -->

    <!-- パンくずリスト -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
      <li><a href="">ニュース一覧</a></li>
    </ul>

  </div><!-- /.c-column -->
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
