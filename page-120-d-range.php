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
        <h2 class="c-head6">ゴルフ練習場<span>Driving&nbsp;Range</span></h2>

        <div class="picare">
          <div>
            <p class="picare__hd">ドライビングレンジ</p>
            <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_01.jpg" class="fancybox" data-fancybox="range">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_01.jpg" alt="練習場">
            </a>
            <p>
              14打席もあるゆとりのある練習場。<br>
              広々としたフェアウェイに向かって思いきりスイングできる、天然芝の練習エリア。<br class="c-brpc">
              自然林に囲まれた静かな環境で、集中してショットを磨けます。<br>
              奥行きあるレイアウトは実戦さながらの臨場感。<br>
              プレー前の調整にも、じっくりと取り組む練習にも最適です。
            </p>
          </div>
          <div>
            <p class="picare__hd">バンカー</p>
            <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_02.jpg" class="fancybox" data-fancybox="range">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/range/img_range_02.jpg" alt="練習場">
            </a>
            <p>
              練習場にはバンカーエリアも併設しており、ショットだけでなく多彩なシーンに対応した練習が可能です。
            </p>
          </div>
        </div>


        <table class="tb-01">
          <tbody>
            <tr>
              <th>料金</th>
              <td>
                30球 550円（税込）
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