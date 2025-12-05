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
    <?php
    // ACFで設定した画像を取得
    $image_1 = get_field('top_image_1');
    $image_2 = get_field('top_image_2');
    $image_3 = get_field('top_image_3');

    // ACF返却値（配列/ID/URLすべて対応）→ URL(custom_2600) に変換
    function kv_get_url_2600($img) {

        // ACF画像配列
        if (is_array($img) && isset($img['ID'])) {
            return wp_get_attachment_image_url($img['ID'], 'custom_2600');
        }

        // ID
        if (is_numeric($img)) {
            return wp_get_attachment_image_url((int)$img, 'custom_2600');
        }

        // URL
        if (is_string($img)) {
            $id = attachment_url_to_postid($img);
            if ($id) {
                return wp_get_attachment_image_url($id, 'custom_2600');
            }
            return $img;
        }

        return '';
    }

    $url_1 = kv_get_url_2600($image_1);
    $url_2 = kv_get_url_2600($image_2);
    $url_3 = kv_get_url_2600($image_3);
    ?>

    <div>
      <!-- 1つ目の画像 -->
      <?php if ($url_1): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($url_1); ?>');"></div>
      <?php endif; ?>

      <!-- 2つ目の画像 -->
      <?php if ($url_2): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($url_2); ?>');"></div>
      <?php endif; ?>

      <!-- 3つ目の画像 -->
      <?php if ($url_3): ?>
        <div class="kv-img" style="background-image: url('<?php echo esc_url($url_3); ?>');"></div>
      <?php endif; ?>
    </div>

    <div class="top-mtxt">
      <h1>心をほどく、<br class="">美しさと味わいの時間を。</h1>
      <p>緑が彩るコース、旬を味わう料理、<br class="c-brsp">心を尽くした接遇。<br>訪れるたび、ここを選んでよかったと思える。<br class="c-brpc">気持ちを込めて、上質なおもてなしをお届けします。</p>
    </div>
</div>

  <!-- 共通パーツ -->
  <?php include get_template_directory() . '/include-120-reservation-start.php'; ?>
  <!-- 共通パーツ -->
  

  <section class="top-news">
    <div class="bg-news">
      <div class="c-column">
        <h2 class="c-sec-headline">Information</h2>
      </div>

      <div class="post-index">
        <ul>
          <?php
          /* --------------------------------
        * 共通設定
        * --------------------------------*/
          $posts_per_page = 4;        // 表示件数
          $shown_ids      = [];       // 表示済み ID を格納

          /* --------------------------------
        * ① ニュースカテゴリに属する Sticky 投稿
        * --------------------------------*/
          $sticky_ids = [];
          $all_sticky = get_option('sticky_posts');

          if ($all_sticky) {
            $sticky_ids = get_posts([
              'post_type'      => 'post',
              'post__in'       => $all_sticky,
              'category_name'  => 'news',
              'fields'         => 'ids',
              'posts_per_page' => -1,
            ]);
          }

          if ($sticky_ids) :
            $sticky_q = new WP_Query([
              'post_type' => 'post',
              'post__in'  => $sticky_ids,
              'orderby'   => 'post__in',  // Sticky順
            ]);

            while ($sticky_q->have_posts()) : $sticky_q->the_post();
              $shown_ids[] = get_the_ID(); ?>
              <li>
                <a href="<?php
                          $news_file = get_field('news_file');
                          if (get_field('link_url')) {
                            echo esc_url(get_field('link_url'));
                          } elseif ($news_file && get_field('direct_link')) {
                            echo esc_url($news_file);
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
          $remain = $posts_per_page - count($shown_ids);

          if ($remain > 0) :
            $normal_q = new WP_Query([
              'post_type'           => 'post',
              'posts_per_page'      => $remain,
              'category_name'       => 'news',
              'post__not_in'        => $shown_ids,
              'ignore_sticky_posts' => true,   // 重複防止
            ]);

            if ($normal_q->have_posts()) :
              while ($normal_q->have_posts()) : $normal_q->the_post(); ?>
                <li>
                  <a href="<?php
                            $news_file = get_field('news_file');
                            if (get_field('link_url')) {
                              echo esc_url(get_field('link_url'));
                            } elseif ($news_file && get_field('direct_link')) {
                              echo esc_url($news_file);
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
          if (empty($shown_ids) && (empty($normal_q) || ! $normal_q->post_count)) {
            echo '<li>現在お知らせはありません。</li>';
          }
          ?>
        </ul>
      </div>

      <a href="<?php echo esc_url(home_url('/news')); ?>" class="top-news__more">ニュース一覧へ</a>
    </div>
  </section>

  <!-- ボタンエリア -->
  <div class="btnarea">
    <div class="c-column">
      <ul>
        <li>
          <a href="<?php echo esc_url(home_url('')); ?>/recruit/">キャディスタッフ<br class="c-brsp">募集中</a>
        </li>
        <li>
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/charity240619.pdf" target="_blank">チャリティ<br class="c-brsp">ゴルフェスタ</a>
        </li>
        <li>
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/member2024.pdf" target="_blank">会員募集について</a>
        </li>
        <li>
          <a href="<?php echo esc_url(home_url('')); ?>/dresscode/">ドレスコード</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- ボタンエリア -->

  <section class="top-box">
    <span class="deco _01"><span></span></span>
    <span class="deco _02"><span></span></span>
    <span class="deco _03"><span></span></span>
    <div class="c-column">

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">ご予約方法について<span>Reservation</span></h2>
          <p>ご予約方法についてテキストが入ります。ご予約方法についてテキストが入ります。ご予約方法についてテキストが入ります。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/guide/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_01.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">レストラン<span>Restaurant</span></h2>
          <p>レストランが入ります。レストランが入ります。レストランが入ります。レストランが入ります。レストランが入ります。レストランが入ります。レストランが入ります。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/course/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_02.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">プライベートルーム<span>PrivateRoom</span></h2>
          <p>プライベートルームの説明が入ります。プライベートルームの説明が入ります。プライベートルームの説明が入ります。プライベートルームの説明が入ります。<br></p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/facility/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_03.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">施設案内<span>Facility</span></h2>
          <p>施設案内テキストが入ります。施設案内テキストが入ります。施設案内テキストが入ります。施設案内テキストが入ります。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_04.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">コース案内<span>Courrse</span></h2>
          <p>緑豊かな景観と丁寧に整えられたフェアウェイが魅力のコース。季節の移ろいを感じながら、静かな環境の中で上質なゴルフ時間をお過ごしいただけます。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/access/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_05.jpg" alt="" loading="lazy"></span>
      </div>

      <div class="top__flex fade-in">
        <div class="top__info">
          <h2 class="c-head4">アクセス&bull;近隣ホテル情報<span>Access</span></h2>
          <p>交通手段ごとのアクセス、近隣ホテルの情報を掲載しております。</p>
          <p class="top__flex--btn"><a href="<?php echo esc_url(home_url('')); ?>/access/">more</a></p>
        </div>
        <span class="top__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/img_06.jpg" alt="" loading="lazy"></span>
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