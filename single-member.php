    <?php
    /*
      Template Name: 会員お知らせ詳細
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-member">
        <span class="deco _01"><span></span></span>
        <div class="c-page-header lazyload">
            <div class="c-column c-page-header__inner">
                <h1 class="c-page-header__title">Member
                    <span>会員様お知らせ</span>
                </h1>
            </div>
        </div>
        <ul class="m-list">
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員様お知らせ</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-sales/">営業案内</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-kusunoki/">くすのき会</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-partner/">提携コース</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-calendar/">ビジター様料金</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-registration/">コンペ申込</a></li>
        </ul>
        <div class="c-column">
            <div class="news-box">
            <div class="news-box__left">

                <?php if (have_posts()): while (have_posts()): the_post(); ?>

                <!-- タイトルと日付 -->
                <h2 class="news-dt__ttl">
                    <span><?php echo get_the_date('Y.m.d'); ?></span>
                    <?php the_title(); ?>
                </h2>

                <!-- 本文 -->
                <div class="m-single__content">
                    <?php the_content(); ?>
                </div>

                <!-- 上部カスタムテキスト -->
                <?php if (get_field('news_txt')): ?>
                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt')); ?></p>
                <?php endif; ?>

                <!-- 画像 1〜3 -->
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

                <!-- PDF / リンクボタン -->
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

                <!-- 下部カスタムテキスト -->
                <?php if (get_field('news_txt2')): ?>
                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt2')); ?></p>
                <?php endif; ?>

                <?php endwhile; endif; ?>

            </div>

            <!-- ======================
                サイドバー（会員）
            ====================== -->
            <div class="news-box__right">
                <h3 class="c-head5">Archive</h3>
                <div class="news-box__right--box">

                <!-- 新着5件（member限定） -->
                <div class="recent-posts-box">
                    <h3>新着記事</h3>
                    <ul>
                    <?php
                    $recent_q = new WP_Query([
                        'posts_per_page'      => 5,
                        'category_name'       => 'member',
                        'ignore_sticky_posts' => true,
                    ]);
                    while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                </div>

                <!-- 年別アーカイブ（memberのみ） -->
                <div>
                    <h3>年度別</h3>
                    <ul class="news-box__right--list">
                    <?php
                    $all_years = fhg_get_all_years();
                    foreach ($all_years as $y):
                        $count = count(get_posts([
                        'post_type'      => 'post',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'category_name'  => 'member',
                        'year'           => $y,
                        ]));
                        if ($count > 0):
                    ?>
                        <li>
                        <a href="<?php echo esc_url(home_url("/member/{$y}/")); ?>">
                            <?php echo $y; ?>年（<?php echo $count; ?>）
                        </a>
                        </li>
                    <?php endif; endforeach; ?>
                    </ul>
                </div>

                </div>
            </div>
            <!-- /サイドバー -->

            </div>

            <!-- パンくずリスト -->
            <ul class="c-brd">
                <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
                <?php if (in_category('member')): ?>
                    <li><a href="<?php echo esc_url(home_url('news/')); ?>">ニュース一覧</a></li>
                    <li><a href="<?php echo esc_url(home_url('news/kawaraban/')); ?>">かわら版一覧</a></li>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(home_url('news')); ?>">ニュース一覧</a></li>
                <?php endif; ?>
                <li><a href="#"><?php the_title(); ?></a></li>
            </ul>
        </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>