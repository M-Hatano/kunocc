      <?php
      /*
      Template Name: コース紹介（箱根コースTOP）
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/page-header2.jpg">
          <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">Course
              <span>箱根コース</span>
            </h1>
          </div>
        </div>

        
        <section class="_mtl">
         <div class="c-column-s">

          <div class="visual">
            <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/slick_hakone_01.jpg"></div>
            <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/slick_hakone_03.jpg"></div>
            <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/slick_hakone_06.jpg"></div>
            <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/slick_hakone_09.jpg"></div>
            <div><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/slick_hakone_09-2.jpg"></div>
          </div>

          <p class="c-ct-lead">フラットで豪快な富士コースとは対照的に戦略性に富む9ホール。<br>距離もたっぷりあり、ドッグレッグするホールもある。<br>ゴルファーの技量を試すにふさわしいコースです。</p>

          <h2 class="c-head1 c-tac _mtl">各ホール詳細<span class="c-head1__en">HoleInfo</span></h2>

          <div class="cslist">
            <?php if ( have_rows( 'hi_hole_cards' ) ) : ?>

              <?php
                $course_slug = get_post_field( 'post_name', get_the_ID() );
                $course_code = substr( $course_slug, 0, 1 ); // f / h / t
              ?>

              <?php while ( have_rows( 'hi_hole_cards' ) ) : the_row(); ?>
                <?php
                  $hole_no   = get_sub_field( 'hi_hole_no' );         // 数値 or null
                  $hole_code = $hole_no ? sprintf( '%02d', $hole_no ) : ''; // 01〜18
                  $thumb     = get_sub_field( 'hi_hole_image' );      // URL または false
                  $link      = $hole_code
                              ? home_url( "/course/{$course_slug}/{$course_code}{$hole_code}/" )
                              : '';                                   // 番号がない場合リンクは空

                  $stats = [];
                  if ( have_rows( 'hi_green_info' ) ) {
                    while ( have_rows( 'hi_green_info' ) ) {
                      the_row();
                      $label = trim( get_sub_field( 'hi_green_label' ) );
                      if ( $label !== '' ) {
                        $stats[] = $label;
                      }
                    }
                  }
                ?>

                <div class="csbox csbox2">
                  <a href="<?php echo esc_url( $link ?: '#' ); ?>">

                    <?php if ( $hole_no ) : ?>
                      <p class="csbox__ttl">HOLE<span><?php echo esc_html( $hole_no ); ?></span></p>
                    <?php endif; ?>

                    <?php if ( ! empty( $stats ) ) : ?>
                      <div class="csbox__hd">
                        <?php foreach ( $stats as $stat ) : ?>
                          <p class="csbox__hd--txt"><?php echo esc_html( $stat ); ?></p>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>

                    <?php if ( $thumb ) : ?>
                      <img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy">
                    <?php endif; ?>

                  </a>
                </div>

              <?php endwhile; ?>
            <?php endif; ?>
          </div>

         </div>
        </section>


        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/course/">コース全景</a></li>
            <li><a href="">箱根コース</a></li>
          </ul>
        </div>
       
        </main>




        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
          <!--  フッタ読込 -->

        

          <?php wp_footer(); ?>

        </body>

        </html>