    <?php
      /*
      Template Name: ドレスコード
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
            <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/header/page-header4.jpg">
                <div class="c-column c-page-header__inner">
                    <h1 class="c-page-header__title">Dresscode<span>ドレスコード</span></h1>
                </div>
            </div>

            <section class="_mtl">
                <div class="c-column-s">
                    <h2 class="c-head1">ドレスコード<span class="c-head1__en">Dresscode</span></h2>
                    <div class="c-tac">
                        <p class="c-tal">
                            当倶楽部は会員制ゴルフ倶楽部であり、ドレスコードを設定させて頂いております。<br>
                            ご来場またはプレーの際には紳士淑女に相応しい品位ある着こなしをして頂くようお願い致します。<br>
                            また、認められている服装であっても、他のお客様に不快を与える可能性のある服装に関しては、ご遠慮いただく場合がございますので予めご了承ください。<br>
                            詳細はこちらの案内をご参考下さい。
                        </p>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/2015dresscode.jpg" alt="ドレスコード" class="_mts">
                    </div>

                </div>
            </section>

            <div class="c-column">
                <ul class="c-brd">
                    <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
                    <li><a href="">ドレスコード</a></li>
                </ul>
            </div>

        </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

       