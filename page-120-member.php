<?php
/*
  Template Name: 会員お知らせ
*/
?>

<?php get_header('120'); ?>

<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>会員様お知らせ</span>
      </h1>
    </div>
  </div>

  <!-- 共通メニュー -->
  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
  <!-- 共通メニュー -->

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>
        <ul class="news-box__list">

<?php
/* ======================================================
 * ① 年の取得（year は rewrite でセットされている）
 * ====================================================== */
$year  = get_query_var('year');
$paged = max(1, get_query_var('paged'));

$args = [
    'post_type'      => 'member_post',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

/* 年別フィルタ */
if ($year) {
    $args['year'] = $year;
}

$query = new WP_Query($args);

/* ======================================================
 * ② 一覧ループ
 * ====================================================== */
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();

        // ACF のリンク判定
        $news_file = get_field('news_file');
        $direct    = get_field('direct_link');
        $link_url  = get_field('link_url');

        if ($link_url) {
            $href = $link_url;
        } elseif ($news_file && $direct) {
            $href = $news_file;
        } else {
            $href = get_permalink();
        }
?>
        <li>
          <a href="<?php echo esc_url($href); ?>">
            <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
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

        <!-- ▼ ページネーション -->
        <ul class="c-pagenation">
            <?php custom_pagination($query); ?>
        </ul>

      </div><!-- /.left -->

      <!-- ================================
            サイドバー（会員）
      ================================ -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>
        <div class="news-box__right--box">

          <!-- ▼ 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
<?php
$recent = new WP_Query([
    'post_type'      => 'member_post',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

while ($recent->have_posts()) : $recent->the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;
wp_reset_postdata();
?>
            </ul>
          </div>

          <!-- ▼ 年別アーカイブ -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
<?php
// member_post の公開年を取得
global $wpdb;
$years = $wpdb->get_col("
    SELECT DISTINCT YEAR(post_date)
    FROM {$wpdb->posts}
    WHERE post_type = 'member_post'
      AND post_status = 'publish'
    ORDER BY YEAR(post_date) DESC
");

foreach ($years as $y) : ?>
    <li>
      <a href="<?php echo esc_url(home_url("/member/{$y}/")); ?>">
        <?php echo esc_html($y); ?>年
      </a>
    </li>
<?php endforeach; ?>
            </ul>
          </div>

        </div>
      </div><!-- /.right -->

    </div><!-- /.news-box -->

    <!-- ▼ パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo home_url('/'); ?>">TOP</a></li>
      <li>会員様お知らせ</li>
    </ul>

  </div><!-- /.c-column -->

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
