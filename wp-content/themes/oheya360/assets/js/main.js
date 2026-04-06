/**
 * oheya360 - Main JavaScript
 */

(function () {
  'use strict';

  // =========================================
  // ヘッダー スクロール検知
  // =========================================
  const header = document.getElementById('site-header');

  if (header) {
    const onScroll = () => {
      if (window.scrollY > 40) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // 初期化
  }

  // =========================================
  // ハンバーガーメニュー
  // =========================================
  const hamburger   = document.getElementById('hamburger');
  const mobileMenu  = document.getElementById('mobile-menu');

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('open');
      hamburger.classList.toggle('active');
      hamburger.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // メニュー内リンクをクリックで閉じる
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });

    // Escキーで閉じる
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  // =========================================
  // スクロールリビール
  // =========================================
  const revealElements = document.querySelectorAll('.reveal');

  if (revealElements.length > 0) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );

    revealElements.forEach(el => observer.observe(el));
  }

  // =========================================
  // FAQ アコーディオン
  // =========================================
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    const answer   = item.querySelector('.faq-answer');
    const icon     = item.querySelector('.faq-icon');

    if (!question || !answer) return;

    question.addEventListener('click', () => {
      const isOpen = question.getAttribute('aria-expanded') === 'true';

      // 他のアイテムを閉じる
      faqItems.forEach(other => {
        if (other !== item) {
          const otherQ = other.querySelector('.faq-question');
          const otherA = other.querySelector('.faq-answer');
          const otherI = other.querySelector('.faq-icon');
          if (otherQ) otherQ.setAttribute('aria-expanded', 'false');
          if (otherA) otherA.style.display = 'none';
          if (otherI) otherI.style.transform = 'rotate(0deg)';
        }
      });

      // 現在のアイテムをトグル
      question.setAttribute('aria-expanded', !isOpen);
      answer.style.display  = isOpen ? 'none' : 'block';
      if (icon) icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });
  });

  // =========================================
  // 制作事例 AJAXフィルター
  // =========================================
  const filterBtns = document.querySelectorAll('.filter-btn');
  const worksGrid  = document.getElementById('works-grid');

  if (filterBtns.length > 0 && worksGrid && typeof oheya360Ajax !== 'undefined') {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // アクティブクラス切替
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.getAttribute('data-category');

        // ローディング表示
        worksGrid.style.opacity = '0.4';
        worksGrid.style.pointerEvents = 'none';

        // AJAX リクエスト
        const formData = new FormData();
        formData.append('action',   'filter_works');
        formData.append('nonce',    oheya360Ajax.nonce);
        formData.append('category', category);

        fetch(oheya360Ajax.ajaxUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              worksGrid.innerHTML = data.data.html;
              // 新しい要素にリビール適用
              worksGrid.querySelectorAll('.reveal').forEach(el => {
                el.classList.add('visible');
              });
            }
          })
          .catch(err => console.error('Filter error:', err))
          .finally(() => {
            worksGrid.style.opacity = '1';
            worksGrid.style.pointerEvents = '';
          });
      });
    });
  }

  // =========================================
  // スムーズスクロール（アンカーリンク）
  // =========================================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#') return;

      const target = document.querySelector(href);
      if (!target) return;

      e.preventDefault();
      const offset = 80; // ヘッダー高さ分
      const top = target.getBoundingClientRect().top + window.pageYOffset - offset;

      window.scrollTo({ top, behavior: 'smooth' });
    });
  });

  // =========================================
  // カウントアップアニメーション（ヒーロー統計）
  // =========================================
  const statNumbers = document.querySelectorAll('.hero-stat-number');

  if (statNumbers.length > 0) {
    const countObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el     = entry.target;
          const target = el.textContent;
          const num    = parseFloat(target.replace(/[^0-9.]/g, ''));
          const suffix = target.replace(/[0-9.]/g, '');

          if (isNaN(num)) return;

          let start   = 0;
          const steps = 60;
          const step  = num / steps;
          let current = 0;

          const timer = setInterval(() => {
            current += step;
            if (current >= num) {
              current = num;
              clearInterval(timer);
            }
            el.textContent = (Number.isInteger(num) ? Math.round(current) : current.toFixed(1)) + suffix;
          }, 16);

          countObserver.unobserve(el);
        });
      },
      { threshold: 0.5 }
    );

    statNumbers.forEach(el => countObserver.observe(el));
  }

  // =========================================
  // アクティブナビリンクのページ内検知
  // =========================================
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');

  if (sections.length > 0 && navLinks.length > 0) {
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            navLinks.forEach(link => {
              link.classList.remove('active');
              if (link.getAttribute('href') === '#' + entry.target.id) {
                link.classList.add('active');
              }
            });
          }
        });
      },
      { threshold: 0.4 }
    );

    sections.forEach(s => sectionObserver.observe(s));
  }

  // =========================================
  // Matterport ファサード
  // =========================================
  const facade = document.getElementById('matterport-facade');

  if (facade) {
    const keyHandler = (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        activateFacade();
      }
    };

    const activateFacade = () => {
      const src = facade.getAttribute('data-src');
      if (!src) return;

      const iframe = document.createElement('iframe');
      iframe.src = src;
      iframe.className = 'hero-preview-iframe';
      iframe.allow = 'xr-spatial-tracking; fullscreen';
      // Note: camera/microphone/vr omitted intentionally — facade is display-only;
      // these permissions are not required for the standard Matterport viewer embed.
      iframe.setAttribute('allowfullscreen', '');
      iframe.setAttribute('title', 'Matterportバーチャルツアーデモ');

      facade.innerHTML = '';
      facade.appendChild(iframe);
      facade.style.cursor = 'default';
      facade.removeAttribute('role');
      facade.removeAttribute('tabindex');
      facade.removeAttribute('aria-label');
      facade.removeEventListener('click', activateFacade);
      facade.removeEventListener('keydown', keyHandler);
    };

    facade.addEventListener('click', activateFacade);
    facade.addEventListener('keydown', keyHandler);
  }

})();
