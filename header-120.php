<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- +++ noindex 出力 +++ -->
  <?php knc_add_noindex_meta(); ?>
  <!-- +++ noindex 出力 +++ -->

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">

  <title><?php wp_title('|', true, 'right'); ?>久能カントリー倶楽部</title>

  <!-- OGP -->
  <?php $meta_description = get_dynamic_meta_description(); ?>
  <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
  <meta property="og:title" content="久能カントリー倶楽部">
  <meta property="og:description" content="<?php echo esc_attr($meta_description); ?>">
  <meta property="og:url" content="<?php echo esc_url(home_url()); ?>">
  <meta property="og:locale" content="ja_JP">
  <meta property="og:image" content="<?php echo esc_url(get_template_directory_uri() . '/img/ogp.jpg'); ?>">
  <meta property="og:site_name" content="久能カントリー倶楽部">
  <meta property="og:type" content="website">

  <link rel="canonical" href="<?php echo esc_url(home_url()); ?>">

  <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="32x32" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon-32x32.png">
  <link rel="apple-touch-icon" sizes="16x16" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon-16x16.png">
  <link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/img/favicon.ico">

  <!-- CSS / Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playwrite+IN:wght@100..400&family=Quicksand:wght@300..700&family=Shippori+Mincho:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
  >

  <!-- LazySizes -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/plugins/unveilhooks/ls.unveilhooks.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.body.classList.remove('customize-support');
    });
  </script>

  <!-- Google Tag Manager (noscript) -->
  <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZR2M45FQ91"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ZR2M45FQ91');
    </script>
  <!-- End Google Tag Manager (noscript) -->

  <?php wp_head(); ?>
</head>

<body id="<?php echo my_custom_body_id(); ?>" class="<?php echo my_custom_body_class(); ?>">
  <div class="c-wrapper">
    <header class="c-header" role="banner" id="inc-hd">
      <div class="c-header__inner">

        <div class="c-header__logo">
          <a href="<?php echo esc_url(home_url('')); ?>/">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo.svg" alt="ロゴ画像">
          </a>
        </div>

        <p class="c-header__member">
          <a href="<?php echo esc_url(home_url('')); ?>/member/">会員専用</a>
        </p>

        <div class="c-header__menu js-menu">
          <div>
            <span>MENU</span>
            <div class="c-header__menu--inner">
              <span></span><span></span><span></span>
            </div>
          </div>
        </div>

        <nav class="c-nav" role="navigation" id="nav">
          <div class="c-nav__inner">

            <div class="c-nav__name">
              <div class="c-nav__logo">
                <a href="<?php echo esc_url(home_url('')); ?>/">
                  <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo.png" alt="">
                </a>
              </div>
            </div>

            <div class="c-nav__conts">

              <div class="c-nav__box">
                <ul class="c-nav__list">
                  <li><a href="<?php echo esc_url(home_url('')); ?>/reservation/">ご予約方法について</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/facility/#link03">プライベートルーム</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/facility/">施設案内</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/course/">コース紹介</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/access/">アクセス&#12539;近隣ホテル情報</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/news/">ニュース</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/club/">倶楽部紹介</a></li>
                </ul>
              </div>

              <div class="c-nav__box">
                <ul class="c-nav__list">
                  <li><a href="<?php echo esc_url(home_url('')); ?>/d-range/">ゴルフ練習場</a></li>
                  <!-- <li><a href="<?php echo esc_url(home_url('')); ?>/recruit/">求人情報</a></li> -->
                  <li>
                    <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/member2024.pdf" target="_blank" rel="noopener noreferrer">
                      会員募集について
                    </a>
                  </li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/dresscode/">ドレスコード</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/sitepolicy/">サイトポリシー</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/privacypolicy/">プライバシーポリシー</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/charassment/">カスタマーハラスメントへの対応について</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/links/">リンク集</a></li>
                  <li><a href="<?php echo esc_url(home_url('')); ?>/contact/">お問い合わせ</a></li>
                </ul>

                <div class="c-nav__bnr">
                  <a
                    href="https://weathernews.jp/golf/kanto/chiba/724/"
                    class="c-nav__bnr--mbr _weat"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    久能CCの天気
                  </a>
                  <a href="<?php echo esc_url(home_url('')); ?>/member/" class="c-nav__bnr--mbr">会員専用ページ</a>
                </div>
              </div>

            </div><!-- /.c-nav__conts -->
          </div><!-- /.c-nav__inner -->
        </nav>

      </div><!-- /.c-header__inner -->
    </header>
