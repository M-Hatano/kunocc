      <?php
      /*
      Template Name: アウトコースホール詳細
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/page-header1.jpg">
          <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">Course
              <span>富士コース</span>
            </h1>
          </div>
        </div>

        
          <section class="_mtl">
            <div class="c-column-s">

              <div class="b-c-dtl__top">
                <?php
                  // ホール番号取得
                  $hole_num = intval(get_field('hole-no'));
                  $max_hole     = 18;

                  // 前後ホール番号（ループ）
                  $prev_num = ($hole_num > 1) ? $hole_num - 1 : $max_hole;
                  $next_num = ($hole_num < $max_hole) ? $hole_num + 1 : 1;

                  // URL組み立て
                  $prev_url = home_url(sprintf('/course/hole%d/', $prev_num));
                  $next_url = home_url(sprintf('/course/hole%d/', $next_num));
                ?>

                <div>
                  <a href="<?php echo esc_url($prev_url); ?>" class="b-c-dtl__btn pre">Preview</a>
                  <h2 class="b-c-dtl__top--hd">Hole<span><?php the_field('hole-no'); ?></span></h2>
                  <a href="<?php echo esc_url($next_url); ?>" class="b-c-dtl__btn nxt">Next</a>
                </div>
              </div>
          
              <div class="b-c-dtl__rate">
                <p class="b-c-dtl__rate--hd">
                  <span><?php the_field('par'); ?></span> / <span><?php the_field('hdcp'); ?></span>
                <span class="b-c-dtl__rate--small">
                <span class="div">
                  <?php if( have_rows('green_info') ): ?>
                    <?php while( have_rows('green_info') ): the_row(); ?>
                      <?php
                        $label = get_sub_field('green_label');
                        if (preg_match('/^(.+?)\s+(\d+)(Y?)$/', $label, $matches)) {
                          echo '<span>' . esc_html($matches[1]) . ' ' . esc_html($matches[2] . $matches[3]) . '</span>';
                        } else {
                          echo '<span>' . esc_html($label) . '</span>';
                        }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                </span>
              </span>
              </p>
  
            
            
            
              <ul class="b-c-dtl__yd">
                <li>
                  <span>BACK</span>
                  <span>
                    <?php if (have_rows('tee_back')) : ?>
                      <?php while (have_rows('tee_back')) : the_row(); ?>
                        <?php if (get_sub_field('yard')) : ?>
                          <span class="div"><?php the_sub_field('yard'); ?></span>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </span>
                </li>
                <li>
                  <span>REG</span>
                  <span>
                    <?php if (have_rows('tee_reg')) : ?>
                      <?php while (have_rows('tee_reg')) : the_row(); ?>
                        <?php if (get_sub_field('yard')) : ?>
                          <span class="div"><?php the_sub_field('yard'); ?></span>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </span>
                </li>
                <li>
                  <span>FRONT</span>
                  <span>
                    <?php if (have_rows('tee_front')) : ?>
                      <?php while (have_rows('tee_front')) : the_row(); ?>
                        <?php if (get_sub_field('yard')) : ?>
                          <span class="div"><?php the_sub_field('yard'); ?></span>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </span>
                </li>
                <li>
                  <span>LADIES</span>
                  <span>
                    <?php if (have_rows('tee_ladies')) : ?>
                      <?php while (have_rows('tee_ladies')) : the_row(); ?>
                        <?php if (get_sub_field('yard')) : ?>
                          <span class="div"><?php the_sub_field('yard'); ?></span>
                        <?php endif; ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                  </span>
                </li>
              </ul>
          </div>

          <div class="b-c-dtl_info">
            <div class="b-c-dtl_info--lt">
              <ul>
                <?php if ( get_field('sub_image_a') || get_field('sub_text_a') ) : ?>
                  <li>
                    <?php if ( get_field('sub_image_a') ) : ?>
                      <img src="<?php the_field('sub_image_a'); ?>" alt="" loading="lazy">
                    <?php endif; ?>
                    <?php if ( get_field('sub_text_a') ) : ?>
                      <p><?php the_field('sub_text_a'); ?></p>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>

                <?php if ( get_field('sub_image_b') || get_field('sub_text_b') ) : ?>
                  <li>
                    <?php if ( get_field('sub_image_b') ) : ?>
                      <img src="<?php the_field('sub_image_b'); ?>" alt="" loading="lazy">
                    <?php endif; ?>
                    <?php if ( get_field('sub_text_b') ) : ?>
                      <p><?php the_field('sub_text_b'); ?></p>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>

                <?php if ( get_field('sub_image_c') || get_field('sub_text_c') ) : ?>
                  <li>
                    <?php if ( get_field('sub_image_c') ) : ?>
                      <img src="<?php the_field('sub_image_c'); ?>" alt="" loading="lazy">
                    <?php endif; ?>
                    <?php if ( get_field('sub_text_c') ) : ?>
                      <p><?php the_field('sub_text_c'); ?></p>
                    <?php endif; ?>
                  </li>
                <?php endif; ?>
              </ul>
            </div>

            <div class="b-c-dtl_info--rt">
              <?php if ( get_field('hole_image') ) : ?>
                <img src="<?php the_field('hole_image'); ?>" alt="" loading="lazy">
              <?php endif; ?>
            </div>
          </div>

          

          <div class="b-c-dtl__btm">
            <?php course_navigation(); ?>
          </div>

          <div class="b-c-dtl__csbtn">
            <div>
            <ul>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole1/">1</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole2/">2</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole3/">3</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole4/">4</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole5/">5</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole6/">6</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole7/">7</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole8/">8</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole9/">9</a>
              </li>
            </ul>
            </div>

            <div>
            <ul>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole10/">10</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole11/">11</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole12/">12</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole13/">13</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole14/">14</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole15/">15</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole16/">16</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole17/">17</a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url('')); ?>/course/hole18/">18</a>
              </li>
            </ul>
            </div>
          </div>
            
         </div>
        </section>


        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/course/">コース全景</a></li>
            <li><a href="/">hole<?php the_field('hole-no'); ?></a></li>
          </ul>
        </div>
       
        </main>




        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
          <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

        </html>