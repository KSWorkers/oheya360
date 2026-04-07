<?php
/**
 * oheya360 Theme Functions
 */

defined('ABSPATH') || exit;

// =========================================
// テーマサポート
// =========================================
function oheya360_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');

    // サムネイルサイズ
    add_image_size('work-thumb', 800, 500, true);
    add_image_size('blog-thumb', 800, 450, true);
    add_image_size('og-image', 1200, 630, true);

    // ナビゲーション
    register_nav_menus([
        'primary' => 'プライマリーメニュー',
        'footer'  => 'フッターメニュー',
    ]);
}
add_action('after_setup_theme', 'oheya360_setup');

// =========================================
// スクリプト・スタイル読み込み
// =========================================
function oheya360_enqueue_assets() {
    $ver = wp_get_theme()->get('Version');

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;800&family=Inter:wght@400;500;600;700;800&display=swap',
        [],
        null
    );

    // メインスタイル
    wp_enqueue_style('oheya360-style', get_stylesheet_uri(), ['google-fonts'], $ver);

    // メインJS
    wp_enqueue_script(
        'oheya360-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $ver,
        true
    );

    // Contact Form 7 スタイル上書き（CF7有効時のみ）
    if (class_exists('WPCF7')) {
        wp_enqueue_style(
            'oheya360-cf7',
            get_template_directory_uri() . '/assets/css/cf7.css',
            ['oheya360-style'],
            $ver
        );
        // CF7 は contact ページのみで読み込む
        if ( ! is_page('contact') ) {
            wp_dequeue_script('contact-form-7');
            wp_dequeue_style('contact-form-7');
            wp_dequeue_style('oheya360-cf7');
        }
    }
}
add_action('wp_enqueue_scripts', 'oheya360_enqueue_assets');

function oheya360_preload_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'oheya360_preload_fonts', 1);

// =========================================
// カスタム投稿タイプ：制作事例
// =========================================
function oheya360_register_post_types() {
    register_post_type('work', [
        'labels' => [
            'name'               => '制作事例',
            'singular_name'      => '制作事例',
            'add_new'            => '新規追加',
            'add_new_item'       => '制作事例を追加',
            'edit_item'          => '制作事例を編集',
            'new_item'           => '新しい制作事例',
            'view_item'          => '制作事例を表示',
            'search_items'       => '制作事例を検索',
            'not_found'          => '制作事例が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に制作事例はありません',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'works'],
        'menu_icon'     => 'dashicons-camera',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'oheya360_register_post_types');

// =========================================
// カスタムタクソノミー：業種
// =========================================
function oheya360_register_taxonomies() {
    register_taxonomy('work_category', 'work', [
        'labels' => [
            'name'          => '業種カテゴリー',
            'singular_name' => '業種カテゴリー',
            'all_items'     => 'すべての業種',
            'edit_item'     => '業種を編集',
            'add_new_item'  => '業種を追加',
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'work-category'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'oheya360_register_taxonomies');

// =========================================
// カスタムフィールド（ACF不使用の場合の補完）
// =========================================
function oheya360_register_meta_boxes() {
    add_meta_box(
        'work_details',
        '制作事例詳細',
        'oheya360_work_details_callback',
        'work',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'oheya360_register_meta_boxes');

function oheya360_work_details_callback($post) {
    wp_nonce_field('oheya360_work_nonce', 'work_nonce');
    $matterport_url = get_post_meta($post->ID, '_matterport_url', true);
    $client_name    = get_post_meta($post->ID, '_client_name', true);
    $location       = get_post_meta($post->ID, '_location', true);
    $year           = get_post_meta($post->ID, '_year', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="matterport_url">Matterport URL</label></th>
            <td><input type="url" id="matterport_url" name="matterport_url"
                value="<?php echo esc_attr($matterport_url); ?>" class="large-text"
                placeholder="https://my.matterport.com/show/?m=XXXXXX" /></td>
        </tr>
        <tr>
            <th><label for="client_name">クライアント名</label></th>
            <td><input type="text" id="client_name" name="client_name"
                value="<?php echo esc_attr($client_name); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="location">所在地</label></th>
            <td><input type="text" id="location" name="location"
                value="<?php echo esc_attr($location); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="year">制作年</label></th>
            <td><input type="text" id="year" name="year"
                value="<?php echo esc_attr($year); ?>" class="small-text"
                placeholder="2024" /></td>
        </tr>
    </table>
    <?php
}

function oheya360_save_work_meta($post_id) {
    if (!isset($_POST['work_nonce']) || !wp_verify_nonce($_POST['work_nonce'], 'oheya360_work_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['matterport_url', 'client_name', 'location', 'year'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_$field", sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_work', 'oheya360_save_work_meta');

// =========================================
// ウィジェットエリア
// =========================================
function oheya360_widgets_init() {
    register_sidebar([
        'name'          => 'ブログサイドバー',
        'id'            => 'blog-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'oheya360_widgets_init');

// =========================================
// ヘルパー関数
// =========================================

/**
 * Matterport埋め込み URL を iframeに変換
 */
function oheya360_get_matterport_embed($url) {
    if (empty($url)) return '';
    // 既にembed URLの場合はそのまま返す
    if (strpos($url, 'show/?m=') !== false) {
        return $url . '&play=1&qs=1&lang=ja';
    }
    return $url;
}

/**
 * 読了時間を計算
 */
function oheya360_reading_time($post_id = null) {
    $content    = get_post_field('post_content', $post_id);
    $word_count = mb_strlen(strip_tags($content));
    $minutes    = ceil($word_count / 400);
    return $minutes . '分で読めます';
}

/**
 * SVGアイコン出力
 */
function oheya360_icon($name, $class = '') {
    $icons = [
        'arrow-right' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>',
        'play'        => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>',
        'mail'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        'phone'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'location'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
        'cube'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 16-9 5-9-5V8l9-5 9 5v8Z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>',
        'camera'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
        'share'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>',
        'building'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
        'check'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
        'twitter'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'instagram'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/></svg>',
    ];
    $class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';
    return isset($icons[$name]) ? '<span' . $class_attr . '>' . $icons[$name] . '</span>' : '';
}

// =========================================
// OGP / SEO
// =========================================
function oheya360_ogp_tags() {
    global $post;
    $site_name = get_bloginfo('name');
    $site_url  = home_url();

    if (is_singular()) {
        $title = get_the_title();
        $url   = get_permalink();
        $desc  = get_the_excerpt() ?: get_bloginfo('description');
        $image = get_the_post_thumbnail_url(null, 'og-image') ?: get_template_directory_uri() . '/assets/images/og-default.jpg';
    } else {
        $title = $site_name;
        $url   = $site_url;
        $desc  = get_bloginfo('description');
        $image = get_template_directory_uri() . '/assets/images/og-default.jpg';
    }
    ?>
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr(wp_strip_all_tags($desc)); ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:image" content="<?php echo esc_url($image); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr(wp_strip_all_tags($desc)); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php
}
add_action('wp_head', 'oheya360_ogp_tags');

// =========================================
// wp_head クリーンアップ
// =========================================
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// =========================================
// 抜粋の長さ
// =========================================
function oheya360_excerpt_length($length) {
    return 80;
}
add_filter('excerpt_length', 'oheya360_excerpt_length');

function oheya360_excerpt_more($more) {
    return '…';
}
add_filter('excerpt_more', 'oheya360_excerpt_more');

// =========================================
// AJAX: 制作事例フィルター
// =========================================
function oheya360_filter_works() {
    check_ajax_referer('oheya360_nonce', 'nonce');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = [
        'post_type'      => 'work',
        'posts_per_page' => 12,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if ($category && $category !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'work_category',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }

    $query = new WP_Query($args);
    $html  = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            include get_template_directory() . '/template-parts/card-work.php';
            $html .= ob_get_clean();
        }
        wp_reset_postdata();
    }

    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_filter_works', 'oheya360_filter_works');
add_action('wp_ajax_nopriv_filter_works', 'oheya360_filter_works');

// =========================================
// フロントページ設定用のページ判定
// =========================================
function oheya360_is_front_page() {
    return is_front_page() && is_page();
}

// nonce を JS へ渡す
function oheya360_localize_script() {
    wp_localize_script('oheya360-main', 'oheya360Ajax', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('oheya360_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'oheya360_localize_script');

// =========================================
// 構造化データ（JSON-LD）
// =========================================
function oheya360_structured_data() {
    if ( ! is_front_page() ) return;

    $data = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => 'LocalBusiness',
                '@id'         => 'https://oheya360.net/#business',
                'name'        => 'お部屋360°',
                'url'         => 'https://oheya360.net',
                'logo'        => get_template_directory_uri() . '/assets/images/og-default.jpg',
                'description' => 'Matterportによる3Dバーチャルツアー・デジタルツイン制作サービス。不動産・ホテル・店舗・施設など全国対応。最短3日納品。',
                'email'       => 'info@oheya360.net',
                'areaServed'  => '日本',
                'priceRange'  => '¥39,800〜',
                'serviceType' => '3Dバーチャルツアー制作・Matterport撮影・デジタルツイン構築',
            ],
            [
                '@type'       => 'WebSite',
                '@id'         => 'https://oheya360.net/#website',
                'url'         => 'https://oheya360.net',
                'name'        => 'お部屋360°',
                'inLanguage'  => 'ja',
                'publisher'   => [ '@id' => 'https://oheya360.net/#business' ],
            ],
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action('wp_head', 'oheya360_structured_data');

function oheya360_post_structured_data() {
    if ( ! is_single() ) return;

    $post_type = get_post_type();
    if ( $post_type === 'work' ) {
        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'CreativeWork',
            'name'     => get_the_title(),
            'url'      => get_permalink(),
            'image'    => get_the_post_thumbnail_url( get_the_ID(), 'og-image' ) ?: get_template_directory_uri() . '/assets/images/og-default.jpg',
        ];
    } else {
        $data = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => get_the_title(),
            'url'           => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified'  => get_the_modified_date('c'),
            'image'         => get_the_post_thumbnail_url( get_the_ID(), 'og-image' ) ?: get_template_directory_uri() . '/assets/images/og-default.jpg',
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => 'お部屋360°',
                'url'   => 'https://oheya360.net',
            ],
            'author'    => [
                '@type' => 'Organization',
                '@id'   => 'https://oheya360.net/#business',
            ],
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action('wp_head', 'oheya360_post_structured_data');
