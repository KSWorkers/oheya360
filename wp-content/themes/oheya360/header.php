<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
// Yoast SEO が無効の場合のみ description を出力（OGP は functions.php の oheya360_ogp_tags で対応済）
if ( ! defined('WPSEO_VERSION') ) :
    if ( is_singular() && ! is_front_page() ) {
        $raw_excerpt = get_post_field( 'post_excerpt', get_the_ID() );
        $raw_content = $raw_excerpt ?: get_post_field( 'post_content', get_the_ID() );
        $desc        = wp_trim_words( strip_tags( $raw_content ), 30, '...' );
    } else {
        $desc = 'Matterportによる3Dバーチャルツアー・デジタルツイン制作。不動産・ホテル・店舗など全国対応。最短3日納品・¥39,800〜。';
    }
?>
  <meta name="description" content="<?php echo esc_attr($desc); ?>">
<?php endif; ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">メインコンテンツへスキップ</a>

<header class="site-header" id="site-header">
  <div class="header-inner">

    <!-- ロゴ -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
      oheya<span>360</span>
    </a>

    <!-- デスクトップナビ -->
    <nav class="site-nav" role="navigation" aria-label="メインナビゲーション">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>">ホーム</a>
      <a href="<?php echo esc_url(home_url('/works/')); ?>" class="nav-link <?php echo is_post_type_archive('work') || get_post_type() === 'work' ? 'active' : ''; ?>">制作事例</a>
      <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="nav-link <?php echo is_home() || is_single() && get_post_type() === 'post' ? 'active' : ''; ?>">ブログ</a>
      <a href="<?php echo esc_url(home_url('/#pricing')); ?>" class="nav-link">料金</a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary nav-cta">
        お問い合わせ
        <?php echo oheya360_icon('arrow-right'); ?>
      </a>
    </nav>

    <!-- ハンバーガー -->
    <button class="hamburger" id="hamburger" aria-label="メニューを開く" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</header>

<!-- モバイルメニュー -->
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-label="モバイルメニュー">
  <nav>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">ホーム</a>
    <a href="<?php echo esc_url(home_url('/works/')); ?>" class="nav-link">制作事例</a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="nav-link">ブログ</a>
    <a href="<?php echo esc_url(home_url('/#pricing')); ?>" class="nav-link">料金</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary">お問い合わせ</a>
  </nav>
</div>
