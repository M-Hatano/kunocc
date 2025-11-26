<?php

// WordPressの管理画面ログインURLを変更する
define('LOGIN_CHANGE_PAGE', 'knc-120.php');

// 指定以外のログインURLはTOPページへリダイレクト
if (! function_exists('login_change_init')) {
    function login_change_init()
    {
        if (!defined('LOGIN_CHANGE') || sha1('LZrxkvK4mwFG') != LOGIN_CHANGE) {
            wp_safe_redirect(home_url());
            exit;
        }
    }
}
add_action('login_init', 'login_change_init');

// ログイン済みか新設のログインURLの場合はwp-login.phpを置き換える
if (! function_exists('login_change_site_url')) {
    function login_change_site_url($url, $path, $orig_scheme, $blog_id)
    {
        if (
            $path == 'wp-login.php' &&
            (is_user_logged_in() || strpos($_SERVER['REQUEST_URI'], LOGIN_CHANGE_PAGE) !== false)
        )
            $url = str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $url);
        return $url;
    }
}
add_filter('site_url', 'login_change_site_url', 10, 4);

// ログアウト時のリダイレクト先の設定
if (! function_exists('login_change_wp_redirect')) {
    function login_change_wp_redirect($location, $status)
    {
        if (strpos($_SERVER['REQUEST_URI'], LOGIN_CHANGE_PAGE) !== false)
            $location = str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $location);
        return $location;
    }
}
add_filter('wp_redirect', 'login_change_wp_redirect', 10, 2);

// ログアウトURLの置き換え
add_filter('logout_url', function ($logout_url, $redir) {
    return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $logout_url);
}, 10, 2);


//ログインURL隠し
add_filter('author_rewrite_rules', '__return_empty_array');
function disable_author_archive()
{
    if ($_GET['author'] || preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url('/404.php'));
        exit;
    }
}
add_action('init', 'disable_author_archive');


// 動的にメタタグのdescriptionを取得する関数
function get_dynamic_meta_description()
{
    $meta_descriptions = [
        'club' => '久能カントリー倶楽部 公式サイト 倶楽部紹介ページです。倶楽部についての詳細を記載しております。',
        'news' => '久能カントリー倶楽部 公式サイト ニュース一覧ページです。ニュース一覧を掲載しております。',
        'course' => '久能カントリー倶楽部 公式サイト コース案内ページです。コースの詳細について掲載しております。',
        'facility' => '久能カントリー倶楽部 公式サイト 施設案内ページです。施設の詳細について掲載しております。',
        'guide' => '久能カントリー倶楽部 公式サイト ご利用案内ページです。料金情報、予約受付日、レンタルクラブ、お取り扱いカードについて掲載しております。',
        'restaurant' => '久能カントリー倶楽部 公式サイト レストランページです。レストランメニューについて掲載しております。',
        'access' => '久能カントリー倶楽部 公式サイト アクセス情報ページです。アクセス情報について掲載しております。',
        'privacypolicy' => '久能カントリー倶楽部 公式サイト プライバシーポリシーページです。プライバシーポリシーについて掲載しております。',
        'contact'     => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/confirm'  => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/complete' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'dresscode' => '久能カントリー倶楽部 公式サイト ドレスコードページです。ドレスコードについて掲載しております。',
        'solo-reserve' => '久能カントリー倶楽部 公式サイト 一人予約はこちらから。',
    ];

    // 現在のURLパスを取得
    $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // フロントページの場合
    if (is_front_page() || $current_path === '') {
        return '久能カントリー倶楽部のトップページです。';
    }

    // single.php（ニュース詳細ページ）の場合
    if (is_single()) {
        return '久能カントリー倶楽部 公式サイト ニュース詳細ページです。各ニュース記事を掲載しております。';
    }

    // 配列にあるURLに一致する場合はその説明文を返す
    return $meta_descriptions[$current_path] ?? '久能カントリー倶楽部 公式サイト';
}

/**
 * カテゴリーによって single テンプレートを切り替え
 */
add_filter('single_template', function ($template) {

    // 投稿が member（会員ニュース）カテゴリーなら専用テンプレートを使用
    if (has_category('member')) {
        $member_template = locate_template('single-member.php');
        if ($member_template) {
            return $member_template;
        }
    }

    // それ以外は通常の single.php を使う
    return $template;
});


// bodyIDを取得する関数
function my_custom_body_id()
{
    // ★ /kunocc/cms/ を除去
    $uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $uri = preg_replace('#^[^/]+/[^/]+/#', '', $uri);

    /* ---------------------------------------------------
     * ▼ 会員ニュース（一覧 / 年別 / ページ2 / single）
     *    カテゴリ: member / kusunoki / information
     * --------------------------------------------------- */
    if (
        // 投稿 single
        (is_single() && (has_category('member') || has_category('kusunoki') || has_category('information')))

        // category archive（年別含む）
        || is_category(array('member','kusunoki','information'))

        // 固定ページ /member/, /member/kusunoki/, /member/information/
        || is_page(array('member','kusunoki','information'))
    ) {
        return 'm-news';
    }

    /* ---------------------------------------------------
     * ▼ 一般ニュース（single, 年別）
     * --------------------------------------------------- */
    if (is_single() && has_category('news')) {
        return 'single-page';
    }

    if (is_date()) {
        return 'single-page';
    }

    /* ---------------------------------------------------
     * ▼ その他ページ
     * --------------------------------------------------- */
    if (is_front_page()) return 'top';
    if (is_404()) return 'errorpage';

    if (is_page()) {
        global $post;
        return get_post_field('post_name', $post);
    }

    return '';
}

// body_classにカスタムクラス（ルート親のスラッグ）を追加する関数
function my_custom_body_class()
{
    /* -----------------------------------------
     * 会員ページ（一覧 / 年別 / single / 固定ページ）
     * ----------------------------------------- */
    if (
        is_category(array('member','kusunoki','information')) ||
        (is_single() && (has_category('member') || has_category('kusunoki') || has_category('information'))) ||
        is_page(array('member','kusunoki','information'))
    ) {
        return 'm-news';
    }

    /* -----------------------------------------
     * 一般ニュース
     * ----------------------------------------- */
    if (is_single() && has_category('news')) {
        return 'news';
    }

    if (is_date()) {
        return 'news';
    }

    /* -----------------------------------------
     * 固定ページ
     * ----------------------------------------- */
    if (is_page()) {
        global $post;
        $slug = get_post_field('post_name', $post);
        $anc  = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $top  = end($anc);
            $slug = get_post_field('post_name', $top);
        }
        return $slug;
    }

    if (is_404()) return 'errorpage';
    if (is_front_page()) return 'top';

    /* その他は news 扱い（予備） */
    return 'news';
}

// body_class フィルターでカスタムクラスを追加
function my_custom_body_classes($classes)
{
    $body_class = my_custom_body_class();
    if ($body_class) {
        $classes[] = $body_class;
    }
    return $classes;
}
add_filter('body_class', 'my_custom_body_classes');


// ページごとのCSSを読み込む関数
function enqueue_page_specific_styles()
{
    $dir = get_template_directory_uri();

    /* -----------------------------------
     * ▼ 共通CSS（全ページ）
     * ----------------------------------- */
    wp_enqueue_style(
        'common-style',
        $dir . '/css/common.css',
        [],
        null
    );

    /* -----------------------------------
     * ▼ 会員ニュース（member / information / kusunoki）
     *    ・固定ページ
     *    ・single（投稿）
     *    ・カテゴリ一覧（年別含む）
     *    → 必ず m-news.css を読み込む
     * ----------------------------------- */
    if (
        // カテゴリー（年別も含む）
        is_category(array('member', 'kusunoki', 'information'))

        // SINGLE（投稿）
        || (is_single() && (
                has_category('member') ||
                has_category('kusunoki') ||
                has_category('information')
            ))

        // 固定ページ
        || is_page(array('member', 'kusunoki', 'information'))
    ) {

        wp_enqueue_style(
            'm-news-style',
            $dir . '/css/m-news.css',
            [],
            null
        );

        return; // 他のCSSはここで停止
    }

    /* -----------------------------------
     * ▼ 一般ニュース（news カテゴリ）
     * ----------------------------------- */
    if (is_single() && has_category('news')) {
        wp_enqueue_style('news-style', $dir . '/css/news.css', [], null);
        return;
    }

    // 通常 WordPress の年別アーカイブ（/2025/）
    if (is_date() && !is_category()) {
        wp_enqueue_style('news-style', $dir . '/css/news.css', [], null);
        return;
    }

    /* -----------------------------------
     * ▼ 固定ページの個別CSS（従来）
     * ----------------------------------- */
    if (is_page()) {
        global $post;
        $slug = $post->post_name;

        // 親ページがある場合は親スラッグに揃える
        $anc  = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $top  = end($anc);
            $slug = get_post_field('post_name', $top);
        }

        $css_path = get_template_directory() . '/css/' . $slug . '.css';
        if (file_exists($css_path)) {
            wp_enqueue_style(
                $slug . '-style',
                $dir . '/css/' . $slug . '.css',
                [],
                null
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_page_specific_styles');




// スクリプトタグから id 属性を削除するフィルター
function remove_script_id_attribute($tag, $handle, $src)
{
    // id 属性を削除したスクリプトタグを返す
    return '<script type="text/javascript" src="' . esc_url($src) . '"></script>';
}
add_filter('script_loader_tag', 'remove_script_id_attribute', 10, 3);

// ページごとのJSを読み込む関数
function enqueue_page_specific_scripts()
{
    $dir = get_template_directory_uri(); // テーマディレクトリのURIを取得
    $dir_path = get_template_directory(); // テーマディレクトリのパスを取得

    // common.js を全てのページで読み込む
    wp_enqueue_script(
        'common-js',
        $dir . '/js/common.js',
        array(),
        null,
        true // フッターで読み込み
    );

    //  カレンダー専用テンプレートの場合のみ calendar.js / holidays.js を読み込む
    if (is_page('m-calendar')) {
        wp_enqueue_script('holidays-js', $dir . '/js/holidays.js', array(), null, true);
        wp_enqueue_script('calendar-js', $dir . '/js/calendar.js', array('holidays-js'), null, true);
    }

    // フロントページの場合
    if (is_front_page()) {
        // top.js を読み込む
        $js_file_uri = $dir . '/js/top.js';
        $js_file_path = $dir_path . '/js/top.js';

        if (file_exists($js_file_path)) {
            wp_enqueue_script('top-js', $js_file_uri, array(), null, true);
        }
    }
    // 投稿ページの場合
    elseif (is_single()) {
        // news.js を読み込む
        $js_file_uri = $dir . '/js/news.js';
        $js_file_path = $dir_path . '/js/news.js';

        if (file_exists($js_file_path)) {
            wp_enqueue_script('news-js', $js_file_uri, array(), null, true);
        }
    }
    // 固定ページの場合
    elseif (is_page()) {
        global $post;

        // 自身のスラッグを取得
        $slug = $post->post_name;

        // 親ページがある場合は親ページのスラッグを取得
        $parent_id = wp_get_post_parent_id($post->ID);
        if ($parent_id) {
            $slug = get_post_field('post_name', $parent_id);
        }

        // スラッグが 'course' の場合に Slick を読み込む
        if ($slug === 'course') {
            // SlickのCSS
            wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
            wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');

            // SlickのJavaScript
            wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);

            // Slickの初期化スクリプトをインラインで挿入
            add_action('wp_footer', function () {
                echo "<script>
                    jQuery(document).ready(function($) {
                        $('.csbox__img').slick({
                            dots: true,
                            arrows: false, // 矢印を非表示
                            infinite: true,
                            speed: 300,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            draggable: true, // ドラッグを有効にする
                            autoplay: false // オートプレイをオフにする
                        });
                    });
                </script>";
            });
        }

        // JavaScriptファイルのパスを生成
        $js_filename = $slug . '.js';
        $js_file_uri = $dir . '/js/' . $js_filename;
        $js_file_path = $dir_path . '/js/' . $js_filename;

        // JavaScriptファイルが存在する場合にのみ読み込む
        if (file_exists($js_file_path)) {
            wp_enqueue_script($slug . '-js', $js_file_uri, array(), null, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_page_specific_scripts');

// ＝＝＝＝不要＝＝＝＝
// かわら版用のショートコード
function my_upload_uri_shortcode()
{
    $u = wp_get_upload_dir();
    return esc_url($u['baseurl']);
}
add_shortcode('upload_uri', 'my_upload_uri_shortcode');
// ＝＝＝＝不要＝＝＝＝


// ACF オプションページ「ご予約方法」追加
if ( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'  => 'ご予約方法について',   // ページタイトル
        'menu_title'  => 'ご予約方法',           // 管理メニューの表示名
        'menu_slug'   => 'reservation_settings', // スラッグ（ACF JSONと一致）
        'capability'  => 'edit_posts',           // 権限
        'redirect'    => false                   // サブページに飛ばさない
    ));

}

add_filter('query_vars', function($vars){
    $vars[] = 'year';
    return $vars;
});

// ニュースページネーション（NEWS / MEMBER 自動判定：query 内容を優先）
function custom_pagination($query = null)
{
    // 対象クエリ決定
    if ($query instanceof WP_Query) {
        $target_query = $query;
    } else {
        global $wp_query;
        $target_query = $wp_query;
    }

    $total_pages  = (int) $target_query->max_num_pages;
    $current_page = max(1, (int) get_query_var('paged'));

    if ($total_pages <= 1) return;

    /* -----------------------------
    * NEWS / MEMBER / INFORMATION 判定
    * -----------------------------*/
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $mode = 'news';

    if (preg_match('#/member/information(/|$)#', $uri)) {
        $mode = 'information';
    }
    elseif (preg_match('#/member/kusunoki(/|$)#', $uri)) {
        $mode = 'kusunoki';
    }
    elseif (preg_match('#/member(/|$)#', $uri)) {
        $mode = 'member';
    }

    /* -----------------------------
     * 絞り込み変数
     * -----------------------------*/
    $subcat = get_query_var('subcat');
    $year   = get_query_var('year');

    if ($mode === 'information') $subcat = 'information';
    if ($mode === 'kusunoki')    $subcat = 'kusunoki';

    /* -----------------------------
     * ベースURL生成（リライトルールなし版）
     * -----------------------------*/

    if ($mode === 'news') {

        // NEWS 一覧
        if (!$year) {
            // /news/
            $base_link = home_url("/news/");
        } else {
            // 年別アーカイブ → /2025/
            $base_link = home_url("/{$year}/");
        }

    } else {

        // MEMBER / INFORMATION / KUSUNOKI
        if ($subcat && $year) {
            $base_link = home_url("/member/{$subcat}/{$year}/");
        } elseif ($subcat) {
            $base_link = home_url("/member/{$subcat}/");
        } elseif ($year) {
            $base_link = home_url("/member/{$year}/");
        } else {
            $base_link = home_url("/member/");
        }
    }

    $base_link = trailingslashit($base_link);

    /* -----------------------------
     * ページ番号出力
     * -----------------------------*/
    $range = 1;
    $start = max(1, $current_page - $range);
    $end   = min($total_pages, $current_page + $range);

    // 最初 / 前
    if ($current_page > 1) {
        echo '<li class="c-pagenation__first"><a href="' . esc_url($base_link) . '">最初</a></li>';
        echo '<li class="c-pagenation__before"><a href="' . esc_url("{$base_link}page/" . ($current_page - 1) . "/") . '">←</a></li>';
    }

    // 数字
    for ($i = $start; $i <= $end; $i++) {
        $class = ($i === $current_page) ? ' class="is-current"' : '';
        echo "<li{$class}><a href='" . esc_url("{$base_link}page/{$i}/") . "'>{$i}</a></li>";
    }

    // 次 / 最後
    if ($current_page < $total_pages) {
        echo '<li class="c-pagenation__after"><a href="' . esc_url("{$base_link}page/" . ($current_page + 1) . "/") . '">→</a></li>';
        echo '<li class="c-pagenation__last"><a href="' . esc_url("{$base_link}page/{$total_pages}/") . '">最後</a></li>';
    }
}


// コースサブナビ
function course_navigation() {
    // 現在のホール番号を取得
    $nownum = intval(get_field('hole-no'));
    if (!$nownum) return;

    // 全18ホール仕様
    $max_hole = 18;

    // 前後ホール番号を計算
    $prev_num = ($nownum > 1) ? $nownum - 1 : $max_hole;
    $next_num = ($nownum < $max_hole) ? $nownum + 1 : 1;

    // URLを生成
    $prev_url     = home_url("/course/hole{$prev_num}/");
    $next_url     = home_url("/course/hole{$next_num}/");
    $overview_url = home_url("/course/");

    // URL出力
    echo '<a href="' . esc_url($prev_url) . '" class="b-c-dtl__btn pre">Preview</a>';
    echo '<a href="' . esc_url($overview_url) . '" class="b-c-dtl__btm--top">コース全景へ</a>';
    echo '<a href="' . esc_url($next_url) . '" class="b-c-dtl__btn nxt">Next</a>';
}


/* 画質を 70 % に統一*/
add_filter('wp_editor_set_quality', fn() => 70);
add_filter('jpeg_quality',          fn() => 70);   //旧WP互換5.8以下

// /* 横幅 1000pxに上書きリサイズ”*/
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'wp_handle_upload', function ( $fileinfo ) {

	// 画像imageファイル以外はそのまま処理する
	if ( strpos( $fileinfo['type'], 'image/' ) !== 0 ) {
		return $fileinfo;
	}

    // 画像リサイズにエラーが出た場合は元画像をそのまま処理する
	$path   = $fileinfo['file'];
	$editor = wp_get_image_editor( $path );
	if ( is_wp_error( $editor ) ) {
		return $fileinfo;                    
	}

    // 幅1000以上ならリサイズ、以下ならそのまま処理
	$size = $editor->get_size();
	if ( $size['width'] <= 1000 ) {
		return $fileinfo;                    
	}

	/* 縮小してリサイズ、同じファイル名で上書き保存 */
	$editor->resize( 1000, null, false );   // 横は1000　高さは指定なし
	$editor->set_quality( 70 );             // 画像サイズ再指定
	$editor->save( $path );                 // ファイル名はそのままになるように上書き保存

	return $fileinfo;
}, 20 );

/*  中間サイズの自動トリミングを完全停止 */
add_filter('intermediate_image_sizes_advanced', '__return_empty_array');

/* 生成されたサイズ情報も空にする */
add_filter('wp_generate_attachment_metadata', function ($meta) {
    $meta['sizes'] = [];
    return $meta;
}, 20);


/**
 * 「メディアを追加」で挿入される <img> タグから
 * width / height / class など不要な属性を取り除く
 * 例）<img src="..." alt=""> だけにする
 */
function cg_strip_img_attributes($html, $id, $caption, $title, $align, $url, $size, $alt)
{
    // width / height を削除
    $html = preg_replace('/\s*(width|height)="\d*"\s*/i', '', $html);
    // class を削除（alignnone size-medium wp-image-XXXX など）
    $html = preg_replace('/\s*class="[^"]*"\s*/i', '', $html);
    // 連続した空白を整理
    $html = preg_replace('/\s+/', ' ', $html);
    return trim($html);
}
add_filter('image_send_to_editor', 'cg_strip_img_attributes', 10, 8);



// <img> タグに loading="lazy" 等を追加（post_type が 'post' の場合のみ）
function add_lazy_attributes_to_images($content_or_value, $post_id = null, $field = null)
{
    // 投稿タイプが 'post' の場合のみ適用
    $target_post_type = 'post';

    // 投稿IDから投稿タイプを取得
    if ($post_id && get_post_type($post_id) !== $target_post_type) {
        return $content_or_value;
    }

    // the_content() フィルターでは $post_id は null なので get_post_type() を直接使用
    if (is_null($post_id) && get_post_type() !== $target_post_type) {
        return $content_or_value;
    }

    // loading属性が未指定の <img> タグに属性を追加
    $content_or_value = preg_replace_callback(
        '/<img(?![^>]+loading=)([^>]+)>/',
        function ($matches) {
            return '<img loading="lazy" decoding="async"' . $matches[1] . '>';
        },
        $content_or_value
    );

    return $content_or_value;
}

// 投稿本文（the_content）に適用
add_filter('the_content', 'add_lazy_attributes_to_images');

// ACFのWYSIWYGフィールドにも適用（全フィールドに対応する場合）
add_filter('acf/format_value/type=wysiwyg', 'add_lazy_attributes_to_images', 10, 3);


//画像トリミングサイズ
//アップロード以降にあげた画像から適用、以前は適用されないので注意
if (function_exists('add_theme_support')) {
    add_image_size('defaultsize', '', '', true); // デフォルト
}


/**
 * 管理画面：カテゴリー選択メタボックスの
 * ・インデントを復活
 * ・子カテゴリチェック時に親カテゴリも自動チェック
 * ・子カテゴリが残っているときは親のチェック解除をキャンセル
 */
function fhg_admin_category_meta_fix()
{
    $screen = get_current_screen();
    // 投稿編集画面のみ
    if ($screen->base === 'post') {
        // CSS：インデントを確保
        echo '<style>
                /* 子カテゴリのリストにマージンを戻す */
                #categorychecklist .children {
                    margin-left: 20px !important;
                }
            </style>';

        // JS：チェック時に親も、解除時に子が残っていればキャンセル
        echo '<script>
            jQuery(function($){
                $("#categorydiv").on("change", "input[type=checkbox]", function(){
                    var $li = $(this).closest("li");
                    if ( this.checked ) {
                        // チェック時：全ての親 li > label > input をチェック
                        $li.parents("li").find("> label > input[type=checkbox]").prop("checked", true);
                    } else {
                        // 解除時：自分の下にチェック済みの子があれば解除を取り消す
                        if ( $li.find("input[type=checkbox]:checked").length ) {
                            $(this).prop("checked", true);
                        }
                    }
                });
            });
            </script>';
    }
}
add_action('admin_head',   'fhg_admin_category_meta_fix');
add_action('admin_footer', 'fhg_admin_category_meta_fix');


/**
 * 投稿画面のカテゴリー選択で
 * 選択済み項目を先頭に移動させない
 */
add_filter('wp_terms_checklist_args', function ($args, $post_id) {
    // 「category」タクソノミーのみ適用
    if (isset($args['taxonomy']) && $args['taxonomy'] === 'category') {
        $args['checked_ontop'] = false;
    }
    return $args;
}, 10, 2);

/**
 * 全投稿（post_type = post）の公開年度を降順で取得
 *
 * @return int[] 年度の配列（例: [2025,2024,2023…]）
 */
function fhg_get_all_years()
{
    global $wpdb;
    $years = $wpdb->get_col(
        "SELECT DISTINCT YEAR(post_date) AS y
            FROM {$wpdb->posts}
            WHERE post_type = 'post'
                AND post_status = 'publish'
            ORDER BY y DESC"
    );
    return array_map('intval', $years);
}


/**
 * カテゴリ slug=news に属する全投稿の公開年度を降順で取得
 *
 * @return int[] 年度の配列（例: [2025,2024,2023…]）
 */
function fhg_get_news_years()
{
    global $wpdb;

    // news カテゴリの term_id を取得
    $news_term_id = $wpdb->get_var("
        SELECT term_id FROM {$wpdb->terms}
        WHERE slug = 'news'
        LIMIT 1
    ");
    if (! $news_term_id) {
        return [];
    }

    // 投稿とタクソノミーを結合して年度を取得
    $years = $wpdb->get_col("
        SELECT DISTINCT YEAR(p.post_date) AS y
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
        INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        WHERE p.post_type = 'post'
          AND p.post_status = 'publish'
          AND tt.taxonomy = 'category'
          AND tt.term_id = {$news_term_id}
        ORDER BY y DESC
    ");

    return array_map('intval', $years);
}



// 検索結果から特定カテゴリ・特定固定ページを除外
function fhg_exclude_from_search($query)
{
    if (! is_admin() && $query->is_main_query() && $query->is_search()) {

        // ① 除外したいカテゴリスラッグ → term_id に変換
        $exclude_slugs = array('news', 'mevent', 'mnews', 'mcompe', 'mmanage');
        $exclude_term_ids = array();
        foreach ($exclude_slugs as $slug) {
            if ($term = get_category_by_slug($slug)) {
                $exclude_term_ids[] = $term->term_id;
            }
        }
        if (! empty($exclude_term_ids)) {
            $query->set('category__not_in', $exclude_term_ids);  // カテゴリ除外
        }

        // ② 除外したい固定ページのID（かわら版一覧ページなど）
        $exclude_page_id = 6429;
        $post__not_in = (array) $query->get('post__not_in');
        $post__not_in[] = $exclude_page_id;
        $query->set('post__not_in', $post__not_in);            // 固定ページ除外
    }
}
add_action('pre_get_posts', 'fhg_exclude_from_search');


// ─────────────────────────────────────────────────
// 特定カテゴリ・特定固定ページを noindex にする
// ─────────────────────────────────────────────────
function fhg_add_noindex_meta()
{
    // 投稿ページで、指定のカテゴリスラッグを持つものを noindex
    if (is_singular('post')) {
        $exclude = array('news', 'mevent', 'mnews', 'mcompe', 'mmanage');
        $cats    = wp_get_post_categories(get_the_ID(), ['fields' => 'slugs']);
        if (array_intersect($cats, $exclude)) {
            echo '<meta name="robots" content="noindex,follow">' . "\n";
            return;
        }
    }
    // 固定ページ ID=6429（かわら版一覧）を noindex
    if (is_page(6429)) {
        echo '<meta name="robots" content="noindex,follow">' . "\n";
    }
}
add_action('wp_head', 'fhg_add_noindex_meta', 1);

// --- ACF 画像サイズ切り替え: field_group_key が 3 の投稿は幅上限 2600px を適用
add_action('after_setup_theme', function () {
    add_image_size('custom_2600', 2600, 9999, false);
});

// ACF 画像サイズ切り替えフィルター（トップページ用3枚の画像）
add_filter('acf/format_value/key=field_678f48c48831d', 'my_acf_image_size_override', 10, 3); // top_image_1
add_filter('acf/format_value/key=field_678f48ff8831e', 'my_acf_image_size_override', 10, 3); // top_image_2
add_filter('acf/format_value/key=field_678f49128831f', 'my_acf_image_size_override', 10, 3); // top_image_3
function my_acf_image_size_override($value, $post_id, $field)
{

    // ACF メタ 'display_group'（投稿編集画面で使っているグループ識別用フィールド）を取得
    $group = get_field('display_group', $post_id);

    // 「3」に一致する投稿だけカスタムサイズに切り替え
    if (intval($group) === 3) {
        // — Array 返却なら img タグごと —
        if (is_array($value) && isset($value['ID'])) {
            return wp_get_attachment_image($value['ID'], 'custom_2600');
        }
        // — ID 返却なら img タグごと —
        if (is_numeric($value)) {
            return wp_get_attachment_image((int)$value, 'custom_2600');
        }
        // — URL 返却なら URL をカスタムサイズの URL に置き換え —
        if (is_string($value)) {
            return wp_get_attachment_image_url(attachment_url_to_postid($value), 'custom_2600');
        }
    }
    return $value;
}
