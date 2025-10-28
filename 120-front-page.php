<?php
/*
Template Name: トップページ
*/
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->


<main class="c-main">

  <div class="top_mv">
    <!-- <div class="top-logo">
      <img src="<#?php echo esc_url(get_template_directory_uri()); ?>" alt="" loading="lazy">
    </div> -->
    <?php
    // ACFで設定した画像をそれぞれ取得
    $image_1 = get_field('top_image_1');
    $image_2 = get_field('top_image_2');
    $image_3 = get_field('top_image_3');
    ?>

    <div>
      <!-- 1つ目の画像 -->
      <?php if ($image_1): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($image_1['url']); ?>');"></div>
      <?php endif; ?>

      <!-- 2つ目の画像 -->
      <?php if ($image_2): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($image_2['url']); ?>');"></div>
      <?php endif; ?>

      <!-- 3つ目の画像 -->
      <?php if ($image_3): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($image_3['url']); ?>');"></div>
      <?php endif; ?>
    </div>
  </div>

  <section class="top-news">
  <div class="bg-news">
    <div class="c-column">
      <h2 class="c-sec-headline">新着情報</h2>
    </div>

    <div class="post-index">
      <ul>
        <?php
        /* --------------------------------
        * 共通設定
        * --------------------------------*/
        $posts_per_page = 5;        // 表示件数
        $shown_ids      = [];       // 表示済み ID を格納

        /* --------------------------------
        * ① ニュースカテゴリに属する Sticky 投稿
        * --------------------------------*/
        $sticky_ids = [];
        $all_sticky = get_option('sticky_posts');

        if ( $all_sticky ) {
          $sticky_ids = get_posts( [
            'post_type'      => 'post',
            'post__in'       => $all_sticky,
            'category_name'  => 'news',
            'fields'         => 'ids',
            'posts_per_page' => -1,
          ] );
        }

        if ( $sticky_ids ) :
          $sticky_q = new WP_Query( [
            'post_type' => 'post',
            'post__in'  => $sticky_ids,
            'orderby'   => 'post__in',  // Sticky順
          ] );

          while ( $sticky_q->have_posts() ) : $sticky_q->the_post();
            $shown_ids[] = get_the_ID(); ?>
                <li>
                  <a href="<?php
                    $news_file = get_field('news_file');
                    if ( get_field('link_url') ) {
                      echo esc_url( get_field('link_url') );
                    } elseif ( $news_file && get_field('direct_link') ) {
                      echo esc_url( $news_file );
                    } else {
                      the_permalink();
                    }
                  ?>">
                    <div>
                      <span class="time"><?php echo get_the_date('Y.m.d'); ?></span>
                      <p><?php the_title(); ?></p>
                    </div>
                  </a>
                </li>
          <?php endwhile;
          wp_reset_postdata();
        endif;

        /* --------------------------------
        * ② Sticky を除いた通常のニュース投稿
        * --------------------------------*/
        $remain = $posts_per_page - count( $shown_ids );

        if ( $remain > 0 ) :
          $normal_q = new WP_Query( [
            'post_type'           => 'post',
            'posts_per_page'      => $remain,
            'category_name'       => 'news',
            'post__not_in'        => $shown_ids,
            'ignore_sticky_posts' => true,   // 重複防止
          ] );

          if ( $normal_q->have_posts() ) :
            while ( $normal_q->have_posts() ) : $normal_q->the_post(); ?>
                <li>
                  <a href="<?php
                    $news_file = get_field('news_file');
                    if ( get_field('link_url') ) {
                      echo esc_url( get_field('link_url') );
                    } elseif ( $news_file && get_field('direct_link') ) {
                      echo esc_url( $news_file );
                    } else {
                      the_permalink();
                    }
                  ?>">
                    <div>
                      <span class="time"><?php echo get_the_date('Y.m.d'); ?></span>
                      <p><?php the_title(); ?></p>
                    </div>
                  </a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
          endif;
        endif;

        /* 表示がゼロ件の場合のフォールバック */
        if ( empty( $shown_ids ) && ( empty( $normal_q ) || ! $normal_q->post_count ) ) {
          echo '<li>現在お知らせはありません。</li>';
        }
        ?>
      </ul>
    </div>

    <a href="<?php echo esc_url( home_url('/news') ); ?>" class="top-news__more">ニュース一覧へ</a>
  </div>
</section>
  <!-- バナー3種 -->
  <div class="banner">
    <div class="c-column">

      <?php if( have_rows('banners') ): ?>
        <div class="banner-box">
          <?php
            // テンプレートを表示している固定ページの ID が 456 なら…
            $page_id = 1142;
          ?>
          <?php while( have_rows('banners') ): the_row();
            $img  = get_sub_field('banner_image');
            $url  = get_sub_field('banner_link');
            $new_tab = get_sub_field('open_in_new_tab');
            if( !$img || !$url ) continue;
          ?>
            <a href="<?php echo esc_url($url); ?>"
              <?php if( $new_tab ): ?> target="_blank" rel="noopener"<?php endif; ?>>
              <img src="<?php echo esc_url($img['url']); ?>"
                  alt="<?php echo esc_attr($img['alt']); ?>"
                  loading="lazy">
            </a>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
  <!--end バナー3種 -->

  <!-- youtube -->
  <div class="box01-ytb">
    <div class="c-column">
      <iframe width="530" height="290" src="https://www.youtube.com/embed/yESG1PHP7M8?si=JtnefZhBvAF7WKXB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </div>
  <!-- youtube -->

  <section class="top-box _bg">
    <div class="c-column">

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">ご利用案内<span>Guide</span></h2>
          <p>プレー料金、練習場のご案内について掲載しております。<br>ご利用の前にこちらをご確認ください。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/guide/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_01_02.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">コース案内<span>Course</span></h2>
          <p>どのホールからも富士山が望める富士平原ゴルフクラブ。<br>プレー時に世界遺産のベストショットをお楽しみください。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/course/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_02.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">施設案内<span>Facility</span></h2>
          <p>当クラブの施設内情報を掲載しております。<br></p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/facility/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_03.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">レストラン<span>Restaurant</span></h2>
          <p>レストラン西側窓正面に雄大な富士山を！南側窓からはコースを望みながら、チーフ自慢の料理をご堪能下さい。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_04.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">アクセス<span>Access</span></h2>
          <p>当クラブまでのアクセス情報について掲載しております。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/access/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_05.jpg" alt="" loading="lazy"></span>
      </div>

    </div>
  </section>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>