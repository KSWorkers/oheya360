<?php get_header(); ?>

<!-- Page Header -->
<div class="page-header" id="main-content">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <nav class="breadcrumb" aria-label="パンくずリスト">
        <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
        <span class="breadcrumb-sep">/</span>
        <span>制作事例</span>
      </nav>
      <span class="section-label">Works</span>
      <h1 class="section-title">制作事例</h1>
      <p class="section-subtitle">Matterportで制作したバーチャルツアー・デジタルツインの実績をご覧ください。</p>
    </div>
  </div>
</div>

<!-- Works Archive -->
<section class="section section--dark">
  <div class="container">

    <!-- フィルター -->
    <?php
    $categories = get_terms(['taxonomy' => 'work_category', 'hide_empty' => true]);
    if (!empty($categories) && !is_wp_error($categories)) :
    ?>
    <div class="works-filter" id="works-filter">
      <button class="filter-btn active" data-category="all">すべて</button>
      <?php foreach ($categories as $cat) : ?>
      <button class="filter-btn" data-category="<?php echo esc_attr($cat->slug); ?>">
        <?php echo esc_html($cat->name); ?>
      </button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- グリッド -->
    <div class="works-grid" id="works-grid">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php include get_template_directory() . '/template-parts/card-work.php'; ?>
        <?php endwhile; ?>
      <?php else : ?>
        <div style="grid-column:1/-1; text-align:center; padding:5rem 0; color:var(--color-text-muted);">
          <p>まだ制作事例がありません。</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- ページネーション -->
    <div class="pagination">
      <?php
      echo paginate_links([
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
      ]);
      ?>
    </div>

  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner reveal">
      <span class="section-label">Contact</span>
      <h2 class="cta-title">あなたの空間もバーチャルツアーに</h2>
      <p class="cta-desc">お見積もり・ご相談は無料です。まずはお問い合わせください。</p>
      <div class="cta-actions">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary">
          お問い合わせはこちら
          <?php echo oheya360_icon('arrow-right'); ?>
        </a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
