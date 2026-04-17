# Notion → WordPress コンテンツ同期

oheya360.net の Notion コンテンツデータベースから WordPress へコンテンツを同期します。

## 事前確認

以下の環境変数が設定されていることを確認してください（`/Users/k.s.workers/Claude-cowork/oheya360/.env` を参照）:
- `NOTION_TOKEN`
- `NOTION_CONTENT_DB_ID`
- `NOTION_BLOG_DB_ID`
- `WP_SITE_URL`
- `WP_APP_USER`
- `WP_APP_PASSWORD`

## 同期手順

### Step 1: コンテンツDB からデータ取得

Notion MCP の `notion-fetch` または `notion-search` ツールを使い、NOTION_CONTENT_DB_ID のデータベースから `published = true` のレコードを全件取得する。

取得したレコードを以下の type ごとに分類する:
- `pricing` — 料金プラン
- `faq` — よくある質問
- `testimonial` — テスティモニアル
- `service` — サービス説明

### Step 2: 各 type を WP REST API に送信

取得したデータを type ごとに以下の形式に整形し、`POST {WP_SITE_URL}/wp-json/oheya360/v1/sync` に送信する。

認証ヘッダー: `Authorization: Basic {base64(WP_APP_USER:WP_APP_PASSWORD)}`

**pricing 用フォーマット:**
```json
{
  "type": "pricing",
  "items": [
    {
      "tier": "Light",
      "title": "ライト",
      "price": 39800,
      "featured": false,
      "badge": "",
      "features": ["撮影面積100㎡まで", "..."],
      "cta_text": "ライトプランで相談する",
      "cta_slug": "light",
      "cta_class": "btn--outline"
    }
  ]
}
```

**faq 用フォーマット:**
```json
{
  "type": "faq",
  "items": [
    { "q": "質問文", "a": "回答文", "order": 1 }
  ]
}
```

**testimonial 用フォーマット:**
```json
{
  "type": "testimonial",
  "items": [
    { "quote": "お客様の声", "name": "田中 様", "role": "不動産会社 代表", "industry": "不動産", "order": 1 }
  ]
}
```

**service 用フォーマット:**
```json
{
  "type": "service",
  "items": [
    { "icon": "cube", "title": "サービス名", "body": "説明文", "order": 1 }
  ]
}
```

各 type の送信後、Notion の該当レコードの `last_synced` フィールドを現在日時に更新する。

### Step 3: ブログDB から投稿を同期

NOTION_BLOG_DB_ID のデータベースから `status = publish` のレコードを全件取得する。

各レコードについて:
- `wp_post_id` が空 → `POST {WP_SITE_URL}/wp-json/wp/v2/posts` で新規作成
- `wp_post_id` に数値あり → `PUT {WP_SITE_URL}/wp-json/wp/v2/posts/{wp_post_id}` で更新

送信フォーマット:
```json
{
  "title": "記事タイトル",
  "content": "本文（HTML or Markdown）",
  "status": "publish",
  "date": "2026-04-09T00:00:00"
}
```

新規作成後、レスポンスの `id` を Notion の `wp_post_id` フィールドに記録する。

### Step 4: 結果サマリーを表示

全同期完了後、以下のサマリーを出力する:

```
✅ 同期完了 (2026-04-09 14:23:00)
  pricing:     3件更新
  faq:         5件更新
  testimonial: 3件更新
  service:     3件更新
  blog:        2件作成, 1件更新
```

エラーがあった場合:
```
⚠️ 一部エラー
  pricing: 3件更新
  faq: ❌ エラー — [エラー内容]（スキップして継続）
```

## エラー処理

- Notion API 接続失敗 → エラーメッセージを表示して中断。WordPress は変更しない。
- WP API 認証失敗（401/403）→ エラーメッセージを表示して中断。認証情報を確認するよう促す。
- 個別アイテムの失敗 → エラーをログに記録してスキップし、次のアイテムへ継続。
