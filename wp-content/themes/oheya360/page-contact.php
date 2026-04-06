<?php
/**
 * Template Name: お問い合わせ
 */
get_header();
?>

<!-- Page Header -->
<div class="page-header">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <nav class="breadcrumb" aria-label="パンくずリスト">
        <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
        <span class="breadcrumb-sep">/</span>
        <span>お問い合わせ</span>
      </nav>
      <span class="section-label">Contact</span>
      <h1 class="section-title">お問い合わせ</h1>
      <p class="section-subtitle">ご質問・お見積もりなど、お気軽にご連絡ください。</p>
    </div>
  </div>
</div>

<!-- Contact Section -->
<section class="section section--dark">
  <div class="container">
    <div class="contact-grid">

      <!-- 左：情報 -->
      <div class="contact-info reveal">
        <h2>まずはお気軽に<br>ご相談ください</h2>
        <p>
          バーチャルツアーの制作についてのご質問、お見積もりのご依頼など、
          どんなことでもお問い合わせください。<br>
          通常1〜2営業日以内にご返信します。
        </p>

        <div class="contact-detail">
          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <?php echo oheya360_icon('mail'); ?>
            </div>
            <div>
              <div class="contact-detail-label">メール</div>
              <div class="contact-detail-value">info@oheya360.net</div>
            </div>
          </div>

          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <?php echo oheya360_icon('phone'); ?>
            </div>
            <div>
              <div class="contact-detail-label">電話</div>
              <div class="contact-detail-value">受付時間：平日 10:00〜18:00</div>
            </div>
          </div>

          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <?php echo oheya360_icon('location'); ?>
            </div>
            <div>
              <div class="contact-detail-label">対応エリア</div>
              <div class="contact-detail-value">全国対応（出張撮影可）</div>
            </div>
          </div>
        </div>

        <!-- 特徴 -->
        <div style="margin-top:3rem; padding:2rem; background:var(--color-bg-card); border:1px solid var(--color-border); border-radius:var(--radius-lg);">
          <h3 style="font-size:1rem; margin-bottom:1.25rem; color:var(--color-accent);">お問い合わせいただいた方へ</h3>
          <ul style="display:flex; flex-direction:column; gap:0.875rem;">
            <?php
            $benefits = [
              '見積もりは完全無料',
              '最短当日中にご返信',
              '営業電話は一切しません',
              'オンライン相談も対応',
            ];
            foreach ($benefits as $b) : ?>
            <li style="display:flex; gap:0.75rem; font-size:0.9rem; color:var(--color-text-secondary);">
              <span style="color:var(--color-accent); flex-shrink:0;"><?php echo oheya360_icon('check'); ?></span>
              <?php echo esc_html($b); ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- 右：フォーム -->
      <div class="contact-form-wrapper reveal reveal-delay-1">
        <?php if (shortcode_exists('contact-form-7')) : ?>
          <?php
          // Contact Form 7 のフォームIDを確認して変更してください
          $cf7_id = get_option('oheya360_cf7_id', 1);
          echo do_shortcode('[contact-form-7 id="' . intval($cf7_id) . '" title="お問い合わせ"]');
          ?>
        <?php else : ?>
        <!-- CF7未インストール時のHTMLフォーム（確認用） -->
        <form class="contact-form-fallback" method="post" action="#">
          <div class="form-group">
            <label class="form-label" for="name">お名前 <span class="required">*</span></label>
            <input class="form-input" type="text" id="name" name="name" placeholder="山田 太郎" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="company">会社名・屋号</label>
            <input class="form-input" type="text" id="company" name="company" placeholder="株式会社〇〇">
          </div>

          <div class="form-group">
            <label class="form-label" for="email">メールアドレス <span class="required">*</span></label>
            <input class="form-input" type="email" id="email" name="email" placeholder="info@example.com" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="phone">電話番号</label>
            <input class="form-input" type="tel" id="phone" name="phone" placeholder="090-0000-0000">
          </div>

          <div class="form-group">
            <label class="form-label" for="inquiry_type">お問い合わせ種別 <span class="required">*</span></label>
            <select class="form-select" id="inquiry_type" name="inquiry_type" required>
              <option value="">選択してください</option>
              <option value="estimate">お見積もり依頼</option>
              <option value="consultation">制作相談</option>
              <option value="service">サービス内容について</option>
              <option value="other">その他</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="space">撮影予定の空間（任意）</label>
            <input class="form-input" type="text" id="space" name="space" placeholder="例：マンション1LDK、商業施設 約500㎡">
          </div>

          <div class="form-group">
            <label class="form-label" for="message">お問い合わせ内容 <span class="required">*</span></label>
            <textarea class="form-textarea" id="message" name="message" placeholder="ご質問・ご要望をご記入ください" required></textarea>
          </div>

          <button type="submit" class="btn btn--primary form-submit">
            送信する
            <?php echo oheya360_icon('arrow-right'); ?>
          </button>

          <p style="margin-top:1rem; font-size:0.8125rem; color:var(--color-text-muted); text-align:center;">
            ※ Contact Form 7 プラグインをインストールするとこのフォームが有効化されます。
          </p>
        </form>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>
