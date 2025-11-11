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
                            <!-- ニュースのタイトルと日付 -->
                            <h2 class="news-dt__ttl">
                                <span><?php echo get_the_date('Y.m.d'); ?></span> <!-- ニュースの日付 -->
                                <?php the_title(); ?> <!-- ニュースのタイトル -->
                            </h2>

                            <!-- テストテキスト -->
                            <p>お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。</p>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/member/dummy.jpg" alt="ダミー画像">
                            <p>お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。お知らせのテキストが入ります。</p>

                            <!-- パスワード保護 -->
                            <?php if (post_password_required()) : ?>
                                <?php echo get_the_password_form(); ?>
                            <?php else : ?>

                                <!-- ニュースの本文 -->
                                <?php
                                $content = get_the_content();
                                if (trim($content) !== '') : ?>
                                    <div>
                                        <?php the_content(); ?> <!-- 投稿の本文を表示 -->
                                    </div>
                                <?php endif; ?>

                                <!-- カスタムフィールドのテキストがあれば表示（文章上） -->
                                <?php if (get_field('news_txt')): ?>
                                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt')); ?></p>
                                <?php endif; ?>

                                <!-- カスタムフィールドの画像があれば表示 -->
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

                                <!-- カスタムフィールドのファイルリンクがあれば表示 -->
                                <?php
                                $files = [
                                    'file1' => [
                                        'url' => get_field('news_file'),
                                        'txt' => get_field('txt_btn') ?: "詳しくはこちらをご覧ください"
                                    ],
                                    'file2' => [
                                        'url' => get_field('news_file2'),
                                        'txt' => get_field('txt_btn2') ?: "詳しくはこちらをご覧ください"
                                    ],
                                    'file3' => [
                                        'url' => get_field('news_file3'),
                                        'txt' => get_field('txt_btn3') ?: "詳しくはこちらをご覧ください"
                                    ],
                                    'file4' => [
                                        'url' => get_field('news_file4'),
                                        'txt' => get_field('txt_btn4') ?: "詳しくはこちらをご覧ください"
                                    ],
                                    'file5' => [
                                        'url' => get_field('news_file5'),
                                        'txt' => get_field('txt_btn5') ?: "詳しくはこちらをご覧ください"
                                    ]
                                ];

                                // 少なくとも1つでもURLがあるかチェック
                                $has_file = false;
                                foreach ($files as $file) {
                                    if (!empty($file['url'])) {
                                        $has_file = true;
                                        break;
                                    }
                                }
                                ?>

                                <?php if ($has_file): ?>
                                    <div class="btn-area">
                                        <?php foreach ($files as $file): ?>
                                            <?php if ($file['url']): ?>
                                                <a href="<?php echo esc_url($file['url']); ?>" target="_blank" class="c-link-pdf">
                                                    <?php echo esc_html($file['txt']); ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- カスタムフィールドのテキストがあれば表示（文章下） -->
                                <?php if (get_field('news_txt2')): ?>
                                    <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt2')); ?></p>
                                <?php endif; ?>

                            <?php endif; ?>
                    <?php endwhile;
                    endif; ?>
                </div>

                <?php
                // サイドバー：Archive リンク
                $years = fhg_get_news_years();  // news カテゴリ限定の年リスト
                if (! empty($years)) :
                    $base = home_url('news'); // ベース URL
                ?>
                    <div class="news-box__right">
                        <h3 class="c-head5">Archive</h3>
                        <div class="news-box__right--box">
                            <!-- ★ ①ここから：新着記事ボックス -->
                            <div class="recent-posts-box">
                                <h3>新着記事</h3>
                                <ul>
                                    <?php
                                    // テンプレートごとに大カテゴリを切り替えてください
                                    $cat = 'news';
                                    $recent_q = new WP_Query([
                                        'posts_per_page'      => 5,
                                        'category_name'       => $cat,
                                        'ignore_sticky_posts' => true,
                                    ]);
                                    if ($recent_q->have_posts()):
                                        while ($recent_q->have_posts()): $recent_q->the_post();
                                    ?>
                                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                    ?>
                                </ul>
                            </div>
                            <!-- ★ ①ここまで：新着記事ボックス -->

                            <div>
                                <h3>年度別</h3>
                                <ul class="news-box__right--list">
                                    <?php foreach ($years as $y) :
                                        // 各年の投稿数を取得
                                        $count = count(get_posts([
                                            'post_type'           => 'post',
                                            'posts_per_page'      => -1,
                                            'fields'              => 'ids',
                                            'category_name'       => 'news',
                                            'year'                => $y,
                                            'ignore_sticky_posts' => true,
                                        ]));
                                    ?>
                                        <li>
                                            <a href="<?php echo esc_url("{$base}/{$y}/"); ?>">
                                                <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

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