<?php
      /*
      Template Name: リンク集
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
      <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/header/page-header2.jpg">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Links
            <span>リンク集</span>
          </h1>
        </div>
      </div>

      <section class="_mtl">
        <div class="c-column-s">

          <h3 class="partnership-golf">リゾート</h3>
          <ul class="link-lists">
            <li class="link-external"><a href="" target="_blank" rel="noopener noreferrer">テストリンク</a></li>
          </ul>

          <h3 class="partnership-golf">観光案内</h3>
          <ul class="link-lists">
            <li class="link-external"><a href="" target="_blank"
                rel="noopener noreferrer">テストリンク</a></li>
          </ul>

          <h3 class="partnership-golf">お食事処</h3>
          <ul class="link-lists">
            <li class="link-external"><a href="" target="_blank"
                rel="noopener noreferrer">テストリンク</a></li>
          </ul>




        </div>

      </section>
      <div class="c-column">
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
          <li><a href="">リンク集</a></li>
        </ul>
      </div>

    </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

   