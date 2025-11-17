<?php
/*
  Template Name: 会員お知らせ
*/
?>

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

  <!-- 会員ナビ -->
  <ul class="m-list">
    <li><a href="<?php echo esc_url(home_url('/m-news/')); ?>">会員様お知らせ</a></li>
    <li><a href="<?php echo esc_url(home_url('/m-news/m-sales/')); ?>">営業案内</a></li>
    <li><a href="<?php echo esc_url(home_url('/m-news/m-kusunoki/')); ?>">くすのき会</a></li>
    <li><a href="<?php echo esc_url(home_url('/m-news/m-partner/')); ?>">提携コース</a></li>
    <li><a href="<?php echo esc_url(home_url('/m-news/m-calendar/')); ?>">ビジター様料金</a></li>
    <li><a href="<?php echo esc_url(home_url('/m-news/m-registration/')); ?>">コンペ申込</a></li>
  </ul>

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>

        <ul class="news-box__list">

          <?php
          /* -----------------------------
            基本設定
          ----------------------------- */
          $paged = max(1, get_query_var('paged'));
          $year  = intval(get_query_var('year'));
          $ppp   = 10;

          /* -----------------------------
            会員（member カテゴリ）の記事を取得
          ----------------------------- */
          $member_q = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => $ppp,
            'paged'               => $paged,
            'category_name'       => 'member',
            'year'                => $year,
            'ignore_sticky_posts' => true,
          ]);

          if ($member_q->have_posts()):
            while ($member_q->have_posts()):
              $member_q->the_post();
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
          <?php custom_pagination($member_q); ?>
        </ul>

      </div>

      <!-- ======================
          サイドバー（会員）
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
                'posts_per_page'      => 5,
                'category_name'       => 'member',
                'ignore_sticky_posts' => true,
              ]);

              while ($recent_q->have_posts()):
                  $recent_q->the_post();
              ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_postdata(); ?>
            </ul>
          </div>

          <!-- 年別アーカイブ -->
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

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li>会員様お知らせ</li>
    </ul>

  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
