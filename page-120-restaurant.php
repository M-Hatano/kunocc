    <?php
    /*
      Template Name: レストラン
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main">
            <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/bg_header_01.jpg">
            </div>

            <!-- 導入部 -->
            <section class="lead">
                <div class="c-column">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_titl_01.svg" class="rs-title" alt="レストランタイトル">
                </div>
                <div class="lead__recommend">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_lead_01.jpg" alt="うなぎ">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_lead_02.jpg" alt="担々麺">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_lead_03.jpg" alt="ハンバーグ">
                </div>

                <div class="c-column">
                    <p class="lead__text">
                        料理も、コースも、味わって。
                        <span>
                            手作りにこだわり、彩り豊かに仕上げた<br class="c-brsp">レストランの逸品。<br>
                            味はもちろん、盛り付けにも心を込めた一皿が、<br class="c-brsp">ラウンド後の時間をより豊かに彩ります。<br>
                            多様な食のスタイルにも柔軟に対応いたします。
                        </span>
                    </p>

                    <ul class="c-scroll sc_01">
                        <li><a href="#private">プライベートルーム</a></li>
                        <li><a href="#morning">モーニング</a></li>
                        <li><a href="#lunch">ランチ</a></li>
                        <li><a href="#cafe">茶屋</a></li>
                        <li><a href="#party">パーティープラン</a></li>
                        <li><a href="#drink">ドリンク</a></li>
                    </ul>
                </div>
            </section>

            <!-- プライベートルーム -->
            <section id="private" class="private">
                <div class="c-column">
                    <h2 class="c-head5">プライベートルーム<span>PrivateRoom</span></h2>
                    <div class="feature">
                        <figure>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_private_01.jpg" alt="プライベートルーム">
                        </figure>
                        <div class="feature__text">
                            <p>
                                お食事の際、大切なお客様にゆっくりとご利用いただける個室を15室ご用意しております。<br>
                                お部屋の詳細については施設紹介ページをご覧ください。
                            </p>
                            <a href="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/private-room.pdf" target="_blank" class="c-btn">プライベートルーム詳細</a>
                        </div>
                    </div>
                </div>
                <span class="deco _01"><span></span></span>
            </section>

            <!-- モーニング -->
            <section id="morning" class="morning">
                <div class="c-column">
                    <h2 class="c-head5">モーニングメニュー<span>Morning</span></h2>

                    <ul class="list01">

                        <?php if ( have_rows('morning_items') ) : ?>
                            <?php while ( have_rows('morning_items') ) : the_row(); ?>

                                <?php
                                $name     = get_sub_field('name');      // 商品名
                                $name_sub = get_sub_field('name_sub');  // 補足（例：広島産2Lサイズ）
                                $price    = get_sub_field('price');     // 金額
                                $text     = get_sub_field('text');      // 詳細（textarea）
                                ?>

                                <li class="list01__item u-other">
                                    <div class="list01__item--menu">
                                        <p>
                                            <span class="list01__item--name">
                                                <?php echo esc_html($name); ?>
                                                
                                                <?php if ($name_sub) : ?>
                                                    <span>(<?php echo esc_html($name_sub); ?>)</span>
                                                <?php endif; ?>
                                            </span>

                                            <span class="list01__item--price">
                                                <?php echo esc_html($price); ?>
                                            </span>
                                        </p>
                                        <p class="list01__item--text">
                                            <?php echo nl2br( esc_html($text) ); ?>
                                        </p>
                                    </div>
                                </li>

                            <?php endwhile; ?>
                        <?php endif; ?>

                    </ul>


                    <!-- おつまみ -->
                    <div class="l-card">
                        <div class="l-card__inner">
                            <h3 class="c-head6">おつまみ<span>Snack</span></h3>

                            <div class="l-card__menu">
                            <?php if ( have_rows('snack_items') ) : ?>

                                <?php
                                // すべて取得
                                $items = get_field('snack_items');

                                // ===== 左右交互に分配 =====
                                $left_items  = [];
                                $right_items = [];

                                $i = 0;
                                foreach ($items as $item) {
                                    if ($i % 2 === 0) {
                                        // 偶数 → 左
                                        $left_items[] = $item;
                                    } else {
                                        // 奇数 → 右
                                        $right_items[] = $item;
                                    }
                                    $i++;
                                }
                                ?>

                                <!-- 左列 -->
                                <div>
                                    <ul>
                                        <?php foreach ($left_items as $item) : ?>
                                            <li>
                                                <?php echo esc_html($item['name']); ?>
                                                <span><?php echo esc_html($item['price']); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <!-- 右列 -->
                                <div>
                                    <ul>
                                        <?php foreach ($right_items as $item) : ?>
                                            <li>
                                                <?php echo esc_html($item['name']); ?>
                                                <span><?php echo esc_html($item['price']); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    <!-- 飲み物 -->
                    <div class="l-card _bgchange">
                        <div class="l-card__inner">
                            <div class="d_deco">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <h3 class="c-head6">飲み物<span>Drink</span></h3>
                            <div class="l-card__menu l-card__menu--al01">
                                <div>
                                    <h3>【アルコール】</h3>
                                    <ul>
                                        <?php if ( have_rows('alcohol_items') ) : ?>
                                            <?php while ( have_rows('alcohol_items') ) : the_row(); ?>

                                                <?php
                                                $name  = get_sub_field('name');
                                                $price = get_sub_field('price');
                                                ?>

                                                <li>
                                                    <?php echo esc_html($name); ?>
                                                    <span><?php echo esc_html($price); ?></span>
                                                </li>

                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h3>【ソフトドリンク】</h3>
                                    <ul>
                                        <?php if ( have_rows('soft_drink_items') ) : ?>
                                            <?php while ( have_rows('soft_drink_items') ) : the_row(); ?>

                                                <?php
                                                $name  = get_sub_field('name');
                                                $price = get_sub_field('price');
                                                ?>

                                                <li>
                                                    <?php echo esc_html($name); ?>
                                                    <span><?php echo esc_html($price); ?></span>
                                                </li>

                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>


            <!-- ランチメニュー -->
            <section id="lunch" class="lunch">
                <div class="c-column">
                    <h2 class="c-head5">ランチメニュー<span>Lunch</span></h2>
                    <span class="deco _02"><span></span></span>
                    <span class="deco _02 reverse"><span></span></span>

                    <?php if ( have_rows('lunch_items') ) : ?>
                        <ul class="lu-list">

                            <?php while ( have_rows('lunch_items') ) : the_row(); ?>

                                <?php
                                $image    = get_sub_field('image');
                                $name     = get_sub_field('name');
                                $name_sub = get_sub_field('name_sub');
                                $price    = get_sub_field('price');
                                $desc     = get_sub_field('desc');
                                ?>

                                <li class="lu-list__item">

                                    <?php if ( $image ) : ?>
                                        <img 
                                            loading="lazy"
                                            src="<?php echo esc_url($image['url']); ?>"
                                            alt="<?php echo esc_attr($image['alt'] ?: $name); ?>">
                                    <?php endif; ?>

                                    <p>
                                        <span class="lu-list__item--name">
                                            <?php echo esc_html($name); ?>
                                            <?php if ($name_sub) : ?>
                                                <span><?php echo esc_html($name_sub); ?></span>
                                            <?php endif; ?>
                                        </span>

                                        <?php if ($price): ?>
                                            <span class="lu-list__item--price">
                                                <?php echo esc_html($price); ?>
                                            </span>
                                        <?php endif; ?>
                                    </p>

                                    <?php if ($desc): ?>
                                        <p><?php echo nl2br(esc_html($desc)); ?></p>
                                    <?php endif; ?>

                                </li>

                            <?php endwhile; ?>

                        </ul>
                    <?php endif; ?>

                    <!-- その他 -->
                    <div class="other">
                        <h2 class="c-head5">その他<span>Other</span></h2>

                        <ul class="list01">

                            <?php if ( have_rows('other_items') ) : ?>
                                <?php while ( have_rows('other_items') ) : the_row(); ?>

                                    <?php
                                    $name     = get_sub_field('name');      // 商品名
                                    $name_sub = get_sub_field('name_sub');  // 補足（例：広島産2Lサイズ）
                                    $price    = get_sub_field('price');     // 金額
                                    $text     = get_sub_field('text');      // 詳細（textarea）
                                    ?>

                                    <li class="list01__item u-other">
                                        <div class="list01__item--menu">
                                            <p>
                                                <span class="list01__item--name">
                                                    <?php echo esc_html($name); ?>
                                                    <?php if ($name_sub) : ?>
                                                        <span><?php echo esc_html($name_sub); ?></span>
                                                    <?php endif; ?>
                                                </span>

                                                <span class="list01__item--price">
                                                    <?php echo esc_html($price); ?>
                                                </span>
                                            </p>
                                            <p class="list01__item--text">
                                                <?php echo nl2br( esc_html($text) ); ?>
                                            </p>
                                        </div>
                                    </li>

                                <?php endwhile; ?>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
                <span class="deco _03"><span></span></span>
            </section>

            <section id="cafe" class="cafe">
            <div class="c-column">
                <h2 class="c-head5">茶屋メニュー<span>Cafe</span></h2>

            <!-- おつまみ -->
            <div class="l-card">
                <div class="l-card__inner">
                    <h3 class="c-head6">おつまみ<span>Snack</span></h3>

                    <div class="l-card__menu">

                        <?php if ( have_rows('cafe_snack_items') ) : ?>

                            <?php
                            // 全取得
                            $items = get_field('cafe_snack_items');

                            // 左右交互に振り分け
                            $left_items  = [];
                            $right_items = [];
                            $i = 0;

                            foreach ($items as $item) {
                                if ($i % 2 === 0) {
                                    $left_items[] = $item;  // 偶数 → 左
                                } else {
                                    $right_items[] = $item; // 奇数 → 右
                                }
                                $i++;
                            }
                            ?>

                            <!-- 左列 -->
                            <div>
                                <ul>
                                    <?php foreach ($left_items as $item): ?>
                                        <li>
                                            <?php echo esc_html($item['name']); ?>
                                            <span><?php echo esc_html($item['price']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- 右列 -->
                            <div>
                                <ul>
                                    <?php foreach ($right_items as $item): ?>
                                        <li>
                                            <?php echo esc_html($item['name']); ?>
                                            <span><?php echo esc_html($item['price']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php endif; ?>

                            </div>
                        </div>
                    </div>



                    <!-- 飲み物 -->
                    <div class="l-card _bgchange">
                        <div class="l-card__inner">
                            <div class="d_deco">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <h3 class="c-head6">飲み物<span>Drink</span></h3>
                            <div class="l-card__menu">
                                <div>
                                    <h3>【アルコール】</h3>
                                    <ul>
                                        <?php if ( have_rows('cafe_alcohol_items') ) : ?>
                                            <?php while ( have_rows('cafe_alcohol_items') ) : the_row(); ?>

                                                <?php
                                                $name  = get_sub_field('name');
                                                $price = get_sub_field('price');
                                                ?>

                                                <li>
                                                    <?php echo esc_html($name); ?>
                                                    <span><?php echo esc_html($price); ?></span>
                                                </li>

                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h3>【ソフトドリンク】</h3>
                                    <ul>
                                        <?php if ( have_rows('cafe_soft_drink_items') ) : ?>
                                            <?php while ( have_rows('cafe_soft_drink_items') ) : the_row(); ?>

                                                <?php
                                                $name  = get_sub_field('name');
                                                $price = get_sub_field('price');
                                                ?>

                                                <li>
                                                    <?php echo esc_html($name); ?>
                                                    <span><?php echo esc_html($price); ?></span>
                                                </li>

                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section id="party" class="party">
                <span class="deco _04"><span></span></span>
                <div class="c-column">
                    <h2 class="c-head5">パーティープラン<span>Party</span></h2>
                    <!-- 軽食セット -->
                    <h3>軽食セット</h3>
                    <ul class="list02">
                        <li class="list02__item">
                            <div class="list02__menu">
                                <div class="list02__menu--ribbon">
                                    軽食セットA
                                </div>
                                <p class="list02__menu--text">ケーキセット<br>（コーヒー又は紅茶付き）</p>
                                <p class="list02__menu--price">1,320円</p>
                            </div>
                        </li>
                        <li class="list02__item">
                            <div class="list02__menu">
                                <div class="list02__menu--ribbon">
                                    軽食セットB
                                </div>
                                <p class="list02__menu--text">サラダ等<br>さつま揚げ等<br>デザート等</p>
                                <p class="list02__menu--price">1,320円</p>
                            </div>
                        </li>
                        <li class="list02__item">
                            <div class="list02__menu">
                                <div class="list02__menu--ribbon">
                                    軽食セットC
                                </div>
                                <p class="list02__menu--text">サラダ<br>揚げもの<br>サンドイッチ等<br>デザート等</p>
                                <p class="list02__menu--price">1,650円</p>
                            </div>
                        </li>
                    </ul>
                    <!-- スタンダードセット -->
                    <h3>スタンダードセット</h3>
                    <ul class="list02 u-standard">
                        <li class="list02__item">
                            <div class="list02__menu">
                                <div class="list02__menu--ribbon list02__menu--color">
                                    スタンダードA
                                </div>
                                <p class="list02__menu--text">サラダ<br>一品料理<br>鶏肉料理<br>麺<br>デザート</p>
                                <p class="list02__menu--price">2,200円</p>
                            </div>
                        </li>
                        <li class="list02__item">
                            <div class="list02__menu">
                                <div class="list02__menu--ribbon list02__menu--color">
                                    スタンダードB
                                </div>
                                <p class="list02__menu--text">一品料理<br>刺身<br>揚げ物<br>肉料理<br>デザート</p>
                                <p class="list02__menu--price">2,750円</p>
                            </div>
                        </li>
                    </ul>
                    <!-- 会食セット -->
                    <h3>会食セット</h3>
                    <ul class="list02">
                        <li class="list02__item">
                            <div class="list02__menu list02__menu--pt01">
                                <div class="list02__menu--ribbon">
                                    会食セットA
                                </div>
                                <p class="list02__menu--text">
                                    季節の一品料理1点<br>お造り（鮮魚1点）<br>焼魚（例：鮭の西京焼き）<br>揚げ物（名物新鮮アジフライ等）<br>チキンガーリックステーキ等<br>食事（茶そば）<br>デザート
                                </p>
                                <p class="list02__menu--price">4,400円</p>
                            </div>
                        </li>
                        <li class="list02__item">
                            <div class="list02__menu list02__menu--pt01">
                                <div class="list02__menu--ribbon">
                                    会食セットB
                                </div>
                                <p class="list02__menu--text">
                                    季節の一品料理２点<br>お造り（鮮魚盛り合わせ）<br>焼魚（例：銀鱈の西京焼き）<br>揚物（名物新鮮アジフライ等）<br>和牛カルビ焼き等<br>食事（稲庭饂飩）<br>デザート叉は水菓子
                                </p>
                                <p class="list02__menu--price">5,500円</p>
                            </div>
                        </li>
                        <li class="list02__item">
                            <div class="list02__menu list02__menu--pt01">
                                <div class="list02__menu--ribbon">
                                    会食セットC
                                </div>
                                <p class="list02__menu--text">
                                    前菜盛合せ<br>お造り（鮮魚盛り合わせ）<br>洋皿（例：ホタテ料理）<br>揚物（名物新鮮アジフライ等）<br>和牛ステーキ等<br>食事（選べる食事スタイル）<br>水菓子
                                </p>
                                <p class="list02__menu--price">6,600円</p>
                            </div>
                        </li>
                    </ul>

                    <ul class="c-list">
                        <li>食材の仕入れ情況により、メニューは変更になります。</li>
                        <li>毎週末旬の食材を仕入れるため、メニュー確定は直近になります。</li>
                        <li>お客様に合わせて内容変更できますのでご相談ください。</li>
                        <li>飲み放題（2h）2,750円、2組以上で承ります。<br>（ビール、ウィスキー、ワイン、焼酎、ノンアルコール、日本酒、ソフトドリンク）</li>
                        <li>ソフトドリンク飲み放題770円、2組以上で承ります。（烏龍茶、コーラ、ジンジャーエール、コーヒー）</li>
                        <li>2日前からキャンセル料が発生いたします。</li>
                    </ul>
                </div>
                <span class="deco _05"><span></span></span>
            </section>

            <!-- 飲み物メニュー -->
            <section id="drink" class="drink">
                <div class="bghd">
                    <h2 class="c-head5">飲み物メニュー<span>Drink</span></h2>
                    <div class="dwrap">
                        <div class="c-column">
                            <div class="dwrap__pic">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_drink_01.jpg" class="dwrap__pic--left" alt="ウィスキー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/img_drink_02.jpg" class="dwrap__pic--right" alt="焼酎">
                            </div>
                            <p>ゴルフのあとのひとときに、<br class="c-brsp">すこし贅沢な一杯はいかがでしょうか。<br>こだわりの熟成酒や希少な銘柄など、<br
                                    class="c-brsp">贅沢な時間をお楽しみください。</p>
                            <span class="deco _06"><span></span></span>
                            <span class="deco _07"><span></span></span>
                        </div>
                    </div>
                </div>

                <div class="dbgmenu">
                    <div class="c-column">
                        <div class="dwrap02">

                            <!-- ビール・日本酒・焼酎・ワイン -->
                            <div class="dwrap02__inner">
                                <h3>ビール・日本酒・焼酎・ワイン</h3>
                                <ul>
                                    <?php if ( have_rows('drinkmenu_alcohol_items') ) : ?>
                                        <?php while ( have_rows('drinkmenu_alcohol_items') ) : the_row(); ?>
                                            <li>
                                                <?php echo esc_html(get_sub_field('name')); ?>
                                                <span>&yen;<?php echo esc_html(get_sub_field('price')); ?></span>
                                            </li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <!-- ウィスキー -->
                            <div class="dwrap02__inner">
                                <h3>ウィスキー</h3>
                                <ul>
                                    <?php if ( have_rows('drinkmenu_whiskey_items') ) : ?>
                                        <?php while ( have_rows('drinkmenu_whiskey_items') ) : the_row(); ?>
                                            <li>
                                                <?php echo esc_html(get_sub_field('name')); ?>
                                                <span>&yen;<?php echo esc_html(get_sub_field('price')); ?></span>
                                            </li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <!-- ソフトドリンク -->
                            <div class="dwrap02__inner">
                                <h3>ソフトドリンク</h3>
                                <ul>
                                    <?php if ( have_rows('drinkmenu_softdrink_items') ) : ?>
                                        <?php while ( have_rows('drinkmenu_softdrink_items') ) : the_row(); ?>
                                            <li>
                                                <?php echo esc_html(get_sub_field('name')); ?>
                                                <span>&yen;<?php echo esc_html(get_sub_field('price')); ?></span>
                                            </li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <ul class="c-brd">
                            <li><a href="/">TOP</a></li>
                            <li><a>レストラン</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>
        
    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>