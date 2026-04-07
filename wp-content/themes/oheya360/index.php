<?php get_header(); ?>

<!-- =========================================
   HERO (v2: split layout)
   ========================================= -->
<section class="hero" id="main-content" tabindex="-1">
  <div class="hero-bg">
    <div class="hero-grid-lines"></div>
    <div class="hero-bg-overlay"></div>
  </div>

  <div class="hero-content">
    <div class="hero-split">

      <!-- 左：コピー -->
      <div class="hero-left">
        <div class="hero-eyebrow">
          <span class="hero-eyebrow-dot"></span>
          <span class="hero-eyebrow-text">Powered by Matterport</span>
        </div>

        <h1 class="hero-title">
          空間を、<br>
          <span class="accent">デジタルで体験</span>へ。
        </h1>

        <p class="hero-desc">
          Matterportによる3Dバーチャルツアー・デジタルツイン制作で、
          あなたの空間を時間・場所を問わず世界中に届けます。
        </p>

        <div class="hero-actions">
          <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn btn--primary">
            制作事例を見る
            <?php echo oheya360_icon('arrow-right'); ?>
          </a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">
            無料相談する
          </a>
        </div>

        <div class="hero-stats">
          <div class="hero-stat">
            <div class="hero-stat-number">150+</div>
            <div class="hero-stat-label">制作実績</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-number">98%</div>
            <div class="hero-stat-label">顧客満足度</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-number">3日</div>
            <div class="hero-stat-label">最短納品</div>
          </div>
        </div>
      </div>

      <!-- 右：Matterport プレビュー -->
      <div class="hero-right">
        <div class="hero-preview">
          <div class="hero-preview-badge">
            <span class="hero-eyebrow-dot"></span>
            LIVE DEMO
          </div>
          <div class="matterport-facade" id="matterport-facade"
               data-src="https://my.matterport.com/show/?m=SxQL3iGyvpk&play=1&qs=1&lang=ja"
               role="button"
               tabindex="0"
               aria-label="Matterportバーチャルツアーデモを開始する">
            <img
              src="https://my.matterport.com/api/v1/player/models/SxQL3iGyvpk/thumb?width=800&dpr=1&disable_cookies=0"
              alt="Matterportバーチャルツアーデモのサムネイル"
              class="matterport-facade-thumb"
              width="800"
              height="500"
              loading="eager"
              fetchpriority="high"
            >
            <div class="matterport-facade-overlay">
              <div class="matterport-play-btn" aria-hidden="true">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                  <circle cx="32" cy="32" r="32" fill="rgba(0,0,0,0.6)"/>
                  <polygon points="26,20 26,44 48,32" fill="#ffffff"/>
                </svg>
                <span>バーチャルツアーを体験</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="hero-scroll">
    <span class="hero-scroll-text">Scroll</span>
    <span class="hero-scroll-line"></span>
  </div>
</section>

<!-- =========================================
   SERVICES
   ========================================= -->
<section class="section section--surface" id="services">
  <div class="container">
    <div class="services-header reveal">
      <span class="section-label">Services</span>
      <h2 class="section-title">提供サービス</h2>
      <p class="section-subtitle">Matterportの専門知識と最新機材で、あらゆる空間のデジタル化に対応します。</p>
    </div>

    <div class="grid-3">
      <div class="service-card reveal reveal-delay-1">
        <div class="service-icon">
          <?php echo oheya360_icon('cube'); ?>
        </div>
        <h3>3Dバーチャルツアー制作</h3>
        <p>Matterportカメラによる高精度な360°撮影。不動産・ホテル・店舗など、あらゆる空間をインタラクティブなバーチャルツアーに変換します。</p>
      </div>

      <div class="service-card reveal reveal-delay-2">
        <div class="service-icon">
          <?php echo oheya360_icon('building'); ?>
        </div>
        <h3>デジタルツイン構築</h3>
        <p>実空間の正確な3Dデータを取得し、施設管理・設計・BIMへの活用を可能にするデジタルツインを構築します。</p>
      </div>

      <div class="service-card reveal reveal-delay-3">
        <div class="service-icon">
          <?php echo oheya360_icon('share'); ?>
        </div>
        <h3>コンテンツ配信・埋め込み</h3>
        <p>制作したバーチャルツアーをWebサイトやSNSへ最適化して配信。QRコードやリンクでシームレスな体験を提供します。</p>
      </div>
    </div>
  </div>
</section>

<!-- =========================================
   WORKS
   ========================================= -->
<section class="section section--dark" id="works">
  <div class="container">
    <div class="reveal" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:var(--spacing-lg); flex-wrap:wrap; gap:1rem;">
      <div>
        <span class="section-label">Works</span>
        <h2 class="section-title" style="margin-bottom:0;">制作事例</h2>
      </div>
      <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn btn--ghost">
        すべて見る <?php echo oheya360_icon('arrow-right'); ?>
      </a>
    </div>

    <div class="works-grid">
      <?php
      $works = new WP_Query([
        'post_type'      => 'work',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);

      if ($works->have_posts()) :
        while ($works->have_posts()) : $works->the_post();
          include get_template_directory() . '/template-parts/card-work.php';
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <!-- プレースホルダー（事例登録前） -->
        <?php for ($i = 1; $i <= 3; $i++) : ?>
        <div class="work-card reveal reveal-delay-<?php echo $i; ?>">
          <div class="work-card-thumb" style="background:var(--color-surface);">
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--color-text-muted);font-size:0.875rem;">
              Coming Soon
            </div>
          </div>
          <div class="work-card-body">
            <div class="work-card-category">不動産</div>
            <h3 class="work-card-title">サンプル物件 <?php echo $i; ?></h3>
            <p class="work-card-desc">制作事例を登録するとここに表示されます。</p>
          </div>
        </div>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- =========================================
   PROCESS
   ========================================= -->
<section class="section section--surface" id="process">
  <div class="container">
    <div class="reveal" style="margin-bottom:var(--spacing-lg);">
      <span class="section-label">Process</span>
      <h2 class="section-title">制作の流れ</h2>
      <p class="section-subtitle">お問い合わせから納品まで、丁寧にサポートします。</p>
    </div>

    <div class="grid-2" style="gap:var(--spacing-lg); align-items:start;">
      <div>
        <div class="process-list">
          <div class="process-item reveal">
            <div class="process-number">01</div>
            <div class="process-content">
              <h3>お問い合わせ・ヒアリング</h3>
              <p>撮影する空間の用途・目的・ご要望をヒアリングします。オンライン・対面どちらでも対応可能です。</p>
            </div>
          </div>
          <div class="process-item reveal reveal-delay-1">
            <div class="process-number">02</div>
            <div class="process-content">
              <h3>お見積もり・ご提案</h3>
              <p>空間の広さや用途に合わせた最適なプランをご提案。費用・スケジュールを明示します。</p>
            </div>
          </div>
          <div class="process-item reveal reveal-delay-2">
            <div class="process-number">03</div>
            <div class="process-content">
              <h3>現地撮影</h3>
              <p>Matterportカメラで現地を3D撮影。準備から撮影完了まで、スムーズに進行します。</p>
            </div>
          </div>
          <div class="process-item reveal reveal-delay-3">
            <div class="process-number">04</div>
            <div class="process-content">
              <h3>データ処理・制作</h3>
              <p>撮影データをクラウドで処理し、高品質な3Dモデルを生成。品質チェックを経て仕上げます。</p>
            </div>
          </div>
          <div class="process-item reveal reveal-delay-4">
            <div class="process-number">05</div>
            <div class="process-content">
              <h3>納品・活用サポート</h3>
              <p>完成データの埋め込みコードをご提供。Webサイトへの組み込みや活用方法もサポートします。</p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal reveal-delay-2" style="position:sticky; top:120px;">
        <div style="background:var(--color-bg-card); border:1px solid var(--color-border); border-radius:var(--radius-lg); padding:2.5rem;">
          <h3 style="font-size:1.25rem; margin-bottom:1.5rem;">よく選ばれる理由</h3>
          <ul style="display:flex; flex-direction:column; gap:1rem;">
            <?php
            $reasons = [
              '最短3日の納品スピード',
              'Matterport認定スキャナー保有',
              '全国対応・出張撮影可',
              '撮影後の修正・再撮影にも対応',
              'Webサイト埋め込みまで一括サポート',
            ];
            foreach ($reasons as $reason) : ?>
            <li style="display:flex; gap:0.75rem; align-items:flex-start; font-size:0.9375rem;">
              <span style="color:var(--color-accent); flex-shrink:0; margin-top:2px;">
                <?php echo oheya360_icon('check'); ?>
              </span>
              <?php echo esc_html($reason); ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <div style="margin-top:2rem;">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary" style="width:100%; justify-content:center;">
              無料相談はこちら
              <?php echo oheya360_icon('arrow-right'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =========================================
   BLOG
   ========================================= -->
<section class="section section--dark" id="blog">
  <div class="container">
    <div class="reveal" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:var(--spacing-lg); flex-wrap:wrap; gap:1rem;">
      <div>
        <span class="section-label">Blog</span>
        <h2 class="section-title" style="margin-bottom:0;">最新記事</h2>
      </div>
      <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn--ghost">
        すべて見る <?php echo oheya360_icon('arrow-right'); ?>
      </a>
    </div>

    <div class="blog-grid">
      <?php
      $blog_posts = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
      ]);

      if ($blog_posts->have_posts()) :
        while ($blog_posts->have_posts()) : $blog_posts->the_post();
          include get_template_directory() . '/template-parts/card-blog.php';
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <?php for ($i = 1; $i <= 3; $i++) : ?>
        <div class="blog-card reveal reveal-delay-<?php echo $i; ?>">
          <div class="blog-card-thumb" style="display:flex;align-items:center;justify-content:center;background:var(--color-surface);">
            <span style="color:var(--color-text-muted); font-size:0.875rem;">Coming Soon</span>
          </div>
          <div class="blog-card-body">
            <div class="blog-card-meta">
              <span class="blog-card-date"><?php echo date('Y.m.d'); ?></span>
              <span class="tag">Matterport</span>
            </div>
            <h3 class="blog-card-title">ブログ記事を投稿するとここに表示されます</h3>
            <p class="blog-card-excerpt">WordPress管理画面から記事を投稿してください。</p>
          </div>
        </div>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- =========================================
   TESTIMONIALS
   ========================================= -->
<section class="section section--surface" id="testimonials">
  <div class="container">
    <div class="text-center reveal" style="margin-bottom:var(--spacing-lg);">
      <span class="section-label">Testimonials</span>
      <h2 class="section-title">お客様の声</h2>
      <p class="section-subtitle" style="margin:0 auto;">実際にご利用いただいたお客様からのフィードバック</p>
    </div>

    <div class="testimonials-grid">
      <?php
      $testimonials = [
        [
          'quote'    => 'Matterportの撮影から納品まで非常にスピーディーで、物件のオンライン内見率が大幅に向上しました。問い合わせ数も増加し、費用対効果が高いと感じています。',
          'name'     => '田中 様',
          'role'     => '不動産会社 代表',
          'industry' => '不動産',
        ],
        [
          'quote'    => '店舗のバーチャルツアーをSNSで公開したところ、遠方からの来店客が増えました。撮影当日の対応も丁寧で、スタッフも安心して任せられました。',
          'name'     => '山田 様',
          'role'     => '飲食店オーナー',
          'industry' => '飲食',
        ],
        [
          'quote'    => '採用活動でオフィスツアーを活用しています。候補者がオフィスの雰囲気を事前に把握できるため、入社後のギャップが減り定着率が改善されました。',
          'name'     => '鈴木 様',
          'role'     => '人事部長',
          'industry' => 'IT企業',
        ],
      ];
      foreach ( $testimonials as $i => $t ) :
      ?>
      <div class="testimonial-card reveal reveal-delay-<?php echo $i + 1; ?>">
        <div class="testimonial-quote">
          <svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
            <path d="M9.5 14C7 14 5 16 5 18.5C5 21 7 23 9.5 23C12 23 14 21 14 18.5C14 16 12 14 9.5 14ZM9.5 14C9.5 10 12 7 16 6M22.5 14C20 14 18 16 18 18.5C18 21 20 23 22.5 23C25 23 27 21 27 18.5C27 16 25 14 22.5 14ZM22.5 14C22.5 10 25 7 29 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <p class="testimonial-text"><?php echo esc_html($t['quote']); ?></p>
        <div class="testimonial-author">
          <div class="testimonial-avatar" aria-hidden="true">
            <?php echo mb_substr($t['name'], 0, 1); ?>
          </div>
          <div>
            <div class="testimonial-name"><?php echo esc_html($t['name']); ?></div>
            <div class="testimonial-role"><?php echo esc_html($t['role']); ?></div>
          </div>
          <span class="tag" style="margin-left:auto;"><?php echo esc_html($t['industry']); ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =========================================
   PRICING (v2)
   ========================================= -->
<section class="section section--dark" id="pricing">
  <div class="container">
    <div class="text-center reveal" style="margin-bottom:var(--spacing-lg);">
      <span class="section-label">Pricing</span>
      <h2 class="section-title">料金プラン</h2>
      <p class="section-subtitle" style="margin:0 auto;">空間の規模や用途に合わせて3つのプランをご用意。<br>まずはお気軽にご相談ください。</p>
    </div>

    <div class="pricing-grid">

      <!-- ライト -->
      <div class="pricing-card reveal reveal-delay-1">
        <div class="pricing-tier">Light</div>
        <div class="pricing-name">ライト</div>
        <div class="pricing-price">
          <span class="pricing-price-from">税別</span>
          <span class="pricing-price-amount">¥39,800</span>
          <span class="pricing-price-unit">〜</span>
        </div>
        <ul class="pricing-features">
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            撮影面積100㎡まで
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            Matterport 3Dモデル作成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            埋め込みコード納品
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            QRコード生成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            納品後30日サポート
          </li>
        </ul>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline" style="width:100%;justify-content:center;">
          お問い合わせ
        </a>
      </div>

      <!-- スタンダード（おすすめ） -->
      <div class="pricing-card pricing-card--featured reveal reveal-delay-2">
        <div class="pricing-badge">人気No.1</div>
        <div class="pricing-tier">Standard</div>
        <div class="pricing-name">スタンダード</div>
        <div class="pricing-price">
          <span class="pricing-price-from">税別</span>
          <span class="pricing-price-amount">¥79,800</span>
          <span class="pricing-price-unit">〜</span>
        </div>
        <ul class="pricing-features">
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            撮影面積300㎡まで
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            Matterport 3Dモデル作成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            埋め込みコード納品
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            平面図・間取り図作成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            QRコード生成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            サイト埋め込みサポート
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            納品後60日サポート
          </li>
        </ul>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary" style="width:100%;justify-content:center;">
          お問い合わせ
          <?php echo oheya360_icon('arrow-right'); ?>
        </a>
      </div>

      <!-- プレミアム -->
      <div class="pricing-card reveal reveal-delay-3">
        <div class="pricing-tier">Premium</div>
        <div class="pricing-name">プレミアム</div>
        <div class="pricing-price">
          <span class="pricing-price-amount" style="font-size:1.75rem;">要見積もり</span>
        </div>
        <ul class="pricing-features">
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            撮影面積300㎡以上
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            Matterport 3Dモデル作成
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            複数拠点・大規模施設対応
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            BIM・CAD連携データ
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            Googleストリートビュー登録
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            専任担当者によるサポート
          </li>
          <li class="pricing-feature">
            <span class="pricing-feature-icon"><?php echo oheya360_icon('check'); ?></span>
            長期サポート・保守契約
          </li>
        </ul>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline" style="width:100%;justify-content:center;">
          無料相談する
        </a>
      </div>

    </div>

    <p class="pricing-note text-center">
      ※ 価格はすべて税別表示です。撮影エリアの広さや出張費・追加オプションにより変動する場合があります。詳しくはお問い合わせください。
    </p>
  </div>
</section>

<!-- =========================================
   FAQ
   ========================================= -->
<section class="section section--surface" id="faq">
  <div class="container container--narrow">
    <div class="text-center reveal" style="margin-bottom:var(--spacing-lg);">
      <span class="section-label">FAQ</span>
      <h2 class="section-title">よくある質問</h2>
    </div>

    <div id="faq-list" style="display:flex; flex-direction:column; gap:1rem;">
      <?php
      $faqs = [
        ['q' => 'どのような空間に対応していますか？', 'a' => '不動産（マンション・一戸建て・オフィス）、ホテル・旅館、飲食店・小売店、医療施設、工場・倉庫など、あらゆる空間に対応しています。まずはお気軽にご相談ください。'],
        ['q' => '撮影から納品までどのくらいかかりますか？', 'a' => '撮影後、通常3〜5営業日でデータが完成します。お急ぎの場合は最短翌日納品も対応可能です（別途料金）。'],
        ['q' => '料金はどのように決まりますか？', 'a' => '空間の広さ（㎡数）や撮影箇所数によって異なります。まずはお問い合わせフォームからご連絡いただければ、無料でお見積もりいたします。'],
        ['q' => '遠方でも対応してもらえますか？', 'a' => '全国対応しています。交通費・出張費が別途かかる場合がありますが、詳細はお問い合わせください。'],
        ['q' => 'Matterportのデータはどのように活用できますか？', 'a' => 'Webサイトへの埋め込み、QRコードによる案内、間取り図や平面図の自動生成、Googleストリートビューとの連携など、多彩な活用が可能です。'],
      ];

      foreach ($faqs as $i => $faq) :
      ?>
      <div class="faq-item reveal" style="background:var(--color-bg-card); border:1px solid var(--color-border); border-radius:var(--radius-md); overflow:hidden;">
        <button class="faq-question" aria-expanded="false"
          style="width:100%; display:flex; justify-content:space-between; align-items:center; padding:1.5rem; text-align:left; font-size:1rem; font-weight:600; color:var(--color-text); background:none; border:none; cursor:pointer; gap:1rem; font-family:var(--font-sans);">
          <?php echo esc_html($faq['q']); ?>
          <span class="faq-icon" style="flex-shrink:0; color:var(--color-accent); transition:transform 0.3s ease;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
          </span>
        </button>
        <div class="faq-answer">
          <?php echo esc_html($faq['a']); ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =========================================
   CTA
   ========================================= -->
<section class="cta-section">
  <div class="container">
    <div class="cta-bg"></div>
    <div class="cta-inner reveal">
      <span class="section-label">Contact</span>
      <h2 class="cta-title">まずは無料でご相談ください</h2>
      <p class="cta-desc">お見積もり・ご質問は無料です。お気軽にお問い合わせください。</p>
      <div class="cta-actions">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary">
          お問い合わせはこちら
          <?php echo oheya360_icon('arrow-right'); ?>
        </a>
        <a href="<?php echo esc_url(home_url('/works/')); ?>" class="btn btn--outline">
          制作事例を見る
        </a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
