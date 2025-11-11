    <?php
    /*
        Template Name: 料金カレンダー
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-member">
        <span class="deco _01"><span></span></span>
        <div class="c-page-header lazyload">
            <div class="c-column c-page-header__inner">
                <h1 class="c-page-header__title">Member
                    <span>ビジター様料金</span>
                </h1>
            </div>
        </div>
        <ul class="m-list">
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員様お知らせ</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-sales/">営業案内</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-kusunoki/">くすのき会</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-partner/">提携コース</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-calendar/">ビジター様料金</a></li>
            <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/m-registration/">コンペ申込</a></li>
        </ul>


        <div class="c-colomun">
            <h2 class="c-head6 m_head">ビジター様料金カレンダー<span>Calender</span></h2>
            <p>料金については以下をご覧ください。</p>
            <div class="calendar-container">
                <div>
                    <div class="calendar-head">
                        <button id="prev" class="calendar-nav left">＜</button>
                        <div id="current-month" class="calendar-month-label"></div>
                        <button id="next" class="calendar-nav right">＞</button>
                    </div>
                    <div id="calendar"></div>
                </div>

                <div id="calendar-events">
                    <?php
                    if (have_rows('calendar_events')):
                        while (have_rows('calendar_events')): the_row();
                            $date    = get_sub_field('event_date');
                            $member  = get_sub_field('member_price');
                            $visitor = get_sub_field('visitor_price');
                            $event   = get_sub_field('event_name');
                            $link_type  = get_sub_field('event_link_type'); // url / pdf / image
                            $link       = get_sub_field('event_link');


                            // ←ここがポイント：リンクURLを取得
                            $link_url = '';
                            if (is_array($link) && isset($link['url'])) {
                                $link_url = $link['url'];
                            } elseif (is_string($link)) {
                                $link_url = $link;
                            }
                    ?>
                            <div data-date="<?php echo esc_attr($date); ?>">
                                <div class="price-group">
                                    <?php if (!empty($member)): ?>
                                        <div class="member"><!-- メンバー： -->&yen;<?php echo esc_html($member); ?></div>
                                    <?php endif; ?>

                                    <?php if (!empty($visitor)): ?>
                                        <div class="visitor"><!-- ビジター： -->&yen;<?php echo esc_html($visitor); ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- イベント 処理 -->
                                <?php if ($link_type === 'url' && $link_url): ?>
                                    <a href="<?php echo esc_url($link_url); ?>" class="event-name" target="_blank" rel="noopener">
                                        <?php echo esc_html($event); ?><span>（外部Link）</span>
                                    </a>

                                <?php elseif ($link_type === 'pdf' && $link_url): ?>
                                    <a href="<?php echo esc_url($link_url); ?>" class="event-name" download>
                                        <?php echo esc_html($event); ?><span>（PDF）</span>
                                    </a>

                                <?php elseif ($link_type === 'image' && $link_url): ?>
                                    <a href="<?php echo esc_url($link_url); ?>" class="event-name popup-link">
                                        <?php echo esc_html($event); ?><span>（画像）</span>
                                    </a>

                                <?php else: ?>
                                    <p class="event-name"><?php echo esc_html($event); ?></p>
                                <?php endif; ?>
                            </div>
                    <?php
                        endwhile;
                    endif;
                    ?>
                </div>

                <!-- 画像ポップアップ用モーダル -->
                <div id="image-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);justify-content:center;align-items:center;z-index:9999;">
                    <img id="modal-img" src="" style="max-width:90%;max-height:90%;box-shadow:0 0 20px #000;">
                </div>
            </div>


            <div class="c-column">
                <!-- パンくずリスト -->
                <ul class="c-brd">
                    <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
                    <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員サイト</a></li>
                    <li><a href="">コンペ申し込み</a></li>
                </ul>
            </div>
        </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>


    </body>

    </html>