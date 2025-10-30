      <?php
      /*
      Template Name: Google Form テスト
      */
      ?>

      <!--本番ではこのページのみ挿入 functions.php-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
      <!--本番ではこのページのみ挿入 functions.php-->

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/header/page-header6.jpg">
          <div class="c-column s-page-header__inner">
            <h1 class="c-page-header__title">Form
              <span>フォーム</span>
            </h1>
          </div>
        </div>

        
        <section class="_mtl">
         <div class="c-column-s">

       

          <p class="c-ct-lead">コース紹介のリード文が入ります。コース紹介のリード文が入ります。コース紹介のリード文が入ります。コース紹介のリード文が入ります。コース紹介のリード文が入ります。コース紹介のリード文が入ります。</p>
          <!-- <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdP9PoQ8SaUkjOOct83UBhbzHqlsryoFqvur911Mf-CRhk7yQ/viewform?embedded=true" width="1000" height="2000" frameborder="0" marginheight="0" marginwidth="0">読み込んでいます…</iframe> -->
            <!-- <iframe src="https://script.google.com/macros/s/AKfycby51BZgXhrY4powHgUYonV0vayeTQSSVmt14Dct_TQppuZHYffTt8csaNSJ8uuJgcSqeQ/exec" width="100%" height="1000" frameborder="0" style="border: none;"></iframe> -->
              <!-- https://script.google.com/macros/s/AKfycbzNhy49TPsWTjfKRB-aJ9I36_dIIrUTbIufAfBgJJA-Z9WT_NYA3rKlM8WQkQXAT7Q1qg/exec -->
              <!-- https://script.google.com/macros/s/AKfycbzF862_aI1paw0YINJ91GGSQ2PrCf6coKIYE8ONm5ot-7hfkJGj_IXP4X-UArD9viJG/exec -->
              <!-- https://script.google.com/macros/s/AKfycbw-hAVC-XXD7lJqNe4auVpm7yXB5I4oaGU09jzgSjZO19Qin9T4gizG6vHP2I3Lfax2/exec -->
              
         </div>
        </section>


        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="">フォームテスト</a></li>
          </ul>
        </div>
       
        </main>




        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
          <!--  フッタ読込 -->

        <!--本番ではこのページのみ挿入 functions.php-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <!--本番ではこのページのみ挿入 functions.php-->

          <?php wp_footer(); ?>

        </body>

        </html>