<?php
$categories = get_the_terms(get_the_ID(), 'work_category');
$cat_name   = ($categories && !is_wp_error($categories)) ? $categories[0]->name : '';
?>
<a href="<?php the_permalink(); ?>" class="work-card reveal">
  <div class="work-card-thumb">
    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('work-thumb'); ?>
    <?php else : ?>
      <div style="width:100%;height:100%;background:var(--color-surface);display:flex;align-items:center;justify-content:center;color:var(--color-text-muted);">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m21 16-9 5-9-5V8l9-5 9 5v8Z"/></svg>
      </div>
    <?php endif; ?>
    <div class="work-card-thumb-overlay">
      <div class="work-card-play">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
      </div>
    </div>
  </div>
  <div class="work-card-body">
    <?php if ($cat_name) : ?>
    <div class="work-card-category"><?php echo esc_html($cat_name); ?></div>
    <?php endif; ?>
    <h3 class="work-card-title"><?php the_title(); ?></h3>
    <p class="work-card-desc"><?php echo esc_html(get_the_excerpt()); ?></p>
  </div>
</a>
