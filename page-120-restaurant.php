    <?php
    /*
      Template Name: レストラン
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main _bg">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/restaurant/page-header.jpg">
            <div class="c-column c-page-header__inner">
                <h1 class="c-page-header__title">Restaurant<span>レストラン</span></h1>
            </div>
        </div>

        <div class="c-column-s"> 
        <ul class="c-scroll">
            <li><a href="#gd-launch">ランチメニュー</a></li>
            <li><a href="#gd-morning">朝食メニュー</a></li>
            <li><a href="#gd-party">パーティーメニュー</a></li>
            <li><a href="#gd-snack">おつまみ</a></li>
            <li><a href="#gd-alcohol">アルコール</a></li>
        </ul>
        </div>
        

    <section id="link01">
        <!-- <div class="contents c-column-s"> -->
                <!-- <h2 class="c-head5 c-tac">クラブハウスレストラン<span>Club House</span></h2> -->
                <?php /* if (have_rows('club-res')): ?>
                    <?php while (have_rows('club-res')): the_row(); ?>
                        <div class="rst-intro">
                            <div class="rst-intro__txt">
                                <!-- レストラン説明文 -->
                                <p><?php the_sub_field('club-res-txt'); ?></p>
                                <!-- レストラン備考 -->
                                <ul class="r-list">
                                    <?php if (have_rows('clb_list')): ?>
                                        <?php while (have_rows('clb_list')): the_row(); ?>
                                            <li><span>※</span><?php the_sub_field('clb_item'); ?></li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php
                            // レストラン画像
                            $image = get_sub_field('image-cub-res');
                            if ($image): ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; */?>

        
            <div class="contents c-column-s" id="gd-launch">
              <h3 class="c-head1 c-tac">ランチメニュー<span class="c-head1__en">launch</span></h3>
                <?php
                // WordPressテーマファイル内に記述
                if (have_rows('menu_items')) : ?>
                    <ul class="menubox">
                        <?php while (have_rows('menu_items')) : the_row(); ?>
                            <li>
                                <?php
                                $image = get_sub_field('image'); // 画像フィールド
                                $menuname = get_sub_field('menuname'); // pタグ内の説明文
                                $price = get_sub_field('price'); // spanタグ内の価格
                                $detail = get_sub_field('detail'); // pタグ内のメニュー詳細
                                ?>

                                <?php if ($image): ?>
                                    <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                <?php endif; ?>

                                <?php if ($menuname): ?>
                                    <p class="menuname"><?php echo esc_html($menuname); ?></p>
                                <?php endif; ?>

                                <?php if ($price): ?>
                                    <span><?php echo esc_html($price); ?></span>
                                <?php endif; ?>

                                <?php /* if ($detail): ?>
                                    <p class="detail"><?php echo esc_html($detail); ?></p>
                                <?php endif; */?>

                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>  
            <div class="contents c-column-s _mtm" id="gd-morning">
             <h3 class="c-head1 c-tac">朝食メニュー<span class="c-head1__en">morning</span></h3>
                <?php
                // WordPressテーマファイル内に記述
                if (have_rows('menu_items2')) : ?>
                    <ul class="menubox">
                        <?php while (have_rows('menu_items2')) : the_row(); ?>
                            <li>
                                <?php
                                $image = get_sub_field('image2'); // 画像フィールド
                                $menuname = get_sub_field('menuname2'); // pタグ内の説明文
                                $price = get_sub_field('price2'); // spanタグ内の価格
                                $detail = get_sub_field('detail2'); // pタグ内のメニュー詳細
                                ?>

                                <?php if ($image): ?>
                                    <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                <?php endif; ?>

                                <?php if ($menuname): ?>
                                    <p class="menuname"><?php echo esc_html($menuname); ?></p>
                                <?php endif; ?>

                                <?php if ($price): ?>
                                    <span><?php echo esc_html($price); ?></span>
                                <?php endif; ?>

                                <?php /* if ($detail): ?>
                                    <p class="detail"><?php echo esc_html($detail); ?></p>
                                <?php endif; */?>

                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
  
            <div class="contents c-column-s _mtm" id="gd-party">
                <h3 class="c-head1 c-tac">パーティメニュー<span class="c-head1__en">party</span></h3>
                    <ul class="menubox2">
                        <?php if (have_rows('menu_items3')): ?>
                            <?php while (have_rows('menu_items3')): the_row(); ?>
                                <li>
                                    <?php
                                    // 画像フィールドを取得
                                    $image = get_sub_field('image3');
                                    if ($image): ?>
                                        <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    <?php endif; ?>
                                        <div>
                                            <p class="menubox2__ttl"><?php the_sub_field('title'); ?></p>
                                            <p><?php the_sub_field('description'); ?></p>
                                            <ul class="c-list">
                                                <?php if (have_rows('c_list')): ?>
                                                    <?php $counter = 0; ?>
                                                    <?php while (have_rows('c_list') && $counter < 3): the_row(); ?>
                                                        <li>
                                                            <span>※</span>
                                                            <?php the_sub_field('list_item'); ?>
                                                        </li>
                                                        <?php $counter++; ?>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
            </div>
            <div class="contents c-column-s _mtm" id="gd-snack">
                <h3 class="c-head1 c-tac">おつまみ<span class="c-head1__en">Pppetizers</span></h3>
                    <?php
                        // WordPressテーマファイル内に記述
                        if (have_rows('menu_items4')) : ?>
                            <ul class="menubox">
                                <?php while (have_rows('menu_items4')) : the_row(); ?>
                                    <li>
                                        <?php
                                        $image = get_sub_field('image4'); // 画像フィールド
                                        $menuname = get_sub_field('menuname4'); // pタグ内の説明文
                                        $price = get_sub_field('price4'); // spanタグ内の価格
                                        $detail = get_sub_field('detail4'); // pタグ内のメニュー詳細
                                        ?>

                                        <?php if ($image): ?>
                                            <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        <?php endif; ?>

                                        <?php if ($menuname): ?>
                                            <p class="menuname"><?php echo esc_html($menuname); ?></p>
                                        <?php endif; ?>

                                        <?php if ($price): ?>
                                            <span><?php echo esc_html($price); ?></span>
                                        <?php endif; ?>

                                        <?php /* if ($detail): ?>
                                            <p class="detail"><?php echo esc_html($detail); ?></p>
                                        <?php endif; */?>

                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
            </div>
  
             <div class="contents c-column-s _mtm" id="gd-alcohol">          
                <h3 class="c-head1 c-tac">アルコール<span class="c-head1__en">Alcohol</span></h3>

                    <?php if (have_rows('menu_group')) : ?>
                        <?php while (have_rows('menu_group')) : the_row(); ?>
                            <?php
                            $menu_title     = trim(get_sub_field('menu_title'));
                            $group_title    = trim(get_sub_field('group_title'));
                            $group_subtitle = trim(get_sub_field('group_subtitle'));
                            $has_items      = false;
                            ob_start(); // 出力を一時的に保存
                            ?>

                            <?php if (have_rows('item_list')) : ?>
                                <?php while (have_rows('item_list')) : the_row(); ?>
                                    <?php
                                    $item_name  = trim(get_sub_field('item_name'));
                                    $item_price = trim(get_sub_field('item_price'));
                                    if ($item_name !== '' || $item_price !== '') :
                                        $has_items = true;
                                    ?>
                                        <dl>
                                            <?php if ($item_name !== '') : ?>
                                                <dt><?php echo esc_html($item_name); ?></dt>
                                            <?php endif; ?>
                                            <?php if ($item_price !== '') : ?>
                                                <dd><?php echo esc_html($item_price); ?></dd>
                                            <?php endif; ?>
                                        </dl>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>

                            <?php
                            $items_output = ob_get_clean(); // item_list の出力取得
                            ?>

                            <?php if ($menu_title !== '') : ?>
                                <p class="textmenu__head _mts"><?php echo esc_html($menu_title); ?></p>
                            <?php endif; ?>

                            <?php if ($group_title !== '' || $group_subtitle !== '' || $has_items) : ?>
                                <div class="textmenu__box">
                                    <?php if ($group_title !== '' || $group_subtitle !== '') : ?>
                                        <p class="textmenu__box--ttl">
                                            <?php if ($group_title !== '') : ?>
                                                <?php echo esc_html($group_title); ?>
                                            <?php endif; ?>
                                            <?php if ($group_subtitle !== '') : ?>
                                                <span class="small"><?php echo esc_html($group_subtitle); ?></span>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php echo $items_output; ?>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>
                  
            </div>
        </section>

        <div class="c-column">
            <ul class="c-brd">
                <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
                <li><a href="<?php echo esc_url(home_url('')); ?>/restaurant/">レストラン</a></li>
            </ul>
        </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>