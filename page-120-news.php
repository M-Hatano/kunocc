<?php
/*
  Template Name: ニュース
*/
?>

<?php get_header('120'); ?>

<main class="c-main">
    <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">
                News <span>ニュース</span>
            </h1>
        </div>
    </div>

    <div class="c-column">

        <h2 class="c-head6">記事一覧<span>News</span></h2>

        <div class="news-box">
            <div class="news-box__left">

                <ul class="news-box__list">

                    <?php
                    /* -------------------------------------------------
                    * ① ニュース用カテゴリ制限（news のみ取得）
                    * -------------------------------------------------*/
                    $tax_query = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['news'],
                        ],
                    ];

                    /* -------------------------------------------------
                     * ② 基本設定
                     * -------------------------------------------------*/
                    $paged          = max(1, get_query_var('paged'));
                    $year           = intval(get_query_var('year'));
                    $posts_per_page = 10;

                    /* -------------------------------------------------
                     * ③ Sticky（1ページ目は最大3件まで）
                     * -------------------------------------------------*/
                    $sticky_ids = [];
                    $shown_ids  = [];

                    if ($paged === 1) {

                        $all_sticky = get_option('sticky_posts');

                        if ($all_sticky) {

                            // Sticky の中から news カテゴリーのみ取得（最大3件）
                            $sticky_ids = get_posts([
                                'post_type'      => 'post',
                                'post__in'       => $all_sticky,
                                'fields'         => 'ids',
                                'posts_per_page' => 3,
                                'year'           => $year,
                                'tax_query'      => $tax_query,
                            ]);

                            // 念のため3件に固定
                            $sticky_ids = array_slice($sticky_ids, 0, 3);
                        }

                        if (!empty($sticky_ids)) :

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
                                        } ?>">
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
                     * ④ 通常記事（sticky を除外）
                     * -------------------------------------------------*/
                    $remain = ($paged === 1) ? $posts_per_page - count($shown_ids) : $posts_per_page;
                    $remain = max(0, $remain);

                    $normal_q = new WP_Query([
                        'post_type'           => 'post',
                        'paged'               => $paged,
                        'posts_per_page'      => $remain,
                        'post__not_in'        => $shown_ids,
                        'ignore_sticky_posts' => true,
                        'year'                => $year,
                        'tax_query'           => $tax_query,
                    ]);

                     /* -------------------------------------------------
                    * ⑤ ページネーション専用クエリ（★追加）
                    * -------------------------------------------------*/
                    $paging_q = new WP_Query([
                        'post_type'           => 'post',
                        'posts_per_page'      => $posts_per_page, // ★ 常に10固定
                        'paged'               => $paged,
                        'ignore_sticky_posts' => true,
                        'year'                => $year,
                        'tax_query'           => $tax_query,
                    ]);

                    if ($normal_q->have_posts()) :

                        while ($normal_q->have_posts()) :
                            $normal_q->the_post();
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
                                    } ?>">
                                    <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                                    <?php the_title(); ?>
                                </a>
                            </li>
                    <?php
                        endwhile;

                    else :

                        if (empty($shown_ids)) {
                            echo '<li>現在お知らせはありません。</li>';
                        }

                    endif;

                    wp_reset_postdata();
                    ?>

                </ul>

                <!-- ページネーション -->
                <ul class="c-pagenation">
                    <?php custom_pagination($paging_q); ?>
                </ul>

            </div>


            <!-- 右側サイドバー -->
            <div class="news-box__right">

                <h3 class="c-head5">Archive</h3>

                <div class="news-box__right--box">

                    <!-- 新着5件 -->
                    <div class="recent-posts-box">
                        <h3>新着記事</h3>

                        <ul>
                            <?php
                            $recent_q = new WP_Query([
                                'posts_per_page'      => 5,
                                'post_type'           => 'post',
                                'ignore_sticky_posts' => true,
                                'tax_query' => [
                                    [
                                        'taxonomy' => 'category',
                                        'field'    => 'slug',
                                        'terms'    => ['news'],
                                    ],
                                ],
                            ]);

                            while ($recent_q->have_posts()) :
                                $recent_q->the_post();

                                // 同じ直リンク処理
                                $news_file = get_field('news_file');
                                if (get_field('link_url')) {
                                    $href = esc_url(get_field('link_url'));
                                } elseif ($news_file && get_field('direct_link')) {
                                    $href = esc_url($news_file);
                                } else {
                                    $href = get_permalink();
                                }
                            ?>
                                <li>
                                    <a href="<?php echo $href; ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div>

                    <!-- 年度別 -->
                    <div>
                        <h3>年度別</h3>
                        <ul class="news-box__right--list">
                            <?php
                            global $wpdb;
                            $years = $wpdb->get_results("
                                SELECT YEAR(post_date) AS y, COUNT(*) AS cnt
                                FROM {$wpdb->posts} AS p
                                INNER JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
                                INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                                INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                                WHERE p.post_type = 'post'
                                  AND p.post_status = 'publish'
                                  AND t.slug = 'news'
                                GROUP BY YEAR(post_date)
                                HAVING y IS NOT NULL
                                ORDER BY y DESC
                            ");

                            foreach ($years as $row) :
                            ?>
                                <li>
                                    <a href="<?php echo esc_url(home_url("/news/{$row->y}/")); ?>">
                                        <?php echo esc_html($row->y); ?>年（<?php echo esc_html($row->cnt); ?>）
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
            <li><a href="">ニュース一覧</a></li>
        </ul>

    </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
