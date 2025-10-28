<?php
/*
      Template Name: アクセス
      */
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/page-header.jpg">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Access
        <span>アクセス</span>
      </h1>
    </div>
  </div>

  <section class="_mtl">
    <div class="c-column-s">
      <h2 class="c-head1">交通アクセスのご案内<span class="c-head1__en">Access</span></h2>

      <div class="access__map"> <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d52071.25415333425!2d138.888257!3d35.344393!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601970a31216af47%3A0xfeb081361147d4f0!2z5pel5pys44CB44CSNDEyLTAwMDEg6Z2Z5bKh55yM5b6h5q6_5aC05biC5rC05Zyf6YeO77yT77yQ77yQ4oiS77yR!5e0!3m2!1sja!2sus!4v1747731304439!5m2!1sja!2sus" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="false" tabindex="0"></iframe></div>

      <h3 class="c-head3 _mtm">富士平原ゴルフクラブ</h3>
      <table class="tb-01">
        <tbody>
          <tr>
            <th>所在地</th>
            <td>
              <p>〒412-0001<br>静岡県御殿場市水土野300-1</p>
            </td>
          </tr>
        </tbody>
      </table>
  </section>


  <section class="c-column _mtm">
    <h3 class="c-head3">お車でお越しの方</h3>
    <p class="_mts c-tac">東名高速道路「御殿場IC」より10km 中央自動車道河口湖IC～東富士五湖道路須走ICより 2km</p>
    <p class="c-tac"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/map_202106.jpg" alt="" loading="lazy">
  </section>

  <div class="btn-wrapper">
    <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/map_202106.jpg" target="_blank" class="c-btn">大きな画像を見る</a>

    <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/map_202106.pdf" target="_blank" class="c-btn">印刷データはこちら</a>
  </div>

    


  <section class="c-column _mtm">
    <h3 class="c-head3">電車でお越しの方（クラブバス・電車時刻表）</h3>
    <p class="c-tac">小田急電鉄・JR御殿場線 御殿場駅下車</p>
    <h4 class="_mts c-tac">ご来場</h4>
    <p class="c-tac"><?php echo get_field('train_arrival_html'); ?></p>
    <h4 class="_mts c-tac">お帰り</h4>
    <p class="c-tac"><?php echo get_field('train_return_html'); ?></p>
    <ul class="c-list">
      <li><span>※</span>お迎えのバスをご利用になられた方がいらっしゃらない場合、お送りのバスは予約制での運行となります。</li>
      <li><span>※</span>時刻表は変更になる場合がございます。ご確認ください。</li>
    </ul>
    <a class="link_dl" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/access-train-2024.pdf" target="_blank">印刷はこちらから</a>
  </section>

  <!-- <section class="c-column _mtm">
    <h3 class="c-head3">小田急ハイウェイバスでお越しの方（バス時刻表）</h3>
    <div class="bus-text">
      <p><?php echo get_field('highwaybus_table_html'); ?></p>
      <ul class="c-list">
        <li><span>※</span>料金は各ターミナルから御殿場駅間の料金です。（円）</li>
        <li><span>※</span>ハイウェイの発着は、御殿場駅 乙女口 のバスターミナルです。ご注意ください。</li>
        <li><span>※</span>時刻表は変更になる場合がございます。ご確認ください。</li>
      </ul>
      <p><a class="link_dl" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/bus.pdf" target="_blank">印刷はこちら</a></p>
    </div>
  </section> -->
  </div>



  <div class="c-column">
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
      <li><a href="">アクセス</a></li>
    </ul>
  </div>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>