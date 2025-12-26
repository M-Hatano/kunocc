<?php
/*
      Template Name: 施設案内
      */
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Facility
        <span>施設案内</span>
      </h1>
    </div>
  </div>

  <div class="c-column">

    <h2 class="c-head6">フロア図<span>Floor&nbsp;Map</span></h2>
    <div class="fimg">
      <div>
        <p class="fimg__flo">1F</p>
        <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_01.jpg" class="fancybox" data-fancybox="floor-map">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_01.jpg" alt="フロア図1F" loading="lazy">
        </a>
      </div>
      <div>
        <p class="fimg__flo">2F</p>
        <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_02.jpg" class="fancybox" data-fancybox="floor-map">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_02.jpg" alt="フロア図2F" loading="lazy">
        </a>
      </div>
    </div>

    <ul class="c-scroll">
      <li><a href="#link01">エントランス</a></li>
      <li><a href="#link02">レストラン</a></li>
      <li><a href="#link03">プライベートルーム</a></li>
      <li><a href="#link04">ロッカールーム</a></li>
      <li><a href="#link05">バスルーム</a></li>
      <li><a href="#link06">中庭</a></li>
      <li><a href="#link07">練習場</a></li>
    </ul>

    <section class="_scr01" id="link01">
      <h2 class="c-head6">エントランス<span>Entrance</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <p>重厚感と洗練が調和したエントランスは、選ばれたゲストを迎えるための迎賓空間。<br>
              接待・ご会合といった大切な場においても、 自信をもってお招きいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_01.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_01.jpg" alt="エントランス" loading="lazy">
          </a>
        </span>
      </div>
    </section>

    <section class="_scr01" id="link02">
      <h2 class="c-head6">レストラン<span>Restaurant</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <p>コースの余韻をそのままに、心ほどける時間をお過ごしいただけるレストラン。<br>
              当倶楽部の自慢であるシェフが腕を振るう料理と、ゆったりとした空間をお楽しみください。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_02.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_02.jpg" alt="レストラン" loading="lazy">
          </a>
        </span>
      </div>
      <a href="<?php echo esc_url(home_url('')); ?>/restaurant/" class="c-btn">レストランメニュー詳細へ</a>
    </section>
  </div>

  <!-- プライベートルーム -->
  <section class="_scr01 bgchen" id="link03">
    <span class="deco _01 fade-in _fast"><span></span></span>
    <span class="deco _02 fade-in _fast"><span></span></span>
    <div class="c-column">
      <h2 class="c-head6" id="link03">プライベートルーム<span>Privateroom</span></h2>
      <p>大切なお客様にゆっくりとご利用いただける個室を15室ご用意しております。</p>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="c-head3">洋室</h3>
            <p>ゆとりある広さを確保した洋室は、<br>大切なご商談やご会食の場としても安心してご利用いただけます。<br>
              周囲を気にすることなく、落ち着いた時間をお過ごしいただける空間です。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_03.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_03.jpg" alt="洋室" loading="lazy">
          </a>
        </span>
      </div>

      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="c-head3">和室</h3>
            <p>日本ならではの設えが息づく和室は、接待の場として多くのお客様にお選びいただいております。<br>
              大切なご縁を深める場として、心に残る時間をご提供いたします。
            </p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_04.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_04.jpg" alt="和室" loading="lazy">
          </a>
        </span>
      </div>

      <div class="proom fade-in">
        <table class="proom__tb">
          <tr>
            <th>個室名</th>
            <th colspan="2">着席可能人数</th>
          </tr>
          <tr>
            <td>くすのき</td>
            <td colspan="2">8人</td>
          </tr>
          <tr>
            <td>きり</td>
            <td colspan="2">8人</td>
          </tr>
          <tr>
            <td>つばき</td>
            <td colspan="2">8人</td>
          </tr>
          <tr>
            <td>さくら</td>
            <td colspan="2">8人</td>
          </tr>
          <tr>
            <td>まき</td>
            <td colspan="2">4人</td>
          </tr>
          <tr>
            <td>ローズ</td>
            <td colspan="2">24人&#12316;28人</td>
          </tr>
          <tr class="proom__tb--color">
            <td>ふじ</td>
            <td>12人</td>
            <td rowspan="3">3室繋げて<br class="c-brpc">40&#12316;48名で<br class="c-brpc">コンペ可能</td>
          </tr>
          <tr class="proom__tb--color">
            <td>けやき</td>
            <td>12人</td>
          </tr>
          <tr class="proom__tb--color">
            <td>たちばな</td>
            <td>12人</td>
          </tr>
          <tr>
            <td>さつき</td>
            <td colspan="2">4人</td>
          </tr>
          <tr>
            <td>ひのき</td>
            <td colspan="2">12人</td>
          </tr>
          <tr>
            <td>すぎ</td>
            <td colspan="2">12人</td>
          </tr>
          <tr class="proom__tb--color">
            <td>もみじ①②</td>
            <td>4人</td>
            <td rowspan="2">景観重視の<br>お部屋です</td>
          </tr>
          <tr class="proom__tb--color">
            <td>もみじ③</td>
            <td>8人</td>
          </tr>
        </table>
        <div class="proom__tb--imgbox">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_03.jpg" class="fancybox" data-fancybox="floor-map">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_03.jpg" alt="個室平面図" loading="lazy">
          </a>
        </div>
      </div>
      <p>より多くのお客様のご要望にお答えできるよう、個室の確定はご利用開始直前とさせていただきます。（料金&colon;1万円〜2万円）</p>
    </div>
  </section>

  <div class="c-column">
    <section class="_scr01" id="link04">
      <h2 class="c-head6" id="link03">ロッカールーム<span>Locker&nbsp;room</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <p>気品と落ち着きを兼ね備えたロッカールーム。<br class="c-brpc">広々とした動線、美しい木製ロッカー、天窓から差し込む柔らかな自然光に包まれてゆったりとした時間をお過ごしいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_05.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_05.jpg" alt="ロッカールーム" loading="lazy">
          </a>
        </span>
      </div>
    </section>


    <section class="_scr01" id="link05">
      <h2 class="c-head6" id="link03">バスルーム<span>Largebathhouse</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">更衣室</h3>
            <p>プレー前後のひとときを支える更衣室にも、当倶楽部ならではのゆとりと配慮を。<br>快適で清潔な空間をご用意しております。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_06.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_06.jpg" alt="更衣室" loading="lazy">
          </a>
        </span>
      </div>

      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">大浴場</h3>
            <p>ゴルフを満喫したあとは、広々とした屋内浴場で心と体を癒してください。<br class="c-brpc">大きな窓越しに広がる緑豊かな景色が、まるで森の中にいるような非日常のひとときを演出します。<br class="c-brpc">やわらかな光と静けさに包まれながら、贅沢なリラックスタイムをお楽しみいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_07.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_07.jpg" alt="大浴場" loading="lazy">
          </a>
        </span>
      </div>

      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">サウナ</h3>
            <p>上質な天然木を贅沢に使用した、ゆったりとくつろげるサウナをご用意しております。<br class="c-brpc">木の香りとやわらかな温もりに包まれながら、心と身体をゆっくりと整えるひとときをお過ごしください。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_08.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_08.jpg" alt="サウナ" loading="lazy">
          </a>
        </span>
      </div>

      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">パウダールーム</h3>
            <p>女性のお客様用の、ゆったりと落ち着いた雰囲気のパウダールームです。大きな鏡と清潔な空間で、リラックスしてお使いいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_09.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_09.jpg" alt="パウダールーム" loading="lazy">
          </a>
        </span>
      </div>
    </section>

    <section class="_scr01" id="link06">
      <h2 class="c-head6   _norev" id="link03">中庭<span>Atrium</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <p>館内に足を踏み入れると、ガラス越しに現れるのは、静寂に包まれた美しい中庭。<br class="c-brpc">凛とした竹がすっと伸び、自然と建築が調和したこの庭は、訪れる方の心に静かな感動をもたらします。<br class="c-brpc">プレー前後のひとときに、ぜひその美しさをご鑑賞ください。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_10.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_10.jpg" alt="洋中庭室" loading="lazy">
          </a>
        </span>
      </div>
    </section>

    <section class="_scr01" id="link07">
      <h2 class="c-head6" id="link03">ゴルフ練習場<span>Driving&nbsp;range</span></h2>
      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">ドライビングレンジ</h3>
            <p>15打席もあるゆとりのある練習場。<br>広々としたフェアウェイに向かって思いきりスイングできる、天然芝の練習エリア。<br>自然林に囲まれた静かな環境で、集中してショットを磨けます。<br>奥行きあるレイアウトは実戦さながらの臨場感。<br class="c-brpc">プレー前の調整にも、じっくりと取り組む練習にも最適です。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_11.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_11.jpg" alt="ドライビングレンジ" loading="lazy">
          </a>
        </span>
      </div>

      <div class="facility__flex fade-in">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">バンカー</h3>
            <p>練習場にはバンカーエリアも併設しており、ショットだけでなく多彩なシーンに対応した練習が可能です。</p>
          </div>
        </div>
        <span class="facility__flex--img">
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_12.jpg" class="fancybox" data-fancybox="facility">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_12.jpg" alt="バンカー" loading="lazy">
          </a>
        </span>
      </div>
      <a href="<?php echo esc_url(home_url('')); ?>/d-range/" class="c-btn">ゴルフ練習場概要へ</a>
    </section>
  </div>


  <div class="c-column">
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
      <li><a href="">施設案内</a></li>
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