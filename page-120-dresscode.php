    <?php
      /*
      Template Name: ドレスコード
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
            <div class="c-page-header lazyload">
                <div class="c-column c-page-header__inner">
                    <h1 class="c-page-header__title">Dresscode
                        <span>ドレスコード</span>
                    </h1>
                </div>
            </div>

            <div class="d-column">
                <p class="d-lead">
                    当倶楽部では、ご来場いただきましたすべてのお客様に、「不快感を与えない服装」を基準としてご来場時、プレー時、館内において下記のドレスコードを定めております。<br>ご来場の皆様全員のご協力をお願い致します。
                </p>
                <section>
                    <h2>プレー時以外の服装</h2>
                    <div class="dbox">
                        <span class="deco _01"><span></span></span>
                        <div class="dbox__flex">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy01.jpg" alt="">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy01.jpg" alt="">
                        </div>
                    </div>
                    <p>ご来場に際しては、上着（ジャケットやブレザー）等を着用してください。<br>但し、6〜9月は除きます。</p>
                </section>

                <section>
                    <h2>プレー時の服装</h2>
                    <div class="dbox">
                        <span class="deco _01"><span></span></span>
                        <div class="dbox__flex">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy01.jpg" alt="">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy01.jpg" alt="">
                        </div>
                    </div>
                    <p>襟付きのシャツ・スラックス、またはゴルフウェアの着用をお願いいたします。</p>
                </section>

                <section>
                    <div class="dbox colchen">
                        <span class="deco _01"><span></span></span>
                        <div class="dbox__ngsty">
                            <div class="dbox__ban">
                                <span></span>
                                <span></span>
                            </div>
                            <p>以下の服装はご遠慮ください</p>
                            <ul class="dbox__exam">
                                <li>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <p>ジーンズ</p>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <p>シャツ</p>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <p>トレーニング<br>ウェア</p>
                                </li>
                                <li>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <p>サンダル</p>
                                    <p>クロックス</p>
                                </li>
                            </ul>
                            <div class="dbox__atn">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/img_dress_01.jpg" alt="サンプル">
                                <p>プレー中及びクラブハウス内において、タオルを首に下げたり<br>首、肩に巻いたりすることはご遠慮願います。</p>
                            </div>
                        </div>

                        <div class="okbat">
                            <div>
                                <div class="okbat__imbox">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                </div>
                                <p>シャツの裾は必ずズボンの中に入れてください。</p>
                                <span class="okbat__ok"></span>
                                <div class="dbox__ban _bat">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <div>
                                <div class="okbat__imbox">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/dresscode/dummy02.jpg" alt="ダミー">
                                </div>
                                <p>
                                    ショートパンツは、<br>ゴルフ用で膝まであるものをご使用ください。<br>ハイソックスではなくてもOKですが、<br>アンクルソックス（くるぶしまでのもの）<br>はご遠慮いただいております。
                                </p>
                                <span class="okbat__ok"></span>
                                <div class="dbox__ban _bat">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <ul class="c-brd">
                    <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
                    <li><a href="">ドレスコード &amp; エチケット</a></li>
                </ul>
            </div>

            

        </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

          <?php wp_footer(); ?>

        </body>

</html>

       