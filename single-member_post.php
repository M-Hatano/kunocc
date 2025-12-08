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

                <?php if (have_posts()): while (have_posts()): the_post(); ?>

                <!-- タイトル・日付 -->
                <h2 class="news-dt__ttl">
                    <span><?php echo get_the_date('Y.m.d'); ?></span>
                    <?php the_title(); ?>
                </h2>

                <!-- 本文（WYSIWYG本文） -->
                <div class="m-single__content">
                    <?php the_content(); ?>
                </div>

                <!-- 上部テキスト（ACF） -->
                <?php if (get_field('news_txt')): ?>
                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt')); ?></p>
                <?php endif; ?>

                <!-- 画像1〜3 -->
                <?php
                $imgs = [
                    get_field('news_image'),
                    get_field('news_image2'),
                    get_field('news_image3')
                ];
                ?>

                <?php foreach ($imgs as $img): ?>
                    <?php if ($img): ?>
                    <div class="img-area">
                        <?php echo wp_get_attachment_image($img, 'large', false, ['loading' => 'lazy']); ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- PDFリンク（ACF） -->
                <?php
                $files = [
                    ['url' => get_field('news_file'),  'txt' => get_field('txt_btn')  ?: "詳しくはこちら"],
                    ['url' => get_field('news_file2'), 'txt' => get_field('txt_btn2') ?: "詳しくはこちら"],
                    ['url' => get_field('news_file3'), 'txt' => get_field('txt_btn3') ?: "詳しくはこちら"],
                    ['url' => get_field('news_file4'), 'txt' => get_field('txt_btn4') ?: "詳しくはこちら"],
                    ['url' => get_field('news_file5'), 'txt' => get_field('txt_btn5') ?: "詳しくはこちら"],
                ];

                $has_file = false;
                foreach ($files as $f) {
                    if (!empty($f['url'])) $has_file = true;
                }
                ?>

                <?php if ($has_file): ?>
                    <div class="btn-area">
                        <?php foreach ($files as $f): ?>
                            <?php if (!empty($f['url'])): ?>
                                <a href="<?php echo esc_url($f['url']); ?>" target="_blank" class="c-link-pdf">
                                    <?php echo esc_html($f['txt']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- 下部テキスト -->
                <?php if (get_field('news_txt2')): ?>
                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt2')); ?></p>
                <?php endif; ?>

                <?php endwhile; endif; ?>
            </div>

            <!-- =======================
                サイドバー（会員）
            ======================= -->
            <div class="news-box__right">
                <h3 class="c-head5">Archive</h3>
                <div class="news-box__right--box">

                    <!-- 新着5件（member_post 限定） -->
                    <div class="recent-posts-box">
                        <h3>新着記事</h3>
                        <ul>
                        <?php
                        $recent_q = new WP_Query([
                            'post_type'      => 'member_post',
                            'posts_per_page' => 5,
                            'orderby'        => 'date',
                            'order'          => 'DESC'
                        ]);
                        while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div>

                    <!-- 年別アーカイブ（member_post の年だけ） -->
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

                        foreach ($years as $y): ?>
                            <li>
                                <a href="<?php echo esc_url(home_url("/member/{$y}/")); ?>">
                                    <?php echo esc_html($y); ?>年
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
            <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('/member/')); ?>">会員サイト</a></li>
            <li><?php the_title(); ?></li>
        </ul>

    </div>
</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
