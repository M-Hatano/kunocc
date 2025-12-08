<?php
/*
  Template Name: 会員営業案内
*/
?>

<?php get_header('120'); ?>

<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>営業案内</span>
      </h1>
    </div>
  </div>

  <!-- 共通メニュー -->
  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
  <!-- 共通メニュー -->

  <div class="c-column">
    <div class="news-box">

      <!-- ======================
           左カラム：一覧
      ====================== -->
      <div class="news-box__left">
        <h2 class="c-head6">営業案内<span>News</span></h2>
        <ul class="news-box__list">

        <?php
        $paged = max(1, get_query_var('paged'));
        $year  = intval(get_query_var('year'));
        $ppp   = 10;

        /*
         * ▼ カスタム投稿仕様（member_post）
         * ▼ カテゴリ → member_category: information
         */
        $info_q = new WP_Query([
          'post_type'      => 'member_post',
          'posts_per_page' => $ppp,
          'paged'          => $paged,
          'year'           => $year,
          'tax_query'      => [
            [
              'taxonomy' => 'member_category',
              'field'    => 'slug',
              'terms'    => 'information',
            ]
          ],
          'ignore_sticky_posts' => true,
        ]);

        if ($info_q->have_posts()):
          while ($info_q->have_posts()):
            $info_q->the_post();
        ?>
          <li>
            <a href="<?php
              $file = get_field('news_file');
              if (get_field('link_url')) {
                echo esc_url(get_field('link_url'));
              } elseif ($file && get_field('direct_link')) {
                echo esc_url($file);
              } else {
                the_permalink();
              }
            ?>">
              <span class="news-box__time"><?php echo get_the_date('Y.m.d'); ?></span>
              <?php the_title(); ?>
            </a>
          </li>
        <?php
          endwhile;
        else:
          echo '<li>現在お知らせはありません。</li>';
        endif;

        wp_reset_postdata();
        ?>

        </ul>

        <!-- ページネーション -->
        <ul class="c-pagenation">
          <?php custom_pagination($info_q); ?>
        </ul>
      </div>


      <!-- ======================
           右カラム：サイドバー
      ====================== -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>

        <div class="news-box__right--box">

          <!-- 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
            <?php
            $recent_q = new WP_Query([
              'post_type'      => 'member_post',
              'posts_per_page' => 5,
              'tax_query'      => [
                [
                  'taxonomy' => 'member_category',
                  'field'    => 'slug',
                  'terms'    => 'information',
                ]
              ],
              'ignore_sticky_posts' => true,
            ]);

            while ($recent_q->have_posts()): $recent_q->the_post(); ?>
              <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile;

            wp_reset_postdata(); ?>
            </ul>
          </div>


          <!-- 年別アーカイブ -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">

            <?php
                // ==============================
                // 年度別アーカイブ（member_post × information）
                // ==============================

                global $wpdb;

                // 年度一覧を取得
                $years = $wpdb->get_col("
                    SELECT DISTINCT YEAR(p.post_date)
                    FROM $wpdb->posts p
                    INNER JOIN $wpdb->term_relationships tr ON p.ID = tr.object_id
                    INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    INNER JOIN $wpdb->terms t ON t.term_id = tt.term_id
                    WHERE p.post_type = 'member_post'
                      AND p.post_status = 'publish'
                      AND tt.taxonomy = 'member_category'
                      AND t.slug = 'information'
                    ORDER BY YEAR(p.post_date) DESC
                ");

                if (!empty($years)) :
                    foreach ($years as $y) :

                        // 年ごとの投稿数
                        $count = $wpdb->get_var($wpdb->prepare("
                            SELECT COUNT(*)
                            FROM $wpdb->posts p
                            INNER JOIN $wpdb->term_relationships tr ON p.ID = tr.object_id
                            INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                            INNER JOIN $wpdb->terms t ON t.term_id = tt.term_id
                            WHERE p.post_type = 'member_post'
                              AND p.post_status = 'publish'
                              AND YEAR(p.post_date) = %d
                              AND tt.taxonomy = 'member_category'
                              AND t.slug = 'information'
                        ", $y));

                        if ($count > 0):
                            $url = home_url("/member/information/{$y}/");
                ?>
                <li>
                <a href="<?php echo esc_url(site_url("/member/information/{$y}/")); ?>">
                    <?php echo esc_html($y); ?>年（<?php echo esc_html($count); ?>）
                  </a>
                </li>
                <?php
                        endif;

                    endforeach;
                endif;
                ?>


            </ul>
          </div>

        </div>
      </div>

    </div>

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo home_url(); ?>">TOP</a></li>
      <li><a href="<?php echo home_url('/member/'); ?>">会員サイト</a></li>
      <li><a>営業案内</a></li>
    </ul>
  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
