    <?php
    /*
      Template Name: 提携コース
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-member">
      <div class="for_deco">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Member
            <span>提携コースのご案内</span>
          </h1>
        </div>
      </div>

     <!-- 共通メニュー -->
    <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
    <!-- 共通メニュー -->

      <div class="c-column">
        <h2 class="c-head6 m_head">提携コースのご案内<span>Partner Courses</span></h2>
        <p>当倶楽部の提携コースの情報を<br class="c-brsp">掲載しております</p>
        <div class="c-form box-pat">
          <div class="for_deco">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
          <ul>
            <?php if (have_rows('partner_courses')): ?>
              <?php while (have_rows('partner_courses')): the_row(); ?>

                <?php
                  $name = get_sub_field('course_name');
                  $pdf  = get_sub_field('course_pdf');
                  $pdf_url = '';

                  if (is_array($pdf) && !empty($pdf['url'])) {
                      $pdf_url = $pdf['url'];
                  }
                ?>

                <?php if (!empty($name)): ?>
                  <li>
                    <?php if ($pdf_url): ?>
                      <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener">
                        <?php echo esc_html($name); ?>
                      </a>
                    <?php else: ?>
                      <?php echo esc_html($name); ?>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>

              <?php endwhile; ?>
            <?php endif; ?>
          </ul>
        </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="<?php echo esc_url(home_url('')); ?>/member/">会員サイト</a></li>
          <li><a href="">提携コースのご案内</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>