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

                <!-- 上部テキスト -->
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

                foreach ($imgs as $img):

                    if ($img):

                        // ACF画像フィールドは配列のことがある → ID を取得
                        $attachment_id = is_array($img) ? $img['ID'] : $img;

                        // 保護URLに変換（会員チェックONのときのみ ID付き URL になる）
                        $protected_url = knc_protect_image_url($attachment_id);

                        // alt
                        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                ?>
                        <div class="img-area">
                            <img 
                                src="<?php echo esc_url($protected_url); ?>" 
                                alt="<?php echo esc_attr($alt); ?>" 
                                loading="lazy"
                            >
                        </div>

                <?php
                    endif;
                endforeach;
                ?>

                <!-- PDF / ファイル ボタン -->
                <?php
                $files = [
                    ['file' => get_field('news_file'),  'txt' => get_field('txt_btn')  ?: "詳しくはこちら"],
                    ['file' => get_field('news_file2'), 'txt' => get_field('txt_btn2') ?: "詳しくはこちら"],
                    ['file' => get_field('news_file3'), 'txt' => get_field('txt_btn3') ?: "詳しくはこちら"],
                    ['file' => get_field('news_file4'), 'txt' => get_field('txt_btn4') ?: "詳しくはこちら"],
                    ['file' => get_field('news_file5'), 'txt' => get_field('txt_btn5') ?: "詳しくはこちら"],
                ];

                // いずれか1つでもあればボタン表示
                $has_file = false;
                foreach ($files as $f) {
                    if (!empty($f['file'])) $has_file = true;
                }
                ?>

                <?php if ($has_file): ?>
                    <div class="btn-area">
                        <?php foreach ($files as $f): ?>
                            <?php if (!empty($f['file'])): ?>

                                <?php
                                // ここが重要 → 保護 URL に変換
                                $href = knc_get_protected_acf_file_url($f['file']);
                                ?>

                                <a href="<?php echo esc_url($href); ?>" target="_blank" class="c-link-pdf">
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

                    <?php
                    // 現在記事のカテゴリ取得
                    $terms = get_the_terms(get_the_ID(), 'member_category');
                    $subcat = 'member';

                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            if (in_array($term->slug, ['information', 'kusunoki'])) {
                                $subcat = $term->slug;
                            }
                        }
                    }

                    $year = get_the_date('Y');
                    ?>

                    <!-- 新着5件 -->
                    <div class="recent-posts-box">
                        <h3>新着記事</h3>
                        <ul>
                        <?php
                        $recent_args = [
                            'post_type'      => 'member_post',
                            'posts_per_page' => 5,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        ];

                        if ($subcat !== 'member') {
                            $recent_args['tax_query'] = [[
                                'taxonomy' => 'member_category',
                                'field'    => 'slug',
                                'terms'    => $subcat,
                            ]];
                        }

                        $recent_q = new WP_Query($recent_args);

                        while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </div>

                    <!-- 年度別 -->
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

                        foreach ($years as $y):

                            $count_args = [
                                'post_type'      => 'member_post',
                                'fields'         => 'ids',
                                'posts_per_page' => -1,
                                'year'           => $y,
                            ];

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
                                <a href="<?php echo esc_url( site_url("/member/{$y}/") ); ?>">
                                    <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                                </a>
                            </li>

                        <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

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
