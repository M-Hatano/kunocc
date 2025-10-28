      <?php
      /*
      Template Name: コース詳細（富士コース）
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

          <div class="b-c-dtl__csbtn">
            <div>
              <p>富士コース</p>
                <ul>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f01/">1</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f02/">2</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f03/">3</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f04/">4</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f05/">5</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f06/">6</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f07/">7</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f08/">8</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/f09/">9</a></li>
                </ul>
            </div>
          </div>

              <div class="b-c-dtl__top">
                <?php
                  // ホール番号取得
                  $hole_num = intval(get_field('hole-no'));

                  // 親ページのスラッグ（例: fuji, hakone, tanzawa）取得
                  global $post;
                  $parent_id    = wp_get_post_parent_id($post->ID);
                  $course_slug  = get_post_field('post_name', $parent_id);
                  $prefix       = substr($course_slug, 0, 1);
                  $max_hole     = 9;

                  // コース名の表示（日本語化）
                  $course_name = '';
                  switch ($course_slug) {
                    case 'fuji':    $course_name = '富士コース'; break;
                    case 'hakone':  $course_name = '箱根コース'; break;
                    case 'tanzawa': $course_name = '丹沢コース'; break;
                    default:        $course_name = ucfirst($course_slug) . 'コース'; break;
                  }

                  // 前後ホール番号（ループ）
                  $prev_num = ($hole_num > 1) ? $hole_num - 1 : $max_hole;
                  $next_num = ($hole_num < $max_hole) ? $hole_num + 1 : 1;

                  // URL組み立て
                  $prev_url = home_url(sprintf('/course/%s/%s%02d/', $course_slug, $prefix, $prev_num));
                  $next_url = home_url(sprintf('/course/%s/%s%02d/', $course_slug, $prefix, $next_num));
                ?>

                <p class="b-c-dtl__csname">- <span><?php echo esc_html($course_name); ?></span> -</p>
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
              <p>箱根コース</p>
                <ul>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h01/">1</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h02/">2</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h03/">3</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h04/">4</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h05/">5</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h06/">6</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h07/">7</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h08/">8</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/hakone/h09/">9</a></li>
                </ul>
            </div>

            <div>
              <p>丹沢コース</p>
                <ul>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t01/">1</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t02/">2</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t03/">3</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t04/">4</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t05/">5</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t06/">6</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t07/">7</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t08/">8</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/tanzawa/t09/">9</a></li>
                </ul>
            </div>
          </div>
            
         </div>
        </section>


        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/course/">コース全景</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/course/fuji/">富士コース</a></li>
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