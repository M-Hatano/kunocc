      <?php
      /*
      Template Name: コース全景
      */
      ?>

      <!--  header -->
      <?php get_header('120'); ?>
      <!--  header -->

      <main class="c-main">
        <div class="c-page-header lazyload" data-bg="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/page-header.jpg">
          <div class="c-column c-page-header__inner">
            <h1 class="c-page-header__title">Course
              <span>コース案内</span>
            </h1>
          </div>
        </div>

        <section class="_mtl">
          <h2 class="c-head1">
            コース詳細
            <span class="c-head1__en">Detail</span>
          </h2>
            <div class="detail">
              <a href="<?php echo esc_url(home_url('/course/fuji/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/img_course_fuji.jpg" alt="富士コース" loading="lazy">
                <div>
                  <span>富士コース</span>
                  <p>
                    3コース中で最も距離が長く、<br>
                    しかもフェアウェイの幅が広いので<br>
                    ドライバーを豪快に振り回して<br>
                    思いっきり攻略できるのが最大の魅力。
                  </p>
                  <p>
                    ストレートなホールが続き、<br>
                    さながら、富士山と散歩しながらの<br>
                    ゴルフが楽しめます。<br>
                  </p>
                  <p class="detail__btn">コースレイアウト</p>
                </div>
              </a>
              <a href="<?php echo esc_url(home_url('/course/hakone/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/img_course_hakone.jpg" alt="箱根コース" loading="lazy">
                <div>
                  <span>箱根コース</span>
                  <p>
                    フラットで豪快な富士コースとは対照的に<br>
                    戦略性に富む9ホール。<br>
                    距離もたっぷりあり、<br>
                    ドッグレッグするホールもある。
                  </p>
                  <p>
                    ゴルファーの技量を試すに<br>
                    ふさわしいコースです。<br>
                  </p>
                  <p class="detail__btn">コースレイアウト</p>
                </div>
              </a>
              <a href="<?php echo esc_url(home_url('/course/tanzawa/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/img_course_tanzawa.jpg" alt="丹沢コース" loading="lazy">
                <div>
                  <span>丹沢コース</span>
                  <p>
                    全体に距離は短めだが、<br>
                    コース全体が変化に富んでいるので<br>
                    正確なショットが要求されるコース。
                  </p>
                  <p>
                    力まずに確実性重視でコースを攻略すれば、<br>
                    好スコアが期待できます。
                  </p>
                  <p class="detail__btn">コースレイアウト</p>
                </div>
              </a>
            </div>
        </section>

        <section class="_mtl">
          <h2 class="c-head1">
            コース全景
            <span class="c-head1__en">View</span>
          </h2>
          <div class="c-column">
            <div class="map">
              <figure class="crs__img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/img_course_04.png" alt="コース全景" usemap="#ImageMap"></figure>
              <map name="ImageMap">
                <area shape="poly" coords="141,46,160,25,226,37,301,36,323,45,368,100,398,176,403,217,376,227,353,240,227,272,166,306,133,308,119,191,131,130,139,63,139,63" href="<?php echo esc_url(home_url('/course/hakone')); ?>" alt="" />
                <area shape="poly" coords="326,40,530,96,778,183,891,230,885,246,757,258,617,252,519,244,453,235,400,216,410,197,406,170,325,48,364,69" href="<?php echo esc_url(home_url('/course/fuji')); ?>" alt="" />
                <area shape="poly" coords="130,319,212,282,320,246,367,244,381,265,478,249,506,278,535,315,464,349,421,369,319,388,253,417,197,468,157,498,127,485,128,322,136,329" href="<?php echo esc_url(home_url('/course/tanzawa')); ?>" alt="" />

              </map>


            </div>

            <div class="crs-ytb _mtm" id="vw-point">
              <h4 class=" c-head3 c-tac">富士山世界遺産 平原ベストビューポイント</h4>
              <p>どのホールからも富士山が望める富士平原ゴルフクラブ ベストビューポイント５か所の紹介です。</p>
              <iframe width="560" class="_mts"  height="315" src="https://www.youtube.com/embed/yESG1PHP7M8?si=dK7dmF5WJnXAaLBV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

              <div class="ex-view _mts">
                <ul>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_002_tamba_3.jpg" alt="丹沢コース３番" loading="lazy">
                    <p>丹沢コース３番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_003_tamba_7.gif" alt="丹沢コース７番" loading="lazy">
                    <p>丹沢コース７番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_004_tamba_9.jpg" alt="丹沢コース９番" loading="lazy">
                    <p>丹沢コース９番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_001_fuji_1.jpg" alt="富士コース１番" loading="lazy">
                    <p>富士コース１番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_008_fuji_1.gif" alt="昭和34年オープン当時の富士コース１番" loading="lazy">
                    <p>昭和34年オープン当時の<br>富士コース１番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_005_tamba_4.gif" alt="富士コース４番" loading="lazy">
                    <p>富士コース４番</p>
                  </li>
                  <li>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/course/photo_bestview_001_fuji_1.gif" alt="富士コース１番" loading="lazy">
                    <p>富士コース１番</p>
                  </li>
                </ul>
              </div>

            </div>
          </div>
        </section>

        <section class="_mtl">
          <h2 class="c-head1">
            ヤーデージ
            <span class="c-head1__en">Yardage</span>
          </h2>
          <div class="c-column">
            <div class="table-scroll">
              <table class="table-type-02 table-course">
                <caption>富士</caption>
                <thead>
                  <tr>
                    <th width="20%">HOLES</th>
                    <th width="8%">1</th>
                    <th width="8%">2</th>
                    <th width="8%">3</th>
                    <th width="8%">4</th>
                    <th width="8%">5</th>
                    <th width="8%">6</th>
                    <th width="8%">7</th>
                    <th width="8%">8</th>
                    <th width="8%">9</th>
                    <th width="8%">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Hdcp</th>
                    <td>4</td>
                    <td>1</td>
                    <td>9</td>
                    <td>8</td>
                    <td>6</td>
                    <td>3</td>
                    <td>7</td>
                    <td>2</td>
                    <td>5</td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Back</th>
                    <td>435</td>
                    <td>533</td>
                    <td>148</td>
                    <td>356</td>
                    <td>186</td>
                    <td>535</td>
                    <td>383</td>
                    <td>463</td>
                    <td>445</td>
                    <td>3,484</td>
                  </tr>
                  <tr>
                    <th>Front</th>
                    <td>405</td>
                    <td>503</td>
                    <td>138</td>
                    <td>332</td>
                    <td>170</td>
                    <td>492</td>
                    <td>362</td>
                    <td>361</td>
                    <td>388</td>
                    <td>3,151</td>
                  </tr>
                  <tr>
                    <th>Ladys</th>
                    <td>333</td>
                    <td>432</td>
                    <td>120</td>
                    <td>332</td>
                    <td>155</td>
                    <td>446</td>
                    <td>328</td>
                    <td>318</td>
                    <td>388</td>
                    <td>2,852</td>
                  </tr>
                  <tr>
                    <th>Par</th>
                    <td>4</td>
                    <td>5</td>
                    <td>3</td>
                    <td>4</td>
                    <td>3</td>
                    <td>5</td>
                    <td>4</td>
                    <td>4</td>
                    <td>4</td>
                    <td>36</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-scroll">
              <table class="table-type-02 table-course">
                <caption>箱根</caption>
                <thead>
                  <tr>
                    <th width="20%">HOLES</th>
                    <th width="7.27%">1</th>
                    <th width="7.27%">2</th>
                    <th width="7.27%">3</th>
                    <th width="7.27%">4</th>
                    <th width="7.27%">5</th>
                    <th width="7.27%">6</th>
                    <th width="7.27%">7</th>
                    <th width="7.27%">8</th>
                    <th width="7.27%">9</th>
                    <th width="7.27%">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Hdcp</th>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>1</td>
                    <td>4</td>
                    <td>8</td>
                    <td>7</td>
                    <td>9</td>
                    <td>6</td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Back</th>
                    <td>427</td>
                    <td>498</td>
                    <td>399</td>
                    <td>423</td>
                    <td>507</td>
                    <td>193</td>
                    <td>348</td>
                    <td>143</td>
                    <td>401</td>
                    <td>3,339</td>
                  </tr>
                  <tr>
                    <th>Front</th>
                    <td>405</td>
                    <td>476</td>
                    <td>366</td>
                    <td>394</td>
                    <td>498</td>
                    <td>170</td>
                    <td>312</td>
                    <td>128</td>
                    <td>377</td>
                    <td>3,126</td>
                  </tr>
                  <tr>
                    <th>Ladys</th>
                    <td>342</td>
                    <td>448</td>
                    <td>327</td>
                    <td>314</td>
                    <td>393</td>
                    <td>164</td>
                    <td>282</td>
                    <td>128</td>
                    <td>324</td>
                    <td>2,722</td>
                  </tr>
                  <tr>
                    <th>Par</th>
                    <td>4</td>
                    <td>5</td>
                    <td>4</td>
                    <td>4</td>
                    <td>5</td>
                    <td>3</td>
                    <td>4</td>
                    <td>3</td>
                    <td>4</td>
                    <td>36</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-scroll">
              <table class="table-type-02 table-course">
                <caption>丹沢</caption>
                <thead>
                  <tr>
                    <th width="20%">HOLES</th>
                    <th width="7.27%">1</th>
                    <th width="7.27%">2</th>
                    <th width="7.27%">3</th>
                    <th width="7.27%">4</th>
                    <th width="7.27%">5</th>
                    <th width="7.27%">6</th>
                    <th width="7.27%">7</th>
                    <th width="7.27%">8</th>
                    <th width="7.27%">9</th>
                    <th width="7.27%">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Hdcp</th>
                    <td>2</td>
                    <td>9</td>
                    <td>1</td>
                    <td>7</td>
                    <td>5</td>
                    <td>6</td>
                    <td>3</td>
                    <td>8</td>
                    <td>4</td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Back</th>
                    <td>474</td>
                    <td>186</td>
                    <td>408</td>
                    <td>160</td>
                    <td>358</td>
                    <td>127</td>
                    <td>373</td>
                    <td>268</td>
                    <td>472</td>
                    <td>2,826</td>
                  </tr>
                  <tr>
                    <th>Front</th>
                    <td>466</td>
                    <td>171</td>
                    <td>396</td>
                    <td>144</td>
                    <td>323</td>
                    <td>105</td>
                    <td>355</td>
                    <td>254</td>
                    <td>451</td>
                    <td>2,665</td>
                  </tr>
                  <tr>
                    <th>Ladys</th>
                    <td>457</td>
                    <td>125</td>
                    <td>300</td>
                    <td>144</td>
                    <td>285</td>
                    <td>105</td>
                    <td>311</td>
                    <td>254</td>
                    <td>383</td>
                    <td>2,364</td>
                  </tr>
                  <tr>
                    <th>Par</th>
                    <td>5</td>
                    <td>3</td>
                    <td>4</td>
                    <td>3</td>
                    <td>4</td>
                    <td>3</td>
                    <td>4</td>
                    <td>4</td>
                    <td>5</td>
                    <td>35</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <div class="c-column">
          <ul class="c-brd">
            <li><a href="<?php echo esc_url(home_url('')); ?>">TOP</a></li>
            <li><a href="">コース案内</a></li>
          </ul>
        </div>

      </main>

      <!--  フッタ読込 -->
      <?php get_footer('120'); ?>
      <!--  フッタ読込 -->

      <script src="https://unpkg.com/image-map-resizer@1.0.10/js/imageMapResizer.min.js"></script>
      <script>imageMapResize();</script>

      <?php wp_footer(); ?>

      </body>

      </html>