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
        'sitemap' => '久能カントリー倶楽部 公式サイト サイトマップページです。サイトマップについて掲載しております。',
        'contact'     => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/confirm'  => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'contact/complete' => '久能カントリー倶楽部へのお問い合わせはこちらから。',
        'partnership' => '久能カントリー倶楽部 公式サイト 会員提携コースのご案内ページです。会員提携コースのご案内について掲載しております。',
        'm-calendar' => '久能カントリー倶楽部 公式サイト 会員ビジター様料金カレンダーページです。会員ビジター様料金カレンダーについて掲載しております。',
        'registration' => '久能カントリー倶楽部 公式サイト 会員コンペ申し込みページです。会員コンペ申し込みについて掲載しております。',
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



    /* ----------------------------------------------------
     * ▼▼▼ あなた指定の優先ルール（重複なし） ▼▼▼
     * ---------------------------------------------------- */

    // ■ /news/2025/ → id="date"
    if (preg_match('#^news/[0-9]{4}/?$#', $uri)) {
        return 'date';
    }

    // ■ /member/kusunoki(/page/2/) → id="kusunoki"
    if (preg_match('#^member/kusunoki(?:/page/[0-9]+)?/?$#', $uri)) {
        return 'kusunoki';
    }

    // ■ /member/information(/page/2/) → id="information"
    if (preg_match('#^member/information(?:/page/[0-9]+)?/?$#', $uri)) {
        return 'information';
    }

    // ■ member 個別記事 → id="member-single-page"
    //   /member/YYYY/MM/slug/
    //   /member/kusunoki/YYYY/MM/slug/
    //   /member/information/YYYY/MM/slug/
    if (preg_match('#^member(?:/(information|kusunoki))?/[0-9]{4}/[0-9]{2}/[^/]+/?$#', $uri)) {
        return 'member-single-page';
    }

    // ■ 会員の年別 → id="member-date"
    //   /member/YYYY/
    //   /member/kusunoki/YYYY/
    //   /member/information/YYYY/
    if (preg_match('#^member(?:/(information|kusunoki))?/([0-9]{4})/?$#', $uri)) {
        return 'member-date';
    }



    /* ----------------------------------------------------
     * ▼▼▼ WordPress の補助判定（必要最小限に整理） ▼▼▼
     * ---------------------------------------------------- */

    // ■ 会員カテゴリーの投稿 → id="member-single-page"
    if (is_single() && has_category(['member', 'kusunoki', 'information'])) {
        return 'member-single-page';
    }

    // ■ 会員固定ページ → 「スラッグ名」を返す
    if (is_page(['member', 'kusunoki', 'information'])) {
        global $post;
        return get_post_field('post_name', $post);
    }

    // ■ 年別ニュース（news配下）
    if (is_date() && strpos($uri, 'news/') !== false) {
        return 'date';
    }

    // ■ 年別会員ニュース（member配下）
    if (is_date() && strpos($uri, 'member/') !== false) {
        return 'member-date';
    }



    /* ----------------------------------------------------
     * ▼▼▼ 通常ページ ▼▼▼
     * ---------------------------------------------------- */

    if (is_front_page()) return 'top';
    if (is_404())        return 'errorpage';

    if (is_single())     return 'single-page';

    if (is_page()) {
        global $post;
        return get_post_field('post_name', $post);
    }

    return '';
}


// body_classにカスタムクラス（ルート親のスラッグ）を追加する関数
function my_custom_body_class()
{
    // ★ 追加：/kunocc/cms/ を除去
    $uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $uri = preg_replace('#^[^/]+/[^/]+/#', '', $uri);
    // 例) /kunocc/cms/member/information/page/2/ → member/information/page/2/

    // ▼ information / kusunoki ページネーション
    if (preg_match('#^member/(information|kusunoki)/page/[0-9]+/?$#', $uri)) {
        return 'm-news';
    }

    // ▼ member ページネーション
    if (preg_match('#^member/page/[0-9]+/?$#', $uri)) {
        return 'm-news';
    }

    // ▼ 固定トップ
    if (preg_match('#^member/(information|kusunoki)/?$#', $uri)) {
        return 'm-news';
    }

    // ▼ single
    if (is_single() && (has_category('member') || has_category('kusunoki') || has_category('information'))) {
        return 'm-news';
    }

    // ▼ 固定ページ
    if (is_page(array('member', 'kusunoki', 'information', 'member-login'))) {
        return 'm-news';
    }

    // ▼ 年別ニュース
    if (is_date() && strpos($uri, 'news/') !== false) {
        return 'news';
    }

    // ▼ 年別会員ニュース
    if (is_date() && strpos($uri, 'member/') !== false) {
        return 'm-news';
    }

    if (is_front_page()) return 'top';
    if (is_404()) return 'errorpage';
    if (is_single()) return 'news';

    if (is_page()) {
        global $post;
        $slug = get_post_field('post_name', $post);
        $anc = get_post_ancestors($post->ID);
        if (!empty($anc)) {
            $top = end($anc);
            $slug = get_post_field('post_name', $top);
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
/* ======================================================
 * トップ KV 画像だけアップロード時の1000px縮小を回避する
 * ====================================================== */

/* KV の ACF フィールドキー */
function cg_kv_field_keys() {
    return [
        'field_678f48c48831d', // top_image_1
        'field_678f48ff8831e', // top_image_2
        'field_678f49128831f', // top_image_3
    ];
}

/* KV 判定：アップロードされた画像が KV にセットされたか？ */
function cg_is_kv_attachment( $attachment_id ) {

    if ( empty( $_REQUEST['acf'] ) ) {
        return false;
    }

    $acf = $_REQUEST['acf'];
    $kv_keys = cg_kv_field_keys();

    foreach ( $kv_keys as $key ) {

        if ( empty( $acf[$key] ) ) continue;

        // ACF は返却形式によって値が変わる
        $val = $acf[$key];

        // 画像配列形式
        if ( is_array( $val ) && !empty($val['ID']) ) {
            if ( intval($val['ID']) === intval($attachment_id) ) {
                return true;
            }
        }

        // 単純な ID 形式
        if ( is_numeric( $val ) ) {
            if ( intval($val) === intval($attachment_id) ) {
                return true;
            }
        }
    }

    return false;
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
 * 画質を 70% に統一（既存機能を維持）
 * ------------------------------------------------------ */
add_filter('wp_editor_set_quality', fn() => 70);
add_filter('jpeg_quality',          fn() => 70);   // 古いWP用


/* ------------------------------------------------------
 * big image 自動縮小を無効化（既存機能維持）
 * ------------------------------------------------------ */
add_filter('big_image_size_threshold', '__return_false');


/* ------------------------------------------------------
 * 中間サイズ生成を停止（既存機能維持）
 * ------------------------------------------------------ */
add_filter('intermediate_image_sizes_advanced', '__return_empty_array');

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
 * ① query_vars に subcat と year を登録
 * （ニュース・会員ニュースのURL制御に必要）
 */
add_filter('query_vars', function ($vars) {
    $vars[] = 'subcat';
    $vars[] = 'year';
    return $vars;
});




/**
 * カテゴリ別にパーマリンクの表示URLを変更
 */
add_filter('post_link', 'custom_post_permalink_by_category', 10, 3);
function custom_post_permalink_by_category($permalink, $post, $leavename) {

    $year  = get_the_date('Y', $post);
    $month = get_the_date('m', $post);
    $slug  = $post->post_name;

    if (in_category('information', $post)) {
        return home_url("/member/information/{$year}/{$month}/{$slug}/");
    }
    if (in_category('kusunoki', $post)) {
        return home_url("/member/kusunoki/{$year}/{$month}/{$slug}/");
    }
    if (in_category('member', $post)) {
        return home_url("/member/{$year}/{$month}/{$slug}/");
    }
    if (in_category('news', $post)) {
        return home_url("/news/{$year}/{$month}/{$slug}/");
    }

    return $permalink;
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

    // member (親)
    add_rewrite_rule(
        '^member/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?name=$matches[3]',
        'top'
    );

    // information
    add_rewrite_rule(
        '^member/information/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?name=$matches[3]',
        'top'
    );

    // kusunoki
    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/([0-9]{2})/([^/]+)/?$',
        'index.php?name=$matches[3]',
        'top'
    );

    // member YYYY
    add_rewrite_rule(
        '^member/([0-9]{4})/?$',
        'index.php?post_type=post&category_name=member&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=post&category_name=member&year=$matches[1]&paged=$matches[2]',
        'top'
    );

    // information YYYY
    add_rewrite_rule(
        '^member/information/([0-9]{4})/?$',
        'index.php?post_type=post&category_name=information&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/information/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=post&category_name=information&year=$matches[1]&paged=$matches[2]',
        'top'
    );

    // kusunoki YYYY
    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/?$',
        'index.php?post_type=post&category_name=kusunoki&year=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^member/kusunoki/([0-9]{4})/page/([0-9]+)/?$',
        'index.php?post_type=post&category_name=kusunoki&year=$matches[1]&paged=$matches[2]',
        'top'
    );
});

add_filter('template_include', 'knc_template_router', 20);
function knc_template_router($template) {

    /* ---------------------------------------------------------
     * 1) 正しい URI 正規化（★これだけ修正）
     * --------------------------------------------------------- */
    $uri_raw = $_SERVER['REQUEST_URI'] ?? '';
    $uri = parse_url($uri_raw, PHP_URL_PATH);

    // /kunocc/cms/ を完全に除去
    // 例：/kunocc/cms/member/page/2/ → /member/page/2/
    $uri = preg_replace('#^/[^/]+/[^/]+/#', '/', $uri);

    $uri = trim($uri, '/'); 
    // $uri の例： member/page/2


    /* ---------------------------------------------------------
     * 2) ここから先はあなたの既存ロジックをそのまま残す
     * --------------------------------------------------------- */

    // ★ カレンダー
    if ($uri === 'member/calendar') {
        return locate_template('page-120-calendar.php');
    }

    if (preg_match('#^member/information/page/[0-9]+/?$#', $uri)) {
        return locate_template('page-120-information.php');
    }

    if (preg_match('#^member/kusunoki/page/[0-9]+/?$#', $uri)) {
        return locate_template('page-120-kusunoki.php');
    }

    if (preg_match('#^member/page/[0-9]+/?$#', $uri)) {
        return locate_template('page-120-member.php');
    }

    // 年別（information / kusunoki）
    if (preg_match('#^member/(information|kusunoki)/[0-9]{4}(/page/[0-9]+)?/?$#', $uri)) {
        return locate_template('date-member.php');
    }

    // 年別（information / kusunoki）
    if (preg_match('#^member/(information|kusunoki)/[0-9]{4}(/page/[0-9]+)?/?$#', $uri)) {
        return locate_template('date-member.php');
    }

    // 年別（member）
    if (preg_match('#^member/[0-9]{4}(/page/[0-9]+)?/?$#', $uri)) {
        return locate_template('date-member.php');
    }

    if ($uri === 'member/information') {
        return locate_template('page-120-information.php');
    }

    if ($uri === 'member/kusunoki') {
        return locate_template('page-120-kusunoki.php');
    }

    if ($uri === 'member') {
        return locate_template('page-120-member.php');
    }

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
 * STEP3：/member/ 以下をログイン必須（ID保持版）
 --------------------------------*/
 add_action('template_redirect', 'knc_member_login_check');
function knc_member_login_check() {

    if (is_user_logged_in()) return;

    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $home_path = wp_parse_url(home_url('/'), PHP_URL_PATH);
    if (!$home_path) $home_path = '/';

    $member_base = rtrim($home_path, '/') . '/member/';

    // /member/（固定ページトップ）は例外
    if ($request_path === $member_base) return;

    // ページネーション例外
    $pattern = '#^' . preg_quote($member_base, '#') .
           '('
           . 'page/[0-9]+'                         // /member/page/2/
           . '|[0-9]{4}/page/[0-9]+'               // /member/2025/page/2/
           . '|kusunoki/page/[0-9]+'               // /member/kusunoki/page/2/
           . '|information/page/[0-9]+'            // /member/information/page/2/
           . ')'
           . '/?$#';

    if (preg_match($pattern, $request_path)) {
        return;
    }

    // /member/ 以下はログイン必須
    if (strpos($request_path, $member_base) === 0) {

        $query_string = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

        $clean_path = preg_replace('#^' . preg_quote($home_path, '#') . '#', '', $request_path);

        $redirect_to = home_url('/' . ltrim($clean_path, '/')) . $query_string;

        wp_redirect(home_url('/knc-120.php') . '?redirect_to=' . rawurlencode($redirect_to));
        exit;
    }
}



/*--------------------------------
 * 会員向け記事用カスタム投稿タイプ
 * URL例：
 *   一覧   : /member/news/
 *   個別   : /member/news/スラッグ/
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
         'has_archive'        => 'member/news',
         'rewrite'            => array(
             'slug'       => 'member/news',
             'with_front' => false,
         ),
         'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
         'exclude_from_search'=> true,
         'publicly_queryable' => true,
         'show_in_rest'       => true,
     ) );
 }

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


add_action('wp_loaded', function () {
    global $wp_rewrite;
    $wp_rewrite->wp_rewrite_rules(); // 確実に生成させる

    error_log("----- REWRITE RULES START -----");
    foreach ($wp_rewrite->rules as $rule => $query) {
        error_log("$rule => $query");
    }
    error_log("----- REWRITE RULES END -----");
});



