<?php
// ブログ一覧ページ（WordPressで「投稿ページ」に設定されたページ用）
get_header();
?>

<div class="page-header">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <nav class="breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
        <span class="breadcrumb-sep">/</span>
        <span>ブログ</span>
      </nav>
      <span class="section-label">Blog</span>
      <h1 class="section-title">ブログ</h1>
      <p class="section-subtitle">Matterport・バーチャルツアーに関する最新情報をお届けします。</p>
    </div>
  </div>
</div>

<section class="section section--dark">
  <div class="container">

    <?php if (have_posts()) : ?>

      <?php if (!is_paged()) : ?>
        <?php
        // フィーチャード記事（1ページ目のみ最初の記事を大きく表示）
        the_post();
        ?>
        <div class="blog-featured reveal">
          <a href="<?php the_permalink(); ?>" class="blog-featured-card">
            <div class="blog-featured-thumb">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('blog-thumb'); ?>
              <?php else : ?>
                <div style="width:100%;height:100%;background:var(--color-surface);display:flex;align-items:center;justify-content:center;color:var(--color-text-muted);font-size:0.875rem;">No Image</div>
              <?php endif; ?>
            </div>
            <div class="blog-featured-body">
              <span class="blog-featured-label">Featured</span>
              <?php
              $cats = get_the_category();
              if ($cats) {
                echo '<span class="tag" style="margin-bottom:1rem;display:inline-block;">' . esc_html($cats[0]->name) . '</span>';
              }
              ?>
              <h2 class="blog-featured-title"><?php the_title(); ?></h2>
              <p class="blog-featured-excerpt"><?php the_excerpt(); ?></p>
              <div class="blog-featured-meta">
                <span class="blog-card-date"><?php echo get_the_date('Y.m.d'); ?></span>
                <span style="color:var(--color-text-muted);font-size:0.8125rem;"><?php echo oheya360_reading_time(get_the_ID()); ?></span>
              </div>
              <div style="margin-top:1.5rem;">
                <span class="btn btn--ghost">
                  続きを読む <?php echo oheya360_icon('arrow-right'); ?>
                </span>
              </div>
            </div>
          </a>
        </div>
      <?php endif; ?>

      <?php if (have_posts()) : ?>
        <div class="blog-grid-label">
          <?php echo is_paged() ? 'すべての記事' : '最新記事'; ?>
        </div>
        <div class="blog-grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php include get_template_directory() . '/template-parts/card-blog.php'; ?>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>

    <?php else : ?>
      <div style="text-align:center; padding:5rem 0; color:var(--color-text-muted);">
        <p>まだ記事がありません。</p>
      </div>
    <?php endif; ?>

    <div class="pagination">
      <?php echo paginate_links(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
    </div>

  </div>
</section>

<?php get_footer(); ?>
