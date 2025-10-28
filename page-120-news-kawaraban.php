<?php
  /*
  Template Name: 富士平原 かわら版
  */
  // サブカテゴリ絞り込み用クエリ変数を追加
  add_filter( 'query_vars', function( $vars ){
    $vars[] = 'subcat';
    return $vars;
  } );
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<?php
  // ── 年度別ソート＆ページネーション用パラメータ取得 ──
  $paged = max( 1, get_query_var('paged'), get_query_var('page') );
  $year  = intval( get_query_var('year') );
?>


<main class="c-main">
  <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/news/page-header.jpg">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">News
        <span>- 富士平原 かわら版 -</span>
      </h1>
    </div>
  </div>

  <div class="c-column">
    <h2 class="c-head2">記事一覧</h2>
    <div class="news-box">
      <div class="news-box__left">

        <?php
        // ──────────────────────────────────────
        // ① 基本設定
        // ──────────────────────────────────────

        // $paged は上で取得済み
        $posts_per_page = 10;
        $year   = get_query_var('year');    // 年度絞り込み
        $subcat = get_query_var('subcat');  // サブカテゴリ絞り込み
        if ( $subcat ) {
          $year = null;
        }
        if ( $year ) {
          $subcat = null;
        }
        ?>

        <ul class="news-box__list">
        <?php
        // Sticky（memberカテゴリ）1ページ目限定
        $sticky_ids = [];
        $shown_ids  = [];

        if ( $paged === 1 ) {
          $all_sticky = get_option('sticky_posts');
          if ( $all_sticky ) {
            $sticky_ids = get_posts([
              'post_type'      => 'post',
              'post__in'       => $all_sticky,
              'category_name'  => 'member',
              'fields'         => 'ids',
              'posts_per_page' => -1,
              'year'           => $year,
            ]);
            $sticky_ids = array_slice( $sticky_ids, 0, $posts_per_page );
          }
          if ( $sticky_ids ) {
            $sticky_q = new WP_Query([
              'post_type'      => 'post',
              'post__in'       => $sticky_ids,
              'orderby'        => 'post__in',
            ]);
            while ( $sticky_q->have_posts() ) {
              $sticky_q->the_post();
              $shown_ids[] = get_the_ID();
        ?>
            <li>
              <a href="<?php
                $news_file = get_field('news_file');
                if ( get_field('link_url') ) {
                  echo esc_url( get_field('link_url') );
                } elseif ( $news_file && get_field('direct_link') ) {
                  echo esc_url( $news_file );
                } else {
                  the_permalink();
                } ?>">
                <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                <?php the_title(); ?>
              </a>
            </li>
        <?php
            }
            wp_reset_postdata();
          }
        }

        // 通常ループ
        $remain = ( $paged === 1 )
                ? $posts_per_page - count( $shown_ids )
                : $posts_per_page;
        $remain = max( 0, $remain );

            $args = [
                'post_type'           => 'post',
                'paged'               => $paged,
                'posts_per_page'      => $remain,           // ← ここを $remain に
                'ignore_sticky_posts' => true,
              ];
        // 子カテゴリ指定がある場合はそれだけで絞り込む
        if ( $subcat ) {
          $args['category_name'] = sanitize_key( $subcat );
          // 年度フィルタは無効化
          $year = null;
        } else {
          $args['category_name'] = 'member';
        }
        // 年度が指定されている時だけ year パラメータを追加
        if ( $year ) {
          $args['year'] = intval( $year );
        }
        $normal_q = new WP_Query( $args );
        if ( $normal_q->have_posts() ) {
          while ( $normal_q->have_posts() ) {
            $normal_q->the_post();
        ?>
            <li>
              <a href="<?php
                $news_file = get_field('news_file');
                if ( get_field('link_url') ) {
                  echo esc_url( get_field('link_url') );
                } elseif ( $news_file && get_field('direct_link') ) {
                  echo esc_url( $news_file );
                } else {
                  the_permalink();
                } ?>">
                <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
                <?php the_title(); ?>
              </a>
            </li>
        <?php
          }
          wp_reset_postdata();
        } elseif ( empty( $shown_ids ) ) {
          echo '<li>現在お知らせはありません。</li>';
        }
        ?>
        </ul>

        <!-- ページネーション -->
        <!-- <ul class="c-pagenation">
        <?php
        $pag_args = [
          'post_type'           => 'post',
          'posts_per_page'      => $posts_per_page,
          'paged'               => $paged,
          'category_name'       => 'member',
          'ignore_sticky_posts' => true,
          'fields'              => 'ids',
        ];
        if ( $year ) {
          $pag_args['year'] = intval( $year );
        }
        if ( $subcat ) { $pag_args['category_name'] .= ',' . sanitize_key( $subcat ); }
        custom_pagination( new WP_Query( $pag_args ) );
        ?>
        </ul> -->
        <ul class="c-pagenation">
          <?php custom_pagination( $normal_q ); ?>
        </ul>
      </div>

      <?php
        // サイドバーArchive
        $years      = fhg_get_all_years();
        $member_cat = get_category_by_slug( 'member' );
        $subcats    = $member_cat
                    ? get_categories([
                        'child_of'   => $member_cat->term_id,
                        'hide_empty' => true,
                        'orderby'    => 'name',
                      ])
                    : [];
        if ( $years || $subcats ):
          // カテゴリ用ベースURL（年度を含めない）
          $category_base = home_url( 'news/kawaraban' ) . '/';
          // 年度用ベースURL（サブカテゴリを含めない）
          $year_base     = home_url( 'news/kawaraban' );

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
                 $cat = 'member'; // かわら版一覧なら 'member' ／ ニュース一覧なら 'news'
                 $recent_q = new WP_Query([
                   'posts_per_page'      => 5,
                   'category_name'       => $cat,
                   'ignore_sticky_posts' => true,
                 ]);
                 if ( $recent_q->have_posts() ):
                   while( $recent_q->have_posts() ): $recent_q->the_post();
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

            <!-- カテゴリ別 -->
            <?php if ( $subcats ): ?>
            <div class="archive-by-cat">
              <h3>カテゴリ別</h3>
              <ul class="news-box__right--list">
                <?php foreach ( $subcats as $cat ): 
                 // 「カテゴリのみ」で絞るには、year を含まないパスを直接指定
                  $url = home_url( "news/kawaraban/{$cat->slug}/" );
                  $count = $cat->count;
                  $active = ( $subcat === $cat->slug ) ? ' class="is-current"' : '';
                ?>
                  <li<?php echo $active;?>>
                    <a href="<?php echo esc_url( $url ); ?>">
                      <?php echo esc_html( $cat->name ); ?>（<?php echo esc_html( $count ); ?>）
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <!-- 年度別 -->
            <?php if ( $years ): ?>
            <div class="archive-by-year">
              <h3>年度別</h3>
              <ul class="news-box__right--list">
                  <?php foreach ( $years as $y ):
                  // サブカテゴリパラメータを含めず、その年度だけで絞り込み
                  $count = count( get_posts([
                    'post_type'           => 'post',
                    'posts_per_page'      => -1,
                    'fields'              => 'ids',
                    'category_name'       => 'member',
                    'year'                => $y,
                    'ignore_sticky_posts' => true,
                  ]) );
                  if ( ! $count ) continue;
                  $url = "{$year_base}/{$y}/";
                ?>
                  <li>
                    <a href="<?php echo esc_url( $url ); ?>">
                      <?php echo esc_html( $y ); ?>年（<?php echo esc_html( $count ); ?>）
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

          </div>
        </div>
      <?php endif; ?>

    </div>

    <!-- パンくずリスト -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('news')); ?>">ニュース一覧</a></li>
      <li><a href="">かわら版一覧</a></li>
    </ul>
  </div>
</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>
</body>
</html>