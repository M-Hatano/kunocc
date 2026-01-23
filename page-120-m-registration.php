    <?php
    /*
      Template Name: 会員コンペ申し込み
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main>
      <div class="c-page-header lazyload">
        <div class="c-column c-page-header__inner">
          <h1 class="c-page-header__title">Member
            <span>コンペ申し込み</span>
          </h1>
        </div>
      </div>

      <!-- 共通メニュー -->
      <?php include get_template_directory() . '/include-120-member-menu.php'; ?>
      <!-- 共通メニュー -->

      <section class="c-member">
        <span class="deco _01"><span></span></span>
        <div class="c-column">
          <h2 class="c-head6 m_head">コンペ申し込み<span>Registration</span></h2>
          <p>コンペのご予約については<br class="c-brsp">以下よりお送りください。</p>
          <div class="box-pat c-form">
            <div class="apply">
              <p>お申込み方法</p>
            </div>

            <p><!--（組み合わせ・承り非表示関連） WEB上でご入力をされないお客様は、-->以下にご予約連絡フォーム（エクセル形式・PDF形式）をそれぞれご用意しております。</p>
            <?php if (have_rows('event_list')): ?>
              <ul>
                <?php while (have_rows('event_list')): the_row();
                  $date_raw = get_sub_field('event_date');
                  $title    = get_sub_field('event_title');

                  // ファイル（ACF ファイルフィールド）
                  $file = get_sub_field('event_link');

                  // 返り値が「配列」でも「URL」でも対応
                  $url = '';
                  if (is_array($file) && !empty($file['url'])) {
                    $url = $file['url'];
                  } elseif (is_string($file) && $file !== '') {
                    $url = $file;
                  }

                  $date_formatted = date_i18n('Y年 n月 j日(D)', strtotime($date_raw));
                ?>
                  <?php if ($url): ?>
                    <li>
                      <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                        <span><?php echo esc_html($date_formatted); ?></span>
                        <?php echo esc_html($title); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endwhile; ?>
              </ul>
            <?php endif; ?>


            <p class="regi_send">ご入力後のファイルは以下アドレス、またはFAXにて送信をお願いいたします。<br>（手書きで持参いただくことも可能です。）</p>

            <div class="regi_send--box">
              <a href="mailto:info@kunocc.co.jp" class="mailbox"><span></span>info@kunocc.co.jp</a>
              <a href="tel:0476-92-5063" class="mailbox _tell"><span></span>FAX 0476(92)5063</a>
            </div>
          </div>

          <!-- パンくずリスト -->
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/member/">会員サイト</a></li>
            <li><a href="">コンペ申し込み</a></li>
          </ul>
        </div>
      </section>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>