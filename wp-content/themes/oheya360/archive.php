<?php get_header(); ?>

<div class="page-header" id="main-content">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <nav class="breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
        <span class="breadcrumb-sep">/</span>
        <span><?php the_archive_title(); ?></span>
      </nav>
      <h1 class="section-title"><?php the_archive_title(); ?></h1>
    </div>
  </div>
</div>

<section class="section section--dark">
  <div class="container">
    <div class="blog-grid">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php include get_template_directory() . '/template-parts/card-blog.php'; ?>
        <?php endwhile; ?>
      <?php else : ?>
        <div style="grid-column:1/-1; text-align:center; padding:5rem 0; color:var(--color-text-muted);">
          <p>記事が見つかりません。</p>
        </div>
      <?php endif; ?>
    </div>
    <div class="pagination">
      <?php echo paginate_links(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
