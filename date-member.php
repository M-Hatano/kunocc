<?php
/*
 * カスタム投稿：member_post 年別アーカイブ
 * URL例：
 * /member/2025/
 * /member/information/2025/
 * /member/kusunoki/2025/
 */

// 年
$year = (int) get_query_var('year');

// ページング
$paged = max(1, (int) get_query_var('paged'));

// サブカテゴリ（rewrite で member_category が入る想定）
$subcat = get_query_var('member_category');

// --------------------------------------------------
// フォールバック：URL から subcat 推定
// --------------------------------------------------
if (! $subcat && function_exists('knc_get_site_relative_path')) {
  $uri = knc_get_site_relative_path();
  if (preg_match('#^member/(information|kusunoki)/[0-9]{4}#', $uri, $m)) {
    $subcat = $m[1];
  }
}

$subcat = $subcat ?: 'member';

// ホワイトリスト
$allowed = ['member', 'information', 'kusunoki'];
if (! in_array($subcat, $allowed, true)) {
  $subcat = 'member';
}

// --------------------------------------------------
// year が不正な場合は 404
// --------------------------------------------------
if ($year <= 0) {
  global $wp_query;
  $wp_query->set_404();
  status_header(404);
  nocache_headers();

  get_header('120');
  echo '<main class="c-member"><div class="c-column"><p>ページが見つかりません。</p></div></main>';
  get_footer('120');
  exit;
}

// 表示ラベル
$label = '会員様お知らせ';
if ($subcat === 'information') $label = '営業案内';
if ($subcat === 'kusunoki')   $label = 'くすのき会';

// --------------------------------------------------
// taxonomy クエリ
// --------------------------------------------------
$tax_query_member = [
  [
    'taxonomy' => 'member_category',
    'field'    => 'slug',
    'terms'    => [$subcat],
  ],
];

// --------------------------------------------------
// 一覧クエリ
// --------------------------------------------------
$posts_per_page = 10;

$list_q = new WP_Query([
  'post_type'           => 'member_post',
  'posts_per_page'      => $posts_per_page,
  'paged'               => $paged,
  'year'                => $year,
  'ignore_sticky_posts' => true,
  'tax_query'           => $tax_query_member,
]);
?>

<?php get_header('120'); ?>



  <!-- ====================
       ページヘッダー
  ==================== -->
  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">
        Member
        <span><?php echo esc_html($label); ?></span>
      </h1>
    </div>
  </div>

  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>

  <section class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-column">
    <div class="news-box">

      <!-- ====================
           左：年別一覧
      ==================== -->
      <div class="news-box__left">
        <h2 class="c-head6">
          <?php echo esc_html($label); ?>
          <span><?php echo esc_html($year); ?>年</span>
        </h2>

        <ul class="news-box__list">
          <?php
          if ($list_q->have_posts()) :
            while ($list_q->have_posts()) :
              $list_q->the_post();

              $news_file = get_field('news_file');
              $direct    = get_field('direct_link');
              $link_url  = get_field('link_url');

              if ($link_url) {
                $href = function_exists('my_member_convert_url')
                  ? my_member_convert_url($link_url)
                  : $link_url;
              } elseif ($news_file && $direct) {
                $href = function_exists('knc_get_protected_acf_file_url')
                  ? knc_get_protected_acf_file_url($news_file)
                  : $news_file;
              } else {
                $href = get_permalink();
              }
          ?>
              <li>
                <a href="<?php echo esc_url($href); ?>">
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
          <?php custom_pagination($list_q); ?>
        </ul>
      </div>

      <!-- ====================
           右：アーカイブ
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
                'post_type'           => 'member_post',
                'posts_per_page'      => 5,
                'ignore_sticky_posts' => true,
                'tax_query'           => $tax_query_member,
              ]);

              while ($recent_q->have_posts()) :
                $recent_q->the_post();

                $news_file = get_field('news_file');
                $direct    = get_field('direct_link');
                $link_url  = get_field('link_url');

                if ($link_url) {
                  $href = function_exists('my_member_convert_url')
                    ? my_member_convert_url($link_url)
                    : $link_url;
                } elseif ($news_file && $direct) {
                  $href = function_exists('knc_get_protected_acf_file_url')
                    ? knc_get_protected_acf_file_url($news_file)
                    : $news_file;
                } else {
                  $href = get_permalink();
                }
              ?>
                <li>
                  <a href="<?php echo esc_url($href); ?>">
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

              $rows = $wpdb->get_results(
                $wpdb->prepare(
                  "
                  SELECT
                    YEAR(p.post_date) AS y,
                    COUNT(*) AS cnt
                  FROM {$wpdb->posts} p
                  INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                  INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                  INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
                  WHERE p.post_type = 'member_post'
                    AND p.post_status = 'publish'
                    AND tt.taxonomy = 'member_category'
                    AND t.slug = %s
                  GROUP BY YEAR(p.post_date)
                  ORDER BY y DESC
                  ",
                  $subcat
                )
              );

              $base = '/member';
              if ($subcat === 'information') $base = '/member/information';
              if ($subcat === 'kusunoki')   $base = '/member/kusunoki';

              if (! empty($rows)) :
                foreach ($rows as $r) :
                  $y   = (int) $r->y;
                  $cnt = (int) $r->cnt;
              ?>
                  <li>
                    <a href="<?php echo esc_url(home_url("{$base}/{$y}/")); ?>">
                      <?php echo esc_html($y); ?>年（<?php echo esc_html($cnt); ?>）
                    </a>
                  </li>
              <?php
                endforeach;
              endif;
              ?>
            </ul>
          </div>

        </div>
      </div>

    </div>

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('/member/')); ?>">会員サイト</a></li>
      <li><?php echo esc_html($year); ?>年</li>
    </ul>
  </div>
  </section>
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
