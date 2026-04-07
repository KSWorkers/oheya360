<?php get_header(); ?>

<section class="section" id="main-content" tabindex="-1" style="min-height:70vh; display:flex; align-items:center;">
  <div class="container text-center">
    <div style="font-family:var(--font-en); font-size:8rem; font-weight:800; color:var(--color-border); line-height:1; margin-bottom:2rem;">404</div>
    <h1 style="font-size:2rem; margin-bottom:1rem;">ページが見つかりません</h1>
    <p style="color:var(--color-text-muted); margin-bottom:3rem;">お探しのページは移動または削除された可能性があります。</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
      トップページへ戻る
      <?php echo oheya360_icon('arrow-right'); ?>
    </a>
  </div>
</section>

<?php get_footer(); ?>
