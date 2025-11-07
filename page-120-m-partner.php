    <?php
    /*
      Template Name: 提携コース
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
            <span>提携コースのご案内</span>
          </h1>
        </div>
      </div>
      <ul class="m-list">
        <li><a href="">会員様お知らせ</a></li>
        <li><a href="">営業案内</a></li>
        <li><a href="">くすのき会</a></li>
        <li><a href="">提携コース</a></li>
        <li><a href="">ビジター様料金</a></li>
        <li><a href="">コンペ申込</a></li>
      </ul>

      <div class="c-column">
        <h2 class="c-head6">提携コースのご案内<span>Partner Courses</span></h2>
        <div class="box-pat">
          <div class="deco _02">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
          <ul>
            <li><a href="" target="_blank">パサージュ琴海</a></li>
            <li><a href="" target="_blank">釧路カントリークラブ</a></li>
            <li><a href="" target="_blank">大浅間ゴルフクラブ</a></li>
            <li><a href="" target="_blank">三井の森蓼科ゴルフ倶楽部</a></li>
            <li><a href="" target="_blank">フォレストカントリークラブ 三井の森</a></li>
          </ul>
        </div>

        <!-- パンくずリスト -->
        <ul class="c-brd">
          <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
          <li><a href="<?php echo esc_url(home_url('')); ?>/m-news/">会員サイト</a></li>
          <li><a href="">会員様お知らせ</a></li>
        </ul>
      </div>

    </main>

    <!--  フッタ読込 -->
    <?php get_footer('120'); ?>
    <!--  フッタ読込 -->

    <?php wp_footer(); ?>

    </body>

    </html>