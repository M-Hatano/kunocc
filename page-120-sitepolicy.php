    <?php
    /*
      Template Name: サイトポリシー
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main">
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title _sub">Sitepolicy
            <span>サイトポリシー</span>
          </h1>
        </div>
      </div>

      <section class="_mtl">
        <div class="c-column">
          <div class="c-box">
            <h2 class="c-head3 _mts c-tal">1.著作権・商標権について</h2>
            <ul class="c-list">
              <li>
                <span>・</span>
                当サイトに掲載されている文章・画像・映像・音声・プログラム等の著作権は、特別の記載がない限り当社に帰属します。
              </li>
              <li>
                <span>・</span>
                無断使用・複製・転載・改変を禁止します。
              </li>
            </ul>

            <h2 class="c-head3 _mts c-tal">2.免責事項</h2>
            <ul class="c-list">
              <li>
                <span>・</span>
                当サイトの情報は正確性に配慮していますが、その完全性・有用性・安全性を保証するものではありません。
              </li>
              <li>
                <span>・</span>
                利用者が当サイトを利用したことにより生じた損害について、当社は一切責任を負いません。
              </li>
              <li>
                <span>・</span>
                当サイトからリンクしている外部サイトの内容についても、当社は責任を負いません。
              </li>
              <li>
                <span>・</span>
                当サイトは予告なしに運営の中断・中止や内容の変更を行うことがありますが、これらにより生じたトラブル・損失・損害等に対しても、当社は一切責任を負いません。
              </li>
            </ul>

            <h2 class="c-head3 _mts c-tal">3.リンクについて</h2>
            <p>当サイトへのリンクは原則自由ですが、以下のようなサイトからのリンクは固くお断りします。</p>
            <ul class="c-list">
              <li>
                <span>・</span>
                公序良俗に反する内容を含むサイト
              </li>
              <li>
                <span>・</span>
                違法な情報を掲載しているサイト
              </li>
              <li>
                <span>・</span>
                当社の信用を損なう恐れのあるサイト
              </li>
            </ul>

            <h2 class="c-head3 _mts c-tal">4.推奨環境</h2>
            <p>当サイトは以下の環境でのご利用を推奨します</p>
            <ul class="c-list">
              <li>
                <span>・</span>
                ブラウザ：最新版の Google Chrome、Safari、Firefox、Microsoft Edge
              </li>
              <li>
                <span>・</span>
                JavaScript/CSS の有効化
              </li>
            </ul>

            <h2 class="c-head3 _mts c-tal">5.Cookie（クッキー）の利用</h2>
            <ul class="c-list">
              <li>
                <span>・</span>
                当サイトでは、利便性向上やアクセス解析のために Cookie を使用する場合があります。
              </li>
              <li>
                <span>・</span>
                Cookieにより利用者個人を特定することはありません
              </li>
            </ul>

            <h2 class="c-head3 _mts c-tal">6.サイトの運営・変更・停止</h2>
            <ul class="c-list">
              <li>
                <span>・</span>
                当社は、予告なく当サイトの内容を変更・削除する場合があります。
              </li>
              <li>
                <span>・</span>
                当サイトの運営を一時的または恒久的に中止する場合があります。
              </li>
            </ul>
          </div>

        </div>
      </section>

      <div class="c-column">
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
          <li><a href="">サイトポリシー</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>