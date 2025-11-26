<?php
/**
 * Template for category: member
 * 年別フィルタ（?year=2025）対応版 + custom_pagination()使用
 */
?>

<?php get_header('120'); ?>

<main class="c-member">

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

        <?php
        /* -----------------------------------------
         * 年度フィルタ
         * ----------------------------------------- */
        $year = isset($_GET['year']) ? intval($_GET['year']) : null;

        /* -----------------------------------------
         * ページネーション
         * ----------------------------------------- */
        // paged は GET からも拾う（?paged=2 を有効化）
        $paged = get_query_var('paged');
        if (!$paged) {
            $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        }

        /* -----------------------------------------
         * カテゴリー
         * ----------------------------------------- */
        $cat = get_queried_object();
        $cat_slug = $cat->slug;

        /* -----------------------------------------
         * WP_Query
         * ----------------------------------------- */
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
            'paged'          => $paged,
            'category_name'  => $cat_slug,
            'ignore_sticky_posts' => true,
        ];

        if ($year) {
            $args['year'] = $year;
        }

        $q = new WP_Query($args);
        ?>

        <ul class="news-box__list">
        <?php
        if ($q->have_posts()) :
            while ($q->have_posts()) : $q->the_post();
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
            echo '<li>現在、お知らせはありません。</li>';
        endif;
        ?>
        </ul>

        <!-- ▼ ページネーション -->
        <ul class="c-pagenation">
            <?php custom_pagination($q); ?>
        </ul>

      </div>

      <!-- 右カラム：年度別リンク -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>
        <div class="news-box__right--box">

          <h3>年度別</h3>
          <ul class="news-box__right--list">
          <?php
            $years = fhg_get_all_years();
            foreach ($years as $y) :
          ?>
            <li>
              <a href="<?php echo esc_url(add_query_arg('year', $y, home_url("/category/{$cat_slug}/"))); ?>">
                <?php echo $y; ?>年
              </a>
            </li>
          <?php endforeach; ?>
          </ul>

        </div>
      </div>

    </div>
  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
