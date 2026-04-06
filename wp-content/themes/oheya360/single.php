<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post-hero">
  <div class="page-header-bg"></div>
  <div class="container container--narrow">
    <nav class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
      <span class="breadcrumb-sep">/</span>
      <a href="<?php echo esc_url(home_url('/blog/')); ?>">ブログ</a>
      <span class="breadcrumb-sep">/</span>
      <span><?php the_title(); ?></span>
    </nav>

    <div class="post-meta">
      <span class="post-date"><?php echo get_the_date('Y.m.d'); ?></span>
      <?php
      $cats = get_the_category();
      if ($cats) : foreach ($cats as $cat) : ?>
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="tag">
          <?php echo esc_html($cat->name); ?>
        </a>
      <?php endforeach; endif; ?>
    </div>

    <h1 class="post-title"><?php the_title(); ?></h1>

    <div style="display:flex; align-items:center; gap:0.75rem; margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid var(--color-border);">
      <span style="font-size:0.875rem; color:var(--color-text-muted);">読了時間：<?php echo oheya360_reading_time(); ?></span>
    </div>
  </div>
</div>

<?php if (has_post_thumbnail()) : ?>
<div class="container container--narrow" style="margin-bottom:var(--spacing-lg);">
  <div class="post-thumb">
    <?php the_post_thumbnail('full'); ?>
  </div>
</div>
<?php endif; ?>

<article class="section section--dark" style="padding-top:0;">
  <div class="container">
    <div class="post-content reveal">
      <?php the_content(); ?>
    </div>

    <!-- タグ -->
    <?php $tags = get_the_tags(); if ($tags) : ?>
    <div style="max-width:720px; margin:3rem auto 0; display:flex; gap:0.5rem; flex-wrap:wrap;">
      <?php foreach ($tags as $tag) : ?>
      <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag"># <?php echo esc_html($tag->name); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- 前後の記事 -->
    <div style="max-width:720px; margin:4rem auto 0; display:grid; grid-template-columns:1fr 1fr; gap:1rem; border-top:1px solid var(--color-border); padding-top:2rem;">
      <div>
        <?php $prev = get_previous_post(); if ($prev) : ?>
        <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" style="display:block; padding:1.25rem; background:var(--color-bg-card); border:1px solid var(--color-border); border-radius:var(--radius-md); transition:border-color var(--transition);" onmouseover="this.style.borderColor='var(--color-accent)'" onmouseout="this.style.borderColor='var(--color-border)'">
          <span style="font-size:0.75rem; color:var(--color-text-muted); display:block; margin-bottom:0.5rem;">← 前の記事</span>
          <span style="font-size:0.875rem; font-weight:600;"><?php echo esc_html(get_the_title($prev->ID)); ?></span>
        </a>
        <?php endif; ?>
      </div>
      <div>
        <?php $next = get_next_post(); if ($next) : ?>
        <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" style="display:block; padding:1.25rem; background:var(--color-bg-card); border:1px solid var(--color-border); border-radius:var(--radius-md); text-align:right; transition:border-color var(--transition);" onmouseover="this.style.borderColor='var(--color-accent)'" onmouseout="this.style.borderColor='var(--color-border)'">
          <span style="font-size:0.75rem; color:var(--color-text-muted); display:block; margin-bottom:0.5rem;">次の記事 →</span>
          <span style="font-size:0.875rem; font-weight:600;"><?php echo esc_html(get_the_title($next->ID)); ?></span>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</article>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner reveal">
      <h2 class="cta-title">バーチャルツアーについてご相談ください</h2>
      <p class="cta-desc">無料でお見積もり・ご相談を承っています。</p>
      <div class="cta-actions">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary">
          お問い合わせはこちら
          <?php echo oheya360_icon('arrow-right'); ?>
        </a>
      </div>
    </div>
  </div>
</section>

<?php endwhile; ?>
<?php get_footer(); ?>
