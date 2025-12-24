<?php
/*
 * カスタム投稿：member_post 年別アーカイブ
 * URL例：
 * /member/2025/
 * /member/information/2025/
 * /member/kusunoki/2025/
 */
?>

<?php
// 年・カテゴリ
$year   = (int) get_query_var('year');
$subcat = get_query_var('member_category') ?: 'member';

// subcat はホワイトリスト（変な値を弾く）
$allowed = ['member', 'information', 'kusunoki'];
if (!in_array($subcat, $allowed, true)) {
  $subcat = 'member';
}

// year が取れてない場合は 404 に落とす（0年表示防止）
if ($year <= 0) {
  global $wp_query;
  $wp_query->set_404();
  status_header(404);
  nocache_headers();
  // 404テンプレへ（テーマに合わせて）
  echo get_header('120');
  echo '<main class="c-member"><div class="c-column"><p>ページが見つかりません。</p></div></main>';
  echo get_footer('120');
  exit;
}

/* タイトル */
$label = '会員様お知らせ';
if ($subcat === 'information') $label = '営業案内';
if ($subcat === 'kusunoki')   $label = 'くすのき会';
?>

<?php
global $wp_query;

// このテンプレが呼ばれているのに 404 扱いのままなら解除（レイアウト崩れ防止）
if (is_404()) {
  $wp_query->is_404 = false;
  status_header(200);
}
?>

<?php get_header('120'); ?>

<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span><?php echo esc_html($label); ?></span>
      </h1>
    </div>
  </div>

  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>

  <div class="c-column">
    <div class="news-box">

      <!-- ============================= -->
      <!-- 左：年別一覧 -->
      <!-- ============================= -->
      <div class="news-box__left">

        <h2 class="c-head6"><?php echo esc_html($label); ?><span><?php echo $year; ?>年</span></h2>

        <ul class="news-box__list">
<?php
global $wp_query;
$q = $wp_query; // メインクエリを使用

if ($q->have_posts()):
  while ($q->have_posts()):
    $q->the_post();

    $news_file = get_field('news_file');
    $direct    = get_field('direct_link');
    $link_url  = get_field('link_url');

    if ($link_url) {
      $href = my_member_convert_url($link_url);
    } elseif ($news_file && $direct) {
      $href = knc_get_protected_acf_file_url($news_file);
    } else {
      $href = get_permalink();
    }
    ?>
    <li>
      <a href="<?php echo esc_url($href); ?>">
        <span class="news-box__time"><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
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


<ul class="c-pagenation">
    <?php custom_pagination($q); ?>
</ul>
      </div>



      <!-- ============================= -->
      <!-- 右：アーカイブエリア -->
      <!-- ============================= -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>

        <div class="news-box__right--box">

          <!-- ▼ 最近5件（保護リンク対応） -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
<?php
$recent_args = [
  'post_type'      => 'member_post',
  'posts_per_page' => 5,
  'ignore_sticky_posts' => true,
];

if ($subcat !== 'member') {
  $recent_args['tax_query'] = [[
      'taxonomy' => 'member_category',
      'field'    => 'slug',
      'terms'    => $subcat,
  ]];
}

$recent_q = new WP_Query($recent_args);

while ($recent_q->have_posts()):
    $recent_q->the_post();

    $news_file = get_field('news_file');
    $direct    = get_field('direct_link');
    $link_url  = get_field('link_url');

    if ($link_url) {
        $href = my_member_convert_url($link_url);

    } elseif ($news_file && $direct) {
        $href = knc_get_protected_acf_file_url($news_file);

    } else {
        $href = get_permalink();
    }
?>
              <li><a href="<?php echo esc_url($href); ?>"><?php the_title(); ?></a></li>
<?php endwhile; wp_reset_postdata(); ?>
            </ul>
          </div>

          <!-- ▼ 年別一覧 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">

<?php
global $wpdb;

$years = $wpdb->get_col("
    SELECT DISTINCT YEAR(post_date)
    FROM {$wpdb->posts}
    WHERE post_type = 'member_post'
      AND post_status = 'publish'
    ORDER BY YEAR(post_date) DESC
");

$base = '/member';
if ($subcat === 'information') $base = '/member/information';
if ($subcat === 'kusunoki')     $base = '/member/kusunoki';

foreach ($years as $y):

  $count_args = [
    'post_type' => 'member_post',
    'year'      => $y,
    'fields'    => 'ids',
    'posts_per_page' => -1,
  ];
  
  if ($subcat !== 'member') {
    $count_args['tax_query'] = [[
      'taxonomy' => 'member_category',
      'field'    => 'slug',
      'terms'    => $subcat,
    ]];
  }
  

    $count = count(get_posts($count_args));
    if ($count <= 0) continue;
?>
    <li>
      <a href="<?php echo esc_url(home_url("{$base}/{$y}/")); ?>">
            <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
        </a>
    </li>
<?php endforeach; ?>

            </ul>
          </div>

        </div>
      </div>

    </div>

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo home_url(); ?>">TOP</a></li>
      <li><a href="<?php echo home_url('/member/'); ?>">会員サイト</a></li>
      <li><?php echo $year; ?>年</li>
    </ul>
  </div>
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
