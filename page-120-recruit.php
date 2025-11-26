    <?php
    /*
    Template Name: 求人情報
      */
    ?>

    <!--  header -->
    <?php get_header('120'); ?>
    <!--  header -->

    <main class="c-main">
        <div class="c-page-header lazyload">
            <div class="c-column c-page-header__inner">
                <h1 class="c-page-header__title">Recruit
                    <span>求人情報</span>
                </h1>
            </div>
        </div>

        <div class="c-column">
            <section class="rbox">
                <h2 class="rbox__rechead">キャディスタッフ募集中<br class="c-brsp">（正社員・パート社員）</h2>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/dummy_01.jpg" alt="ダミー">
                <!-- 表部分 -->
                <?php if (have_rows('job_items')): ?>
                    <table class="tb-01">
                        <tbody>
                            <?php while (have_rows('job_items')): the_row();
                                $title = get_sub_field('title');   // th
                                $content = get_sub_field('content'); // td
                            ?>
                                <tr>
                                    <th><?php echo esc_html($title); ?></th>
                                    <td><?php echo nl2br(esc_html($content)); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (have_rows('notes')): ?>
                    <?php while (have_rows('notes')): the_row();
                        $note = get_sub_field('note_text');
                    ?>
                        <p class="rbox__notes">
                            <?php echo nl2br(esc_html($note)); ?>
                        </p>
                    <?php endwhile; ?>
                <?php endif; ?>

            </section>

            <section class="rbox">
                <h2 class="rbox__rechead">レストランスタッフ（ホール）</h2>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/recruit/dummy_02.jpg" alt="ダミー">
                <!-- 表部分 -->
                <?php if (have_rows('job_items2')): ?>
                    <table class="tb-01">
                        <tbody>
                            <?php while (have_rows('job_items2')): the_row();
                                $title = get_sub_field('title2');   // th
                                $content = get_sub_field('content2'); // td
                            ?>
                                <tr>
                                    <th><?php echo esc_html($title); ?></th>
                                    <td><?php echo nl2br(esc_html($content)); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if (have_rows('notes2')): ?>
                    <?php while (have_rows('notes2')): the_row();
                        $note = get_sub_field('note_text2');
                    ?>
                        <p class="rbox__notes">
                            <?php echo nl2br(esc_html($note)); ?>
                        </p>
                    <?php endwhile; ?>
                <?php endif; ?>

                <p class="rbox__com">未経験の方からでも丁寧に指導いたしますので安心してご応募いただけます。<br>現在、活躍しているスタッフのほとんどが未経験からスタートしています。</p>

                <div class="c-rease">
                    <div>
                        <p>まずはお気軽にお電話ください。</p>
                        <a href="tel:0476-93-9000">0476-93-9000</a>
                    </div>
                </div>
            </section>



            <ul class="c-brd">
                <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
                <li><a href="">求人情報</a></li>
            </ul>
        </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>