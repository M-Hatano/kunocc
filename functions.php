<?php

/**
 * REQUEST_URI から「サイト相対パス」を返す（設置階層ゆれに強い版）
 * - home_url('/') のパス
 * - site_url('/') のパス（WP本体の設置場所）
 * - それらの親ディレクトリ
 * のいずれか最長一致を剥がす
 */
function knc_get_site_relative_path(): string
{
    $req      = $_SERVER['REQUEST_URI'] ?? '/';
    $req_path = parse_url($req, PHP_URL_PATH);
    $req_path = is_string($req_path) ? $req_path : '/';

    // 剥がしたい候補（末尾/ありに正規化）
    $candidates = [];

    $home_path = parse_url(home_url('/'), PHP_URL_PATH);
    $site_path = parse_url(site_url('/'), PHP_URL_PATH);

    foreach ([$home_path, $site_path] as $p) {
        if (!is_string($p) || $p === '') {
            continue;
        }

        $p            = '/' . trim($p, '/') . '/'; // 例: /kunocc2/cms/
        $candidates[] = $p;

        // 親ディレクトリも候補に追加（/kunocc2/）
        $parent = dirname(rtrim($p, '/')); // /kunocc2/cms -> /kunocc2
        if ($parent !== '/' && $parent !== '.') {
            $candidates[] = '/' . trim($parent, '/') . '/';
        }
    }

    // 長い順にして「最長一致」を剥がす
    $candidates = array_unique($candidates);
    usort($candidates, fn($a, $b) => strlen($b) <=> strlen($a));

    foreach ($candidates as $prefix) {
        if ($prefix !== '/' && strpos($req_path . '/', $prefix) === 0) {
            $req_path = substr($req_path, strlen($prefix));
            break;
        }
    }

    return trim($req_path, '/'); // 例: member/2024
}

/**
 * REQUEST_URI から「サイト設置パス」を差し引いたパスを返す
 *
 * 例)
 *  home_url('/') が /kunocc2/cms/ のとき : /kunocc2/cms/member/page/2/ → /member/page/2/
 *  home_url('/') が /kunocc2/     のとき : /kunocc2/member/page/2/     → /member/page/2/
 *  home_url('/') が /            のとき : /member/page/2/             → /member/page/2/
 */
function knc_rel_path(string $request_uri): string
{
    $path = wp_parse_url($request_uri, PHP_URL_PATH) ?? '/';

    $home_path = wp_parse_url(home_url('/'), PHP_URL_PATH) ?? '/';
    $home_path = '/' . trim($home_path, '/'); // 先頭スラッシュを保証

    if ($home_path === '/') {
        return $path; // ルート設置ならそのまま
    }

    // /kunocc2/cms みたいな設置パスを先頭から除去
    if ($path === $home_path) {
        return '/';
    }
    if (strpos($path, $home_path . '/') === 0) {
        return substr($path, strlen($home_path));
    }

    return $path; // 想定外は保険でそのまま
}

/** 比較用（先頭/末尾の / を落として返す） */
function knc_rel_trim(string $request_uri): string
{
    return trim(knc_rel_path($request_uri), '/');
}

/* ---------------------------------------------------------
 * 管理ログイン専用：wp-login.php を knc-120.php に変更
 * 会員ログインには一切干渉しない安全版
 * --------------------------------------------------------- */

// ==============================
// 会員ログイン：セッション開始
// ==============================
add_action(
    'init',
    function () {
        if (!session_id()) {
            session_start();
        }
    },
    1
);

// 会員ログイン判定
function knc_member_is_logged_in(): bool
{
    return !empty($_SESSION['knc_member_login']) && $_SESSION['knc_member_login'] === true;
}

// 管理ログインURL
define('LOGIN_CHANGE_PAGE', 'knc-120.php');

// wp-login.php に直接アクセス → ブロック（管理ログイン以外）
add_action('login_init', function () {
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
add_filter(
    'site_url',
    function ($url, $path, $orig_scheme, $blog_id) {

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
    },
    10,
    4
);

/* ---------------------------------------------------------
 * ログアウトURLの置換（管理ログインのみ）
 * --------------------------------------------------------- */
add_filter(
    'wp_redirect',
    function ($location, $status) {
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';

        // 会員ログイン関係は置換しない
        if (strpos($request_uri, '/member-login') !== false) {
            return $location;
        }

        return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $location);
    },
    10,
    2
);

// ログアウトURL置換
add_filter(
    'logout_url',
    function ($logout_url, $redir) {
        return str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $logout_url);
    },
    10,
    2
);

/* ---------------------------------------------------------
 * 著者ページのブロック（そのまま残す）
 * --------------------------------------------------------- */
add_filter('author_rewrite_rules', '__return_empty_array');

function disable_author_archive()
{
    if (isset($_GET['author']) || preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url('/404.php'));
        exit;
    }
}
add_action('init', 'disable_author_archive');

// ==============================
// 会員ログイン（WPと別ID/PW）
// ==============================
function knc_member_authenticate(string $login, string $password): bool
{
    // ▼ ここを「会員サイトのID/PW」に合わせてください
    // 例：会員ID => パスワード（まずは平文の簡易版）
    $members = [
        'kunocc' => '19891128',
    ];

    if (!isset($members[$login])) {
        return false;
    }

    return hash_equals($members[$login], $password);
}

/**
 * 会員ログイン処理（独自）
 * POST member_login が来た時だけ動作
 */
add_action('init', function () {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    if (empty($_POST['member_login'])) {
        return;
    }

    $login = sanitize_text_field($_POST['log'] ?? '');
    $pwd   = (string) ($_POST['pwd'] ?? '');

    if (!knc_member_authenticate($login, $pwd)) {
        wp_redirect(home_url('/member-login/?login=failed'));
        exit;
    }

    // ログイン成功：会員セッションON
    $_SESSION['knc_member_login'] = true;
    $_SESSION['knc_member_id']    = $login;

    // リダイレクト先
    $redirect = !empty($_POST['redirect_to'])
        ? esc_url_raw($_POST['redirect_to'])
        : home_url('/member/');

    wp_redirect($redirect);
    exit;
});

// 動的にメタタグのdescriptionを取得する関数
function get_dynamic_meta_description()
{
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
        'contact' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/confirm' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/complete' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'partnership' => '久能カントリー倶楽部 公式サイト 会員提携コースのご案内ページです。会員提携コースのご案内について掲載しております。',
        'm-calendar' => '久能カントリー倶楽部 公式サイト 会員ビジター様料金カレンダーページです。会員ビジター様料金カレンダーについて掲載しております。',
        'registration' => '久能カントリー倶楽部 公式サイト 会員コンペ申し込みページです。会員コンペ申し込みについて掲載しております。',
    ];

    $current_path = knc_get_site_relative_path();

    /* ----------------------------------------------------
     * ▼ フロントページ
     * ---------------------------------------------------- */
    if (is_front_page() || $current_path === '') {
        return '久能カントリー倶楽部のトップページです。';
    }

    /* ----------------------------------------------------
     * ▼ single-member.php（会員ニュース 詳細ページ）
     * ---------------------------------------------------- */
    // カテゴリ分類で会員ニュース詳細を判定する場合はこちら
    if (is_single() && has_category(['member', 'kusunoki', 'information'])) {
        return '久能カントリー倶楽部 公式サイト 会員お知らせ詳細ページです。各お知らせ記事を掲載しております.';
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
    // 末尾/先頭のスラッシュ揺れを消す（超重要）
    $uri = trim(knc_get_site_relative_path(), '/');

    /* -------------------------------
     * news 年別（年別 + 年別のページネーション）
     * /news/2024/
     * /news/2024/page/2/
     * ※ rewrite で year が入る前提で判定
     * ------------------------------- */
    if (strpos($uri, 'news/') === 0 && (int) get_query_var('year') > 0) {
        return 'date';
    }

    /* -------------------------------
     * news 一覧（ページネーション含む）
     * /news/
     * /news/page/2/
     * ------------------------------- */
    if (
        $uri === 'news'
        || preg_match('#^news/page/[0-9]+$#', $uri)
    ) {
        return 'news';
    }

    /* -------------------------------
     * member 一覧（ページネーション含む）
     * ------------------------------- */
    if ($uri === 'member' || preg_match('#^member/page/[0-9]+$#', $uri)) {
        return 'member';
    }

    if ($uri === 'member/information' || preg_match('#^member/information/page/[0-9]+$#', $uri)) {
        return 'information';
    }

    if ($uri === 'member/kusunoki' || preg_match('#^member/kusunoki/page/[0-9]+$#', $uri)) {
        return 'kusunoki';
    }

    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}/[0-9]{2}/[^/]+$#', $uri)) {
        return 'member-single-page';
    }

    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}$#', $uri)) {
        return 'date-member';
    }

    // WP フォールバック
    if (is_singular('member_post')) {
        return 'member-single-page';
    }
    if (is_single() && has_category(['member', 'kusunoki', 'information'])) {
        return 'member-single-page';
    }

    if (is_front_page()) {
        return 'top';
    }
    if (is_404()) {
        return 'errorpage';
    }
    if (is_single()) {
        return 'single-page';
    }

    if (is_page()) {
        global $post;
        return $post->post_name;
    }

    return '';
}

// body_classにカスタムクラスを返す関数
function my_custom_body_class()
{
    $uri = knc_get_site_relative_path();

    /* -------------------------------
     * member 系（一覧・ページネーション）
     * ------------------------------- */
    if ($uri === 'member' || preg_match('#^member/page/[0-9]+$#', $uri)) {
        return 'member';
    }

    if ($uri === 'member/information' || preg_match('#^member/information/page/[0-9]+$#', $uri)) {
        return 'member';
    }

    if ($uri === 'member/kusunoki' || preg_match('#^member/kusunoki/page/[0-9]+$#', $uri)) {
        return 'member';
    }

    if (is_singular('member_post')) {
        return 'member';
    }

    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}$#', $uri)) {
        return 'member';
    }

    /* -------------------------------
     * news（通常ニュース）※ここが重要：is_date() 依存をやめて URI 判定にする
     * /news
     * /news/page/2
     * /news/2024
     * /news/2024/page/2
     * ------------------------------- */
    if (
        $uri === 'news'
        || preg_match('#^news/page/[0-9]+$#', $uri)
        || preg_match('#^news/[0-9]{4}(/page/[0-9]+)?$#', $uri)
    ) {
        return 'news';
    }

    /* -------------------------------
     * 既存処理
     * ------------------------------- */
    if (is_front_page()) {
        return 'top';
    }
    if (is_404()) {
        return 'errorpage';
    }
    if (is_single()) {
        return 'news';
    }

    if (is_page()) {
        global $post;

        $slug = $post->post_name;
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

    // 環境差分を吸収した相対パス（例: member/page/2）
    $uri = knc_get_site_relative_path();

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
        // single（会員系カテゴリ）
        (is_single() && (has_category('member') || has_category('kusunoki') || has_category('information')))
        // 固定ページ
        || is_page(['member', 'kusunoki', 'information', 'partnership', 'm-calendar', 'registration', 'member-login'])
        // 年別（member 以下）
        || (strpos($uri, 'member/') === 0)
        // ページネーション
        || preg_match('#^member/page/[0-9]+$#', $uri)
        || preg_match('#^member/information/page/[0-9]+$#', $uri)
        || preg_match('#^member/kusunoki/page/[0-9]+$#', $uri)
        // partnership / calendar
        || strpos($uri, 'member/partnership') === 0
        || strpos($uri, 'member/calendar') === 0
    ) {
        wp_enqueue_style(
            'member-style',
            $dir . '/css/member.css',
            [],
            null
        );
        return;
    }

    /* -----------------------------------
     * ▼ ニュース（news）
     * ----------------------------------- */
    if (
        $uri === 'news'
        || preg_match('#^news/page/[0-9]+$#', $uri)
        || preg_match('#^news/[0-9]{4}(/page/[0-9]+)?$#', $uri)
    ) {
        wp_enqueue_style(
            'news-style',
            $dir . '/css/news.css',
            [],
            null
        );
        return;
    }

    /* -----------------------------------
     * ▼ フロントページ
     * ----------------------------------- */
    if (is_front_page()) {
        wp_enqueue_style(
            'top-style',
            $dir . '/css/top.css',
            [],
            null
        );
        return;
    }

    /* -----------------------------------
     * ▼ 投稿詳細（通常ニュース）
     * ----------------------------------- */
    if (is_single()) {
        wp_enqueue_style(
            'news-style',
            $dir . '/css/news.css',
            [],
            null
        );
        return;
    }

    /* -----------------------------------
     * ▼ 固定ページ個別CSS
     * ----------------------------------- */
    if (is_page()) {
        global $post;

        $slug = $post->post_name;
        $anc  = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $slug = get_post_field('post_name', end($anc));
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
add_filter(
    'script_loader_tag',
    function ($tag, $handle, $src) {

        // media-views は絶対に触らない
        if ($handle === 'media-views') {
            return $tag;
        }

        return '<script type="text/javascript" src="' . esc_url($src) . '"></script>';
    },
    10,
    3
);

// ページごとのJSを読み込む関数
function enqueue_page_specific_scripts()
{
    $dir      = get_template_directory_uri(); // テーマディレクトリのURIを取得
    $dir_path = get_template_directory();     // テーマディレクトリのパスを取得

    // common.js を全てのページで読み込む
    wp_enqueue_script(
        'common-js',
        $dir . '/js/common.js',
        [],
        null,
        true // フッターで読み込み
    );

    // カレンダー専用テンプレートの場合のみ calendar.js / holidays.js を読み込む
    if (is_page('m-calendar')) {
        wp_enqueue_script('holidays-js', $dir . '/js/holidays.js', [], null, true);
        wp_enqueue_script('calendar-js', $dir . '/js/calendar.js', ['holidays-js'], null, true);
    }

    // フロントページの場合
    if (is_front_page()) {
        $js_file_uri  = $dir . '/js/top.js';
        $js_file_path = $dir_path . '/js/top.js';

        if (file_exists($js_file_path)) {
            wp_enqueue_script('top-js', $js_file_uri, [], null, true);
        }
    }
    // 投稿ページの場合
    elseif (is_single()) {
        $js_file_uri  = $dir . '/js/news.js';
        $js_file_path = $dir_path . '/js/news.js';

        if (file_exists($js_file_path)) {
            wp_enqueue_script('news-js', $js_file_uri, [], null, true);
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
            wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', ['jquery'], null, true);

            // Slickの初期化スクリプトをインラインで挿入
            add_action('wp_footer', function () {
                echo "<script>
jQuery(document).ready(function($) {
  $('.csbox__img').slick({
    dots: true,
    arrows: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    draggable: true,
    autoplay: false
  });
});
</script>";
            });
        }

        // JavaScriptファイルのパスを生成
        $js_filename  = $slug . '.js';
        $js_file_uri  = $dir . '/js/' . $js_filename;
        $js_file_path = $dir_path . '/js/' . $js_filename;

        // JavaScriptファイルが存在する場合にのみ読み込む
        if (file_exists($js_file_path)) {
            wp_enqueue_script($slug . '-js', $js_file_uri, [], null, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_page_specific_scripts');

// ACF オプションページ「ご予約方法」追加
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title'  => 'ご予約方法について',   // ページタイトル
        'menu_title'  => 'ご予約方法',           // 管理メニューの表示名
        'menu_slug'   => 'reservation_settings', // スラッグ（ACF JSONと一致）
        'capability'  => 'edit_posts',           // 権限
        'redirect'    => false,                  // サブページに飛ばさない
    ]);
}

add_filter(
    'attachment_fields_to_save',
    function ($post, $attachment) {
        $is_member_only = isset($attachment['member_only']) ? '1' : '0';
        update_post_meta($post['ID'], '_member_only', $is_member_only);

        return $post;
    },
    10,
    2
);

// 会員・ニュース共通ページネーション（最終版：最初/最後付き・liのみ出力）
function custom_pagination($query)
{
    if (!($query instanceof WP_Query)) {
        return;
    }

    $total_pages = (int) $query->max_num_pages;
    if ($total_pages <= 1) {
        return;
    }

    $current_page = max(
        1,
        (int) $query->get('paged'),
        (int) get_query_var('paged')
    );

    /* ---------------------------------
     * モード判定（WP_Query のみを見る）
     * --------------------------------- */
    $mode = 'news';

    if ($query->get('post_type') === 'member_post') {
        $mode = 'member';
    }

    // member_category（information / kusunoki）
    $tax_query = (array) $query->get('tax_query');
    foreach ($tax_query as $tax) {
        if (
            isset($tax['taxonomy'], $tax['terms'])
            && $tax['taxonomy'] === 'member_category'
        ) {
            if (in_array('information', (array) $tax['terms'], true)) {
                $mode = 'information';
            } elseif (in_array('kusunoki', (array) $tax['terms'], true)) {
                $mode = 'kusunoki';
            }
        }
    }

    $year = (int) $query->get('year');

    /* ---------------------------------
     * ベースURL生成（home_urlのみ）
     * --------------------------------- */
    if ($mode === 'news') {
        $base_link = $year ? home_url("/news/{$year}/") : home_url("/news/");
    } else {
        if ($mode !== 'member' && $year) {
            $base_link = home_url("/member/{$mode}/{$year}/");
        } elseif ($mode !== 'member') {
            $base_link = home_url("/member/{$mode}/");
        } elseif ($year) {
            $base_link = home_url("/member/{$year}/");
        } else {
            $base_link = home_url("/member/");
        }
    }
    $base_link = trailingslashit($base_link);

    // page/1 を作らない
    $page_url = function (int $page) use ($base_link): string {
        return ($page <= 1) ? $base_link : $base_link . 'page/' . $page . '/';
    };

    /* ---------------------------------
     * ★ 最後ページ補正（posts_per_page を変えずに実在チェック）
     * --------------------------------- */
    $last_page = $total_pages;

    if ($current_page < $last_page) {
        $check_vars = $query->query_vars;

        // ★ 軽量化（ただし posts_per_page は絶対に変えない）
        $check_vars['fields']                 = 'ids';
        $check_vars['no_found_rows']          = true;
        $check_vars['update_post_meta_cache'] = false;
        $check_vars['update_post_term_cache'] = false;
        $check_vars['cache_results']          = true;

        // ★ ズレが複数でも確実に戻す
        while ($last_page > 1) {
            $check_vars['paged'] = $last_page;
            $q_last              = new WP_Query($check_vars);

            if ((int) $q_last->post_count > 0) {
                break; // このページは実在
            }

            $last_page--;
        }

        wp_reset_postdata();
    }

    /* ---------------------------------
     * ページ番号範囲
     * --------------------------------- */
    $range = 1;
    $start = max(1, $current_page - $range);
    $end   = min($last_page, $current_page + $range);

    /* ---------------------------------
     * 出力（liのみ）
     * --------------------------------- */

    // 最初 / 前
    if ($current_page > 1) {
        echo '<li class="c-pagenation__first"><a href="' . esc_url($page_url(1)) . '">最初</a></li>';
        echo '<li class="c-pagenation__before"><a href="' . esc_url($page_url($current_page - 1)) . '">←</a></li>';
    }

    // 数字
    for ($i = $start; $i <= $end; $i++) {
        $class = ($i === $current_page) ? ' class="is-current"' : '';
        echo "<li{$class}><a href='" . esc_url($page_url($i)) . "'>{$i}</a></li>";
    }

    // 次 / 最後
    if ($current_page < $last_page) {
        echo '<li class="c-pagenation__after"><a href="' . esc_url($page_url($current_page + 1)) . '">→</a></li>';
        echo '<li class="c-pagenation__last"><a href="' . esc_url($page_url($last_page)) . '">最後</a></li>';
    }
}

// コースサブナビ
function course_navigation()
{
    $nownum = intval(get_field('hole-no'));
    if (!$nownum) {
        return;
    }

    $max_hole = 18;

    $prev_num = ($nownum > 1) ? $nownum - 1 : $max_hole;
    $next_num = ($nownum < $max_hole) ? $nownum + 1 : 1;

    $prev_url     = home_url("/course/hole{$prev_num}/");
    $next_url     = home_url("/course/hole{$next_num}/");
    $overview_url = home_url("/course/");

    echo '<a href="' . esc_url($prev_url) . '" class="b-c-dtl__btn pre">Preview</a>';
    echo '<a href="' . esc_url($overview_url) . '" class="b-c-dtl__btm--top">コース全景へ</a>';
    echo '<a href="' . esc_url($next_url) . '" class="b-c-dtl__btn nxt">Next</a>';
}

/*---------------------------------------
  条件付き：画質 70%（ただしトップページID=151は除外）
----------------------------------------*/
add_filter('wp_editor_set_quality', function ($quality) {
    if (!empty($_POST['post_id']) && intval($_POST['post_id']) === 151) {
        return 100;
    }
    return 70;
});

add_filter('jpeg_quality', function ($quality) {
    if (!empty($_POST['post_id']) && intval($_POST['post_id']) === 151) {
        return 100;
    }
    return 70;
});

/*---------------------------------------
  アップロード画像のリサイズ処理（トップページ判定）
----------------------------------------*/
add_filter(
    'wp_handle_upload',
    function ($fileinfo) {

        // 画像以外は処理しない
        if (strpos($fileinfo['type'], 'image/') !== 0) {
            return $fileinfo;
        }

        // アップロード元の post_id を取得
        $post_id = intval($_POST['post_id'] ?? 0);

        // 画像エディター準備
        $path   = $fileinfo['file'];
        $editor = wp_get_image_editor($path);

        if (is_wp_error($editor)) {
            return $fileinfo;
        }

        $size  = $editor->get_size();
        $width = $size['width'];

        /*--------------------------------------------
         * ★ トップページ（固定ページ ID = 151）
         *--------------------------------------------*/
        if ($post_id === 151) {

            // 1600px を超えていたら 1600px に縮小（画質は変更しない）
            if ($width > 1600) {
                $editor->resize(1600, null, false);
                $editor->save($path);
            }

            // 1600px 以下なら何もしない
            return $fileinfo;
        }

        /*--------------------------------------------
         * ★ その他の投稿・ページ（通常画像）
         *--------------------------------------------*/
        if ($width > 1000) {
            $editor->resize(1000, null, false);
            $editor->set_quality(70);
            $editor->save($path);
        }

        return $fileinfo;
    },
    20
);

/*---------------------------------------
  中間サイズの自動生成を停止
----------------------------------------*/
add_filter('intermediate_image_sizes_advanced', '__return_empty_array');

add_filter(
    'wp_generate_attachment_metadata',
    function ($meta) {
        $meta['sizes'] = [];
        return $meta;
    },
    20
);

/**
 * トップページ ACF の KV 画像だけ
 * 1600px へリサイズした画像 custom_1600 を必ず生成する
 */
add_action('after_setup_theme', function () {
    add_image_size('custom_1600', 1600, 9999, false);
});

/* ------------------------------------------------------
 * big image 自動縮小を無効化（既存機能維持）
 * ------------------------------------------------------ */
add_filter('big_image_size_threshold', '__return_false');

/**
 * この添付画像IDが「トップページのキービジュアル画像」かどうか判定
 * ACF フィールドキーと比較して判断する
 */
function cg_is_kv_attachment($attachment_id)
{
    if (!$attachment_id) {
        return false;
    }

    // トップページのID
    $top_id = get_option('page_on_front');

    // トップKV画像の ACF フィールドキー
    $kv_fields = [
        'field_678f48c48831d',
        'field_678f48ff8831e',
        'field_678f49128831f',
    ];

    foreach ($kv_fields as $field_key) {
        // ★ オプションではなく固定ページを参照する
        $value = get_field($field_key, $top_id);

        if (!$value) {
            continue;
        }

        if (is_array($value) && isset($value['ID']) && intval($value['ID']) === intval($attachment_id)) {
            return true;
        }
        if (is_numeric($value) && intval($value) === intval($attachment_id)) {
            return true;
        }
    }

    return false;
}

// <img> タグに loading="lazy" 等を追加（post_type が 'post' の場合のみ）
function add_lazy_attributes_to_images($content_or_value, $post_id = null, $field = null)
{
    $target_post_type = 'post';

    if ($post_id && get_post_type($post_id) !== $target_post_type) {
        return $content_or_value;
    }

    // the_content() フィルターでは $post_id は null なので get_post_type() を直接使用
    if (is_null($post_id) && get_post_type() !== $target_post_type) {
        return $content_or_value;
    }

    $content_or_value = preg_replace_callback(
        '/<img(?![^>]+loading=)([^>]+)>/',
        function ($matches) {
            return '<img loading="lazy" decoding="async"' . $matches[1] . '>';
        },
        $content_or_value
    );

    return $content_or_value;
}
add_filter('the_content', 'add_lazy_attributes_to_images');
add_filter('acf/format_value/type=wysiwyg', 'add_lazy_attributes_to_images', 10, 3);

// 画像トリミングサイズ
if (function_exists('add_theme_support')) {
    add_image_size('defaultsize', '', '', true);
}

add_filter(
    'image_send_to_editor',
    function ($html, $id, $caption, $title, $align, $url, $size, $alt) {

        if (!$id) {
            return $html;
        }

        // 正規URLに統一
        $new_url = wp_get_attachment_url($id);

        // src を置換
        $html = preg_replace(
            '/src=["\'][^"\']+["\']/',
            'src="' . esc_url($new_url) . '"',
            $html
        );

        // width / height 削除
        $html = preg_replace('/\s*(width|height)="\d*"\s*/i', '', $html);

        // class 削除
        $html = preg_replace('/\s*class="[^"]*"\s*/i', '', $html);

        // loading 追加
        if (strpos($html, 'loading=') === false) {
            $html = preg_replace('/<img(.*?)>/i', '<img loading="lazy" decoding="async"$1>', $html);
        }

        return trim($html);
    },
    10,
    8
);

/**
 * 投稿画面のカテゴリー選択で
 * 選択済み項目を先頭に移動させない
 */
add_filter(
    'wp_terms_checklist_args',
    function ($args, $post_id) {
        if (isset($args['taxonomy']) && $args['taxonomy'] === 'category') {
            $args['checked_ontop'] = false;
        }
        return $args;
    },
    10,
    2
);

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
    $vars[] = 'member_category';
    return $vars;
});

/**
 * カテゴリ別にパーマリンクの表示URLを変更
 */
add_filter(
    'post_type_link',
    function ($permalink, $post) {

        if ($post->post_type !== 'member_post') {
            return $permalink;
        }

        $year  = get_the_date('Y', $post);
        $month = get_the_date('m', $post);
        $slug  = $post->post_name;

        if (has_term('information', 'member_category', $post)) {
            return home_url("/member/information/{$year}/{$month}/{$slug}/");
        }
        if (has_term('kusunoki', 'member_category', $post)) {
            return home_url("/member/kusunoki/{$year}/{$month}/{$slug}/");
        }

        return home_url("/member/{$year}/{$month}/{$slug}/");
    },
    10,
    2
);

/**
 * カテゴリ slug=news に属する全投稿の公開年度を降順で取得
 *
 * @return int[] 年度の配列（例: [2025,2024,2023…]）
 */
function fhg_get_news_years()
{
    global $wpdb;

    $news_term_id = $wpdb->get_var("
        SELECT term_id FROM {$wpdb->terms}
        WHERE slug = 'news'
        LIMIT 1
    ");
    if (!$news_term_id) {
        return [];
    }

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

// ─────────────────────────────────────────────────
// 久能CC：会員関連（/member 配下）を noindex にする
// ─────────────────────────────────────────────────
function knc_is_member_area_request(): bool {

    // サイト相対パスを取れるならそれを使う（設置階層ゆれに強い）
    if (function_exists('knc_get_site_relative_path')) {
        $uri = knc_get_site_relative_path(); // 例: 'member', 'member/2025/' など
        $uri = ltrim($uri, '/');

        // member または member/ で始まる場合をすべて拾う
        return (preg_match('#^member(/|$)#', $uri) === 1);
    }

    // フォールバック：REQUEST_URI を直接見る
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $path = is_string($path) ? $path : '/';

    return (preg_match('#/(member)(/|$)#', $path) === 1);
}

function knc_should_noindex(): bool {
    // 会員エリアはすべて noindex
    return knc_is_member_area_request();
}

// meta robots（HTML出力用：header-120.php から直呼び）
function knc_add_noindex_meta() {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    if (knc_should_noindex()) {
        echo "<meta name=\"robots\" content=\"noindex,follow\">\n";
    }
}

// 念押し：HTTPヘッダでも noindex（HTML以外にも効かせたい場合）
function knc_add_xrobots_header() {
    if (is_admin() || wp_doing_ajax()) return;

    if (knc_should_noindex() && !headers_sent()) {
        header('X-Robots-Tag: noindex, follow', true);
    }
}
add_action('send_headers', 'knc_add_xrobots_header', 1);


add_action(
    'init',
    function () {

        /* ======================================================
         * NEWS（既存構造はそのまま）
         * ====================================================== */
        add_rewrite_rule(
            '^news/?$',
            'index.php?pagename=news',
            'top'
        );

        add_rewrite_rule(
            '^news/page/([0-9]+)/?$',
            'index.php?pagename=news&paged=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            '^news/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
            'index.php?post_type=post&name=$matches[3]&category_name=news',
            'top'
        );

        add_rewrite_rule(
            '^news/([0-9]{4})/page/([0-9]+)/?$',
            'index.php?pagename=news&year=$matches[1]&paged=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^news/([0-9]{4})/?$',
            'index.php?pagename=news&year=$matches[1]',
            'top'
        );

        /* ======================================================
         * MEMBER：個別（member_post） ←★これを先に置く
         * ====================================================== */

        // /member/2025/12/slug/
        add_rewrite_rule(
            '^member/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
            'index.php?post_type=member_post&year=$matches[1]&monthnum=$matches[2]&name=$matches[3]',
            'top'
        );

        // /member/information/2025/12/slug/
        // /member/kusunoki/2025/12/slug/
        add_rewrite_rule(
            '^member/(information|kusunoki)/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
            'index.php?post_type=member_post&member_category=$matches[1]&year=$matches[2]&monthnum=$matches[3]&name=$matches[4]',
            'top'
        );

        /* ======================================================
         * MEMBER：年別は固定ページ member に統一（既存）
         * ====================================================== */

        // /member/2025/
        add_rewrite_rule(
            '^member/([0-9]{4})/?$',
            'index.php?pagename=member&year=$matches[1]',
            'top'
        );

        // /member/2025/page/2/
        add_rewrite_rule(
            '^member/([0-9]{4})/page/([0-9]+)/?$',
            'index.php?pagename=member&year=$matches[1]&paged=$matches[2]',
            'top'
        );

        // /member/information/2025/  /member/kusunoki/2025/
        add_rewrite_rule(
            '^member/(information|kusunoki)/([0-9]{4})/?$',
            'index.php?pagename=member&member_category=$matches[1]&year=$matches[2]',
            'top'
        );

        // /member/information/2025/page/2/  /member/kusunoki/2025/page/2/
        add_rewrite_rule(
            '^member/(information|kusunoki)/([0-9]{4})/page/([0-9]+)/?$',
            'index.php?pagename=member&member_category=$matches[1]&year=$matches[2]&paged=$matches[3]',
            'top'
        );
    },
    20
);

add_action('pre_get_posts', function ($q) {
    if (is_admin() || !$q->is_main_query()) {
        return;
    }
    if ($q->get('post_type') !== 'member_post') {
        return;
    }

    // 表示件数など
    $q->set('posts_per_page', 10);

    // member_category が information / kusunoki のときだけ tax_query
    $subcat = $q->get('member_category');
    if (in_array($subcat, ['information', 'kusunoki'], true)) {
        $q->set('tax_query', [[
            'taxonomy' => 'member_category',
            'field'    => 'slug',
            'terms'    => $subcat,
        ]]);
    }
});

/* ---------------------------------------------------------
 * template_include：URLパスでテンプレを振り分ける（最終版）
 * - /news/年別 → date.php
 * - /member/年別 → date-member.php
 * - 一覧系は page-120-xxx.php へ
 * --------------------------------------------------------- */
add_filter('template_include', 'knc_template_router_by_path', 50);

function knc_template_router_by_path($template)
{
    $path = knc_get_site_relative_path(); // 例: news/2023 , member/2025/page/2 など

    // member_post 個別はWPに任せる（single-member_post.php 等）
    if (is_singular('member_post')) {
        return $template;
    }

    /* =========================
     * NEWS：年別は date.php
     * ========================= */
    if (preg_match('#^news/[0-9]{4}(/page/[0-9]+)?$#', $path)) {
        $t = locate_template('date.php');
        return $t ?: $template;
    }

    /* =========================
     * MEMBER：年別は date-member.php
     * ========================= */
    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}(/page/[0-9]+)?$#', $path)) {
        $t = locate_template('date-member.php');
        return $t ?: $template;
    }

    /* =========================
     * MEMBER：一覧/ページング
     * ========================= */
    $member_map = [
        'member'             => 'page-120-m-member.php',
        'member/information' => 'page-120-m-information.php',
        'member/kusunoki'    => 'page-120-m-kusunoki.php',
    ];

    foreach ($member_map as $base => $file) {

        // 一覧
        if ($path === $base) {
            $t = locate_template($file);
            return $t ?: $template;
        }

        // ページング
        if (preg_match('#^' . preg_quote($base, '#') . '/page/[0-9]+$#', $path)) {
            $t = locate_template($file);
            return $t ?: $template;
        }
    }

    /* =========================
     * NEWS：一覧/ページング
     * ========================= */
    if ($path === 'news' || preg_match('#^news/page/[0-9]+$#', $path)) {
        $t = locate_template(['page-120-news.php', 'page-news.php']);
        return $t ?: $template;
    }

    return $template;
}

/**
 * member_post：カテゴリー未選択で「公開」された場合のみ
 * member カテゴリーを自動付与する
 */
add_action(
    'save_post_member_post',
    function ($post_id, $post, $update) {

        // autosave / revision / 権限チェック
        if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // 公開時のみ対象（下書き・非公開では何もしない）
        if ($post->post_status !== 'publish') {
            return;
        }

        // 現在選択されているカテゴリを取得
        $current_terms = wp_get_post_terms(
            $post_id,
            'member_category',
            ['fields' => 'ids']
        );

        if (!empty($current_terms)) {
            return;
        }

        // member カテゴリーを取得
        $member_term = get_term_by('slug', 'member', 'member_category');
        if (!$member_term) {
            return;
        }

        wp_set_post_terms(
            $post_id,
            [(int) $member_term->term_id],
            'member_category',
            false
        );
    },
    10,
    3
);

add_action('template_redirect', function () {
    if (is_category() || is_archive()) {
        global $wp_query;

        error_log('---- CATEGORY ARCHIVE DEBUG ----');
        error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
        error_log('is_category: ' . (is_category() ? 'YES' : 'NO'));
        error_log('get_query_var(category_name): ' . get_query_var('category_name'));
        error_log('get_query_var(year): ' . get_query_var('year'));
        error_log('WP_Query posts found: ' . $wp_query->post_count);
        error_log('-------------------------------');
    }
});

/*--------------------------------
 * STEP3：/member 以下をログイン必須
 * （環境完全対応・クエリ保持）
 --------------------------------*/
add_action('template_redirect', function () {

    // WPログイン または 会員ログイン済みなら何もしない
    if (is_user_logged_in() || knc_member_is_logged_in()) {
        return;
    }

    // 環境差分を除去した相対パス
    $relative = knc_get_site_relative_path();

    // クエリ保持
    $query = $_SERVER['QUERY_STRING'] ?? '';

    // ログイン・ログアウト画面は除外
    if ($relative === 'member-login' || strpos($relative, 'member-login/') === 0) {
        return;
    }
    if ($relative === 'member-logout' || strpos($relative, 'member-logout/') === 0) {
        return;
    }

    // /member 配下のみ対象
    if ($relative === 'member' || strpos($relative, 'member/') === 0) {

        // 元URL（クエリ付き）を復元
        $redirect_to = home_url('/' . $relative . '/');
        if ($query !== '') {
            $redirect_to .= '?' . $query;
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
add_action('init', 'my_register_member_post_type');

function my_register_member_post_type()
{
    $labels = [
        'name'          => '会員向け記事',
        'singular_name' => '会員向け記事',
        'add_new'       => '新規追加',
        'add_new_item'  => '会員向け記事を追加',
        'edit_item'     => '会員向け記事を編集',
        'new_item'      => '新しい会員向け記事',
        'view_item'     => '会員向け記事を表示',
        'search_items'  => '会員向け記事を検索',
        'not_found'     => '会員向け記事はありません。',
    ];

    register_post_type('member_post', [
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-lock',
        'has_archive'         => false, // 一覧は rewrite ルールで作るため false
        'rewrite'             => false, // ★ rewrite は自前で管理するため無効
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'show_in_rest'        => true,
    ]);
}

/* ---------------------------------------------------------
 * 公開ボックスに Sticky チェックを追加（UI を投稿に近づけた版）
 * --------------------------------------------------------- */
add_action('post_submitbox_misc_actions', function () {
    global $post;
    if ($post->post_type !== 'member_post') {
        return;
    }

    $is_sticky = get_post_meta($post->ID, '_member_sticky', true) === '1';
    ?>
    <div class="misc-pub-section misc-pub-misc">
        <label>
            <input type="checkbox" name="member_sticky" value="1" <?php checked($is_sticky, true); ?>>
            この投稿を先頭に固定表示
        </label>
    </div>
    <?php
});

/* ---------------------------------------------------------
 * Sticky 保存処理
 * --------------------------------------------------------- */
add_action('save_post_member_post', function ($post_id) {
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    $is_sticky = isset($_POST['member_sticky']) ? '1' : '0';
    update_post_meta($post_id, '_member_sticky', $is_sticky);
});

/* ---------------------------------------------------------
 * Sticky（先頭固定）member_post ID を取得（最大3件）
 *  - $term_slug: member / information / kusunoki
 *  - $year: 2025 など（0なら無視）
 * --------------------------------------------------------- */
function get_member_sticky_ids_by_term(string $term_slug = 'member', int $limit = 3, int $year = 0): array
{
    // ホワイトリスト（変な値を弾く）
    $allowed = ['member', 'information', 'kusunoki'];
    if (!in_array($term_slug, $allowed, true)) {
        $term_slug = 'member';
    }

    $args = [
        'post_type'      => 'member_post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_key'       => '_member_sticky',
        'meta_value'     => '1',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => [[
            'taxonomy' => 'member_category',
            'field'    => 'slug',
            'terms'    => [$term_slug],
        ]],
    ];

    if ($year > 0) {
        $args['year'] = $year;
    }

    $ids = get_posts($args);

    return array_slice($ids, 0, $limit);
}

/* ---------------------------------------------------------
 * 互換用：既存の呼び出しは member の固定を返す
 * --------------------------------------------------------- */
function get_member_sticky_ids()
{
    return get_member_sticky_ids_by_term('member', 3, 0);
}

/* =========================================================
 * uploads直アクセス → 会員専用ファイルなら member-file へ転送
 * ========================================================= */
add_action('template_redirect', function () {

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path        = parse_url($request_uri, PHP_URL_PATH) ?? '';

    $upload_dir  = wp_get_upload_dir();
    $upload_base = parse_url($upload_dir['baseurl'], PHP_URL_PATH) ?: '';

    if (strpos($path, $upload_base . '/') !== 0) {
        return;
    }

    $relative = substr($path, strlen($upload_base)); // 例）/2025/12/testPDF.pdf
    $full_url = trailingslashit($upload_dir['baseurl']) . ltrim($relative, '/');

    $attachment_id = attachment_url_to_postid($full_url);
    if (!$attachment_id) {
        return;
    }

    $is_member_only = get_post_meta($attachment_id, '_member_only', true);
    if ($is_member_only !== '1') {
        return;
    }

    if (!is_user_logged_in() && !knc_member_is_logged_in()) {
        $login_url = home_url('/member-login/');
        $protected = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));

        wp_redirect($login_url . '?redirect_to=' . rawurlencode($protected));
        exit;
    }

    $protected_url = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));
    wp_redirect($protected_url);
    exit;
});

/*--------------------------------
 * 会員ログアウト → ログインページへ戻す
 --------------------------------*/
add_action('template_redirect', function () {

    $path = '/' . knc_get_site_relative_path();

    if ($path !== '/member-logout' && $path !== '/member-logout/') {
        return;
    }

    unset($_SESSION['knc_member_login'], $_SESSION['knc_member_id']);

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }

    wp_redirect(home_url('/member-login/'));
    exit;
});

/*--------------------------------
 * STEP2：会員向けカテゴリ（タクソノミー）
 --------------------------------*/
add_action('init', 'my_register_member_taxonomy');

function my_register_member_taxonomy()
{
    $labels = [
        'name'              => '会員向けカテゴリ',
        'singular_name'     => '会員向けカテゴリ',
        'search_items'      => 'カテゴリを検索',
        'all_items'         => 'すべてのカテゴリ',
        'edit_item'         => 'カテゴリを編集',
        'update_item'       => 'カテゴリを更新',
        'add_new_item'      => '新規カテゴリを追加',
        'new_item_name'     => '新しいカテゴリ名',
        'menu_name'         => '会員向けカテゴリ',
    ];

    register_taxonomy(
        'member_category',
        'member_post',
        [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => [
                'slug'       => 'member/news/category',
                'with_front' => false,
            ],
        ]
    );
}

/*--------------------------------
 * STEP4-2：本文内の会員専用ファイルURLを保護URLに自動変換
 --------------------------------*/
add_filter('the_content', 'my_member_protect_member_only_files');

function my_member_protect_member_only_files($content)
{
    $upload_dir = wp_get_upload_dir();
    $baseurl    = $upload_dir['baseurl'];
    if (!$baseurl) {
        return $content;
    }

    $baseurl_pattern = preg_quote($baseurl, '#');

    // --- PDFなどの<a href="">リンク変換 ---
    $content = preg_replace_callback(
        '#<a([^>]+)href=["\'](' . $baseurl_pattern . '[^"\']+)["\']([^>]*)>#i',
        function ($m) {
            $attachment_id = attachment_url_to_postid($m[2]);
            if (!$attachment_id) {
                return $m[0];
            }

            $is_member_only = get_post_meta($attachment_id, '_member_only', true);
            if ($is_member_only !== '1') {
                return $m[0];
            }

            $url = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));
            return '<a' . $m[1] . 'href="' . esc_url($url) . '"' . $m[3] . '>';
        },
        $content
    );

    // --- 画像<img src="">も会員専用にする場合 ---
    $content = preg_replace_callback(
        '#<img([^>]+)src=["\'](' . $baseurl_pattern . '[^"\']+)["\']([^>]*)>#i',
        function ($m) {
            $attachment_id = attachment_url_to_postid($m[2]);
            if (!$attachment_id) {
                return $m[0];
            }

            $is_member_only = get_post_meta($attachment_id, '_member_only', true);
            if ($is_member_only !== '1') {
                return $m[0];
            }

            $url = add_query_arg(['id' => $attachment_id], home_url('/member/member-file/'));
            return '<img' . $m[1] . 'src="' . esc_url($url) . '"' . $m[3] . '>';
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

function my_member_protect_acf_files($value, $post_id, $field)
{
    if (in_array($field['type'], ['file', 'image', 'url', 'link'], true)) {
        if (is_array($value) && isset($value['url'])) {
            $value['url'] = my_member_convert_url($value['url']);
        } elseif (is_string($value)) {
            $value = my_member_convert_url($value);
        }
    }

    return $value;
}

add_filter('image_downsize', function ($out, $post_id, $size) {

    if (!$post_id) {
        return false;
    }

    $is_member_only = get_post_meta($post_id, '_member_only', true);

    if ($is_member_only === '1') {
        $url = home_url('/member/member-file/?id=' . $post_id);

        return [
            $url,
            null,
            null,
            false,
        ];
    }

    return false;
}, 10, 3);

/**
 * 会員専用ファイルのURLを保護URLへ強制変換する完全版
 */
function my_member_convert_url($url)
{
    if (!$url) {
        return '';
    }

    $upload_dir = wp_get_upload_dir();
    if (strpos($url, $upload_dir['baseurl']) === false) {
        return $url;
    }

    $attachment_id = attachment_url_to_postid($url);
    if (!$attachment_id) {
        return $url;
    }

    $is_member_only = get_post_meta($attachment_id, '_member_only', true);

    if ($is_member_only !== '1') {
        return $url;
    }

    return home_url("/member/member-file/?id={$attachment_id}");
}

function knc_protect_image_url($attachment_id)
{
    if (!$attachment_id) {
        return '';
    }

    $is_member_only = get_post_meta($attachment_id, '_member_only', true);

    if ($is_member_only === '1') {
        return home_url('/member/member-file/?id=' . $attachment_id);
    }

    return wp_get_attachment_url($attachment_id);
}

function knc_get_protected_acf_file_url($acf_file)
{
    if (!$acf_file) {
        return '';
    }

    if (is_string($acf_file)) {
        return my_member_convert_url($acf_file);
    }

    if (is_array($acf_file)) {
        if (!empty($acf_file['ID'])) {
            return home_url("/member/member-file/?id={$acf_file['ID']}");
        }
        if (!empty($acf_file['url'])) {
            return my_member_convert_url($acf_file['url']);
        }
    }

    if (is_numeric($acf_file)) {
        return home_url("/member/member-file/?id={$acf_file}");
    }

    return '';
}

/**
 * トップページ保存時：KV画像を1600pxに強制リサイズ
 */
add_action('save_post_page', function ($post_id) {

    if ($post_id != get_option('page_on_front')) {
        return;
    }

    $kv_fields = [
        'top_image_1',
        'top_image_2',
        'top_image_3',
    ];

    foreach ($kv_fields as $field_name) {
        $image = get_field($field_name, $post_id);

        if (!$image || empty($image['ID'])) {
            continue;
        }

        $id   = $image['ID'];
        $file = get_attached_file($id);

        $editor = wp_get_image_editor($file);
        if (is_wp_error($editor)) {
            continue;
        }

        $size = $editor->get_size();
        if ($size['width'] > 1600) {
            $editor->resize(1600, null, false);
            $editor->save($file);
        }
    }
});

/**
 * メディアモーダル：アップロード直後は compat が無いので
 * attachment を自動 fetch して「会員専用ファイル」チェックを即表示させる
 */
add_action('admin_enqueue_scripts', function ($hook) {

    if (!in_array($hook, ['post.php', 'post-new.php', 'upload.php'], true)) {
        return;
    }

    wp_add_inline_script(
        'media-views',
        <<<JS
(function($){
  if (!wp || !wp.media) return;

  wp.media.on('attachment:added', function(attachment){
    if (!attachment || !attachment.fetch) return;

    attachment.fetch({
      success: function() {
        var frame = wp.media.frame;
        if (frame && frame.state) {
          var selection = frame.state().get('selection');
          if (selection) {
            selection.reset([attachment]);
          }
        }
      }
    });
  });

})(jQuery);
JS,
        'after'
    );
});

/**
 * メディアアップロード後に1回だけ管理画面をリロードする
 * （attachment_fields_to_edit を確実に反映させる最終手段）
 */
add_action('admin_enqueue_scripts', function ($hook) {

    if (!in_array($hook, ['post.php', 'post-new.php', 'upload.php'], true)) {
        return;
    }

    wp_add_inline_script(
        'media-views',
        <<<JS
(function($){
  if (!wp || !wp.media) return;

  if (sessionStorage.getItem('member_file_reloaded') === '1') {
    return;
  }

  wp.media.on('attachment:added', function() {

    sessionStorage.setItem('member_file_reloaded', '1');

    setTimeout(function(){
      location.reload();
    }, 800);

  });

})(jQuery);
JS,
        'after'
    );
});

add_filter(
    'attachment_fields_to_edit',
    function ($form_fields, $post) {

        $is_member_only = get_post_meta($post->ID, '_member_only', true);

        $form_fields['member_only'] = [
            'label' => '会員専用ファイル',
            'input' => 'html',
            'html'  => '
                <label style="display:block; margin-top:12px;">
                    <input type="checkbox"
                        name="attachments[' . $post->ID . '][member_only]"
                        value="1" ' . checked($is_member_only, '1', false) . '>
                    このファイルを会員専用にする
                </label>
                <p class="description">
                    チェックすると、このファイルは会員限定でのみアクセスできます。
                </p>
            ',
        ];

        return $form_fields;
    },
    9999,
    2
);

/**
 * 全ユーザー共通：管理バー（ツールバー）を全画面で非表示
 */
add_filter('show_admin_bar', '__return_false');

/**
 * /news 系 /member 系のURLで 404 を返さない（テンプレを表示できるようにする）
 */
add_action('template_redirect', function () {

    $path = knc_get_site_relative_path();

    $is_news_route = (
        $path === 'news'
        || preg_match('#^news/page/[0-9]+$#', $path)
        || preg_match('#^news/[0-9]{4}(/page/[0-9]+)?$#', $path)
    );

    $is_member_route = (
        $path === 'member'
        || preg_match('#^member/page/[0-9]+$#', $path)
        || preg_match('#^member/(information|kusunoki)$#', $path)
        || preg_match('#^member/(information|kusunoki)/page/[0-9]+$#', $path)
        || preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}(/page/[0-9]+)?$#', $path)
    );

    if (!$is_news_route && !$is_member_route) {
        return;
    }

    global $wp_query;
    if (!empty($wp_query) && $wp_query->is_404) {
        $wp_query->is_404 = false;
        status_header(200);
    }
}, 0);
