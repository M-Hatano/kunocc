<?php
/*
  Template Name: 会員お知らせ
*/
?>

<?php get_header('120'); ?>

<?php
/**
 * ACFファイルフィールドから安全な会員専用URLを取得
 */
function knc_get_protected_acf_file_url($acf_file) {

    if (!$acf_file) return '';

    // URLのみの場合
    if (is_string($acf_file)) {
        return my_member_convert_url($acf_file);
    }

    // ACF 配列
    if (is_array($acf_file)) {
        if (!empty($acf_file['url'])) {
            return my_member_convert_url($acf_file['url']);
        }
        if (!empty($acf_file['ID'])) {
            $url = wp_get_attachment_url($acf_file['ID']);
            return my_member_convert_url($url);
        }
    }

    // ID のみ
    if (is_numeric($acf_file)) {
        $url = wp_get_attachment_url($acf_file);
        return my_member_convert_url($url);
    }

    return '';
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

  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>

        <ul class="news-box__list">

<?php
/* ======================================================
 * 基本設定
 * ======================================================*/
$year   = get_query_var('year');
$paged  = max(1, get_query_var('paged'));
$per    = 10;

/* ======================================================
 * Sticky（最大3件）
 * ======================================================*/
$sticky_ids = [];
$shown_ids  = [];

if ($paged === 1) {

    $sticky_ids = get_member_sticky_ids();

    if (!empty($sticky_ids)) {

        $sticky_q = new WP_Query([
            'post_type' => 'member_post',
            'post__in'  => $sticky_ids,
            'orderby'   => 'post__in',
        ]);

        while ($sticky_q->have_posts()) : $sticky_q->the_post();

            $shown_ids[] = get_the_ID();

            /* ACFファイルを保護URL化 */
            $news_file = get_field('news_file');
            $direct    = get_field('direct_link');
            $link_url  = get_field('link_url');

            if ($link_url) {
                $href = $link_url;

            } elseif ($news_file && $direct) {
                $href = knc_get_protected_acf_file_url($news_file);

            } else {
                $href = get_permalink();
            }
?>
          <li class="is-sticky">
            <a href="<?php echo esc_url($href); ?>">
              <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
              <?php the_title(); ?>
            </a>
          </li>
<?php
        endwhile;
        wp_reset_postdata();
    }
}

/* ======================================================
 * 通常記事（Sticky を除外）
 * ======================================================*/
$remain = $paged === 1 ? $per - count($shown_ids) : $per;
$remain = max(0, $remain);

$normal_args = [
    'post_type'      => 'member_post',
    'posts_per_page' => $remain,
    'paged'          => $paged,
    'post__not_in'   => $shown_ids,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

if ($year) {
    $normal_args['year'] = $year;
}

$normal_q = new WP_Query($normal_args);

if ($normal_q->have_posts()) :
    while ($normal_q->have_posts()) : $normal_q->the_post();

        /* ACFファイルを保護URL化 */
        $news_file = get_field('news_file');
        $direct    = get_field('direct_link');
        $link_url  = get_field('link_url');

        if ($link_url) {
            $href = $link_url;

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

elseif (empty($shown_ids)) :
    echo '<li>現在お知らせはありません。</li>';
endif;

wp_reset_postdata();
?>

        </ul>

        <ul class="c-pagenation">
          <?php custom_pagination($normal_q); ?>
        </ul>

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
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

while ($recent->have_posts()) : $recent->the_post();

    $news_file = get_field('news_file');
    $direct    = get_field('direct_link');
    $link_url  = get_field('link_url');

    if ($link_url) {
        $href = $link_url;

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


          <!-- 年別 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">

<?php
global $wpdb;

$years = $wpdb->get_results("
    SELECT YEAR(post_date) AS y, COUNT(*) AS cnt
    FROM {$wpdb->posts}
    WHERE post_type='member_post'
      AND post_status='publish'
    GROUP BY YEAR(post_date)
    ORDER BY y DESC
");

foreach ($years as $row) :
?>
  <li>
    <a href="<?php echo esc_url(home_url("/member/{$row->y}/")); ?>">
      <?php echo esc_html($row->y); ?>年（<?php echo esc_html($row->cnt); ?>）
    </a>
  </li>
<?php endforeach; ?>

            </ul>
          </div>

        </div>
      </div><!-- /.right -->

    </div><!-- /.news-box -->

    <ul class="c-brd">
      <li><a href="<?php echo home_url('/'); ?>">TOP</a></li>
      <li>会員様お知らせ</li>
    </ul>

  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
