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
  <link href="https://fonts.googleapis.com/css2?family=Playwrite+IN:wght@100..400&family=Quicksand:wght@300..700&family=Shippori+Mincho&display=swap" rel="stylesheet">
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

  <div class="c-header__inner">
      <div class="c-header__logo">
      <a href="<?php echo esc_url(home_url('')); ?>/"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo.svg" alt="ロゴ画像"/></a>
      </div>
      <p class="c-header__member"><a href="" target="_blank">会員専用</a></p>
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
            <div class="c-nav__logo"><a href="<?php echo esc_url(home_url('')); ?>/"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo_nav.svg" alt=""/></a></div>
          </div>
          <div class="c-nav__conts">
            <div class="c-nav__box">

              <ul class="c-nav__list">
                <li>
                  <p class="c-nav__list--head">倶楽部紹介</p>
                  <div class="c-nav__sub">
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/club/">- 倶楽部概要</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/club/history/">- 倶楽部の歴史</a></li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/news/">ニュース</a>
                </li>
                <li>
                  <p class="c-nav__list--head">コース案内</p>
                  <div class="c-nav__sub">
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/course/">- コース全景</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/course/hole01/">- ホール紹介</a></li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/facility/">施設案内</a>
                </li>
                <li>
                  <p class="c-nav__list--head">ご利用案内</p>
                  <div class="c-nav__sub">
                  <?php
                    // オプションページから「header_text」フィールドを取得
                    $header_text = get_field('header_text', 'option');?>
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-fee">- ご利用料金</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/guide/#gd-compe">- コンペのご案内</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/public/">- 県民開放デー情報</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/dresscode/">- ドレスコード &amp; エチケット</a></li>
                      <?php
                        // オプションページからフィールドを取得
                        $link1 = get_field('hdr_link1', 'option'); // フィールド "リンク1"
                        $name1 = get_field('hdr_name1', 'option'); // フィールド "名前1"
                        $link2 = get_field('hdr_link2', 'option'); // フィールド "リンク2"
                        $name2 = get_field('hdr_name2', 'option'); // フィールド "名前2"

                        // リストアイテムを出力
                        if ($link1 && $name1) {
                            echo '<li><a href="' . esc_url($link1) . '" target="_blank">' . esc_html($name1) . '</a></li>';
                        }
                        if ($link2 && $name2) {
                            echo '<li><a href="' . esc_url($link2) . '" target="_blank">' . esc_html($name2) . '</a></li>';
                        }
                      ?>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/access/">アクセス</a>
                </li>
              </ul>

            </div>
            <div class="c-nav__box">

              <ul class="c-nav__list">
                <li>
                  <p class="c-nav__list--head">県民開放デー情報</p>
                  <div class="c-nav__sub">
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/public/#km_01">- 県民大会</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/public/#km_02">- 県民レディース大会</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/public/#km_03">- 県民シニア・県民グランドシニア大会</a></li>
                      <li><a href="<?php echo esc_url(home_url('')); ?>/public/public_detail/">- お申込み方法</a></li>
                    </ul>
                  </div>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/recruit/">求人情報</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/lesson/">ゴルフ教室受講生募集</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/sitepolicy/">サイトポリシー</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/privacypolicy/">プライバシーポリシー</a>
                </li>
                <li>
                  <a href="<?php echo esc_url(home_url('')); ?>/links/">リンク集</a>
                </li>
                <li>
                  <a href="https://forms.gle/BNssmZvMEZEAej8d8" target="_blank">お問い合わせ</a>
                </li>
              </ul>

              <div class="c-nav__bnr">
                <a href="https://weathernews.jp/golf/" class="c-nav__bnr--mbr _weat" target="_blank">久能CCの天気</a>
                <a href="https://wst1.asts.jp/public/golfnet/0213cc/pps/cllinp.asp" class="c-nav__bnr--mbr" target="_blank">会員専用ページ</a>
              </div>
            </div>
        </div>
      </nav>
    </div>

  </header>


