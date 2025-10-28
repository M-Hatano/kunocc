<!DOCTYPE html>
<html lang="ja">

<head>
  <!-- Google Tag Manager -->
  <!--<script>
    </script>-->
  <!-- End Google Tag Manager -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- +++ noindex 出力 +++ -->
  <?php fhg_add_noindex_meta(); ?>
  <!-- +++ noindex 出力 +++ -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title><?php wp_title('|', true, 'right'); ?>富士平原ゴルフクラブ　御殿場随一の雄大なゴルフ場</title>
  <!-- OGP-->
  <?php
  $meta_description = get_dynamic_meta_description();
  ?>
  <meta content="<?php echo esc_attr($meta_description); ?>" name="description">
  <meta content="富士平原ゴルフクラブ　御殿場随一の雄大なゴルフ場" property="og:title">
  <meta content="<?php echo esc_attr($meta_description); ?>" property="og:description">
  <meta content="<?php echo esc_url(home_url()); ?>" property="og:url">
  <meta content="ja_JP" property="og:locale">
  <meta content="<?php echo esc_url(get_template_directory_uri() . '/img/ogp.jpg'); ?>" property="og:image">
  <meta property="og:site_name" content="富士平原ゴルフクラブ　御殿場随一の雄大なゴルフ場">
  <meta content="website" property="og:type">
  <link rel="canonical" href="<?php echo esc_url(home_url()); ?>">
  <!-- FAVICON-->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon-32x32.png">
  <link rel="apple-touch-icon" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon-16x16.png">
  <link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon.ico">
  <!-- CSS-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!--Google Fonts 使用する場合挿入-->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Playwrite+IN:wght@100..400&display=swap" rel="stylesheet">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/plugins/unveilhooks/ls.unveilhooks.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          document.body.classList.remove('customize-support');
      });
      </script>
      <!-- Google Tag Manager (noscript) -->
     <!-- Google tag (gtag.js) -->
        <!-- End Google Tag Manager (noscript) -->
  <?php wp_head(); ?>
</head>

<body id="<?php echo my_custom_body_id(); ?>" class="<?php echo my_custom_body_class(); ?>">

 
  <div class="c-wrapper">

  <header class="c-header" role="banner" id="inc-hd">
  <a href="<?php echo esc_url(home_url('')); ?>/" class="sp-logo"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo_nav.svg" alt="" loading="lazy"/></a>
  <div class="c-header__inner">

      <nav class="pc-header">
        <div>
          <div class="c-header__logo">
            <a href="<?php echo esc_url(home_url('')); ?>/"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo_nav_w.png" alt="" loading="lazy"/></a>
          </div>
          <ul class="c-header__nav">
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/">ホーム</a>
            </li>
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/guide/">ご利用案内</a>
            </li>
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/course/">コース案内</a>
            </li>
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/facility/">施設案内</a>
            </li>
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a>
            </li>
            <li>
               <a href="<?php echo esc_url(home_url('')); ?>/access/">アクセス</a>
            </li>
            <li class="pc-header-member">
               <a href="https://pp-web2.jp/calendars/fujiheigen/calendar/" target="_blank">予約カレンダー</a>
            </li>
            <li class="pc-header-member _member">
               <a href="https://pp-web2.jp/clubs/fujiheigen-gc/session/page_new" target="_blank">会員ログイン</a>
            </li>
          </ul>
        </div>
      </nav>

      <p class="c-header__member"><a href="https://pp-web2.jp/calendars/fujiheigen/calendar" target="_blank">予約</a></p>
      <div class="c-header__menu js-menu">
        <div>
          <div class="c-header__menu--inner">
            <span></span><span></span><span></span>
          </div>
        </div>
      </div>
      <nav class="c-nav" role="navigation" id="nav">
        <div class="c-nav__inner">
          <div class="c-nav__name">
            <div class="c-nav__logo"><a href="<?php echo esc_url(home_url('')); ?>/"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo_nav.svg" alt="" loading="lazy"/></a></div>
          </div>
          <div class="c-nav__conts">
            <div class="c-nav__box">

              <ul class="c-nav__list">
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/">ホーム</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/solo/">一人予約について</a>
                </li>
                <!-- <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/club/">（要確認）当倶楽部について</a>
                </li> -->
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/news/">ニュース</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/course/">コース案内</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/facility/">施設案内</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/guide/">ご利用案内</a>
                  <div class="c-nav__sub">
                    <ul>
                    <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-member">- プレー料金</a></li>
                    <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-twilight">- 練習場</a></li>
                    <li><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">- レストラン</a></li>
                    <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-rental">- ご予約について</a></li>
                    </ul>
                  </div>
                </li>
              </ul>

            </div>
            <div class="c-nav__box">

              <ul class="c-nav__list">
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/access/">アクセス</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/privacypolicy/">プライバシーポリシー</a>
                </li>
                <!-- <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/links/">リンク集</a>
                </li> -->
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/contact/">お問い合わせ</a>
                </li>
              </ul>

              <div class="c-nav__bnr">
                <a href="https://pp-web2.jp/calendars/fujiheigen/calendar/" class="c-nav__bnr--mbr" target="_blank">空き状況＆WEB予約</a>
                <a href="https://pp-web2.jp/clubs/fujiheigen-gc/session/page_new" class="c-nav__bnr--mbr _member" target="_blank">会員ログイン</a>
              </div>
            </div>
        </div>
      </nav>
    </div>

  </header>


