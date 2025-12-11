<?php

/* ---------------------------------------------------------
 * 管理ログイン専用：wp-login.php を knc-120.php に変更
 * 会員ログインには一切干渉しない安全版
 * --------------------------------------------------------- */

// 管理ログインURL
define('LOGIN_CHANGE_PAGE', 'knc-120.php');

// wp-login.php に直接アクセス → ブロック（管理ログイン以外）
add_action('login_init', function() {

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // 会員ログイン画面（独自フォーム）はブロックしない
    if (strpos($request_uri, '/member-login') !== false) {
        return;
    }

    // knc-120.php 経由は許可
    if (strpos($request_uri, LOGIN_CHANGE_PAGE) !== false) {
        return;
    }

    // wp-login.php に直接来たらトップへ
    if (strpos($request_uri, 'wp-login.php') !== false) {
        wp_safe_redirect(home_url());
        exit;
    }
});

/* ---------------------------------------------------------
 * wp-login.php → knc-120.php 置換（管理ログインだけ）
 * 会員ログインフォームの action では絶対に発動しない
 * --------------------------------------------------------- */
add_filter('site_url', function ($url, $path, $orig_scheme, $blog_id) {

    // wp-login.php 以外は無視
    if ($path !== 'wp-login.php') {
        return $url;
    }

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // 会員ログインフォームは置換しない（最重要）
    if (strpos($request_uri, '/member-login') !== false) {
        return $url;
    }

    // 管理ログインだけ置換
    return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $url);

}, 10, 4);

/* ---------------------------------------------------------
 * ログアウトURLの置換（管理ログインのみ）
 * --------------------------------------------------------- */
add_filter('wp_redirect', function ($location, $status) {

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // 会員ログイン関係は置換しない
    if (strpos($request_uri, '/member-login') !== false) {
        return $location;
    }

    return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $location);

}, 10, 2);

// ログアウトURL置換
add_filter('logout_url', function ($logout_url, $redir) {
    return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $logout_url);
}, 10, 2);


/* ---------------------------------------------------------
 * 著者ページのブロック（そのまま残す）
 * --------------------------------------------------------- */
add_filter('author_rewrite_rules', '__return_empty_array');
function disable_author_archive() {
    if (isset($_GET['author']) || preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url('/404.php'));
        exit;
    }
}
add_action('init', 'disable_author_archive');



/**
 * 会員ログイン処理（wp_signon）
 * ※ login-template 内では処理しない
 */
add_action('init', function() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    if (!isset($_POST['member_login'])) return;

    $creds = [
        'user_login'    => sanitize_text_field($_POST['log']),
        'user_password' => $_POST['pwd'],
        'remember'      => true,
    ];

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        wp_redirect(home_url('/member-login/?login=failed'));
        exit;
    }

    $redirect = !empty($_POST['redirect_to'])
        ? esc_url_raw($_POST['redirect_to'])
        : home_url('/member/');

    wp_redirect($redirect);
    exit;
});

// 動的にメタタグのdescriptionを取得する関数
function get_dynamic_meta_description(){

    $meta_descriptions = [
        'reservation' => '久能カントリー倶楽部 公式サイト ご予約方法についてページです。ご予約方法について掲載しております。',
        'hospitality' => '久能カントリー倶楽部 公式サイト ご利用日当日の流れページです。ご利用日当日の流れについて掲載しております。',
        'restaurant' => '久能カントリー倶楽部 公式サイト レストランページです。レストランメニューについて掲載しております。',
        'facility' => '久能カントリー倶楽部 公式サイト 施設案内ページです。施設の詳細について掲載しております。',
        'news' => '久能カントリー倶楽部 公式サイト ニュース一覧ページです。ニュース一覧を掲載しております。',
        'member' => '久能カントリー倶楽部 公式サイト 会員様お知らせページです。会員様お知らせについて掲載しております。',
        'information' => '久能カントリー倶楽部 公式サイト 営業案内ページです。営業案内について掲載しております。',
        'kusunoki' => '久能カントリー倶楽部 公式サイト くすのき会ページです。くすのき会について掲載しております。',
        'access' => '久能カントリー倶楽部 公式サイト アクセス情報ページです。アクセス情報について掲載しております。',
        'd-range' => '久能カントリー倶楽部 公式サイト ゴルフ練習場のご案内ページです。ゴルフ練習場のご案内について掲載しております。',
        'club' => '久能カントリー倶楽部 公式サイト 倶楽部紹介ページです。倶楽部についての詳細を記載しております。',
        'course' => '久能カントリー倶楽部 公式サイト コース案内ページです。コースの詳細について掲載しております。',
        'recruit' => '久能カントリー倶楽部 公式サイト 求人情報ページです。求人情報について掲載しております。',
        'dresscode' => '久能カントリー倶楽部 公式サイト ドレスコードページです。ドレスコードについて掲載しております。',
        'sitepolicy' => '久能カントリー倶楽部 公式サイト サイトポリシーページです。サイトポリシーについて掲載しております。',
        'privacypolicy' => '久能カントリー倶楽部 公式サイト プライバシーポリシーページです。プライバシーポリシーについて掲載しております。',
        'links' => '久能カントリー倶楽部 公式サイト リンク集ページです。リンク集について掲載しております。',
        'sitemap' => '久能カントリー倶楽部 公式サイト サイトマップページです。サイトマップについて掲載しております.',
        'contact'     => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/confirm'  => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/complete' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'partnership' => '久能カントリー倶楽部 公式サイト 会員提携コースのご案内ページです。会員提携コースのご案内について掲載しております。',
        'm-calendar' => '久能カントリー倶楽部 公式サイト 会員ビジター様料金カレンダーページです。会員ビジター様料金カレンダーについて掲載しております。',
        'registration' => '久能カントリー倶楽部 公式サイト 会員コンペ申し込みページです。会員コンペ申し込みについて掲載しております。',
    ];

    // 現在のパスを取得
    $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // ★ kunocc/cms を除去（最重要）
    $current_path = preg_replace('#^[^/]+/[^/]+/#', '', $current_path);


    /* ----------------------------------------------------
     * ▼ フロントページ
     * ---------------------------------------------------- */
    if (is_front_page() || $current_path === '') {
        return '久能カントリー倶楽部のトップページです。';
    }


    /* ----------------------------------------------------
     * ▼ single-member.php（会員ニュース 詳細ページ）
     * ---------------------------------------------------- */
    if (is_singular('member-news')) { // ←必要なら投稿タイプ名合わせます
        return '久能カントリー倶楽部 公式サイト ニュース詳細ページです。各ニュース記事を掲載しております.';
    }

    // カテゴリ分類で会員ニュース詳細を判定する場合はこちら
    if (is_single() && has_category(['member', 'kusunoki', 'information'])) {
        return '久能カントリー倶楽部 公式サイト ニュース詳細ページです。各ニュース記事を掲載しております.';
    }


    /* ----------------------------------------------------
     * ▼ date.php（ニュース年別ページ）
     * ---------------------------------------------------- */
    if (is_date() && strpos($current_path, 'news') === 0) {
        return '久能カントリー倶楽部 公式サイト ニュース年別ページです。各年ごとの記事を掲載しております。';
    }


    // 会員ニュース年別ページ
    if (is_post_type_archive('member_post') || (is_date() && strpos($current_path, 'member') === 0)) {
        return '久能カントリー倶楽部 公式サイト 会員お知らせ年別ページです。各年ごとの記事を掲載しております。';
    }


    /* ----------------------------------------------------
     * ▼ 通常 single.php（ニュース詳細ページ）
     * ---------------------------------------------------- */
    if (is_single()) {
        return '久能カントリー倶楽部 公式サイト ニュース詳細ページです。各ニュース記事を掲載しております。';
    }


    /* ----------------------------------------------------
     * ▼ 固定ページ（URLスラッグで配列判定）
     * ---------------------------------------------------- */
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
    // /kunocc/cms/ を除去
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uri = preg_replace('#^[^/]+/[^/]+/#', '', $uri);

    /* -------------------------------
     * /member/（会員トップ）
     * ------------------------------- */
    if ($uri === 'member' || $uri === 'member/') {
        return 'member';
    }

    /* -------------------------------
     * /member/information/
     * ------------------------------- */
    if ($uri === 'member/information' || $uri === 'member/information/') {
        return 'information';
    }

    /* -------------------------------
     * /member/kusunoki/
     * ------------------------------- */
    if ($uri === 'member/kusunoki' || $uri === 'member/kusunoki/') {
        return 'kusunoki';
    }

    /* -------------------------------
     * 個別記事
     * ------------------------------- */
    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}/[0-9]{2}/[^/]+/?$#', $uri)) {
        return 'member-single-page';
    }

    /* -------------------------------
     * 年別
     * ------------------------------- */
    if (preg_match('#^member(?:/(information|kusunoki))?/([0-9]{4})/?$#', $uri)) {
        return 'member-date';
    }

    /* WordPress fallback */
    if (is_singular('member_post')) return 'member-single-page';

    if (is_single() && has_category(['member','kusunoki','information']))
        return 'member-single-page';

    if (is_front_page()) return 'top';
    if (is_404()) return 'errorpage';

    if (is_single()) return 'single-page';

    if (is_page()) {
        global $post;
        return $post->post_name;
    }

    return '';
}




// body_classにカスタムクラス（ルート親のスラッグ）を追加する関数
function my_custom_body_class()
{
    $uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $uri = preg_replace('#^[^/]+/[^/]+/#', '', $uri);

    /* -------------------------------
     * /member/ → class は m-news
     * ------------------------------- */
    if ($uri === 'member' || preg_match('#^member/page/[0-9]+/?$#', $uri)) {
        return 'm-news';
    }

    /* -------------------------------
     * /member/information/
     * ------------------------------- */
    if ($uri === 'member/information' || $uri === 'member/information/') {
        return 'm-news';
    }

    /* -------------------------------
     * /member/kusunoki/
     * ------------------------------- */
    if ($uri === 'member/kusunoki' || $uri === 'member/kusunoki/') {
        return 'm-news';
    }

    /* -------------------------------
     * 個別記事
     * ------------------------------- */
    if (is_singular('member_post')) {
        return 'm-news';
    }

    /* -------------------------------
     * 年別ページ
     * ------------------------------- */
    if (is_date() && strpos($uri, 'member/') === 0) {
        return 'm-news';
    }

    /* 既存処理 */
    if (is_date() && strpos($uri, 'news/') === 0) {
        return 'news';
    }

    if (is_front_page()) return 'top';
    if (is_404()) return 'errorpage';

    if (is_single()) return 'news';

    if (is_page()) {
        global $post;
        $slug = get_post_field('post_name', $post);
        $anc  = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $slug = get_post_field('post_name', end($anc));
        }
        return $slug;
    }

    return '';
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
    $uri = $_SERVER['REQUEST_URI'] ?? '';

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
    *    single / 固定ページ / ページネーション / 年別
    * ----------------------------------- */
    if (

        // single
        (is_single() && (has_category('member') || has_category('kusunoki') || has_category('information')))

        // 固定ページ
        || is_page(array('member', 'kusunoki', 'information', 'partnership', 'm-calendar', 'registration', 'member-login'))

        // 年別
        || (is_date() && strpos($uri, '/member/') !== false)

        // ★ ページネーション
        || preg_match('#/member/information/page/[0-9]+/?$#', $uri)
        || preg_match('#/member/kusunoki/page/[0-9]+/?$#', $uri)
        || preg_match('#/member/page/[0-9]+/?$#', $uri)

        // ★★★ partnership を強制的に適用 ★★★
        || strpos($uri, '/member/partnership') !== false
        || strpos($uri, '/member/calendar') !== false
    ) {

        wp_enqueue_style(
            'm-news-style',
            $dir . '/css/m-news.css',
            [],
            null
        );
        return;
    }

    /* 以下はそのまま */
    if (is_date() && strpos($uri, '/news/') !== false) {
        wp_enqueue_style(
            'news-style',
            $dir . '/css/news.css',
            [],
            null
        );
        return;
    }

    if (is_front_page()) {
        wp_enqueue_style(
            'top-style',
            $dir . '/css/top.css',
            [],
            null
        );
        return;
    }

    if (is_single()) {
        wp_enqueue_style(
            'news-style',
            $dir . '/css/news.css',
            [],
            null
        );
        return;
    }

    if (is_page()) {
        global $post;
        $slug = $post->post_name;
        $anc  = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $top  = end($anc);
            $slug = get_post_field('post_name', $top);
        }

        $css_filename  = $slug . '.css';
        $css_file_uri  = $dir . '/css/' . $css_filename;
        $css_file_path = get_template_directory() . '/css/' . $css_filename;

        if (file_exists($css_file_path)) {
            wp_enqueue_style(
                $slug . '-style',
                $css_file_uri,
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


//ニュースページネーション（NEWS / MEMBER 自動判定：query 内容を優先）
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

    $current_page = (int) $target_query->get('paged');
    if ($current_page < 1) {
        // 念のためグローバルもフォールバック
        $current_page = max(1, (int) get_query_var('paged'));
    }

    if ($total_pages <= 1) return;

    /* -----------------------------
     * ▼ URI を正規化する（必須）
     * -----------------------------*/
    $uri_raw = $_SERVER['REQUEST_URI'] ?? '';
    $uri = parse_url($uri_raw, PHP_URL_PATH);

    // /kunocc/cms/ を除去
    // 例）/kunocc/cms/member/page/2/ → /member/page/2/
    $uri = preg_replace('#^/[^/]+/[^/]+/#', '/', $uri);
    $uri = rtrim($uri, '/');

    /* -----------------------------
     * NEWS / MEMBER / INFORMATION 判定
     * -----------------------------*/
    $mode = 'news';

    // information が最優先
    if (preg_match('#^/member/information(/|$)#', $uri)) {
        $mode = 'information';
    }
    // kusunoki
    elseif (preg_match('#^/member/kusunoki(/|$)#', $uri)) {
        $mode = 'kusunoki';
    }
    // member（最後）
    elseif (preg_match('#^/member(/|$)#', $uri)) {
        $mode = 'member';
    }

    /* -----------------------------
     * 絞り込み変数
     * -----------------------------*/
    $subcat = get_query_var('subcat');
    $year   = get_query_var('year');

    if ($mode === 'information') {
        $subcat = 'information';
    }
    if ($mode === 'kusunoki') {
        $subcat = 'kusunoki';
    }

    /* -----------------------------
     * ベースURL生成
     * -----------------------------*/
    if ($mode === 'news') {

        if ($year) {
            $base_link = home_url("/news/{$year}/");
        } else {
            $base_link = home_url("/news/");
        }

    } else {

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
     * ページ番号範囲
     * -----------------------------*/
    $range = 1;
    $start = max(1, $current_page - $range);
    $end   = min($total_pages, $current_page + $range);

    /* -----------------------------
     * ページネーションHTML生成
     * -----------------------------*/

    // 最初 / 前
    if ($current_page > 1) {
        echo '<li class="c-pagenation__first"><a href="' . esc_url(get_pagenum_link(1)) . '">最初</a></li>';
        echo '<li class="c-pagenation__before"><a href="' . esc_url("{$base_link}page/" . ($current_page - 1) . "/") . '">←</a></li>';
    }

    // 数字リンク
    for ($i = $start; $i <= $end; $i++) {
        $class = ($i === $current_page) ? ' class="is-current"' : '';
        echo "<li{$class}><a href='" . esc_url("{$base_link}page/{$i}/") . "'>{$i}</a></li>";
    }

    // 次 / 最後
    if ($current_page < $total_pages) {
        echo '<li class="c-pagenation__after"><a href="' . esc_url("{$base_link}page/" . ($current_page + 1) . "/") . '">→</a></li>';
        echo '<li class="c-pagenation__last"><a href="' . esc_url(get_pagenum_link($total_pages)) . '">最後</a></li>';
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


/**
 * トップ画像3枚だけは「常に custom_2600 の URL を返す」
 */
add_filter('acf/format_value/key=field_678f48c48831d', 'cg_force_kv_2600', 10, 3);
add_filter('acf/format_value/key=field_678f48ff8831e', 'cg_force_kv_2600', 10, 3);
add_filter('acf/format_value/key=field_678f49128831f', 'cg_force_kv_2600', 10, 3);

function cg_force_kv_2600($value, $post_id, $field) {

    // ACF画像配列 → URL
    if (is_array($value) && isset($value['ID'])) {
        return wp_get_attachment_image_url($value['ID'], 'custom_2600');
    }

    // ID → URL
    if (is_numeric($value)) {
        return wp_get_attachment_image_url((int)$value, 'custom_2600');
    }

    // URL → ID → URL（custom_2600）
    if (is_string($value)) {
        $id = attachment_url_to_postid($value);
        if ($id) {
            return wp_get_attachment_image_url($id, 'custom_2600');
        }
    }

    return $value;
}


/* ======================================================
 * メイン：アップロード後にサイズを決定
 * ====================================================== */
add_filter('wp_generate_attachment_metadata', function( $meta, $attachment_id ) {

    $file = get_attached_file( $attachment_id );
    $type = get_post_mime_type( $attachment_id );

    // 画像以外は処理しない
    if ( strpos($type, 'image/') !== 0 ) {
        return $meta;
    }

    // KV 例外：絶対にリサイズしない
    if ( cg_is_kv_attachment( $attachment_id ) ) {
        return $meta; // ← 完全にオリジナルのまま
    }

    // ▼ 通常画像 → 1000pxに縮小（あなたの処理を維持）
    $editor = wp_get_image_editor( $file );
    if ( is_wp_error( $editor ) ) return $meta;

    $size = $editor->get_size();
    if ( $size['width'] > 1000 ) {

        $editor->resize( 1000, null, false );
        $editor->set_quality(70);
        $editor->save( $file );
    }

    return $meta;

}, 10, 2);

/* ------------------------------------------------------
 * big image 自動縮小を無効化（既存機能維持）
 * ------------------------------------------------------ */
add_filter('big_image_size_threshold', '__return_false');

/* ================================
 * KV 画像だけ custom_2600 を生成
 * ================================ */
add_filter('intermediate_image_sizes_advanced', function($sizes) {

    // 通常はサイズ生成なし
    $allow_sizes = [];

    // ACF からアップロードされた画像を確認
    if (!empty($_REQUEST['acf'])) {

        $acf = $_REQUEST['acf'];
        $kv_fields = [
            'field_678f48c48831d',
            'field_678f48ff8831e',
            'field_678f49128831f',
        ];

        foreach ($kv_fields as $key) {
            if (!empty($acf[$key])) {
                // KV画像 → custom_2600を生成
                return [
                    'custom_2600' => [
                        'width'  => 2600,
                        'height' => 9999,
                        'crop'   => false,
                    ]
                ];
            }
        }
    }

    // それ以外は中間サイズなし
    return [];
}, 10, 1);

add_action( 'after_setup_theme', function() {
    add_image_size( 'custom_2600', 2600, 9999, false );
} );


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
function member_get_all_years()
{
    global $wpdb;

    return $wpdb->get_col("
        SELECT DISTINCT YEAR(post_date)
        FROM {$wpdb->posts}
        WHERE post_type='member_post'
          AND post_status='publish'
        ORDER BY YEAR(post_date) DESC
    ");
}


add_filter('query_vars', function ($vars) {
    $vars[] = 'year';
    $vars[] = 'member_category';
    return $vars;
});




/**
 * カテゴリ別にパーマリンクの表示URLを変更
 */
add_filter('post_type_link', function ($permalink, $post) {

    if ($post->post_type !== 'member_post') return $permalink;

    $year  = get_the_date('Y', $post);
    $month = get_the_date('m', $post);
    $slug  = $post->post_name;

    if (has_term('information', 'member_category', $post)) {
        return home_url("/member/information/{$year}/{$month}/{$slug}/");
    }
    if (has_term('kusunoki', 'member_category', $post)) {
        return home_url("/member/kusunoki/{$year}/{$month}/{$slug}/");
    }

    // デフォルト（member）
    return home_url("/member/{$year}/{$month}/{$slug}/");

}, 10, 2);



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

add_action('init', function () {

    /* -----------------------
     * NEWS 年別アーカイブ（最優先）
     * ----------------------- */

    // /news/2025/
    add_rewrite_rule(
        '^news/([0-9]{4})/?$',
        'index.php?post_type=post&category_name=news&year=$matches[1]',
        'top'
    );

    // /news/2025/page/2/
    add_rewrite_rule(
        '^news/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=post&category_name=news&year=$matches[1]&paged=$matches[2]',
        'top'
    );


    /* -----------------------
     * NEWS 月別＋個別記事
     * ----------------------- */
    add_rewrite_rule(
        '^news/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?name=$matches[3]',
        'top'
    );

    /* -----------------------
     * ① 個別記事（member_post）
     * ----------------------- */
    add_rewrite_rule(
        '^member/information/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?post_type=member_post&name=$matches[3]',
        'top'
    );

    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?post_type=member_post&name=$matches[3]',
        'top'
    );

    add_rewrite_rule(
        '^member/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?post_type=member_post&name=$matches[3]',
        'top'
    );


    /* -----------------------
     * ② 年別（member / kusunoki / information）
     * ----------------------- */
    add_rewrite_rule(
        '^member/information/([0-9]{4})/?$',
        'index.php?post_type=member_post&member_category=information&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/information/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=member_post&member_category=information&year=$matches[1]&paged=$matches[2]',
        'top'
    );


    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/?$',
        'index.php?post_type=member_post&member_category=kusunoki&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=member_post&member_category=kusunoki&year=$matches[1]&paged=$matches[2]',
        'top'
    );


    add_rewrite_rule(
        '^member/([0-9]{4})/?$',
        'index.php?post_type=member_post&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=member_post&year=$matches[1]&paged=$matches[2]',
        'top'
    );
});

/* ---------------------------------------------------------
 * ★★★ 完全修正版 template_include（衝突をすべて除去） ★★★
 * --------------------------------------------------------- */
add_filter('template_include', 'knc_template_router_fixed', 20);
function knc_template_router_fixed($template) {

    /* ---------------------------------------------------------
     * ① URI 正規化
     * --------------------------------------------------------- */
    $uri_raw = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($uri_raw, PHP_URL_PATH);

    // /kunocc/cms/ を除去
    $path = preg_replace('#^/[^/]+/[^/]+/#', '/', $path);
    $path = trim($path, '/');


    /* ---------------------------------------------------------
     * ② 固定ページ（member 直下）
     * --------------------------------------------------------- */
    if ($path === 'member') {
        return locate_template('page-120-member.php');
    }
    if ($path === 'member/information') {
        return locate_template('page-120-information.php');
    }
    if ($path === 'member/kusunoki') {
        return locate_template('page-120-kusunoki.php');
    }
    if ($path === 'member/calendar') {
        return locate_template('page-120-calendar.php');
    }


    /* ---------------------------------------------------------
     * ③ ページネーション（固定ページ扱い）
     * --------------------------------------------------------- */
    if (preg_match('#^member/page/[0-9]+/?$#', $path)) {
        return locate_template('page-120-member.php');
    }
    if (preg_match('#^member/information/page/[0-9]+/?$#', $path)) {
        return locate_template('page-120-information.php');
    }
    if (preg_match('#^member/kusunoki/page/[0-9]+/?$#', $path)) {
        return locate_template('page-120-kusunoki.php');
    }


    /* ---------------------------------------------------------
     * ④ 年別アーカイブ（date-member.php）
     * 
     * 例：
     *   /member/2025/
     *   /member/information/2025/
     *   /member/kusunoki/2025/
     * --------------------------------------------------------- */
    if (preg_match('#^member/[0-9]{4}(/page/[0-9]+)?/?$#', $path)) {
        return locate_template('date-member.php');
    }
    if (preg_match('#^member/(information|kusunoki)/[0-9]{4}(/page/[0-9]+)?/?$#', $path)) {
        return locate_template('date-member.php');
    }


    /* ---------------------------------------------------------
     * ⑤ 個別記事（IMPORTANT!）
     *
     * ★ ここでテンプレートを返さない
     * ★ WP に委譲 → single-member_post.php が自動選択される
     * --------------------------------------------------------- */
    if (is_singular('member_post')) {
        return $template; // WP 標準に任せる
    }

    // 手動の正規表現も入れない（壊れるため）
    // /member/.../slug/ のような URL は rewrite + post_type_link に任せる


    /* ---------------------------------------------------------
     * ⑥ デフォルト
     * --------------------------------------------------------- */
    return $template;
}



add_action('template_redirect', function () {
    if (is_category() || is_archive()) {

        global $wp_query;

        error_log('---- CATEGORY ARCHIVE DEBUG ----');
        error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
        error_log('is_category: ' . (is_category() ? 'YES':'NO'));
        error_log('get_query_var(category_name): ' . get_query_var('category_name'));
        error_log('get_query_var(year): ' . get_query_var('year'));
        error_log('WP_Query posts found: ' . $wp_query->post_count);
        error_log('-------------------------------');
    }
});

/*--------------------------------
 * STEP3：/member/ 以下をログイン必須（環境自動対応版・クエリ保持版）
 --------------------------------*/
 add_action('template_redirect', function () {

    // すでにログイン済みなら何もしない
    if (is_user_logged_in()) return;

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // パスとクエリを分解
    $path  = parse_url($request_uri, PHP_URL_PATH) ?? '';
    $query = $_SERVER['QUERY_STRING'] ?? '';

    // /kunocc2/cms/ など環境パスを除去して正規化
    // 例）/kunocc2/cms/member/member-file/ → /member/member-file/
    $path = preg_replace('#^/[^/]+/[^/]+/#', '/', $path);

    // /member-login/ はログイン画面なので除外
    if (strpos($path, '/member-login') !== false) {
        return;
    }

    // Member 以下すべてログイン必須
    if (strpos($path, '/member/') === 0) {

        // 正規化済みパスから redirect_to を組み立て（クエリも保持）
        $redirect_to = home_url($path);
        if ($query !== '') {
            $redirect_to .= '?' . $query;   // ?id=9110 をつけ直す
        }

        wp_redirect(
            home_url('/member-login/') . '?redirect_to=' . rawurlencode($redirect_to)
        );
        exit;
    }

});


/*--------------------------------
 * 会員向け記事用カスタム投稿タイプ
 --------------------------------*/
 add_action( 'init', 'my_register_member_post_type' );
 function my_register_member_post_type() {
 
     $labels = array(
         'name'          => '会員向け記事',
         'singular_name' => '会員向け記事',
         'add_new'       => '新規追加',
         'add_new_item'  => '会員向け記事を追加',
         'edit_item'     => '会員向け記事を編集',
         'new_item'      => '新しい会員向け記事',
         'view_item'     => '会員向け記事を表示',
         'search_items'  => '会員向け記事を検索',
         'not_found'     => '会員向け記事はありません。',
     );
 
     register_post_type( 'member_post', array(
         'labels'             => $labels,
         'public'             => true,
         'show_ui'            => true,
         'show_in_menu'       => true,
         'menu_position'      => 5,
         'menu_icon'          => 'dashicons-lock',
         'has_archive'        => false,    // 一覧は rewrite ルールで作るため false
         'rewrite'            => false,    // ★ rewrite は自前で管理するため無効
         'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
         'exclude_from_search'=> true,
         'publicly_queryable' => true,
         'show_in_rest'       => true,
     ) );
 }
 
 
 /* ---------------------------------------------------------
  * 公開ボックスに Sticky チェックを追加（UI を投稿に近づけた版）
  * --------------------------------------------------------- */
 add_action('post_submitbox_misc_actions', function () {
     global $post;
     if ($post->post_type !== 'member_post') return;
 
     $is_sticky = get_post_meta($post->ID, '_member_sticky', true) === '1';
     ?>
 
     <div class="misc-pub-section misc-pub-misc">
         <label>
             <input type="checkbox" name="member_sticky" value="1"
                 <?php checked($is_sticky, true); ?>>
             この投稿を先頭に固定表示
         </label>
     </div>
 
     <?php
 });
 
 
 /* ---------------------------------------------------------
  * Sticky 保存処理
  * --------------------------------------------------------- */
 add_action('save_post_member_post', function ($post_id) {
 
     if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
 
     $is_sticky = isset($_POST['member_sticky']) ? '1' : '0';
     update_post_meta($post_id, '_member_sticky', $is_sticky);
 });
 
 
 /* ---------------------------------------------------------
  * Sticky（先頭固定）member_post ID を取得（最大3件）
  * --------------------------------------------------------- */
 function get_member_sticky_ids() {
 
     $ids = get_posts([
         'post_type'      => 'member_post',
         'posts_per_page' => -1,
         'fields'         => 'ids',
         'meta_key'       => '_member_sticky',
         'meta_value'     => '1',
         'orderby'        => 'date',
         'order'          => 'DESC',
     ]);
 
     return array_slice($ids, 0, 3);
 }

 /* ============================================================
 * 会員向けカテゴリー自動付与（Gutenberg 完全保証版）
 * ============================================================ */
add_action('save_post_member_post', function ($post_id) {

    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;

    // 投稿タイプ確認
    if (get_post_type($post_id) !== 'member_post') return;

    /* ----------------------------------------
     * ① タクソノミータームの ID を準備
     * ---------------------------------------- */
    $terms = get_terms([
        'taxonomy'   => 'member_category',
        'hide_empty' => false,
    ]);

    if (is_wp_error($terms)) return;

    $slug_to_id = [];
    foreach ($terms as $t) {
        $slug_to_id[$t->slug] = (int)$t->term_id;
    }

    $member_id   = $slug_to_id['member']      ?? 0;
    $kusunoki_id = $slug_to_id['kusunoki']    ?? 0;
    $info_id     = $slug_to_id['information'] ?? 0;

    if (!$member_id) return; // member が無い場合は終了


    /* ----------------------------------------
     * ② 現在保存されているタームを取得（これが最も確実）
     * ---------------------------------------- */
    $current_terms = wp_get_post_terms($post_id, 'member_category', ['fields' => 'ids']);
    $current_terms = array_map('intval', $current_terms);


    /* ----------------------------------------
     * ③ カテゴリー未選択 → 自動で member を付与
     * ---------------------------------------- */
    if (empty($current_terms)) {
        wp_set_post_terms($post_id, [$member_id], 'member_category', false);
        return;
    }


    /* ----------------------------------------
     * ④ サブカテゴリのみの場合 → member を追加
     * ---------------------------------------- */
    $final_terms = $current_terms;

    $has_sub = (
        in_array($kusunoki_id, $current_terms) ||
        in_array($info_id, $current_terms)
    );

    if ($has_sub && !in_array($member_id, $current_terms)) {
        $final_terms[] = $member_id;
    }


    /* ----------------------------------------
     * ⑤ 最終的なタームを保存
     * ---------------------------------------- */
    wp_set_post_terms($post_id, array_unique($final_terms), 'member_category', false);
});

add_action('template_redirect', function () {

    // リクエスト URI（例：/kunocc2/cms/wp-content/uploads/2025/12/testPDF.pdf）
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // パス部分だけを取り出す（クエリは除外）
    $path = parse_url($request_uri, PHP_URL_PATH) ?? '';

    // アップロードフォルダ URL を取得
    $upload_dir  = wp_get_upload_dir();
    $upload_base = parse_url($upload_dir['baseurl'], PHP_URL_PATH) ?: '';

    // uploads 配下のファイルにアクセスしたか？
    // 例）$upload_base = /kunocc2/cms/wp-content/uploads
    if (strpos($path, $upload_base . '/') !== 0) {
        // uploads 直下ではない → 何もしない
        return;
    }

    // 添付ファイル URL を「DB に登録されている形」で生成する
    // 例）/kunocc2/cms/wp-content/uploads + /2025/12/testPDF.pdf
    $relative = substr($path, strlen($upload_base));            // 例）/2025/12/testPDF.pdf
    $full_url = trailingslashit($upload_dir['baseurl']) . ltrim($relative, '/');

    // 添付ファイル ID を取得
    $attachment_id = attachment_url_to_postid($full_url);
    if (!$attachment_id) {
        // WordPress 管理外のファイル（手動アップロード等）はスルー
        return;
    }


    // ---- ここから会員専用制御 ----

    // 会員専用ファイルであってもなくても、uploads直アクセスは禁止し
    // 必ず ID 付きの member-file へ誘導する

    // 未ログイン → ログイン画面へ
    if (!is_user_logged_in()) {

        $login_url   = home_url('/member-login/');
        $protected   = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));

        wp_redirect($login_url . '?redirect_to=' . rawurlencode($protected));
        exit;
    }

    // ログイン済み → 正規の member-file handler へ
    $protected_url = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));
    wp_redirect($protected_url);
    exit;
});



 /*--------------------------------
 * STEP2：会員向けカテゴリ（タクソノミー）
 --------------------------------*/
add_action( 'init', 'my_register_member_taxonomy' );
function my_register_member_taxonomy() {

    $labels = array(
        'name'              => '会員向けカテゴリ',
        'singular_name'     => '会員向けカテゴリ',
        'search_items'      => 'カテゴリを検索',
        'all_items'         => 'すべてのカテゴリ',
        'edit_item'         => 'カテゴリを編集',
        'update_item'       => 'カテゴリを更新',
        'add_new_item'      => '新規カテゴリを追加',
        'new_item_name'     => '新しいカテゴリ名',
        'menu_name'         => '会員向けカテゴリ',
    );

    register_taxonomy(
        'member_category',      // タクソノミー名
        'member_post',          // 紐づける投稿タイプ
        array(
            'hierarchical'      => true, // カテゴリ型（階層あり）
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true, // ブロックエディタ対応
            'rewrite'           => array(
                'slug'       => 'member/news/category',
                'with_front' => false,
            ),
        )
    );
}

/*--------------------------------
 * STEP4-1：メディアに「会員専用ファイル」チェック追加
 --------------------------------*/
 add_filter( 'attachment_fields_to_edit', 'my_member_flag_field', 10, 2 );
 function my_member_flag_field( $form_fields, $post ) {
 
     $is_member_only = get_post_meta( $post->ID, '_member_only', true );
 
     $form_fields['member_only'] = array(
         'label' => '会員専用ファイル',
         'input' => 'html',
         'html'  => '<label><input type="checkbox" name="attachments[' . $post->ID . '][member_only]" value="1" ' . checked( $is_member_only, '1', false ) . '> このファイルを会員専用にする</label>',
         'helps' => 'チェックすると、このファイルは会員限定でのみアクセスできます。',
     );
 
     return $form_fields;
 }
 
 add_filter( 'attachment_fields_to_save', 'my_member_flag_field_save', 10, 2 );
 function my_member_flag_field_save( $post, $attachment ) {
 
     $is_member_only = isset( $attachment['member_only'] ) ? '1' : '0';
     update_post_meta( $post['ID'], '_member_only', $is_member_only );
 
     return $post;
 }

 /*--------------------------------
 * STEP4-2：本文内の会員専用ファイルURLを保護URLに自動変換
 --------------------------------*/
add_filter( 'the_content', 'my_member_protect_member_only_files' );
function my_member_protect_member_only_files( $content ) {

    $upload_dir = wp_get_upload_dir();
    $baseurl    = $upload_dir['baseurl'];
    if ( ! $baseurl ) return $content;

    $baseurl_pattern = preg_quote( $baseurl, '#' );

    // --- PDFなどの<a href="">リンク変換 ---
    $content = preg_replace_callback(
        '#<a([^>]+)href=["\'](' . $baseurl_pattern . '[^"\']+)["\']([^>]*)>#i',
        function ( $m ) {

            $attachment_id = attachment_url_to_postid( $m[2] );
            if ( ! $attachment_id ) return $m[0];

            $is_member_only = get_post_meta( $attachment_id, '_member_only', true );
            if ( $is_member_only !== '1' ) return $m[0];

            $url = add_query_arg( array( 'id' => $attachment_id ), home_url( '/member/member-file/' ) );
            return '<a' . $m[1] . 'href="' . esc_url( $url ) . '"' . $m[3] . '>';
        },
        $content
    );

    // --- 画像<img src="">も会員専用にする場合 ---
    $content = preg_replace_callback(
        '#<img([^>]+)src=["\'](' . $baseurl_pattern . '[^"\']+)["\']([^>]*)>#i',
        function ( $m ) {

            $attachment_id = attachment_url_to_postid( $m[2] );
            if ( ! $attachment_id ) return $m[0];

            $is_member_only = get_post_meta( $attachment_id, '_member_only', true );
            if ( $is_member_only !== '1' ) return $m[0];

            $url = add_query_arg( array( 'id' => $attachment_id ), home_url( '/member/member-file/' ) );
            return '<img' . $m[1] . 'src="' . esc_url( $url ) . '"' . $m[3] . '>';
        },
        $content
    );

    return $content;
}

/**
 * ACFで挿入された画像・ファイルのURLも
 * 「会員専用ファイル」チェックがある場合は保護URLへ変換する
 */
add_filter('acf/format_value', 'my_member_protect_acf_files', 20, 3);
function my_member_protect_acf_files($value, $post_id, $field) {

    // file / image / url / link のとき
    if (in_array($field['type'], ['file', 'image', 'url', 'link'])) {
        if (is_array($value) && isset($value['url'])) {
            $value['url'] = my_member_convert_url($value['url']);
        } elseif (is_string($value)) {
            $value = my_member_convert_url($value);
        }
    }

    return $value;
}

/**
 * 会員専用ファイルのURLを保護URLへ強制変換する完全版
 */
function my_member_convert_url($url) {

    if (!$url) return '';

    // WordPress メディア以外（外部リンク）は除外
    $upload_dir = wp_get_upload_dir();
    if (strpos($url, $upload_dir['baseurl']) === false) {
        return $url;
    }

    // URL → attachment ID
    $attachment_id = attachment_url_to_postid($url);
    if (!$attachment_id) {
        return $url;
    }

    // ★ メディアに「会員専用ファイル」がついているか確認
    $is_member_only = get_post_meta($attachment_id, '_member_only', true);

    // チェックなし → 変換しない
    if ($is_member_only !== '1') {
        return $url;
    }

    // ★ チェックあり → ID付き保護URLへ変換
    return home_url("/member/member-file/?id={$attachment_id}");
}

function knc_protect_image_url($attachment_id) {

    if (!$attachment_id) return '';

    // 正しいメタキーでチェック
    $is_member_only = get_post_meta($attachment_id, '_member_only', true);

    if ($is_member_only === '1') {
        return home_url('/member/member-file/?id=' . $attachment_id);
    }

    return wp_get_attachment_url($attachment_id);
}

/**
 * ACF ボタンリンク（URL / File / Link フィールド）も
 * 会員専用PDFなら自動的に保護URLへ変換する
 */
add_filter('acf/format_value/type=url', 'knc_protect_acf_button_url', 20, 3);
add_filter('acf/format_value/type=link', 'knc_protect_acf_button_url', 20, 3);
add_filter('acf/format_value/type=file', 'knc_protect_acf_button_url', 20, 3);

function knc_protect_acf_button_url($value, $post_id, $field) {

    if (empty($value)) return $value;

    /* -------------------------------
     * link フィールド（配列）
     * ------------------------------- */
    if (is_array($value) && !empty($value['url'])) {
        $value['url'] = my_member_convert_url($value['url']);
        return $value;
    }

    /* -------------------------------
     * file フィールド（配列）
     * ------------------------------- */
    if (is_array($value) && !empty($value['ID'])) {
        $file_url = wp_get_attachment_url($value['ID']);
        $value['url'] = my_member_convert_url($file_url);
        return $value;
    }

    /* -------------------------------
     * URL（文字列）タイプ
     * ------------------------------- */
    if (is_string($value)) {
        return my_member_convert_url($value);
    }

    return $value;
}

function knc_get_protected_acf_file_url($acf_file) {

    if (!$acf_file) return '';

    // URL文字列のみ
    if (is_string($acf_file)) {
        return my_member_convert_url($acf_file);
    }

    // ACF 配列
    if (is_array($acf_file)) {

        // ID がある → 無条件で ID 付き URL へ
        if (!empty($acf_file['ID'])) {
            return home_url("/member/member-file/?id={$acf_file['ID']}");
        }

        // URL がある → URL → ID 変換
        if (!empty($acf_file['url'])) {
            return my_member_convert_url($acf_file['url']);
        }
    }

    // ID のみ
    if (is_numeric($acf_file)) {
        return home_url("/member/member-file/?id={$acf_file}");
    }

    return '';
}




add_action('wp_loaded', function () {
    global $wp_rewrite;
    $wp_rewrite->wp_rewrite_rules(); // 確実に生成させる

    error_log("----- REWRITE RULES START -----");
    foreach ($wp_rewrite->rules as $rule => $query) {
        error_log("$rule => $query");
    }
    error_log("----- REWRITE RULES END -----");
});



