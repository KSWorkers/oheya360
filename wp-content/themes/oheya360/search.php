<?php get_header(); ?>

<div class="page-header" id="main-content" tabindex="-1">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <h1 class="section-title">
        「<?php echo esc_html(get_search_query()); ?>」の検索結果
      </h1>
      <p class="section-subtitle"><?php echo found_posts(); ?>件見つかりました</p>
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
          <p>検索結果が見つかりませんでした。</p>
        </div>
      <?php endif; ?>
    </div>
    <div class="pagination">
      <?php echo paginate_links(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
