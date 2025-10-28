    <?php
      /*
      Template Name: 求人情報
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
            <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/page-header.jpg">
                <div class="c-column c-page-header__inner">
                    <h1 class="c-page-header__title">Recruit<span>求人情報</span></h1>
                </div>
            </div>

            <section>
                <div class="c-column-s">
                    <img class="pc-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/recruit.jpg" alt="リクルート情報" loading="lazy">
                    <img class="sp-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/sp-recruit.jpg" alt="リクルート情報" loading="lazy">

                    <div class="slider-box">
                        <p class="c-forsp slider-box__txt--s">スクロールしてご覧になれます→</p>
                        <div class="slider-box__inner">
                            <img class="sp-img sp-img2" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/sp-recruit2.jpg" alt="リクルート情報" loading="lazy">
                        </div>
                        <p class="c-forsp slider-box__txt c-tac">詳細はPDFをご確認ください！</p>
                        <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/pdf_rec.pdf" class="slider-box__btn c-forsp" target="_blank">PDFをダウンロード</a>
                    </div>

                    <div id="youtube">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/JLoAYUQIxsM?si=4aBKdgIyqBMFA3pa"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                        <h3>\　WEBからの応募はこちら↓　/</h3>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSf1SgM4vY-vAHctcgLp5ICClCO5awv8tSfzlBlu2SwWj0rC7w/viewform?usp=sharing" class="request-btn" target="_blank">応募に進む</a>
                    </div>

                </div>
            </section>

            <div class="c-column">
                <ul class="c-brd">
                    <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
                    <li><a href="">求人情報</a></li>
                </ul>
            </div>

        </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

        