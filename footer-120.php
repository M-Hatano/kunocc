<footer class="c-footer" role="contentinfo" id="inc-ft">

  <!-- ====================
       共通パーツ
  ==================== -->
  <?php include get_template_directory() . '/include-120-reservation-start.php'; ?>

  <!-- ====================
       予約バナー
  ==================== -->
  <div class="c-btbnr" id="c-btbnr">
    <div class="c-column">
      <div class="c-footer__flex _line">

        <div>
          <p class="reseinf">WEBからのご予約情報送信はこちら</p>
          <ul>
            <li>
              <a
                href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_uke.asp"
                target="_blank"
                rel="noopener noreferrer"
              >
                ご予約連絡フォーム
              </a>
            </li>
            <li>
              <a
                href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_kumi.asp"
                target="_blank"
                rel="noopener noreferrer"
              >
                組み合わせ送信フォーム
              </a>
            </li>
          </ul>
        </div>

        <div>
          <p class="reseinf">
            <a href="mailto:info@kunocc.co.jp">メール</a>でのご予約情報送信はこちら
          </p>

          <?php
          $excel = get_field('reservation_form_excel', 'option');
          $pdf   = get_field('reservation_form_pdf', 'option');
          ?>

          <ul>
            <li>
              <a href="<?php echo $excel ? esc_url($excel['url']) : '#'; ?>" target="_blank" rel="noopener noreferrer">
                ご予約連絡フォーム<br class="c-brsp">(エクセル)
              </a>
            </li>
            <li>
              <a
                href="<?php echo $pdf ? esc_url($pdf['url']) : '#'; ?>" target="_blank" rel="noopener noreferrer">
                ご予約連絡フォーム<br class="c-brsp">(PDF)
              </a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>

  <!-- ====================
       フッター情報
  ==================== -->
  <div class="c-column">
    <div class="c-footer__flex _bottom">
      <div>
        <p class="c-footer__name">久能カントリー俱楽部</p>
        <p>
          <span>〒286-0203</span>
          千葉県富里市久能722
        </p>
      </div>

      <div class="c-footer__nebox _aid">
        <p class="c-footer__num">
          <span>TEL&period;</span>
          <a href="tel:0476-93-9000">0476-93-9000</a>
        </p>
        <p class="c-footer__emal">
          <span>E-mail：</span>
          <a href="mailto:info@kunocc.co.jp">info@kunocc.co.jp</a>
        </p>
      </div>
    </div>

    <ul class="c-footer__links">
      <li><a href="<?php echo esc_url(home_url('/sitepolicy/')); ?>">SITE POLICY</a></li>
      <li><a href="<?php echo esc_url(home_url('/privacypolicy/')); ?>">PRIVACY POLICY</a></li>
      <li><a href="<?php echo esc_url(home_url('/links/')); ?>">LINKS</a></li>
      <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">SITEMAP</a></li>
    </ul>
  </div>

  <p class="c-copy">&copy;2025 Kuno Country Club</p>

  <!-- ====================
       ページトップ
  ==================== -->
  <div id="c-float">
    <p class="c-pagetop"><a href="#"></a></p>
  </div>

</footer>

<!-- ====================
     Scripts
==================== -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"
  integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>
<script src="//cdn.wgis.jp/eagle-eyes/api/wv1-o.js"></script>

</div>
