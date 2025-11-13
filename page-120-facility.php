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
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_01" alt="フロア図1F" loading="lazy">
      </div>
      <div>
        <p class="fimg__flo">2F</p>
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_02" alt="フロア図2F" loading="lazy">
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
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <p>クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_01.jpg" alt="エントランス" loading="lazy"></span>
      </div>
    </section>

    <section class="_scr01" id="link02">
      <h2 class="c-head6">レストラン<span>Reataurant</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <p>フロントの説明テキストが入ります。フロントの説明テキストが入ります。フロントの説明テキストが入ります。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_02.jpg" alt="レストラン" loading="lazy"></span>
      </div>
      <a href="<?php echo esc_url(home_url('')); ?>/restaurant/" class="c-btn">レストランメニュー詳細へ</a>
    </section>
  </div>

  <!-- プライベートルーム -->
  <section class="_scr01 bgchen" id="link03">
    <span class="deco _01"><span></span></span>
    <span class="deco _02"><span></span></span>
    <div class="c-column">
      <h2 class="c-head6" id="link03">プライベートルーム<span>Privateroom</span></h2>
      <p>大切なお客様にゆっくりとご利用いただける個室を15室ご用意しております。</p>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="c-head3">洋室</h3>
            <p>クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_03.jpg" alt="洋室" loading="lazy"></span>
      </div>

      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="c-head3">和室</h3>
            <p>クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_04.jpg" alt="和室" loading="lazy"></span>
      </div>

      <div class="proom">
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
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_floor_03.jpg" alt="個室平面図" loading="lazy">
        </div>
      </div>
      <p>より多くのお客様のご要望にお答えできるよう、個室の確定はご利用開始直前とさせていただきます。（料金&colon;1万円〜2万円）</p>
    </div>
  </section>

  <div class="c-column">
    <section class="_scr01" id="link04">
      <h2 class="c-head6" id="link03">ロッカールーム<span>Locker&nbsp;room</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <p>気品と落ち着きを兼ね備えたロッカールーム。<br class="c-brpc">広々とした動線、美しい木製ロッカー、天窓から差し込む柔らかな自然光に包まれてゆったりとした時間をお過ごしください。<br class="c-brpc">プレー前の高揚感も、ラウンド後の余韻も、この空間が穏やかに包み込みます。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_05.jpg" alt="ロッカールーム" loading="lazy"></span>
      </div>
    </section>


    <section class="_scr01" id="link05">
      <h2 class="c-head6" id="link03">バスルーム<span>Largebathhouse</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">更衣室</h3>
            <p>ゴルフを満喫したあとは、広々とした屋内浴場で心と体を癒してください。<br class="c-brpc">大きな窓越しに広がる緑豊かな景色が、まるで森の中にいるような非日常のひとときを演出します。<br class="c-brpc">やわらかな光と静けさに包まれながら、贅沢なリラックスタイムをお楽しみいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_06.jpg" alt="更衣室" loading="lazy"></span>
      </div>

      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">大浴場</h3>
            <p>ゴルフを満喫したあとは、広々とした屋内浴場で心と体を癒してください。<br class="c-brpc">大きな窓越しに広がる緑豊かな景色が、まるで森の中にいるような非日常のひとときを演出します。<br class="c-brpc">やわらかな光と静けさに包まれながら、贅沢なリラックスタイムをお楽しみいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_07.jpg" alt="大浴場" loading="lazy"></span>
      </div>

      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">サウナ</h3>
            <p>上質な天然木を贅沢に使用した、ゆったりとくつろげるサウナをご用意しております。<br class="c-brpc">木の香りとやわらかな温もりに包まれながら、心と身体をゆっくりと整えるひとときをお過ごしください。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_08.jpg" alt="サウナ" loading="lazy"></span>
      </div>

      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">パウダールーム</h3>
            <p>女性のお客様用の、ゆったりと落ち着いた雰囲気のパウダールームです。大きな鏡と清潔な空間で、リラックスしてお使いいただけます。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_09.jpg" alt="パウダールーム" loading="lazy"></span>
      </div>
    </section>

    <section class="_scr01" id="link06">
      <h2 class="c-head6   _norev" id="link03">中庭<span>Atrium</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <p>館内に足を踏み入れると、ガラス越しに現れるのは、静寂に包まれた美しい中庭。<br class="c-brpc">凛とした竹がすっと伸び、自然と建築が調和したこの庭は、訪れる方の心に静かな感動をもたらします。<br class="c-brpc">プレー前後のひとときに、ぜひその美しさをご鑑賞ください。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_10.jpg" alt="洋中庭室" loading="lazy"></span>
      </div>
    </section>

    <section class="_scr01" id="link07">
      <h2 class="c-head6" id="link03">ゴルフ練習場<span>Driving&nbsp;range</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">ドライビングレンジ</h3>
            <p>館内に足を踏み入れると、ガラス越しに現れるのは、静寂に包まれた美しい中庭。<br class="c-brpc">凛とした竹がすっと伸び、自然と建築が調和したこの庭は、訪れる方の心に静かな感動をもたらします。<br class="c-brpc">プレー前後のひとときに、ぜひその美しさをご鑑賞ください。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_11.jpg" alt="ドライビングレンジ" loading="lazy"></span>
      </div>

      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <h3 class="facility__info--sub">バンカー</h3>
            <p>館内に足を踏み入れると、ガラス越しに現れるのは、静寂に包まれた美しい中庭。<br class="c-brpc">凛とした竹がすっと伸び、自然と建築が調和したこの庭は、訪れる方の心に静かな感動をもたらします。<br class="c-brpc">プレー前後のひとときに、ぜひその美しさをご鑑賞ください。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_12.jpg" alt="バンカー" loading="lazy"></span>
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

<?php wp_footer(); ?>

</body>

</html>