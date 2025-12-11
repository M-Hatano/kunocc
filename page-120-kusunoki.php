<?php
/*
  Template Name: くすのき会お知らせ
*/
?>

<?php get_header('120'); ?>

<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>くすのき会</span>
      </h1>
    </div>
  </div>

  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>

  <div class="c-column">
    <div class="news-box">

      <!-- ======================
           左カラム：一覧
      ====================== -->
      <div class="news-box__left">

        <h2 class="c-head6">くすのき会お知らせ<span>Kusunoki News</span></h2>

        <ul class="news-box__list">

<?php
$paged = max(1, get_query_var('paged'));
$year  = intval(get_query_var('year'));
$per   = 10;

/* -----------------------------
 * くすのき会専用一覧
 * ---------------------------- */
$args = [
    'post_type'      => 'member_post',
    'posts_per_page' => $per,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [
        [
            'taxonomy' => 'member_category',
            'field'    => 'slug',
            'terms'    => 'kusunoki',
        ]
    ],
];

if ($year) {
    $args['year'] = $year;
}

$q = new WP_Query($args);

if ($q->have_posts()):
    while ($q->have_posts()):
        $q->the_post();

        $news_file = get_field('news_file');
        $direct    = get_field('direct_link');
        $link_url  = get_field('link_url');

        /* ------------------------------
         * URL 優先順位（安全版）
         * ① 直リンク link_url（保護URL変換）
         * ② news_file（保護URL変換）
         * ③ 投稿ページ permalink
         * ------------------------------ */
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

      </div><!-- /.left -->

      <!-- ======================
           右カラム：サイドバー
      ====================== -->
      <div class="news-box__right">

        <h3 class="c-head5">Archive</h3>
        <div class="news-box__right--box">

          <!-- 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
<?php
$recent = new WP_Query([
    'post_type'      => 'member_post',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [
        [
            'taxonomy' => 'member_category',
            'field'    => 'slug',
            'terms'    => 'kusunoki',
        ]
    ]
]);

while ($recent->have_posts()):
    $recent->the_post();

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
<?php endwhile;
wp_reset_postdata(); ?>
            </ul>
          </div>


          <!-- 年度別アーカイブ -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">

<?php
global $wpdb;

$years = $wpdb->get_col("
    SELECT DISTINCT YEAR(p.post_date)
    FROM {$wpdb->posts} p
    JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
    JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->terms} t ON t.term_id = tt.term_id
    WHERE p.post_type = 'member_post'
      AND p.post_status = 'publish'
      AND tt.taxonomy = 'member_category'
      AND t.slug = 'kusunoki'
    ORDER BY YEAR(p.post_date) DESC
");

foreach ($years as $y):

    $count = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*)
        FROM {$wpdb->posts} p
        JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
        JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN {$wpdb->terms} t ON t.term_id = tt.term_id
        WHERE p.post_type = 'member_post'
          AND p.post_status = 'publish'
          AND YEAR(p.post_date) = %d
          AND tt.taxonomy = 'member_category'
          AND t.slug = 'kusunoki'
    ", $y));

    if ($count > 0):
?>
  <li>
    <a href="<?php echo esc_url(home_url("/member/kusunoki/{$y}/")); ?>">
      <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
    </a>
  </li>
<?php
    endif;

endforeach;
?>
            </ul>
          </div>

        </div>
      </div><!-- /.right -->

    </div><!-- /.news-box -->


    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo home_url('/'); ?>">TOP</a></li>
      <li><a href="<?php echo home_url('/member/'); ?>">会員サイト</a></li>
      <li>くすのき会お知らせ</li>
    </ul>

  </div><!-- /.c-column -->
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
