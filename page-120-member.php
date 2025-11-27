<?php
/*
  Template Name: 会員お知らせ
*/
?>

<?php get_header('120'); ?>

<?php
  // ▼ URL から news / member を判定する
  $uri = $_SERVER['REQUEST_URI'] ?? '';

  if (strpos($uri, '/member/') !== false) {
      $mode = 'member';
  } else {
      $mode = 'news';
  }
  ?>
<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>会員様お知らせ</span>
      </h1>
    </div>
  </div>

  <!-- 会員ナビ -->

  <!-- 共通メニュー -->
  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
    <!-- 共通メニュー -->

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>

        <?php
        /* ----------------------------------------
         * 対象カテゴリ
         * ---------------------------------------- */
        $category_slugs = ['member', 'kusunoki', 'information'];

        $tax_query = [
            [
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category_slugs,
                'operator' => 'IN',
            ]
        ];

        /* ----------------------------------------
         * 年別フィルタ（★追加）
         * ---------------------------------------- */
        $year = isset($_GET['year']) ? intval($_GET['year']) : null;

        /* ----------------------------------------
         * ページ番号（GET対応）
         * ---------------------------------------- */
        $paged = max(1, get_query_var('paged'));
        if (!$paged) {
            $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        }

        $posts_per_page = 10;

        /* ----------------------------------------
         * Sticky取得（1ページ目のみ）
         * ---------------------------------------- */
        $sticky_ids = [];
        $shown_ids  = [];

        if ($paged === 1) {
            $all_sticky = get_option('sticky_posts');

            if (!empty($all_sticky)) {
                $sticky_args = [
                    'post_type'      => 'post',
                    'post__in'       => $all_sticky,
                    'fields'         => 'ids',
                    'posts_per_page' => -1,
                    'tax_query'      => $tax_query,
                ];

                if ($year) {
                    $sticky_args['year'] = $year; // ★年フィルタ適用
                }

                $sticky_ids = get_posts($sticky_args);
                $sticky_ids = array_slice($sticky_ids, 0, $posts_per_page);
            }

            if ($sticky_ids) :
                $sticky_q = new WP_Query([
                    'post_type' => 'post',
                    'post__in'  => $sticky_ids,
                    'orderby'   => 'post__in',
                ]);

                echo '<ul class="news-box__list">';

                while ($sticky_q->have_posts()) :
                    $sticky_q->the_post();
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
                            }
                        ?>">
                        <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                        <?php the_title(); ?>
                        </a>
                    </li>
        <?php
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
        }

        /* ----------------------------------------
         * 通常記事
         * ---------------------------------------- */
        $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;

        $normal_args = [
            'post_type'           => 'post',
            'paged'               => $paged,
            'posts_per_page'      => $remain,
            'post__not_in'        => $shown_ids,
            'ignore_sticky_posts' => true,
            'tax_query'           => $tax_query,
        ];

        if ($year) {
            $normal_args['year'] = $year; // ★年フィルタ適用
        }

        $normal_q = new WP_Query($normal_args);
        ?>

        <ul class="news-box__list">
        <?php
          /* -------------------------------------------------
          * ① スラッグ（または親スラッグ）を取得
          * ------------------------------------------------*/
          global $post;
          $slug = $post->post_name;

          // 親ページがある場合は最上位の親スラッグへ
          $anc = get_post_ancestors($post->ID);
          if (! empty($anc)) {
              $top = end($anc);
              $slug = get_post_field('post_name', $top);
          }

          /* -------------------------------------------------
          * ② 大カテゴリ（news / member）を決定
          * ------------------------------------------------*/
          $mode = 'news'; // 初期値

          if ($slug === 'member') {
              $mode = 'member';
          }

          /* -------------------------------------------------
          * ③ tax_query（カテゴリ制限）
          * ------------------------------------------------*/
          if ($mode === 'news') {
              // newsページ → news だけ。member系は除外。
              $tax_query = [
                  'relation' => 'AND',
                  [
                      'taxonomy' => 'category',
                      'field'    => 'slug',
                      'terms'    => ['news'],
                      'operator' => 'IN',
                  ],
                  [
                      'taxonomy' => 'category',
                      'field'    => 'slug',
                      'terms'    => ['member', 'kusunoki', 'information'],
                      'operator' => 'NOT IN',
                  ],
              ];
          } else {
              // memberページ → member/kusunoki/information だけ。newsは除外。
              $tax_query = [
                  'relation' => 'AND',
                  [
                      'taxonomy' => 'category',
                      'field'    => 'slug',
                      'terms'    => ['member', 'kusunoki', 'information'],
                      'operator' => 'IN',
                  ],
                  [
                      'taxonomy' => 'category',
                      'field'    => 'slug',
                      'terms'    => ['news'],
                      'operator' => 'NOT IN',
                  ],
              ];
          }
          ?>

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
          $sticky_ids = [];
          $shown_ids  = [];

          if ($paged === 1) {

              $all_sticky = get_option('sticky_posts');
              if ($all_sticky) {

                  $sticky_ids = get_posts([
                      'post_type'      => 'post',
                      'post__in'       => $all_sticky,
                      'fields'         => 'ids',
                      'posts_per_page' => -1,
                      'year'           => $year,
                      'tax_query'      => $tax_query,
                  ]);

                  // 最大10件
                  $sticky_ids = array_slice($sticky_ids, 0, $posts_per_page);
              }

              if ($sticky_ids) :
                  $sticky_q = new WP_Query([
                      'post_type' => 'post',
                      'post__in'  => $sticky_ids,
                      'orderby'   => 'post__in',
                  ]);

                  while ($sticky_q->have_posts()) :
                      $sticky_q->the_post();
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
          * ② 通常記事
          * ------------------------------------------------*/
          $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;
          $remain = max(0, $remain);

          $normal_q = new WP_Query([
              'post_type'           => 'post',
              'paged'               => $paged,
              'posts_per_page'      => $remain,
              'post__not_in'        => $shown_ids,
              'ignore_sticky_posts' => true,
              'year'                => $year,
              'tax_query'           => $tax_query,
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

      <!-- ======================
          サイドバー（会員）
      ====================== -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>
        <div class="news-box__right--box">

          <?php
          // サイドバー：Archive リンク
          $all_years = fhg_get_all_years();  // 全年取得
          ?>
          <!-- 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <?php
                /* ----------------------------
                * 新着記事（5件）
                * スラッグが news なら news のみ
                * スラッグが member なら member/kusunoki/information のみ
                * ----------------------------*/
                $recent_tax_query = [];

                if ($mode === 'news') {
                    // newsページ → news のみ
                    $recent_tax_query = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['news'],
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['member', 'kusunoki', 'information'],
                            'operator' => 'NOT IN'
                        ],
                    ];
                } else {
                    // memberページ → member/kusunoki/information のみ
                    $recent_tax_query = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['member', 'kusunoki', 'information'],
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['news'],
                            'operator' => 'NOT IN'
                        ],
                    ];
                }

                $recent_q = new WP_Query([
                    'posts_per_page'      => 5,
                    'post_type'           => 'post',
                    'ignore_sticky_posts' => true,
                    'tax_query'           => $recent_tax_query
                ]);
                ?>
                <ul>
                <?php while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; wp_reset_postdata(); ?>
                </ul>
          </div>

          <!-- 年別アーカイブ -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
                
                  <?php
                  $all_years = fhg_get_all_years();
                  $years = [];

                  foreach ($all_years as $y):

                      if ($mode === 'news') {
                          // NEWS のみカウント（member / kusunoki / information は除外）
                          $count_posts = get_posts([
                              'post_type'      => 'post',
                              'posts_per_page' => -1,
                              'fields'         => 'ids',
                              'year'           => $y,
                              'tax_query'      => [
                                  'relation' => 'AND',
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['news'],
                                      'operator' => 'IN',
                                  ],
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['member', 'kusunoki', 'information'],
                                      'operator' => 'NOT IN',
                                  ],
                              ],
                          ]);
                      } else {
                          // MEMBER 系のみカウント（news は除外）
                          $count_posts = get_posts([
                              'post_type'      => 'post',
                              'posts_per_page' => -1,
                              'fields'         => 'ids',
                              'year'           => $y,
                              'tax_query'      => [
                                  'relation' => 'AND',
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['member', 'kusunoki', 'information'],
                                      'operator' => 'IN',
                                  ],
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['news'],
                                      'operator' => 'NOT IN',
                                  ],
                              ],
                          ]);
                      }

                      if (count($count_posts) > 0):
                          $years[$y] = count($count_posts);
                      endif;

                  endforeach;

                  foreach ($years as $y => $count): ?>
                    <li>
                        <a href="<?php echo esc_url( trailingslashit( home_url(
                            $mode === 'news'
                                ? "/news/{$y}/"
                                : "/member/{$y}/"
                        )) ); ?>">
                            <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                        </a>
                    </li>
                  <?php endforeach; ?>

                </ul>
          </div>

        </div>
      </div>
      <!-- /サイドバー -->

    </div>

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li>会員様お知らせ</li>
    </ul>

  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
