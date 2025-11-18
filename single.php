      
      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload">
            <div class="c-column c-page-header__inner">
                <h1 class="c-page-header__title">News
                <span>- ニュース -</span>
                </h1>
            </div>
        </div>
        <div class="c-column">
          <div class="news-box">
          <div class="news-box__left">
                <?php if(have_posts()): while(have_posts()): the_post(); ?>
                    <!-- ニュースのタイトルと日付 -->
                    <h2 class="news-dt__ttl">
                        <span><?php echo get_the_date('Y.m.d'); ?></span> <!-- ニュースの日付 -->
                        <?php the_title(); ?> <!-- ニュースのタイトル -->
                    </h2>

                    <!-- パスワード保護 -->
                    <?php if ( post_password_required() ) : ?>
                    <?php echo get_the_password_form(); ?>
                    <?php else : ?>

                    <!-- ニュースの本文 -->
                    <?php
                        $content = get_the_content();
                        if ( trim($content) !== '' ) : ?>
                            <div>
                                <?php the_content(); ?> <!-- 投稿の本文を表示 -->
                            </div>
                        <?php endif; ?>

                    <!-- カスタムフィールドのテキストがあれば表示（文章上） -->
                    <?php if(get_field('news_txt')): ?>
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

                    <?php foreach($imgs as $img): ?>
                        <?php if($img): ?>
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
                                <?php foreach($files as $file): ?>
                                    <?php if($file['url']): ?>
                                        <a href="<?php echo esc_url($file['url']); ?>" target="_blank" class="c-link-pdf">
                                            <?php echo esc_html($file['txt']); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <!-- カスタムフィールドのテキストがあれば表示（文章下） -->
                    <?php if(get_field('news_txt2')): ?>
                        <p class="c-txt"><?php echo wp_kses_post(get_field('news_txt2')); ?></p>
                    <?php endif; ?>

                    <?php endif; ?>
                <?php endwhile; endif; ?>

            </div>

            <div class="news-box__right">

                <h3 class="c-head5">Archive</h3>
                <?php
                // ▼ URL から news / member を判定する
                $uri = $_SERVER['REQUEST_URI'] ?? '';

                if (strpos($uri, '/member/') !== false) {
                    $mode = 'member';
                } else {
                    $mode = 'news';
                }
                ?>
                <?php
                // サイドバー：Archive リンク
                $all_years = fhg_get_all_years();  // 全年取得
                ?>
                <div class="news-box__right--box">
                
                <!-- 新着記事5件 -->
                <div class="recent-posts-box">
                    <h3>新着記事</h3>
                    <ul>
                <?php
                /* ----------------------------
                * 新着記事（5件）
                * スラッグが news なら news のみ
                * スラッグが member なら member/kusunoki/information のみ
                * ----------------------------*/
                $recent_tax_query = [];

                if ($mode === 'news') {
                    // newsページ → news のみ
                    $recent_tax_query = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['news'],
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['member', 'kusunoki', 'information'],
                            'operator' => 'NOT IN'
                        ],
                    ];
                } else {
                    // memberページ → member/kusunoki/information のみ
                    $recent_tax_query = [
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['member', 'kusunoki', 'information'],
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => ['news'],
                            'operator' => 'NOT IN'
                        ],
                    ];
                }

                $recent_q = new WP_Query([
                    'posts_per_page'      => 5,
                    'post_type'           => 'post',
                    'ignore_sticky_posts' => true,
                    'tax_query'           => $recent_tax_query
                ]);
                ?>
                <ul>
                <?php while ($recent_q->have_posts()): $recent_q->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; wp_reset_postdata(); ?>
                </ul>
                </div>

                <!-- 年度別 -->
                <div>
                    <h3>年度別</h3>
                    <ul class="news-box__right--list">
                  <?php
                  $all_years = fhg_get_all_years();
                  $years = [];

                  foreach ($all_years as $y):

                      if ($mode === 'news') {
                          // NEWS のみカウント（member / kusunoki / information は除外）
                          $count_posts = get_posts([
                              'post_type'      => 'post',
                              'posts_per_page' => -1,
                              'fields'         => 'ids',
                              'year'           => $y,
                              'tax_query'      => [
                                  'relation' => 'AND',
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['news'],
                                      'operator' => 'IN',
                                  ],
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['member', 'kusunoki', 'information'],
                                      'operator' => 'NOT IN',
                                  ],
                              ],
                          ]);
                      } else {
                          // MEMBER 系のみカウント（news は除外）
                          $count_posts = get_posts([
                              'post_type'      => 'post',
                              'posts_per_page' => -1,
                              'fields'         => 'ids',
                              'year'           => $y,
                              'tax_query'      => [
                                  'relation' => 'AND',
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['member', 'kusunoki', 'information'],
                                      'operator' => 'IN',
                                  ],
                                  [
                                      'taxonomy' => 'category',
                                      'field'    => 'slug',
                                      'terms'    => ['news'],
                                      'operator' => 'NOT IN',
                                  ],
                              ],
                          ]);
                      }

                      if (count($count_posts) > 0):
                          $years[$y] = count($count_posts);
                      endif;

                  endforeach;

                  foreach ($years as $y => $count): ?>
                    <li>
                      <a href="<?php echo esc_url(home_url( $mode === 'news' ? "/news/{$y}/" : "/member/{$y}/" )); ?>">
                        <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
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
            <li><a href="<?php echo esc_url( home_url('') ); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url( home_url('news') ); ?>">ニュース一覧</a></li>
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