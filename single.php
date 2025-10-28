      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/news/page-header.jpg">
            <div class="c-column c-page-header__inner">
                <?php if ( in_category('member') ): ?>
                <h1 class="c-page-header__title">News
                    <span>- 富士平原 かわら版 -</span>
                </h1>
                <?php else: ?>
                <h1 class="c-page-header__title">News
                    <span>- ニュース -</span>
                </h1>
                <?php endif; ?>
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

                <!-- ニュース一覧へのリンク -->
                <?php
                // 「news」カテゴリを優先判定
                if ( in_category( 'news' ) ): ?>
                    <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="news__all">ニュース一覧へ戻る</a>
                <?php
                // 次に「member」カテゴリ
                elseif ( in_category( 'member' ) ): ?>
                    <a href="<?php echo esc_url( home_url( '/news/kawaraban' ) ); ?>" class="news__all">かわら版一覧へ戻る</a>
                <?php
                // その他はデフォルトでニュース一覧へ
                else: ?>
                    <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="news__all">ニュース一覧へ戻る</a>
                <?php endif; ?>
            </div>

            <?php
                // --- アーカイブ出力部分の例 ---
                // すでに $years と $base を設定済みの前提です
                // （single テンプレート内の「ニュース一覧へ戻る」の直後あたり）

                if ( in_category('member') ) {
                    $years = fhg_get_all_years();       // member カテゴリ（かわら版）の年
                    $cat   = 'member';
                    $base  = home_url( 'news/kawaraban' );
                } else {
                    $years = fhg_get_news_years();      // news カテゴリ（ニュース）の年
                    $cat   = 'news';
                    $base  = home_url( 'news' );
                }

                if ( ! empty( $years ) ) : ?>
                <div class="news-box__right">
                    <h3 class="c-head5">Archive</h3>
                    <div class="news-box__right--box">
                        <!--  新着記事ウィジェット -->
                        <div>
                            <h3 class="widget-title">新着記事</h3>
                            <ul>
                                <?php
                                // かわら版記事なら member、ニュース記事なら news
                                if ( in_category('member') ) {
                                $rq = new WP_Query([ 'category_name'=>'member', 'posts_per_page'=>5 ]);
                                } elseif ( in_category('news') ) {
                                $rq = new WP_Query([ 'category_name'=>'news',   'posts_per_page'=>5 ]);
                                }
                                if ( isset($rq) && $rq->have_posts() ) :
                                while ( $rq->have_posts() ) : $rq->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile;
                                wp_reset_postdata();
                                endif;
                                ?>
                            </ul>
                        </div>

                        <div>
                            <?php
                            // 例：かわら版記事一覧
                            if ( is_page_template( 'page-120-news-kawaraban.php' ) ) {
                            $recent = new WP_Query([
                                'post_type'      => 'post',
                                'category_name'  => 'member',
                                'posts_per_page' => 5,
                            ]);
                            if ( $recent->have_posts() ) {
                                echo '<div class="archive-by-recent"><h3>かわら版記事一覧</h3><ul>';
                                while ( $recent->have_posts() ) {
                                $recent->the_post();
                                printf( '<li><a href="%s">%s</a></li>',
                                    esc_url( get_permalink() ),
                                    esc_html( get_the_title() )
                                );
                                }
                                echo '</ul></div>';
                                wp_reset_postdata();
                            }
                            }
                            ?>
                        </div>

                        <?php if ( in_category('member') ): // 「かわら版」のときだけカテゴリ別を表示 ?>
                        <div>
                            <h3 class="widget-title">カテゴリ別</h3>
                            <ul class="news-box__right--list">
                              <?php
                              $base_term = get_category_by_slug('member');
                              if ( $base_term ) {
                                $subs = get_categories([
                                  'child_of'   => $base_term->term_id,
                                  'hide_empty' => true,
                                  'orderby'    => 'name',
                                ]);
                                foreach ( $subs as $sub ) {
                                  $url    = add_query_arg( 'subcat', $sub->slug, $base );
                                  $active = ( get_query_var('subcat') === $sub->slug ) ? ' class="is-current"' : '';
                                  printf(
                                    '<li%s><a href="%s">%s（%d）</a></li>',
                                    $active,
                                    esc_url( $url ),
                                    esc_html( $sub->name ),
                                    esc_html( $sub->count )
                                  );
                                }
                              }
                              ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <div>
                            <h3 class="widget-title">年度別</h3>
                            <ul class="c-archive-list">
                            <?php foreach ( $years as $y ) :
                                // 各年の投稿数を取得
                                $count = count( get_posts([
                                'post_type'           => 'post',
                                'posts_per_page'      => -1,
                                'fields'              => 'ids',
                                'category_name'       => $cat,
                                'year'                => $y,
                                'ignore_sticky_posts' => true,
                                ]) );
                            ?>
                                <li>
                                <a href="<?php echo esc_url( "{$base}/{$y}/" ); ?>">
                                    <?php echo esc_html( $y ); ?>年（<?php echo $count; ?>）
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
            <li><a href="<?php echo esc_url( home_url('') ); ?>">TOP</a></li>
            <?php if ( in_category('member') ): ?>
                <li><a href="<?php echo esc_url( home_url('news/') ); ?>">ニュース一覧</a></li>
                <li><a href="<?php echo esc_url( home_url('news/kawaraban/') ); ?>">かわら版一覧</a></li>
            <?php else: ?>
                <li><a href="<?php echo esc_url( home_url('news') ); ?>">ニュース一覧</a></li>
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