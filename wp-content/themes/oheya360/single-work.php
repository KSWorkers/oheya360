<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>

<?php
$matterport_url = get_post_meta(get_the_ID(), '_matterport_url', true);
$client_name    = get_post_meta(get_the_ID(), '_client_name', true);
$location       = get_post_meta(get_the_ID(), '_location', true);
$year           = get_post_meta(get_the_ID(), '_year', true);
$categories     = get_the_terms(get_the_ID(), 'work_category');
?>

<!-- Work Hero -->
<div class="work-hero" id="main-content" tabindex="-1">
  <div class="page-header-bg"></div>
  <div class="container">
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
      <span class="breadcrumb-sep">/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('work')); ?>">制作事例</a>
      <span class="breadcrumb-sep">/</span>
      <span><?php the_title(); ?></span>
    </nav>

    <div class="work-hero-meta">
      <?php if ($categories && !is_wp_error($categories)) : ?>
        <?php foreach ($categories as $cat) : ?>
          <span class="tag"><?php echo esc_html($cat->name); ?></span>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <h1 class="work-hero-title"><?php the_title(); ?></h1>
  </div>
</div>

<!-- Matterport Embed -->
<?php if ($matterport_url) : ?>
<section class="work-embed-section">
  <div class="container">
    <div class="matterport-frame-wrapper reveal">
      <iframe
        class="matterport-embed"
        src="<?php echo esc_url(oheya360_get_matterport_embed($matterport_url)); ?>"
        allowfullscreen
        allow="xr-spatial-tracking"
        loading="lazy"
        title="<?php the_title_attribute(); ?> バーチャルツアー"
      ></iframe>
    </div>
  </div>
</section>
<?php elseif (has_post_thumbnail()) : ?>
<section class="work-embed-section">
  <div class="container">
    <div style="border-radius:var(--radius-lg); overflow:hidden; aspect-ratio:16/9;">
      <?php the_post_thumbnail('full', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Work Info -->
<section class="section section--dark">
  <div class="container">
    <div class="work-info-grid">
      <div class="work-description reveal">
        <?php the_content(); ?>
      </div>

      <div class="work-meta-list reveal reveal-delay-1">
        <?php if ($client_name) : ?>
        <div class="work-meta-item">
          <div class="work-meta-label">クライアント</div>
          <div class="work-meta-value"><?php echo esc_html($client_name); ?></div>
        </div>
        <?php endif; ?>

        <?php if ($categories && !is_wp_error($categories)) : ?>
        <div class="work-meta-item">
          <div class="work-meta-label">業種</div>
          <div class="work-meta-value"><?php echo esc_html(implode(', ', wp_list_pluck($categories, 'name'))); ?></div>
        </div>
        <?php endif; ?>

        <?php if ($location) : ?>
        <div class="work-meta-item">
          <div class="work-meta-label">所在地</div>
          <div class="work-meta-value"><?php echo esc_html($location); ?></div>
        </div>
        <?php endif; ?>

        <?php if ($year) : ?>
        <div class="work-meta-item">
          <div class="work-meta-label">制作年</div>
          <div class="work-meta-value"><?php echo esc_html($year); ?></div>
        </div>
        <?php endif; ?>

        <div class="work-meta-item">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary" style="width:100%; justify-content:center; margin-top:0.5rem;">
            同様のご相談はこちら
            <?php echo oheya360_icon('arrow-right'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 関連事例 -->
<?php
$related = new WP_Query([
  'post_type'      => 'work',
  'posts_per_page' => 3,
  'post__not_in'   => [get_the_ID()],
  'orderby'        => 'rand',
]);

if ($related->have_posts()) :
?>
<section class="section section--surface">
  <div class="container">
    <div class="reveal" style="margin-bottom:var(--spacing-md);">
      <span class="section-label">Related Works</span>
      <h2 style="font-size:1.75rem; font-weight:700;">関連する制作事例</h2>
    </div>
    <div class="works-grid">
      <?php while ($related->have_posts()) : $related->the_post(); ?>
        <?php include get_template_directory() . '/template-parts/card-work.php'; ?>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>
