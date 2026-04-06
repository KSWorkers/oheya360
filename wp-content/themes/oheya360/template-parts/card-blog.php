<?php
$cats = get_the_category();
$cat  = $cats ? $cats[0] : null;
?>
<a href="<?php the_permalink(); ?>" class="blog-card reveal">
  <div class="blog-card-thumb">
    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('blog-thumb'); ?>
    <?php else : ?>
      <div style="width:100%;height:100%;background:var(--color-surface);display:flex;align-items:center;justify-content:center;color:var(--color-text-muted);">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M2 15h10"/><path d="m9 18 3-3-3-3"/></svg>
      </div>
    <?php endif; ?>
  </div>
  <div class="blog-card-body">
    <div class="blog-card-meta">
      <span class="blog-card-date"><?php echo get_the_date('Y.m.d'); ?></span>
      <?php if ($cat) : ?>
      <span class="tag"><?php echo esc_html($cat->name); ?></span>
      <?php endif; ?>
    </div>
    <h3 class="blog-card-title"><?php the_title(); ?></h3>
    <p class="blog-card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
  </div>
</a>
