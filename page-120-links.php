<?php
/*
      Template Name: リンク集
      */
?>

<!--  header -->
<?php get_header('120'); ?>
<!--  header -->

<main class="c-main">
  <div class="c-page-header lazyload">
    <div class="c-column c-page-header__inner">
      <h1 class="c-page-header__title _sub">Links
        <span>リンク集</span>
      </h1>
    </div>
  </div>

  <section class="_mtl">
    <div class="c-column">

      <div class="c-box">
        <h2 class="title-type-02">リンク集</h2>
        <ul class="link-lists">
          <?php if (have_rows('links_regular')): ?>
              <?php while (have_rows('links_regular')): the_row(); 
                  $name = trim(get_sub_field('link_name'));
                  $url  = trim(get_sub_field('link_url'));

                  // name が空なら何も出力しない
                  if ($name === '') continue;
              ?>
                  <li class="link-external">
                      <?php if ($url): ?>
                          <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                              <?php echo esc_html($name); ?>
                          </a>
                      <?php else: ?>
                          <span><?php echo esc_html($name); ?></span>
                      <?php endif; ?>
                  </li>
              <?php endwhile; ?>
          <?php endif; ?>
        </ul>

        <h3 class="partnership-golf">提携ゴルフ場</h3>
        <ul class="link-lists">
          <?php if (have_rows('links_partnership')): ?>
              <?php while (have_rows('links_partnership')): the_row(); 
                  $name = trim(get_sub_field('partner_name'));
                  $url  = trim(get_sub_field('partner_url'));

                  // name が空なら出力しない
                  if ($name === '') continue;
              ?>
                  <li class="link-external">
                      <?php if ($url): ?>
                          <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                              <?php echo esc_html($name); ?>
                          </a>
                      <?php else: ?>
                          <span><?php echo esc_html($name); ?></span>
                      <?php endif; ?>
                  </li>
              <?php endwhile; ?>
          <?php endif; ?>
        </ul>

      </div>
    </div>

  </section>
  <div class="c-column">
    <ul class="c-brd">
      <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
      <li><a href="">リンク集</a></li>
    </ul>
  </div>

</main>

<!--  フッタ読込 -->
<?php get_footer('120'); ?>
<!--  フッタ読込 -->

<?php wp_footer(); ?>

</body>

</html>