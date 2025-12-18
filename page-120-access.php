    <?php
      /*
      Template Name: アクセス
      */
    ?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">

      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Access
            <span>アクセス&bull;近隣ホテル情報</span>
          </h1>
        </div>
      </div>

      <div class="c-column">
        <ul class="c-scroll">
          <li><a href="#link01">車でお越しの方</a></li>
          <li><a href="#link02">電車で<br class="c-brsp">お越しの方</a></li>
          <li><a href="#link03">クラブバスで<br class="c-brsp">お越しの方</a></li>
          <li><a href="#link04">タクシーのご案内</a></li>
          <li><a href="#link05">近隣宿泊施設のご案内</a></li>
        </ul>

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.392429447867!2d140.3267402446959!3d35.7532240024007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60228cbd2d1c38d7%3A0xe5c311ca91a91a3d!2z5LmF6IO944Kr44Oz44OI44Oq44O85YC25qW96YOo!5e0!3m2!1sja!2sjp!4v1763014115523!5m2!1sja!2sjp"
          width="1100" height="546" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>

        <h2 class="c-head6">所在地<span>Location</span></h2>
        <table class="tb-01">
          <tbody>
            <tr>
              <th>所在地</th>
              <td>
                〒286-0203 千葉県富里市久能７２２
              </td>
            </tr>
            <tr>
              <th>電話</th>
              <td>
                0476-93-9000(代)
              </td>
            </tr>
            <tr>
              <th>FAX</th>
              <td>
                0476-92-5063
              </td>
            </tr>
          </tbody>
        </table>

        <section id="link01">
          <h2 class="ahead">お車をご利用の方</h2>
          <div class="abox">
            <p>東関東自動車道路&nbsp;富里ICより&nbsp;<br class="c-brsp">約3.4Km（車で5分）</p>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_01.jpg" alt="車使用時" class="for-pc abox__mod">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_02.jpg" alt="アクセスマップ" class="for-pc">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_04.jpg" alt="車使用時" class="for-sp">
            <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/kunomap.pdf" class="c-btn" target="_blank">印刷用PDFダウンロード</a>
          </div>
        </section>

        <section id="link02">
          <h2 class="ahead">電車をご利用の方</h2>
          <div class="abox for-pc">
            <p>JR成田駅／京成成田駅より&nbsp;約4.0Km（車で10分）</p>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_03.jpg" alt="電車をご利用の方" class="for-pc">
          </div>
          <div class="abox for-sp">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_05.jpg" alt="電車をご利用の方" class="for-sp">
          </div>
          <div class="abox for-sp">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/img_access_06.jpg" alt="電車をご利用の方" class="for-sp">
          </div>
        </section>

        <section id="link03">
          <h2 class="ahead">クラブバスをご利用の方</h2>
          <table>
            <tbody>
              <tr>
                <th>土日祝日:&nbsp;</th>
                <td>往路のみ運行&nbsp;ＪＲ成田駅東口より&nbsp;<br class="c-brsp">AM7:30（定期便）</td>
              </tr>
              <tr>
                <th></th>
                <td>往路のみ運行&nbsp;ＪＲ成田駅東口より&nbsp;<br class="c-brsp">AM8:40（予約制）</td>
              </tr>
            </tbody>
          </table>
          <p>
            平日:<span>&nbsp;3名&#12316;12名様の場合は運行致します。（予約制）</span>
          </p>
          <p>
            所要時間&nbsp;10分
          </p>
          <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/access/bus161102-1.pdf" class="c-btn _cbus" target="_blank">クラブバス乗り場案内図はこちら（PDF）</a>
        </section>

        <section id="link04">
          <h2 class="ahead">タクシーのご案内</h2>
          <p>JR成田駅&bull;京成成田駅より所要時間10分</p>
          <p>概算料金&nbsp;約1,600円～1,700円</p>
        </section>

        <section id="link05">
          <h2 class="c-head6">近隣宿泊施設のご案内<span>Hotel</span></h2>
          <p>ご予約・お問い合わせは直接ホテルまでお願いいたします。</p>

          <h3 class="ahead02">成田駅周辺ホテル</h3>
          <table class="acctab">
            <tbody>
              <tr>
                <td>センターホテル成田1</td>
                <td><a href="http://www.c-hotel.jp/" target="_blank">http://www.c-hotel.jp/</a></td>
                <td>TEL&period;<a href="tel:0476-23-1133">0476-23-1133</a></td>
              </tr>
              <tr>
                <td>センターホテル成田2&nbsp;R51</td>
                <td><a href="https://www.c-hotel.jp/r51/" target="_blank">https://www.c-hotel.jp/r51/</a></td>
                <td>TEL&period;<a href="tel:0476-23-1133">0476-23-1112</a></td>
              </tr>
              <tr>
                <td>リッチモンドホテル成田</td>
                <td><a href="http://www.richmondhotel.jp/narita/" target="_blank">http://www.richmondhotel.jp/narita/</a></td>
                <td>TEL&period;<a href="tel:0476-24-6660">0476-24-6660</a></td>
              </tr>
              <tr>
                <td>ホテルウェルコ成田</td>
                <td><a href="https://www.hotelwelconarita.com/" target="_blank">https://www.hotelwelconarita.com/</a></td>
                <td>TEL&period;<a href="tel:0476-23-7000">0476-23-7000</a></td>
              </tr>
            </tbody>
          </table>

          <h3 class="ahead02">富里市内ホテル</h3>
          <table class="acctab">
            <tbody>
              <tr>
                <td>インターナショナルリゾートホテル 湯楽城</td>
                <td><a href="https://chi-hotelsresorts.com/" target="_blank">https://chi-hotelsresorts.com/</a></td>
                <td>TEL&period;<a href="tel:0476-93-1234">0476-93-1234</a></td>
              </tr>
            </tbody>
          </table>

          <h3 class="ahead02">富里市内ホテル</h3>
          <table class="acctab">
            <tbody>
              <tr>
                <td>ヒルトン成田</td>
                <td><a href="https://www.hilton.com/ja/hotels/nrthihi-hilton-tokyo-narita-airport/" target="_blank">https://www.hilton.com/ja/hotels/nrthihi-hilton-tokyo-narita-airport/</a></td>
                <td>TEL&period;<a href="tel:0476-33-1121">0476-33-1121</a></td>
              </tr>
              <tr>
                <td>ANAクラウンプラザホテル成田</td>
                <td><a href="https://www.anacrowneplaza-narita.jp/" target="_blank">https://www.anacrowneplaza-narita.jp/</a></td>
                <td>TEL&period;<a href="tel:0476-33-1311">0476-33-1311</a></td>
              </tr>
              <tr>
                <td>ホテル日航成田</td>
                <td><a href="http://www.nikko-narita.com/" target="_blank">http://www.nikko-narita.com/</a></td>
                <td>TEL&period;<a href="tel:0476-32-0032">0476-32-0032</a></td>
              </tr>
              <tr>
                <td>アートホテル成田</td>
                <td><a href="https://art-narita.com/" target="_blank">https://art-narita.com/</a></td>
                <td>TEL&period;<a href="tel:0476-32-1111">0476-32-1111</a></td>
              </tr>
              <tr>
                <td>ホテルマイステイズプレミア成田</td>
                <td><a href="https://www.mspnarita.com/" target="_blank">https://www.mspnarita.com/</a></td>
                <td>TEL&period;<a href="tel:03-3434-3939">03-3434-3939</a></td>
              </tr>
            </tbody>
          </table>

        </section>

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