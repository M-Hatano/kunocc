        <?php
        /*
            Template Name: ご予約方法について
            */
        ?>

        <!--  header -->
        <?php get_header('120'); ?>
        <!--  header -->

        <main class="c-main">
            <div class="c-page-header lazyload">
                <div class="c-column c-page-header__inner">
                    <h1 class="c-page-header__title">Reservation&nbsp;Process
                        <span>ご予約方法について</span>
                    </h1>
                </div>
            </div>

            <div class="c-column">
                <div class="r-lead">
                    <div class="r-lead__texbox">
                        <h2>品格と静謐に包まれた、<br class="c-brsp">接待のためのひととき。</h2>
                        <p>
                            当倶楽部では、法人会員様による大切なお客様のお迎えにふさわしい環境と、<br class="c-brpc">
                            細やかな配慮を行き届かせたサービスをご提供しております。<br>
                            ゆったりとした時間の流れのなかで、<br class="c-brsp">信頼を深める場としてご利用いただけるよう、<br>
                            接待時のご案内からご予約方法までを、こちらのページにてご紹介いたします。
                        </p>
                    </div>
                    <span class="deco _01"><span></span></span>
                    <span class="deco _02"><span></span></span>
                </div>

                <ul class="c-scroll">
                    <li><a href="#link01">ご予約の流れ</a></li>
                    <li><a href="#link02">ご利用日当日の流れ</a></li>
                </ul>
            </div>

            <section id="link01">
                <h2 class="c-head6">ご予約の流れ<span>Hospitality<br class="c-brsp">Schedule</span></h2>
                <div class="rhead">
                    <div class="c-column border _wh _sta">
                        <div class="rcol">
                            <h3 class="rpoit">6か月前<span class="rpoit__text01">予約開始</span></h3>
                        </div>
                    </div>
                </div>
                <div class="c-column border _nv">
                    <div class="rcol _pad">
                        <p class="rtel">ご予約のスタートはお電話にて受付けております。以下の電話番号よりご連絡をお願いいたします。</p>
                        <a href="tel:0476-93-9000">0476-93-9000</a>

                        <div class="rbox">
                            <div class="rbox__method apply">
                                <p>ご予約方法A</p>
                            </div>
                            <p>
                                仮予約が完了いたしましたら、以下の「<span class="cno">①</span>ご予約連絡フォーム」「<span class="cno">②</span>組み合わせ送信フォーム」の順で、<br class="c-brpc">
                                それぞれご予約の詳細情報を一括送信いただけます。<br>
                                ご入力の際には、「プレー日」と「受付番号」をそれぞれご入力ください。
                            </p>
                            <div class="rbox__btnbox">
                                <a href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_uke.asp" target="_blank" rel="noopener noreferrer" class="c-btn"><span class="cno">①</span>ご予約連絡フォーム</a>
                                <a href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_kumi.asp" target="_blank" rel="noopener noreferrer" class="c-btn"><span class="cno">②</span>組み合わせ送信フォーム</a>
                            </div>
                            <span class="deco _03"><span></span></span>
                        </div>

                        <div class="rbox" id="res_form">
                            <div class="rbox__method apply">
                                <p>ご予約方法B</p>
                            </div>
                            <p>WEB上でご入力をされないお客様は、以下にご予約連絡フォーム（エクセル形式・PDF形式）をそれぞれご用意しております。</p>

                            <?php
                            $excel = get_field('reservation_form_excel', 'option');
                            $pdf   = get_field('reservation_form_pdf', 'option');
                            ?>
                            <div class="rbox__btnbox">
                                <a href="<?php echo $excel ? esc_url($excel['url']) : '#'; ?>" class="c-btn">ご予約連絡フォーム（エクセル）</a>
                                <a href="<?php echo $pdf ? esc_url($pdf['url']) : '#'; ?>" class="c-btn">ご予約連絡フォーム（PDF）</a>
                                <span class="deco _04"><span></span></span>
                            </div>
                            <p class="regi_send">ご入力後のファイルは以下アドレスに送信をお願いいたします。<br class="c-brsp">（手書きで持参いただくことも可能です。）</p>
                            <a href="mailto:info@kunocc.co.jp" class="mailbox"><span></span>info@kunocc.co.jp</a>
                        </div>
                    </div>
                </div>

                <div class="bg-chen">
                    <span class="deco _01"><span></span></span>
                    <span class="deco _02"><span></span></span>
                    <div class="c-column border _wh">
                        <div class="rcol">
                            <p class="rpoit _chen">ご確認事項</p>

                            <ul class="rlistbox">
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        プレー料金のご確認
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            プレー料金やゲスト料金については<br>
                                            「会員専用ページ」よりご確認いただけます。その他料金に関しましては以下のリンクよりご確認ください。
                                        </p>
                                        <a href="<?php echo esc_url(home_url('')); ?>">レンタル料金について ／ </a>
                                        <a href="<?php echo esc_url(home_url('')); ?>facility/#link03">個室の料金について ／ </a>
                                        <a href="<?php echo esc_url(home_url('')); ?>/d-range/">練習場の料金について ／ </a>
                                        <a href="<?php echo esc_url(home_url('')); ?>/restaurant/">食事の料金について ／ </a>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        パーティーの内容のご確認
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            プレー後のパーティーは開催されますか？<br>
                                            アレルギーをお持ちの方、ハラル、ベジタリアンの方へのご対応も可能です。<br>
                                            パーティーの内容については以下のリンクよりご確認ください。
                                        </p>
                                        <a href="<?php echo esc_url(home_url('')); ?>/restaurant/#party">パーティープランについて ／ </a>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        個室のご予約のご確認
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            個室のご予約は必要ですか？<br>
                                            お部屋のレイアウトについては以下のリンクよりご確認いただけます。但し、お部屋の指定はできかねますのでご了承ください。
                                        </p>
                                        <a href="<?php echo esc_url(home_url('')); ?>/facility/#link03">プライベートルームについて ／ </a>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        メンバー表<br>キャディバッグについて
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            メンバーの組み合わせのご連絡については<br>
                                            <a
                                                href="">WEB入力用の組み合わせ送信フォーム</a>をご利用ください。キャディバッグ配送の有無、カートの詰め込み順もご指定いただけます。<br>
                                            また、<a href="#res_form">組み合わせ送信フォーム（エクセル・PDF）</a>もご利用ください。
                                        </p>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        集計方法のご連絡
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            スコアの集計はございますか？<br>
                                            集計方法について（競技方法、ハンデ上限、打数制限、同順位決定）は、<a href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_uke.asp" target="_blank" rel="noopener noreferrer">ご予約連絡フォーム（WEB）</a>または<a href="#res_form">ご予約連絡フォーム（エクセル・PDF）</a>でご指定ください。
                                        </p>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        精算方法について
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            精算方法の指定はございますか？指定がございます場合、<a href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_uke.asp" rel="noopener noreferrer" target="_blank">ご予約連絡フォーム（WEB）</a>または<a href="#res_form">ご予約連絡フォーム（エクセル・PDF）</a>をご利用ください。
                                        </p>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        ドレスコードについて
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            ドレスコードについては、以下リンクよりご確認いただけます。
                                        </p>
                                        <a href="<?php echo esc_url(home_url('')); ?>/dresscode/">ドレスコードについて ／ </a>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        アクセス<br>近隣ホテルについて
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            交通手段ごとのアクセス、近隣ホテルの情報を掲載しております。<br>
                                            以下のリンクよりご確認ください。
                                        </p>
                                        <a href="<?php echo esc_url(home_url('')); ?>/access/">アクセスについて ／ </a>
                                        <a href="<?php echo esc_url(home_url('')); ?>/access/#link05"> 近隣ホテルについて</a>
                                    </div>
                                </li>
                                <li class="rlistbox__item">
                                    <div class="rlistbox__item--gd">
                                        お土産について
                                        <span class="deco _05"><span></span></span>
                                    </div>
                                    <div class="rlistbox__item--wh">
                                        <p>
                                            手土産等の事前送付はございますか？<br>
                                            ございます場合、<a href="https://wst1.asts.jp/golfnet/cc/0213cc/compe/index_uke.asp" rel="noopener noreferrer" target="_blank">ご予約連絡フォーム（WEB）</a><br>
                                            または<a href="#res_form">ご予約連絡フォーム（エクセル・PDF）</a></a>をご利用ください。
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="c-column border _nv">
                    <div class="rcol">
                        <p class="rpoit _chen _caut">注意事項</p>
                        <p class="dot">プレー日の１か月前までにプレーヤー名のご連絡をお願いいたします。</p>
                        <p class="dot">皆様に当倶楽部でのゴルフを楽しんでいただくために、同時期での予約は土日祝については最大2日、平日については最大3日までを原則とさせていただきます。</p>
                        <p class="dot">キャンセルや組数変更の場合はお早めにご連絡ください。</p>
                        <p class="dot">直前キャンセル（雨天理由を除いた、当日までに1か月を切ったキャンセル）が多いお客様におかれましては、次回予約を制限させていただく場合がございます。</p>
                        <p class="dot">
                            レンタル用品についてはわずかしかご用意がございません。必要に応じてレンタルクラブ会社からお借りすることも可能ですので、プレーの一週間前までにご予約ください。ブランド等の指定も可能です。
                        </p>
                        <p class="dot">宅急便につきましては、クロネコヤマトの宅急便サービスをご利用いただけます。</p>
                    </div>
                </div>

                <div class="rhead rele01">
                    <div class="c-column border _wh">
                        <div class="rcol">
                            <h3 class="rpoit"><span class="rpoit__days">1か月前</span><span class="rpoit__text02">リリース日程がございましたら、お早めにキャンセルの連絡をお願いいたします。</spanclass=>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="rhead rele02">
                    <div class="c-column border _nv">
                        <div class="rcol">
                            <h3 class="rpoit"><span class="rpoit__days">3日前</span><span class="rpoit__text02">パーティープランキャンセル料発生</span></h3>
                        </div>
                    </div>
                </div>

                <div class="rhead rele03">
                    <div class="c-column border _wh _las">
                        <div class="rcol">
                            <h3 class="rpoit">
                                <spanvz class="rpoit__days">当日</spanvz><span class="rpoit__text02">当倶楽部でのプレーをお楽しみください。<br>プレー当日のイメージは以下よりご確認いただけます。</span>
                            </h3>
                        </div>
                    </div>
                </div>

            </section>

            <!-- 当日の流れ -->
            <section id="link02" class="stream">
                <h2 class="c-head6">ご利用日当日の流れ<span>Hospitality<br class="c-brsp">Schedule</span></h2>

                <!-- タブエリア -->
                <ul class="tabMenu">
                    <li class="active">通常プレーの場合</li>
                    <li class="ignore">スループレーの場合</li>
                </ul>
                <div class="tabbox">
                    <div class="tabContent active">
                        <ul class="pflow">
                            <li class="pflow__arrow_box _01">
                                <div class="pflow__tex">
                                    <h3><span class="cno">①</span>ご来場&middot;お出迎え</h3>
                                    <p>クラブハウスにて、主催者様がゲストの皆様をお迎えいたします。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_01.jpg" alt="ご来場">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_01.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b01"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _02">
                                <div class="pflow__tex">
                                    <h3><span class="cno">②</span>チェックイン手続き</h3>
                                    <p>会員様は専用カウンター、ゲスト様はビジターカウンターにてチェックインをお願いいたします。ご記入内容にはお名前・ご住所・ご連絡先などが含まれます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_02.jpg" alt="チェックイン手続き">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_02.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b02"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _03">
                                <div class="pflow__tex">
                                    <h3><span class="cno">③</span>お着替え</h3>
                                    <p>ロッカールームにて、ゴルフウェアにお着替えいただきます。<br>ロッカーはランダムでのご案内となり、専用ロッカーのご用意はございませんのでご了承ください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_03.jpg" alt="お着替え">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_03.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b03"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _04">
                                <div class="pflow__tex">
                                    <h3><span class="cno">④</span>ご集合&middot;朝食のお時間</h3>
                                    <p>個室をご用意している場合はお部屋へ、ない場合はレストランホールにご集合いただき、モーニングコーヒーや軽食をお楽しみいただけます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_04.jpg" alt="ご集合">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_04.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b04"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _05">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑤</span>練習&middot;ウォーミングアップ</h3>
                                    <p>ゴルフスタート前にウォーミングアップ、<a href="<?php echo esc_url(home_url('')); ?>/d-range/">練習場やパッティンググリーン</a>にて練習をされます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_05.jpg" alt="練習">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_05.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b05"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _06">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑥</span>キャディご挨拶&middot;クラブ確認</h3>
                                    <p>担当キャディよりご挨拶の後、クラブの本数や内容を確認させていただきます。<br>キャディのご指名は承っておりませんので、予めご了承ください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_06.jpg" alt="キャディご挨拶">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_06.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b06"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _07">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑦</span>ラウンドスタート（前半）</h3>
                                    <p>いよいよゴルフスタートです。OUTスタート、INスタートいずれかよりプレーを開始いただきます。全組キャディ・乗用カート付きでのご案内です。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_07.jpg" alt="ラウンドスタート（前半）">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_07.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b07"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _08">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑧</span>前半終了&middot;クラブハウスへ</h3>
                                    <p>9ホール終了後はクラブハウスにお戻りいただきます。<br>スムーズな進行のため、プレー時間は2時間10分を目安としております。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="前半終了">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_08.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b08"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _09">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑨</span>昼食タイム</h3>
                                    <p>後半開始までの約50分間、レストランまたはご予約のお部屋にて昼食をお楽しみください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_09.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b09"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _10">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑩</span>後半ラウンドへ</h3>
                                    <p>昼食後、後半のラウンドへ。<br>OUTスタートの場合は10～18番、INスタートの場合は1～9番ホールをプレーされます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_10.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b10"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _11">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑪</span>プレー終了（ホールアウト）</h3>
                                    <p>後半のラウンドを終えられた後は、スコアの確認・クラブの点検を行い、プレー終了となります。<br>ご希望があればスコア集計表をマスター室よりお渡しします。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_11.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b11"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _12">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑫</span>ご入浴&middot;お着替え</h3>
                                    <p>プレーの疲れを癒すひととき。<br>大浴場で汗を流し、リフレッシュしてお着替えください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_12.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b12"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _13">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑬</span>アフターゴルフ&middot;懇親会</h3>
                                    <p>プライベートルームやレストランホールにて、懇親のお時間をお過ごしください。本日のプレーを振り返りながら、和やかな語らいのひとときをお楽しみいただけます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_13.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b13"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _14">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑭</span>お見送り&middot;ご帰宅</h3>
                                    <p>最後にお土産をお渡しし、ゲストの皆様をお見送りします。<br>※お土産を事前にお送りいただく場合は、当日午前中必着にてお送りください。スタッフにて開封し、お渡しの準備をいたします。
                                    </p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_14.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b014"><span></span></span>
                            </li>
                        </ul>
                        <p class="rnotice">&#8251;ハーフ終了後に45分間の食事休憩、プレー後の飲食等を60分とした場合のスケジュールになります。</p>
                    </div>

                    <!-- スループレー -->
                    <div class="tabContent ignore">
                        <p class="rnotice _thr">&#8251;スループレーは<span>土日祝日</span>のみになります。</p>
                        <ul class="pflow">
                            <li class="pflow__arrow_box _01">
                                <div class="pflow__tex">
                                    <h3><span class="cno">①</span>ご来場&middot;お出迎え</h3>
                                    <p>クラブハウスにて、主催者様がゲストの皆様をお迎えいたします。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_01.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b01"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _02">
                                <div class="pflow__tex">
                                    <h3><span class="cno">②</span>チェックイン手続き</h3>
                                    <p>会員様は専用カウンター、ゲスト様はビジターカウンターにてチェックインをお願いいたします。ご記入内容にはお名前・ご住所・ご連絡先などが含まれます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_02.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b02"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _03">
                                <div class="pflow__tex">
                                    <h3><span class="cno">③</span>お着替え</h3>
                                    <p>ロッカールームにて、ゴルフウェアにお着替えいただきます。<br>ロッカーはランダムでのご案内となり、専用ロッカーのご用意はございませんのでご了承ください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_03.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b03"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _04">
                                <div class="pflow__tex">
                                    <h3><span class="cno">④</span>ご集合&middot;朝食のお時間</h3>
                                    <p>個室をご用意している場合はお部屋へ、ない場合はレストランホールにご集合いただき、モーニングコーヒーや軽食をお楽しみいただけます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_04.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b04"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _05">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑤</span>練習&middot;ウォーミングアップ</h3>
                                    <p>ゴルフスタート前にウォーミングアップ、<a href="<?php echo esc_url(home_url('')); ?>/d-range/">練習場やパッティンググリーン</a>にて練習をされます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_05.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b05"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _06">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑥</span>キャディご挨拶&middot;クラブ確認</h3>
                                    <p>担当キャディよりご挨拶の後、クラブの本数や内容を確認させていただきます。<br>キャディのご指名は承っておりませんので、予めご了承ください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_06.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b06"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _07">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑦</span>ラウンドスタート（前半）</h3>
                                    <p>いよいよゴルフスタートです。OUTスタート、INスタートいずれかよりプレーを開始いただきます。全組キャディ・乗用カート付きでのご案内です。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_07.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b07"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _08">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑧</span>プレー終了（ホールアウト）</h3>
                                    <p>スコアの確認&bull;クラブの点検を行い、プレー終了となります。<br>ご希望があればスコア集計表をマスター室よりお渡しします</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_15.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b15"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _09">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑨</span>ご入浴&bull;お着替え</h3>
                                    <p>プレーの疲れを癒すひととき。<br>大浴場で汗を流し、リフレッシュしてお着替えください。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_16.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b16"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _10">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑩</span>ランチ&bull;懇親会</h3>
                                    <p>プライベートルームやレストランホールにて、お食事のお時間をお過ごしください。本日のプレーを振り返りながら、和やかな語らいのひとときをお楽しみいただけます。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_17.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b17"><span></span></span>
                            </li>
                            <li class="pflow__arrow_box _11">
                                <div class="pflow__tex">
                                    <h3><span class="cno">⑪</span>お見送り&bull;ご帰宅</h3>
                                    <p>最後にお土産をお渡しし、ゲストの皆様をお見送りします。<br>&#8251;お土産を事前にお送りいただく場合は、当日午前中必着にてお送りください。スタッフにて開封し、お渡しの準備をいたします。</p>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_08.jpg" alt="ダミー">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/reservation/img_ball_18.png" alt="bo-ru" class="ball">
                                <span class="deco _deb _b18"><span></span></span>
                            </li>
                        </ul>
                        <p class="rnotice">
                            &#8251;ハーフ終了後、茶屋にて15分の小休憩（稲荷寿司、サンドウィッチ等の軽食あり）<br>ランチ&middot;懇親会を90分とした場合のスケジュールになります。</p>
                    </div>
                </div>
            </section>

            <div class="c-column">
                <ul class="c-brd">
                    <li><a href="<?php echo esc_url(home_url('')); ?>/">TOP</a></li>
                    <li><a href="">ご予約方法について</a></li>
                </ul>
            </div>

        </main>

        <!--  フッタ読込 -->
        <?php get_footer('120'); ?>
        <!--  フッタ読込 -->

        <?php wp_footer(); ?>

        </body>

        </html>