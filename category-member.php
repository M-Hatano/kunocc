<?php
/**
 * Category Template: Member
 * カテゴリ「member」＋子カテゴリ（kusunoki / information）の記事一覧
 * 年別アーカイブ（/category/member/2025/）にも対応
 */

get_header('120');

// ----------------------------------------------
// 基本データ
// ----------------------------------------------
$paged = max(1, get_query_var('paged'));
$year  = intval(get_query_var('year')); // 年別のときは自動でセットされる

// このカテゴリで抽出すべきカテゴリスラッグ
$category_slugs = ['member', 'kusunoki', 'information'];

?>

<main class="c-member">
  <span class="deco _01"><span></span></span>

  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Member
        <span>会員様お知らせ</span>
      </h1>
    </div>
  </div>

  <!-- 共通メニュー -->
  <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
  <!-- 共通メニュー -->

  <div class="c-column">
    <div class="news-box">
      <div class="news-box__left">

        <h2 class="c-head6">会員様お知らせ<span>Member News</span></h2>

        <ul class="news-box__list">

          <?php
          // ------------------------------------------------
          // ① Sticky（1ページ目のみ）
          // ------------------------------------------------
          $sticky_ids = [];
          $shown_ids  = [];

          if ($paged === 1) {

              $all_sticky = get_option('sticky_posts');

              if (!empty($all_sticky)) {

                  $sticky_ids = get_posts([
                      'post_type'      => 'post',
                      'post__in'       => $all_sticky,
                      'fields'         => 'ids',
                      'posts_per_page' => -1,
                      'year'           => $year,
                      'tax_query'      => [
                          [
                              'taxonomy' => 'category',
                              'field'    => 'slug',
                              'terms'    => $category_slugs,
                              'operator' => 'IN',
                          ]
                      ],
                  ]);

                  $sticky_ids = array_slice($sticky_ids, 0, 10);
              }

              if (!empty($sticky_ids)):
                  $sticky_q = new WP_Query([
                      'post_type' => 'post',
                      'post__in'  => $sticky_ids,
                      'orderby'   => 'post__in',
                  ]);

                  while ($sticky_q->have_posts()): $sticky_q->the_post();
                      $shown_ids[] = get_the_ID();
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
                  wp_reset_postdata();
              endif;
          }

          // ------------------------------------------------
          // ② 通常記事
          // ------------------------------------------------
          $remain = ($paged === 1) ? 10 - count($shown_ids) : 10;

          $normal_q = new WP_Query([
              'post_type'           => 'post',
              'paged'               => $paged,
              'posts_per_page'      => $remain,
              'post__not_in'        => $shown_ids,
              'ignore_sticky_posts' => true,
              'year'                => $year,
              'tax_query'           => [
                  [
                      'taxonomy' => 'category',
                      'field'    => 'slug',
                      'terms'    => $category_slugs,
                      'operator' => 'IN',
                  ]
              ],
          ]);

          if ($normal_q->have_posts()):
              while ($normal_q->have_posts()): $normal_q->the_post();
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
              if (empty($shown_ids)) echo '<li>現在お知らせはありません。</li>';
          endif;

          wp_reset_postdata();
          ?>
        </ul>

        <!-- ページネーション -->
        <ul class="c-pagenation">
          <?php custom_pagination($normal_q); ?>
        </ul>

      </div>

      <!-- =========================
           サイドバー
      ========================== -->
      <div class="news-box__right">
        <h3 class="c-head5">Archive</h3>

        <div class="news-box__right--box">

          <!-- 新着5件 -->
          <div class="recent-posts-box">
            <h3>新着記事</h3>
            <ul>
              <?php
              $recent_q = new WP_Query([
                  'posts_per_page' => 5,
                  'post_type'      => 'post',
                  'ignore_sticky_posts' => true,
                  'tax_query'      => [
                      [
                          'taxonomy' => 'category',
                          'field'    => 'slug',
                          'terms'    => $category_slugs,
                          'operator' => 'IN',
                      ]
                  ],
              ]);

              while ($recent_q->have_posts()): $recent_q->the_post();
              ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_postdata(); ?>
            </ul>
          </div>

          <!-- 年別 -->
          <div>
            <h3>年度別</h3>
            <ul class="news-box__right--list">
              <?php
              $years = fhg_get_all_years();
              foreach ($years as $y):

                  $count = count(get_posts([
                      'post_type'      => 'post',
                      'fields'         => 'ids',
                      'posts_per_page' => -1,
                      'year'           => $y,
                      'tax_query'      => [
                          [
                              'taxonomy' => 'category',
                              'field'    => 'slug',
                              'terms'    => $category_slugs,
                              'operator' => 'IN',
                          ]
                      ],
                  ]));

                  if ($count === 0) continue;
              ?>
                <li>
                  <a href="<?php echo esc_url( home_url("/category/member/{$y}/") ); ?>">
                    <?php echo $y; ?>年（<?php echo $count; ?>）
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        </div>
      </div>

    </div>

    <!-- パンくず -->
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
      <li><a href="<?php echo esc_url(home_url('/category/member/')); ?>">会員様お知らせ</a></li>
      <?php if ($year): ?>
          <li><?php echo esc_html($year); ?>年</li>
      <?php endif; ?>
    </ul>

  </div>

</main>

<?php get_footer('120'); ?>
<?php wp_footer(); ?>
</body>
</html>
