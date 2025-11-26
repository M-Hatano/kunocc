<?php
/*
  Template Name: 会員お知らせ（固定ページ版）
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

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>

        <ul class="news-box__list">

        <?php
        /* -------------------------------------------------
         * 取得カテゴリは「member + 子カテゴリ全部」
         * ------------------------------------------------*/
        $category_slugs = ['member', 'kusunoki', 'information'];

        $tax_query = [
            [
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category_slugs,
                'operator' => 'IN',
            ]
        ];

        /* -------------------------------------------------
         * 基本情報
         * ------------------------------------------------*/
        $paged          = max(1, get_query_var('paged'));
        $posts_per_page = 10;

        /* -------------------------------------------------
         * Sticky取得（1ページ目のみ）
         * ------------------------------------------------*/
        $sticky_ids = [];
        $shown_ids  = [];

        if ($paged === 1) {
            $all_sticky = get_option('sticky_posts');

            if (!empty($all_sticky)) {
                $sticky_ids = get_posts([
                    'post_type'      => 'post',
                    'post__in'       => $all_sticky,
                    'fields'         => 'ids',
                    'posts_per_page' => -1,
                    'tax_query'      => $tax_query,
                ]);

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
         * 通常記事
         * ------------------------------------------------*/
        $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;

        $normal_q = new WP_Query([
            'post_type'           => 'post',
            'paged'               => $paged,
            'posts_per_page'      => $remain,
            'post__not_in'        => $shown_ids,
            'ignore_sticky_posts' => true,
            'tax_query'           => $tax_query,
        ]);

        if ($normal_q->have_posts()):
            while ($normal_q->have_posts()): $normal_q->the_post();
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
        else:
            echo '<li>現在お知らせはありません。</li>';
        endif;

        wp_reset_postdata();
        ?>
        </ul>

        <!-- ページネーション -->
        <ul class="c-pagenation">
            <?php custom_pagination($normal_q); ?>
        </ul>

      </div>

      <!-- ▼ サイドバー（member専用） -->
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
                    'post_type'      => 'post',
                    'tax_query'      => [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => $category_slugs,
                            'operator' => 'IN',
                        ]
                    ]
                ]);

                while ($recent_q->have_posts()): $recent_q->the_post();
                ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            </div>

            <!-- 年度別 -->
            <div>
                <h3>年度別</h3>
                <ul class="news-box__right--list">
                <?php
                $years = fhg_get_all_years();
                foreach ($years as $y):
                    $count_posts = get_posts([
                        'post_type' => 'post',
                        'year'      => $y,
                        'fields'    => 'ids',
                        'posts_per_page' => -1,
                        'tax_query' => [
                            [
                                'taxonomy' => 'category',
                                'field'    => 'slug',
                                'terms'    => $category_slugs,
                                'operator' => 'IN',
                            ]
                        ]
                    ]);
                    if (!empty($count_posts)):
                ?>
                    <li>
                        <a href="<?php echo esc_url(home_url("/category/member/{$y}/")); ?>">
                            <?php echo $y; ?>年（<?php echo count($count_posts); ?>）
                        </a>
                    </li>
                <?php endif; endforeach; ?>
                </ul>
            </div>

        </div>
      </div>
      <!-- ▲ サイドバー -->

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