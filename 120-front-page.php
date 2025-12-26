<?php
/*
Template Name: トップページ
*/
?>

<?php get_header('120'); ?>

<main class="c-main">

  <!-- ====================
       メインビジュアル
  ==================== -->
  <div class="top_mv">
    <?php
    // ACF画像取得
    $image_1 = get_field('top_image_1');
    $image_2 = get_field('top_image_2');
    $image_3 = get_field('top_image_3');

    /**
     * KV画像用
     * custom_1600 がなければ full を使用
     */
    function kv_force_1600_or_full($acf_value)
    {
      if (empty($acf_value)) {
        return null;
      }

      $id = 0;

      if (is_array($acf_value) && !empty($acf_value['ID'])) {
        $id = (int) $acf_value['ID'];
      } elseif (is_numeric($acf_value)) {
        $id = (int) $acf_value;
      } elseif (is_string($acf_value)) {
        $id = attachment_url_to_postid($acf_value);
      }

      if (! $id) {
        return null;
      }

      // full サイズはアップロード時点で 1600px 以下に制御
      return wp_get_attachment_image_url($id, 'full');
    }

    // URL生成
    $url_1 = kv_force_1600_or_full($image_1);
    $url_2 = kv_force_1600_or_full($image_2);
    $url_3 = kv_force_1600_or_full($image_3);
    ?>

    <div>
      <?php if ($url_1): ?>
        <div class="kv-img" style="background-image:url('<?php echo esc_url($url_1); ?>');"></div>
      <?php endif; ?>

      <?php if ($url_2): ?>
        <div class="kv-img" style="background-image:url('<?php echo esc_url($url_2); ?>');"></div>
      <?php endif; ?>

      <?php if ($url_3): ?>
        <div class="kv-img" style="background-image:url('<?php echo esc_url($url_3); ?>');"></div>
      <?php endif; ?>
    </div>

    <div class="top-mtxt">
      <h1>
        心をほどく、<br>
        美しさと味わいの時間を。
      </h1>
      <p>
        緑が彩るコース、旬を味わう料理、<br class="c-brsp">
        心を尽くした接遇。<br>
        訪れるたび、ここを選んでよかったと思える。<br class="c-brpc">
        気持ちを込めて、上質なおもてなしをお届けします。
      </p>
    </div>
  </div>

  <!-- ====================
       予約導線（共通）
  ==================== -->
  <?php include get_template_directory() . '/include-120-reservation-start.php'; ?>

  <!-- ====================
       お知らせ
  ==================== -->
  <section class="top-news">
    <div class="bg-news">
      <div class="c-column">
        <h2 class="c-sec-headline">Information</h2>
      </div>

      <div class="post-index">
        <ul>
          <?php
          // 表示設定
          $posts_per_page = 4;
          $shown_ids      = [];

          /**
           * ① Sticky（news カテゴリ）
           */
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
              'orderby'   => 'post__in',
            ]);

            while ($sticky_q->have_posts()) :
              $sticky_q->the_post();
              $shown_ids[] = get_the_ID();
          ?>
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
          <?php
            endwhile;
            wp_reset_postdata();
          endif;

          /**
           * ② 通常ニュース
           */
          $remain = $posts_per_page - count($shown_ids);

          if ($remain > 0) :
            $normal_q = new WP_Query([
              'post_type'           => 'post',
              'posts_per_page'      => $remain,
              'category_name'       => 'news',
              'post__not_in'        => $shown_ids,
              'ignore_sticky_posts' => true,
            ]);

            if ($normal_q->have_posts()) :
              while ($normal_q->have_posts()) :
                $normal_q->the_post();
          ?>
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
          <?php
              endwhile;
              wp_reset_postdata();
            endif;
          endif;

          if (empty($shown_ids) && (empty($normal_q) || ! $normal_q->post_count)) {
            echo '<li>現在お知らせはありません。</li>';
          }
          ?>
        </ul>
      </div>

      <a href="<?php echo esc_url(home_url('/news')); ?>" class="top-news__more">
        ニュース一覧へ
      </a>
    </div>
  </section>

  <!-- ====================
       ボタンエリア
  ==================== -->
  <div class="btnarea">
    <div class="c-column">
      <ul>
        <li><a href="<?php echo esc_url(home_url('/recruit/')); ?>">キャディスタッフ<br class="c-brsp">募集中</a></li>
        <li><a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/charity240619.pdf" target="_blank" rel="noopener noreferrer">チャリティ<br class="c-brsp">ゴルフフェスタ</a></li>
        <li><a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/member2024.pdf" target="_blank" rel="noopener noreferrer">会員募集について</a></li>
        <li><a href="<?php echo esc_url(home_url('/dresscode/')); ?>">ドレスコード</a></li>
      </ul>
    </div>
  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>

</body>
</html>
