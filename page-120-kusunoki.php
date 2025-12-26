<?php
/*
  Template Name: くすのき会お知らせ
*/
?>

<?php get_header('120'); ?>

<main>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>くすのき会</span>
      </h1>
    </div>
  </div>

  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>

  <section class="c-member">
  <span class="deco _01"><span></span></span>
  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

          <h2 class="c-head6">くすのき会お知らせ<span>Kusunoki News</span></h2>

          <ul class="news-box__list">

<?php
$year  = (int) get_query_var('year');
$paged = max(1, (int) get_query_var('paged'));
$per   = 10;

$tax_query_kusunoki = [
  [
    'taxonomy' => 'member_category',
    'field'    => 'slug',
    'terms'    => ['kusunoki'],
  ]
];

/* ---------------------------------
 * Sticky IDs を “確実に” 取る（kusunoki + _member_sticky=1）
 *  - 年別なら year で絞る
 *  - 最大3件
 * --------------------------------*/
$sticky_ids = get_posts([
  'post_type'      => 'member_post',
  'post_status'    => 'publish',
  'posts_per_page' => 3,
  'fields'         => 'ids',
  'orderby'        => 'date',
  'order'          => 'DESC',
  'meta_query'     => [[
    'key'     => '_member_sticky',
    'value'   => '1',
    'compare' => '=',
  ]],
  'tax_query'      => $tax_query_kusunoki,
  // 年別の時だけ絞る
  'year'           => $year ?: '',
]);

/* ---------------------------------
 * ページネーション用（総ページ数計算用）
 * ※ここは “通常一覧と同じ条件” でOK
 * --------------------------------*/
$paging_args = [
  'post_type'           => 'member_post',
  'posts_per_page'      => $per,
  'paged'               => $paged,
  'orderby'             => 'date',
  'order'               => 'DESC',
  'ignore_sticky_posts' => true,
  'tax_query'           => $tax_query_kusunoki,
];

if ($year) {
  $paging_args['year'] = $year;
}

$paging_q = new WP_Query($paging_args);

/* ---------------------------------
 * Sticky 表示（1ページ目のみ）
 * --------------------------------*/
$shown_ids = []; // 表示したID（念のため）

if ($paged === 1 && !empty($sticky_ids)) {

  $sticky_q = new WP_Query([
    'post_type'      => 'member_post',
    'post_status'    => 'publish',
    'post__in'       => $sticky_ids,
    'orderby'        => 'post__in',
    'tax_query'      => $tax_query_kusunoki,
    'no_found_rows'  => true,
  ]);

  while ($sticky_q->have_posts()) : $sticky_q->the_post();

    $shown_ids[] = get_the_ID();

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
    <li class="is-sticky">
      <a href="<?php echo esc_url($href); ?>">
        <span class="news-box__time"><?php echo esc_html(get_the_date('Y.m.d')); ?></span>
        <?php the_title(); ?>
      </a>
    </li>
<?php
  endwhile;
  wp_reset_postdata();
}

/* ---------------------------------
 * 通常記事
 * - 1ページ目は「10 - sticky件数」
 * - 2ページ目以降も sticky は必ず除外（重複防止）
 * --------------------------------*/
$remain = ($paged === 1) ? $per - count($sticky_ids) : $per;
$remain = max(0, $remain);

$normal_args = [
  'post_type'      => 'member_post',
  'post_status'    => 'publish',
  'posts_per_page' => $remain,
  'paged'          => $paged,
  'orderby'        => 'date',
  'order'          => 'DESC',
  'tax_query'      => $tax_query_kusunoki,
  // ★ sticky を必ず除外（ページ2以降に出てくるのを防ぐ）
  'post__not_in'   => $sticky_ids,
];

if ($year) {
  $normal_args['year'] = $year;
}

$normal_q = new WP_Query($normal_args);

if ($normal_q->have_posts()) :
  while ($normal_q->have_posts()) : $normal_q->the_post();

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

elseif ($paged === 1 && empty($sticky_ids)) :
  echo '<li>現在お知らせはありません。</li>';
endif;
wp_reset_postdata();
?>
          </ul>

        <ul class="c-pagenation">
          <?php if (!empty($paging_q)) custom_pagination($paging_q); ?>
        </ul>
        <?php wp_reset_postdata(); ?>

      </div><!-- /.left -->

      <!-- =============================
           サイドバー
      ============================= -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>
        <div class="news-box__right--box">

          <!-- 新着記事5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
<?php
$recent = new WP_Query([
  'post_type'      => 'member_post',
  'posts_per_page' => 5,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
  'tax_query'      => $tax_query_kusunoki,
]);

while ($recent->have_posts()) : $recent->the_post();

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

          <!-- 年別 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
<?php
global $wpdb;
$years = $wpdb->get_results("
  SELECT YEAR(p.post_date) AS y, COUNT(*) AS cnt
  FROM {$wpdb->posts} p
  INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
  INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
  INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
  WHERE p.post_type = 'member_post'
    AND p.post_status = 'publish'
    AND tt.taxonomy = 'member_category'
    AND t.slug = 'kusunoki'
  GROUP BY YEAR(p.post_date)
  ORDER BY y DESC
");

foreach ($years as $row) :
?>
  <li>
    <a href="<?php echo esc_url(home_url("/member/kusunoki/{$row->y}/")); ?>">
      <?php echo esc_html($row->y); ?>年（<?php echo esc_html($row->cnt); ?>）
    </a>
  </li>
<?php endforeach; ?>
            </ul>
          </div>
        </div><!-- /.right -->

      </div><!-- /.news-box -->

    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('/member/')); ?>">会員サイト</a></li>
      <li>くすのき会お知らせ</li>
    </ul>

  </div>
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>

</html>