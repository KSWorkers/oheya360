# oheya360 WordPress カスタムテーマ

Matterportを使ったデジタルツイン・バーチャルツアー制作サービスのための完全カスタムWordPressテーマ。

---

## ファイル構成

```
oheya360/
├── style.css              # テーマ定義・全スタイル
├── functions.php          # テーマ機能・カスタム投稿タイプ等
├── index.php              # トップページ（フロントページ）
├── header.php             # ヘッダー
├── footer.php             # フッター
├── page.php               # 固定ページ（デフォルト）
├── page-contact.php       # お問い合わせページ（テンプレート）
├── single.php             # ブログ記事詳細
├── single-work.php        # 制作事例詳細
├── archive.php            # ブログアーカイブ
├── archive-work.php       # 制作事例アーカイブ
├── home.php               # ブログ一覧（投稿ページ設定時）
├── search.php             # 検索結果
├── 404.php                # 404エラーページ
├── template-parts/
│   ├── card-work.php      # 制作事例カード
│   └── card-blog.php      # ブログカード
└── assets/
    ├── css/
    │   └── cf7.css        # Contact Form 7 スタイル上書き
    ├── js/
    │   └── main.js        # メインJavaScript
    └── images/
        └── og-default.jpg # OGP画像（別途用意）
```

---

## 導入手順

### 1. テーマのアップロード
`oheya360` フォルダごとFTPまたはWordPress管理画面でアップロード。
パス：`/wp-content/themes/oheya360/`

### 2. テーマの有効化
`外観 > テーマ` から「oheya360」を有効化。

### 3. 必須プラグインのインストール
| プラグイン | 役割 |
|-----------|------|
| **Contact Form 7** | お問い合わせフォーム |
| **Yoast SEO** | SEO対策 |
| **UpdraftPlus** | バックアップ |

### 4. お問い合わせフォームの設定
1. Contact Form 7 でフォームを作成
2. フォームID（数字）を `wp-admin > 設定` の任意の箇所でメモ
3. `page-contact.php` の以下を編集：
   ```php
   $cf7_id = get_option('oheya360_cf7_id', 1); // ← IDに変更
   ```
   またはWordPress管理画面の `設定 > oheya360_cf7_id` オプションを追加。

### 5. 固定ページの作成
| ページタイトル | テンプレート | スラッグ |
|--------------|-------------|---------|
| ホーム | デフォルト | （フロントページに設定） |
| お問い合わせ | お問い合わせ | contact |
| プライバシーポリシー | デフォルト | privacy-policy |

### 6. ページ設定
`設定 > 表示設定` にて：
- 「ホームページの表示」→「固定ページ」
- ホームページ：「ホーム」を選択
- 投稿ページ：「ブログ」ページを作成して選択

### 7. パーマリンクの設定
`設定 > パーマリンク` → 「投稿名」を選択して保存。

### 8. ナビゲーションメニュー
`外観 > メニュー` でメニューを作成し「プライマリーメニュー」に割り当て。

### 9. 制作事例の登録
管理画面に「制作事例」メニューが追加されています。
各事例の編集画面で：
- タイトル・本文・アイキャッチ画像を設定
- **Matterport URL**（`制作事例詳細` ボックス）に埋め込みURLを入力
- **業種カテゴリー**を設定（不動産・ホテル・店舗 など）

### 10. OGP画像
`assets/images/og-default.jpg` に1200×630pxの画像を配置。

---

## カスタマイズ

---

### 1. カラーの変更
**ファイル：** `style.css`（上部の `:root` ブロック）

```css
:root {
  --color-bg:           #0a0a0a;   /* ページ全体の背景色 */
  --color-bg-secondary: #111111;   /* セクション背景（少し明るめ） */
  --color-bg-card:      #161616;   /* カード・ボックスの背景 */
  --color-accent:       #00c8ff;   /* メインアクセントカラー（シアン） */
  --color-gradient: linear-gradient(135deg, #00c8ff 0%, #0066ff 100%);
                                   /* ボタン・グラデーション */
}
```

> **例：アクセントカラーをグリーンに変更する場合**
> ```css
> --color-accent:   #00e87a;
> --color-gradient: linear-gradient(135deg, #00e87a 0%, #00a854 100%);
> --color-accent-glow: rgba(0, 232, 122, 0.15);
> ```

---

### 2. フォントの変更
**ファイル：** `style.css`（`:root` ブロック）と `functions.php`（Google Fonts URL）

`style.css` で使用フォントを変更：
```css
:root {
  --font-sans: 'Noto Sans JP', 'Inter', sans-serif; /* 日本語フォント */
  --font-en:   'Inter', sans-serif;                 /* 英字フォント */
}
```

`functions.php` の Google Fonts URL も合わせて変更：
```php
wp_enqueue_style(
    'google-fonts',
    'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;800&family=Inter:wght@400;500;600;700;800&display=swap',
    ...
);
```

---

### 3. ロゴ・サイト名の変更
**ファイル：** `header.php` と `footer.php`

```html
<!-- header.php / footer.php 共通 -->
<a href="..." class="site-logo">
  oheya<span>360</span>   ← テキストを変更
</a>
```

画像ロゴに変更する場合：
```html
<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg"
       alt="サイト名" width="140" height="36">
</a>
```

---

### 4. ヒーローセクションの変更
**ファイル：** `index.php`（上部 `<!-- HERO -->` セクション）

| 変更箇所 | 場所 |
|---------|------|
| キャッチコピー | `.hero-title` 内のテキスト |
| サブテキスト | `.hero-desc` 内のテキスト |
| ボタンラベル | `.hero-actions` 内の `<a>` テキスト |
| 統計数値（実績数・満足度など） | `.hero-stat-number` のテキスト |
| 統計ラベル | `.hero-stat-label` のテキスト |

```html
<!-- キャッチコピー例 -->
<h1 class="hero-title">
  空間を、<br>
  <span class="accent">デジタルで体験</span>へ。  ← ここを変更
</h1>

<!-- 統計数値例 -->
<div class="hero-stat-number">150+</div>   ← 実績数
<div class="hero-stat-label">制作実績</div>
```

---

### 5. Matterportデモ埋め込みの変更
**ファイル：** `index.php`（`<!-- MATTERPORT DEMO -->` セクション）

```html
<iframe
  src="https://my.matterport.com/show/?m=SxQL3iGyvpk&play=1&qs=1&lang=ja"
  <!--                                      ↑ ここをご自身のモデルIDに変更 -->
```

Matterport管理画面の「共有 > 埋め込みリンク」から取得したURLの
`m=` 以降の文字列がモデルIDです。

---

### 6. サービス内容の変更
**ファイル：** `index.php`（`<!-- SERVICES -->` セクション）

各 `.service-card` ブロックを編集：
```html
<div class="service-card">
  <div class="service-icon">
    <?php echo oheya360_icon('cube'); ?>  ← アイコン名を変更
  </div>
  <h3>3Dバーチャルツアー制作</h3>         ← サービス名
  <p>説明テキスト...</p>                   ← 説明文
</div>
```

使用できるアイコン名（`functions.php` の `oheya360_icon()` 参照）：
`cube` / `camera` / `share` / `building` / `check` / `mail` / `phone` / `location`

---

### 7. 制作の流れの変更
**ファイル：** `index.php`（`<!-- PROCESS -->` セクション）

```php
$reasons = [
  '最短3日の納品スピード',        ← テキストを自由に変更
  'Matterport認定スキャナー保有',
  '全国対応・出張撮影可',
  ...
];
```

各ステップ（`process-item`）のタイトルと説明文を直接編集。

---

### 8. よくある質問（FAQ）の変更
**ファイル：** `index.php`（`<!-- FAQ -->` セクション）

```php
$faqs = [
  ['q' => '質問文', 'a' => '回答文'],   ← 追加・変更・削除
  ['q' => '質問文', 'a' => '回答文'],
  ...
];
```

配列に要素を追加・削除するだけで質問数を変更できます。

---

### 9. お問い合わせページの情報変更
**ファイル：** `page-contact.php`

| 変更箇所 | 場所 |
|---------|------|
| メールアドレス | `info@oheya360.net` を検索して変更 |
| 受付時間 | `平日 10:00〜18:00` を変更 |
| 対応エリア | `全国対応（出張撮影可）` を変更 |
| 特徴リスト | `$benefits` 配列を編集 |

---

### 10. フッターの変更
**ファイル：** `footer.php`

| 変更箇所 | 場所 |
|---------|------|
| キャッチフレーズ | `.footer-brand p` のテキスト |
| サービスリンク | `.footer-col` 内の `<a>` リスト |
| SNSリンク | `.social-link` の `href="#"` にURLを設定 |
| コピーライト | `.footer-copy` のテキスト |

SNSリンクの設定例：
```html
<a href="https://twitter.com/oheya360" class="social-link" aria-label="Twitter/X">
<a href="https://instagram.com/oheya360" class="social-link" aria-label="Instagram">
```

---

### 11. Contact Form 7 フォームIDの変更
**ファイル：** `page-contact.php`

```php
$cf7_id = get_option('oheya360_cf7_id', 1);
//                                        ↑ デフォルト値を実際のフォームIDに変更
```

または `wp-config.php` に定数として追加する方法：
```php
// wp-config.php
define('OHEYA360_CF7_ID', 5); // 実際のIDに変更
```

`page-contact.php` 側も合わせて変更：
```php
$cf7_id = defined('OHEYA360_CF7_ID') ? OHEYA360_CF7_ID : 1;
```

---

### 12. OGP・SNSシェア画像の変更
**ファイル：** `assets/images/og-default.jpg`

- サイズ：**1200 × 630px**（推奨）
- 形式：JPG または PNG
- ファイル名は `og-default.jpg` のまま配置するだけでOK

ページごとのOGP画像は、各投稿・固定ページの「アイキャッチ画像」が自動で使用されます。

---

## よくある質問

**Q: 制作事例が表示されない**
A: `設定 > パーマリンク` を一度保存し直してください。

**Q: お問い合わせフォームが表示されない**
A: Contact Form 7 プラグインをインストール・有効化してください。
   プラグインがない場合はHTMLフォーム（送信機能なし）が表示されます。

**Q: モバイルでメニューが開かない**
A: キャッシュプラグインのキャッシュをクリアしてください。
