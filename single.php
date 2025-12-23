<?php
/* -------------------------------------------------
 * ① カテゴリ制限（news 以外は閲覧させない）
 * -------------------------------------------------*/
$cats  = get_the_terms(get_the_ID(), 'category');
$slugs = $cats ? wp_list_pluck($cats, 'slug') : [];

if (!in_array('news', $slugs)) {
    wp_redirect(home_url('/'));
    exit;
}

/* -------------------------------------------------
 * ② 直リンク記事（外部URL or PDF）ならリダイレクト
 * -------------------------------------------------*/
$news_file = get_field('news_file');

if (get_field('link_url')) {
    wp_redirect( esc_url(get_field('link_url')) );
    exit;
} elseif ($news_file && get_field('direct_link')) {
    wp_redirect( esc_url($news_file) );
    exit;
}
?>

<!-- header -->
<?php get_header('120'); ?>
<!-- header -->

<main class="c-main">

    <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">
                News <span>- ニュース -</span>
            </h1>
        </div>
    </div>

    <div class="c-column">

        <div class="news-box">

            <!-- 左カラム（記事本体） -->
            <div class="news-box__left">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <!-- タイトル・公開日 -->
                    <h2 class="news-dt__ttl">
                        <span><?php echo get_the_date('Y.m.d'); ?></span>
                        <?php the_title(); ?>
                    </h2>

                    <!-- パスワード保護 -->
                    <?php if (post_password_required()) : ?>

                        <?php echo get_the_password_form(); ?>

                    <?php else : ?>

                        <!-- 本文 -->
                        <?php if (trim(get_the_content()) !== '') : ?>
                            <div>
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- カスタムフィールド テキスト（文章上） -->
                        <?php if (get_field('news_txt')) : ?>
                            <p class="c-txt">
                                <?php echo wp_kses_post(get_field('news_txt')); ?>
                            </p>
                        <?php endif; ?>

                        <!-- カスタムフィールド画像（1〜3枚） -->
                        <?php
                        $imgs = [
                            get_field('news_image'),
                            get_field('news_image2'),
                            get_field('news_image3')
                        ];
                        ?>

                        <?php foreach ($imgs as $img) : ?>
                            <?php if ($img) : ?>
                                <div class="img-area">
                                    <?php echo wp_get_attachment_image($img, 'large', false, ['loading' => 'lazy']); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- カスタムフィールドPDFリンク -->
                        <?php
                        $files = [
                            [
                                'url' => get_field('news_file'),
                                'txt' => get_field('txt_btn') ?: "詳しくはこちらをご覧ください"
                            ],
                            [
                                'url' => get_field('news_file2'),
                                'txt' => get_field('txt_btn2') ?: "詳しくはこちらをご覧ください"
                            ],
                            [
                                'url' => get_field('news_file3'),
                                'txt' => get_field('txt_btn3') ?: "詳しくはこちらをご覧ください"
                            ],
                            [
                                'url' => get_field('news_file4'),
                                'txt' => get_field('txt_btn4') ?: "詳しくはこちらをご覧ください"
                            ],
                            [
                                'url' => get_field('news_file5'),
                                'txt' => get_field('txt_btn5') ?: "詳しくはこちらをご覧ください"
                            ]
                        ];

                        $has_file = false;
                        foreach ($files as $f) {
                            if (!empty($f['url'])) {
                                $has_file = true;
                                break;
                            }
                        }
                        ?>

                        <?php if ($has_file) : ?>
                            <div class="btn-area">
                                <?php foreach ($files as $f) : ?>
                                    <?php if ($f['url']) : ?>
                                        <a href="<?php echo esc_url($f['url']); ?>" target="_blank" class="c-link-pdf" rel="noopener noreferrer">
                                            <?php echo esc_html($f['txt']); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- カスタムフィールド テキスト（文章下） -->
                        <?php if (get_field('news_txt2')) : ?>
                            <p class="c-txt">
                                <?php echo wp_kses_post(get_field('news_txt2')); ?>
                            </p>
                        <?php endif; ?>

                    <?php endif; ?>

                <?php endwhile; endif; ?>

            </div><!-- /.news-box__left -->

            <!-- 右カラム（アーカイブ・新着） -->
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

                                // 同じ直リンク仕様
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
                                    <a href="<?php echo $href; ?>"><?php the_title(); ?></a>
                                </li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>

                    </div><!-- /.recent-posts-box -->

                    <!-- 年度別 -->
                    <div>

                        <h3>年度別</h3>

                        <ul class="news-box__right--list">
                            <?php
                            global $wpdb;
                            $years = $wpdb->get_results("
                                SELECT YEAR(p.post_date) AS y, COUNT(*) AS cnt
                                FROM {$wpdb->posts} AS p
                                INNER JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
                                INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                                INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
                                WHERE p.post_type = 'post'
                                  AND p.post_status = 'publish'
                                  AND t.slug = 'news'
                                GROUP BY YEAR(p.post_date)
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

                    </div><!-- /.年度別 -->

                </div><!-- /.news-box__right--box -->

            </div><!-- /.news-box__right -->

        </div><!-- /.news-box -->

        <!-- パンくず -->
        <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('news')); ?>">ニュース一覧</a></li>
            <li><a href="#"><?php the_title(); ?></a></li>
        </ul>

    </div><!-- /.c-column -->

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
