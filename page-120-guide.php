<?php
/*
      Template Name: ご利用案内
      */
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/guide/page-header.jpg">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title">Guide
        <span>ご利用案内</span>
      </h1>
    </div>
  </div>

  <div class="c-column-s">
    <ul class="c-scroll">
      <li><a href="#gd-member">メンバー料金</a></li>
      <li><a href="#gd-visitor">ビジター料金</a></li>
      <li><a href="#gd-twilight">薄暮プレー</a></li>
      <li><a href="#gd-increase">割増料金</a></li>
      <li><a href="#gd-rental">レンタルクラブのご案内</a></li>
      <li><a href="#gd-card">お取り扱いカード</a></li>
    </ul>
  </div>

  <section class="gd-member" id="gd-member">
    <div class="c-column-s">
      <h2 class="c-head1">メンバー料金<span class="c-head1__en">Member</span></h2>
      <h3 class="c-tac">料金表</h3>
      <!-- <p class="fw-b c-tac">メンバー基本料金（2019年10月～）</p> -->
    </div>

    <div class="gd-price">
      <div class="c-column-s">
        <h4 class="c-tac">メンバー基本料金</h4>

        <div class="table-scroll">
          <table class="table-type-02">
            <thead>
              <tr>
                <th>プレースタイル</th>
                <th>平日・土日祝</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1R乗用カートキャディ付</td>
                <td>&yen;10,400</td>
              </tr>
              <tr>
                <td>1R乗用カートセルフ</td>
                <td>&yen;8,370</td>
              </tr>
            </tbody>
          </table>
        </div>
        <ul class="c-list">
          <li><span>※</span>70歳以上の方は利用税950円が免税となります。</li>
          <li><span>※</span>平日会員の方は、日曜日・祝祭日(振替休日含)はビジター料金となります。</li>
          <li><span>※</span>週日会員の方は、土曜日・日曜日・祝祭日(振替休日含)はビジター料金となります。</li>
          <li><span>※</span>2名様のみ(2サムプレー)をご希望の場合割増料金が発生いたします。</li>
        </ul>

        <!-- <h4 class="_mtm c-tac">薄暮プレイ料金（午後ハーフプレイ）</h4>
        <table class="tb-03">
          <tr>
            <th>平日</th>
            <th>土日祝</th>
          </tr>
          <tr>
            <td>&yen;5,900<span>円</span></td>
            <td>&yen;8,090<span>円</span></td>
          </tr>
        </table>
        <ul class="c-list">
          <li><span>※</span>状況によりスタート時間が変動いたします。当日にお電話にてご確認ください。</li>
        </ul> -->
      </div>
    </div>
  </section>

  <section class="gd-visitor" id="gd-visitor">
    <div class="c-column-s">
      <h2 class="c-head1">ビジター料金<span class="c-head1__en">Visitor</span></h2>

      <div class="gd-price">
          <h4 class="c-tac">ビジター基本料金（2025年3月1日～12月31日）</h4>

          <div class="table-scroll">
            <table class="table-type-02">
              <thead>
                <tr>
                  <th>プレースタイル</th>
                  <th>平日</th>
                  <th>土曜</th>
                  <th>日・祝</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1R乗用カートキャディ付</td>
                  <td>&yen;15,500</td>
                  <td>&yen;23,500</td>
                  <td>&yen;21,500</td>
                </tr>
                <tr>
                  <td>1R乗用カートセルフ</td>
                  <td>&yen;12,000</td>
                  <td>&yen;20,000</td>
                  <td>&yen;18,000</td>
                </tr>
              </tbody>
            </table>
          </div>
          <ul class="c-list">
            <li><span>※</span>70歳以上の方は利用税950円が免税となります。</li>
            <li><span>※</span>2名様のみ(2サムプレー)をご希望の場合割増料金が発生いたします。</li>
          </ul>
      </div>
  </section>

  <section class="gd-booking" id="gd-booking">
    <div class="c-column-s">
      <h2 class="c-head1">予約受付開始日のお知らせ<span class="c-head1__en">Booking</span></h2>
      <h4 class="c-tac">3ヶ月前の同日の午前10時～</h4>
      <ul class="c-list">
        <li><span>※</span>受付開始日はお電話でのご予約を優先させて頂きます。</li>
        <li><span>※</span>予約センター受付時間：午前10時～午後4時30分　専用電話：0550-88-2100</li>
        <li><span>※</span>ホームページへの予約枠公開は開始日の13時前後を予定しております。</li>
        <li><span>※</span>開始日が定休日の場合、翌営業日より受付開始となります。</li>
        <li><span>※</span>土曜・日祝のコンペは会員の同伴或いは紹介が必要となります。</li>
        <li><span>※</span>土曜・日祝のビジター様の一般予約は予約状況によりお受けできない場合がございます。</li>
      </ul>
      <h4 class="c-tac">コンペ(3組以上)は割引料金がございます。</h4>
      <?php
        // テンプレートを表示している固定ページの ID が 456 なら…
        $page_id = 1142;
      ?>
      <?php
        $link_url = get_field('link_guideurl');
        if ($link_url): ?>
          <a href="<?php echo esc_url($link_url); ?>" class="c-btn">詳しくはこちら</a>
      <?php endif; ?>
    </div>
  </section>

  <section class="gd-twilight" id="gd-twilight">
    <div class="c-column-s">
      <h2 class="c-head1">薄暮プレー<span class="c-head1__en">TwilightPlay</span></h2>

      <div class="gd-price">
          <h4 class="c-tac">薄暮プレー料金（期間 2025年1月6日～12月26日迄）</h4>
          <div class="table-scroll">
            <table class="table-type-02">
              <thead>
                <tr>
                  <th>0.5R乗用セルフ</th>
                  <th>平日</th>
                  <th>土・日祝</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>会員</td>
                  <td colspan="2">&yen;4,150</td>
                </tr>
                <tr>
                  <td>ビジター</td>
                  <td>&yen;5,200</td>
                  <td>&yen;5,850</td>
                </tr>
              </tbody>
            </table>
          </div>
          <ul class="c-list">
            <li>受付は7日前より</li>
            <li><span>☆</span>お申込みは2名様から、お支払いは現金前払い制(フロントで受付時にお支払下さい)</li>
            <li><span>☆</span>ロッカー・浴場・プレー終了後のレストランはご利用できません。</li>
          </ul>
      </div>
    </div>
  </section>

  <section class="gd-increase" id="gd-increase">
    <div class="c-column-s">
      <h2 class="c-head1">割増料金<span class="c-head1__en">Increase</span></h2>

      <div class="gd-price">
          <h4 class="c-tac">割増料金表</h4>
          <div class="table-scroll">
            <table class="table-type-02">
              <thead>
                <tr>
                  <th>区分</th>
                  <th>プレースタイル</th>
                  <th>3B・4B</th>
                  <th>2B</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th rowspan="2">1R</th>
                  <td>乗用カートキャディ付</td>
                  <td>ー</td>
                  <td>&yen;2,200</td>
                </tr>
                <tr>
                  <td>乗用カートセルフ</td>
                  <td>ー</td>
                  <td>&yen;2,200</td>
                </tr>
                <tr>
                  <th rowspan="2">1.5R</th>
                  <td>乗用カートキャディ付</td>
                  <td>&yen;5,170</td>
                  <td>&yen;8,470</td>
                </tr>
                <tr>
                  <td>乗用カートセルフ</td>
                  <td>&yen;3,300</td>
                  <td>&yen;6,600</td>
                </tr>
            </table>
        </div>
      </div>
  </section>

  <section class="gd-rental" id="gd-rental">
    <div class="c-column-s">
      <div class="gd-img">
        <h2 class="c-head1">レンタルクラブのご案内<span class="c-head1__en">Rental</span></h2>
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/guide/img_rental_01.jpg" alt="レンタルクラブ" loading="lazy">
      </div>
    </div>
  </section>

  <section class="gd-card" id="gd-card">
    <div class="c-column-s">
      <h2 class="c-head1">お取り扱いカード<span class="c-head1__en">Card</span></h2>
      <div class="gd-img">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/guide/img_card_01.jpg" alt="取り扱いカード" loading="lazy">
      </div>
    </div>
  </section>

  <div class="c-column">
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
      <li><a href="">ご利用案内</a></li>
    </ul>
  </div>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>