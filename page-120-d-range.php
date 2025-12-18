    <?php
    /*
      Template Name: ゴルフ練習場
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main">
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Golf&nbsp;driving&nbsp;range
            <span>ゴルフ練習場のご案内</span>
          </h1>
        </div>
      </div>

      <div class="c-column">
        <h2 class="c-head6">ゴルフ練習場概要<span>Driving&nbsp;Range</span></h2>

        <div class="picare">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_01.jpg" class="fancybox" data-fancybox="range">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_01.jpg" alt="練習場">
          </a>
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_02.jpg" class="fancybox" data-fancybox="range">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_02.jpg" alt="練習場">
          </a>
        </div>

        <p>
          当倶楽部の練習場は、ゆとりある数多くの打席を備えたドライビングレンジを完備。<br>
          <!-- 天候に左右されず快適にショット練習をお楽しみいただけます。<br> -->
          さらに、実際のコースさながらのバンカー練習エリアも設置しており、<br class="c-brpc">
          ラウンド前の調整や実践的なショット練習に最適です。
        </p>

        <table class="tb-01">
          <tbody>
            <tr>
              <th>料金</th>
              <td>
                ⚫︎⚫︎⚫︎円(税込)
              </td>
            </tr>
            <tr>
              <th>申込み方法</th>
              <td>
                <p class="tb-01__dtex">ダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキストダミーテキスト</p>
                <p>FAX&colon;<span>000-00-0000</span></p>
                <p>メール&colon;info@kunocc.co.jp</p>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="">ゴルフ練習場のご案内</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->
    <script>
      jQuery(function($) {
        $('a.fancybox').fancybox();
      });
    </script>
    <?php wp_footer(); ?>

    </body>

    </html>