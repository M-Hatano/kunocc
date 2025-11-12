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

    <ul class="c-scroll _scr01">
      <li><a href="#link01">エントランス</a></li>
      <li><a href="#link02">レストラン</a></li>
      <li><a href="#link03">プライベートルーム</a></li>
      <li><a href="#link04">ロッカールーム</a></li>
      <li><a href="#link05">バスルーム</a></li>
      <li><a href="#link06">中庭</a></li>
      <li><a href="#link07">練習場</a></li>
    </ul>

    <section>
      <h2 class="c-head6 _scr02" id="link01">エントランス<span>Entrance</span></h2>
      <div class="facility__flex">
        <div class="facility__info">
          <div>
            <p>クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。クラブハウスの説明テキストが入ります。</p>
          </div>
        </div>
        <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_01.jpg" alt="エントランス" loading="lazy"></span>
      </div>

      <h2 class="c-head6 _scr02" id="link02">レストラン<span>Reataurant</span></h2>
      <div class="facility__flex _norev">
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
  <section class="bgchen">
    <span class="deco _01"><span></span></span>
    <span class="deco _02"><span></span></span>
    <div class="c-column">
      <h2 class="c-head6 _scr02" id="link03">プライベートルーム<span>Privateroom</span></h2>
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
          <tr>
            <td class="proom__tb--color">もみじ①②</td>
            <td>4人</td>
            <td rowspan="2">景観重視の<br class="c-brpc">お部屋です</td>
          </tr>
          <tr>
            <td class="proom__tb--color">もみじ③</td>
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

  <section>
    <div class="c-column">
      <div class="fs-div">
        <div class="facility__flex">
          <div class="facility__info">
            <p>クラブハウス玄関を入って右側にフロント。<br>シンプルでやや広めのカウンターからスタッフが笑顔でお迎えいたします。</p>
          </div>
          <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_01.jpg" alt="" loading="lazy"></span>
        </div>

        <div class="facility__flex">
          <div class="facility__info">
            <h3 class="c-head3">コンペルーム</h3>
            <p>レストランと隣接し2室。クラブハウス3階には3室。<br>数人から80人のパーティにも対応できます。<br>パーティ料理も予算に応じてお受けいたします。</p>
          </div>
          <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_02.jpg" alt="" loading="lazy"></span>
        </div>

        <div class="facility__flex">
          <div class="facility__info">
            <h3 class="c-head3">ロッカールーム</h3>
            <p>ナラの木の木目を生かしたイエローゴールド色の落ち着きのある色彩となっております。<br>又、男子・女子とも、それぞれの浴室に隣接していますので大変使いやすいロッカールームです。</p>
          </div>
          <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_03.jpg" alt="" loading="lazy"></span>
        </div>

        <div class="fs-div">
          <h2 class="c-head1" id="link02">
            レストラン
            <span class="c-head1__en">restaurant</span>
          </h2>

          <div class="facility__flex">
            <div class="facility__info">
              <p>レストラン西側窓正面に雄大な富士山を！<br>南側窓からはコースを望みながら、チーフ自慢の料理をご堪能下さい。</p>
            </div>
            <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_04.jpg" alt="" loading="lazy"></span>
          </div>

          <a href="<?php echo esc_url(home_url('')); ?>/restaurant/" class="c-btn">レストラン詳細へ</a>
        </div>

        <div class="fs-div">
          <h2 class="c-head1" id="link03">
            浴場
            <span class="c-head1__en">bathroom</span>
          </h2>

          <div class="facility__flex">
            <div class="facility__info">
              <h3 class="c-head3">男性浴場</h3>
              <p>男子浴室の中央に円形の浴槽。浴室の大窓のキャンパスに雄大な富士山を眺めながら一日の疲れを癒してください。<br>脱衣室の床は健康に良く殺菌作用があるといわれている本物の竹タイルを用いております。<br>又、一角にマッサージ機をご用意しておりますので、湯上りのひと時にお寛ぎ下さい。</p>
            </div>
            <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_05.jpg" alt="" loading="lazy"></span>
          </div>

          <div class="facility__flex">
            <div class="facility__info">
              <h3 class="c-head3">女性浴場</h3>
              <p>２Ｆに構える女性浴場は、浴槽ごしに外の景観を友にしながら、癒しを誘い、富士山の恵み「鉱泉の湯けむり」が肌を潤す。<br>鉱泉＝温泉より低温の、鉱物質をふくむ湧水。<br>浴槽ごしの硝子は外部からは見えない特殊硝子です。ご安心下さい。</p>
            </div>
            <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_06.jpg" alt="" loading="lazy"></span>
          </div>

        </div>

        <div class="fs-div">
          <h2 class="c-head1" id="link04">
            練習場
            <span class="c-head1__en">drivingrange</span>
          </h2>

          <div class="facility__flex">
            <div class="facility__info">
              <h3 class="c-head3">ドライビングレンジ「上達空間 遊球の森」</h3>
              <p class="_mts">ワンコイン（30球）　300円(税込330円) </p>
              <ul class="c-list">
                <li><span>※</span>お一人様ワンコインを原則とさせて頂きます。</li>
                <li><span>※</span>キャディマスター室でコインをお求めください。（オープン時間は正午12時まで）</li>
                <li><span>※</span>但しプロレッスン・レッスンスクール等でのご利用の場合はこの限りではありません。</li>
              </ul>
              <p class="_mts">【お願い】</p>
              <ul class="c-list">
                <li><span>1.</span>打席数8打席のため混み合う場合がございます。ご利用の皆様のご協力をお願い申し上げます。</li>
                <li><span>2.</span>ドライビングレンジの芝生内は大変危険です。芝生内への立ち入りは禁止させて頂きます。</li>
              </ul>
            </div>
            <span class="facility__flex--img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/facility/img_facility_07.jpg" alt="" loading="lazy"></span>
          </div>
        </div>
      </div>
    </div>
  </section>

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