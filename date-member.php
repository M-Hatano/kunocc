<?php
/*
 * 会員お知らせ 年別アーカイブ用 date.php
 * 3カテゴリを自動判定して切り替える
 * - member
 * - information
 * - kusunoki
 */
?>

<?php
// -------------------------
// ① 遷移元URL / 現在のURLから大カテゴリを判定
// -------------------------

$uri = trim($_SERVER['REQUEST_URI'], '/');

// 初期値：member
$main_cat = 'member';
$main_title = '会員様お知らせ';
$base_slug = 'member';

if (strpos($uri, 'information') !== false) {
    $main_cat = 'information';
    $main_title = '営業案内';
    $base_slug = 'member/information';
}

if (strpos($uri, 'kusunoki') !== false) {
    $main_cat = 'kusunoki';
    $main_title = 'くすのき会';
    $base_slug = 'member/kusunoki';
}

// -------------------------
// ② 年取得
// -------------------------
$year = intval(get_query_var('year'));

// -------------------------
// ③ メインクエリ上書き（年度 × カテゴリ）
// -------------------------
add_action('pre_get_posts', function($query) use ($main_cat, $year){
    if (!is_admin() && $query->is_main_query()) {
        $query->set('post_type', 'post');
        $query->set('category_name', $main_cat);
        $query->set('year', $year);
        $query->set('posts_per_page', 10);
        $query->set('ignore_sticky_posts', true);
    }
});
?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-member">
      <span class="deco _01"><span></span></span>
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Member
            <span><?php echo esc_html($main_title); ?></span>
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
          <h2 class="c-head6"><?php echo esc_html($main_title); ?><span>Member</span></h2>
          <ul class="news-box__list">
          <?php
          /* -------------------------------------------------
          * 基本設定
          * ------------------------------------------------*/
          $paged          = max(1, get_query_var('paged'));
          $year           = intval(get_query_var('year'));
          $posts_per_page = 10;

          // この日付アーカイブのカテゴリ（member / information / kusunoki）
          $main_cat = $main_cat ?? 'member';

          /* -------------------------------------------------
          * ① Sticky：1ページ目だけ
          * ------------------------------------------------*/
          $sticky_ids = [];
          $shown_ids  = [];

          if ($paged === 1) {
              $all_sticky = get_option('sticky_posts');

              if (!empty($all_sticky)) {
                  $sticky_ids = get_posts([
                      'post_type'      => 'post',
                      'post__in'       => $all_sticky,
                      'category_name'  => $main_cat,   // ← ここを動的に!
                      'fields'         => 'ids',
                      'posts_per_page' => -1,
                      'year'           => $year,
                  ]);

                  // 上限10件
                  $sticky_ids = array_slice($sticky_ids, 0, $posts_per_page);
              }

              /* Sticky の出力 */
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
                  wp_reset_postdata();
              endif;
          }

          /* -------------------------------------------------
          * ② 通常記事（Sticky除外）
          * ------------------------------------------------*/
          $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;
          $remain = max(0, $remain);

          $normal_q = new WP_Query([
              'post_type'           => 'post',
              'paged'               => $paged,
              'posts_per_page'      => $remain,
              'category_name'       => $main_cat,      // ← 動的カテゴリ
              'post__not_in'        => $shown_ids,
              'ignore_sticky_posts' => true,
              'year'                => $year,
          ]);

          if ($normal_q->have_posts()) :
              while ($normal_q->have_posts()) : $normal_q->the_post();
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
              wp_reset_postdata();
          elseif (empty($shown_ids)) :
              echo '<li>現在お知らせはありません。</li>';
          endif;

          /* -------------------------------------------------
          * ③ 全件カウント（ページネーション用）
          * ------------------------------------------------*/
          $count_q = new WP_Query([
              'post_type'      => 'post',
              'fields'         => 'ids',
              'category_name'  => $main_cat,   // ← 動的
              'year'           => $year,
              'posts_per_page' => -1,
          ]);
          ?>
          </ul>

          <!-- ページネーション -->
          <ul class="c-pagenation">
              <?php custom_pagination($normal_q); ?>
          </ul>
        </div>

          <!-- ========== サイドバー ========== -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>

        <div class="news-box__right--box">

          <!-- 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
              <?php
              $recent_q = new WP_Query([
                'posts_per_page' => 5,
                'category_name'  => $main_cat,
                'ignore_sticky_posts' => true
              ]);
              while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_postdata(); ?>
            </ul>
          </div>

              <!-- 年別アーカイブ -->
                <div>
                  <h3>年度別</h3>
                  <ul class="news-box__right--list">
                    <?php
                    $years = fhg_get_all_years();
                    foreach ($years as $y):
                        $count = count(get_posts([
                          'post_type'      => 'post',
                          'fields'         => 'ids',
                          'category_name'  => $main_cat,
                          'year'           => $y
                        ]));
                        if ($count == 0) continue;
                    ?>
                      <li>
                        <a href="<?php echo home_url("/{$base_slug}/{$y}/"); ?>">
                          <?php echo $y; ?>年（<?php echo $count; ?>）
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
          <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員サイト</a></li>
          <li><a href=""><?php echo esc_html($year); ?>年</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>