<footer class="site-footer">
  <div class="container">
    <div class="footer-inner">

      <!-- ブランド -->
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
          oheya<span>360</span>
        </a>
        <p>Matterportを使ったデジタルツイン・バーチャルツアー制作で、あなたの空間を世界へ。</p>
      </div>

      <!-- サービス -->
      <div class="footer-col">
        <h4>サービス</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>">バーチャルツアー制作</a></li>
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>">デジタルツイン</a></li>
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>">3D空間計測</a></li>
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>">VR体験コンテンツ</a></li>
        </ul>
      </div>

      <!-- コンテンツ -->
      <div class="footer-col">
        <h4>コンテンツ</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/works/')); ?>">制作事例</a></li>
          <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">ブログ</a></li>
          <li><a href="<?php echo esc_url(home_url('/#process')); ?>">制作の流れ</a></li>
          <li><a href="<?php echo esc_url(home_url('/#faq')); ?>">よくある質問</a></li>
        </ul>
      </div>

      <!-- 会社情報 -->
      <div class="footer-col">
        <h4>会社情報</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
          <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">プライバシーポリシー</a></li>
          <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">利用規約</a></li>
        </ul>
      </div>

    </div>

    <!-- フッターボトム -->
    <div class="footer-bottom">
      <p class="footer-copy">
        &copy; <?php echo date('Y'); ?> <span>oheya360</span>. All rights reserved.
      </p>
      <div class="footer-social">
        <a href="#" class="social-link" aria-label="Twitter/X">
          <?php echo oheya360_icon('twitter'); ?>
        </a>
        <a href="#" class="social-link" aria-label="Instagram">
          <?php echo oheya360_icon('instagram'); ?>
        </a>
      </div>
    </div>

  </div>
</footer>

<!-- モバイル固定 CTA -->
<div class="mobile-cta-bar" id="mobile-cta-bar" aria-hidden="true">
  <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mobile-cta-btn">
    <?php echo oheya360_icon('mail'); ?>
    無料相談・お見積もり
  </a>
</div>

<?php wp_footer(); ?>
</body>
</html>
