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
// -------------------------
// ① URL解析
// -------------------------
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri  = preg_replace('#^/[^/]+/[^/]+/#', '/', $uri); // /kunocc/cms/除去
$uri  = trim($uri, '/');
$parts = explode('/', $uri);

/* 初期値 */
$subcat = 'member';
$year   = 0;

if ($parts[0] === 'member') {

    if (isset($parts[1]) && is_numeric($parts[1])) {
        // /member/2025/
        $subcat = 'member';
        $year   = intval($parts[1]);

    } elseif (isset($parts[2]) && is_numeric($parts[2])) {
        // /member/kusunoki/2025/
        $subcat = $parts[1];
        $year   = intval($parts[2]);
    }
}

/* タイトル */
$label = '会員様お知らせ';
if ($subcat === 'information') $label = '営業案内';
if ($subcat === 'kusunoki')     $label = 'くすのき会';
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

  <!-- 共通メニュー -->
  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
  <!-- 共通メニュー -->

  <div class="c-column">
    <div class="news-box">

      <!-- ============================= -->
      <!-- 左：年別一覧 -->
      <!-- ============================= -->
      <div class="news-box__left">

        <h2 class="c-head6"><?php echo esc_html($label); ?><span><?php echo $year; ?>年</span></h2>

        <ul class="news-box__list">
<?php
/* ▼ WP_Query */
$paged = max(1, get_query_var('paged'));

$args = [
    'post_type'      => 'member_post',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'year'           => $year,
    'ignore_sticky_posts' => true,
];

/* カテゴリ指定 */
if ($subcat !== 'member') {
    $args['tax_query'] = [[
        'taxonomy' => 'member_category',
        'field'    => 'slug',
        'terms'    => $subcat,
    ]];
}

$q = new WP_Query($args);

/* ▼ リスト表示 */
if ($q->have_posts()):
  while ($q->have_posts()):
    $q->the_post();
?>
          <li>
            <a href="<?php the_permalink(); ?>">
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

          <!-- ▼ 最近5件 -->
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
?>
              <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; wp_reset_postdata(); ?>
            </ul>
          </div>


          <!-- ▼ 年別一覧（件数付き） -->
<div>
  <h3>年度別</h3>
  <ul class="news-box__right--list">

<?php
// member_post の公開年一覧を取得
global $wpdb;
$years = $wpdb->get_col("
    SELECT DISTINCT YEAR(post_date)
    FROM {$wpdb->posts}
    WHERE post_type = 'member_post'
      AND post_status = 'publish'
    ORDER BY YEAR(post_date) DESC
");

// ベースURL
$base = '/member';
if ($subcat === 'information') {
    $base = '/member/information';
} elseif ($subcat === 'kusunoki') {
    $base = '/member/kusunoki';
}

foreach ($years as $y):

    // 年度ごとの件数を取得
    $count_args = [
        'post_type'      => 'member_post',
        'fields'         => 'ids',
        'posts_per_page' => -1,
        'year'           => $y,
    ];

    // カテゴリ指定（member の場合は tax_query を付けない）
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
        <a href="<?php echo esc_url( site_url("{$base}/{$y}/") ); ?>">
            <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
        </a>
    </li>
<?php endforeach; ?>

  </ul>
</div>

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

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
