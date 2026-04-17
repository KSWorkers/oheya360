# oheya360 週次リサーチ

oheya360.net のマーケティングリサーチを実行し、結果を Notion リサーチDB に保存します。

## 事前確認

`/Users/k.s.workers/Claude-cowork/oheya360/.env` の以下を確認:
- `NOTION_TOKEN`
- `NOTION_RESEARCH_DB_ID`

## 実行手順

### 1. SEOキーワード調査

以下のキーワードで WebSearch を実行し、oheya360.net の検索順位と上位競合を確認する:
- 「Matterport 撮影 東京」
- 「バーチャルツアー 不動産」
- 「3D内見 サービス」
- 「Matterport 業者」

各キーワードについて:
- oheya360.net の表示順位（1〜20位、または圏外）
- 上位3サイトのドメイン・ページタイトル
- 上位サイトとの差別化ポイント

### 2. 競合サイト動向調査

以下の手順で競合サイトを調査する:
1. Notion リサーチDB（NOTION_RESEARCH_DB_ID）から type=`competitor` の最新レコードを取得し、競合URL一覧を確認する
2. レコードがなければ WebSearch で「Matterport 撮影 業者 日本」の上位5サイトを対象にする

各サイトを WebFetch で取得し、以下を確認:
- 価格変更・新プランの追加
- 新サービス・機能の追加
- コンテンツ戦略の変化（ブログ更新頻度、新コンテンツ）

### 3. SNSトレンド調査

以下のキーワードで WebSearch を実行し、SNS上の最新トレンドを確認する:
- 「不動産 3D内見 2026」
- 「バーチャルツアー トレンド」
- 「Matterport 活用事例」

確認事項:
- 話題になっているコンテンツ形式（動画・記事・投稿）
- 注目されている活用シーン（業種）
- 新しいキーワードやハッシュタグ

### 4. ブログネタ提案

上記1〜3の調査結果を統合し、oheya360.net のブログ記事として有望なネタを5〜10本提案する。

各提案に含める内容:
- 記事タイトル案（SEO を意識した具体的なタイトル）
- 想定キーワード（メインKW + サブKW）
- 記事概要（3〜5文）
- 優先度（高/中/低）

## 出力先

Notion リサーチDB（NOTION_RESEARCH_DB_ID）に以下の4レコードを追加する:

**SEO レポート** (type: `seo`):
- title: `{YYYY-MM-DD} SEOキーワード調査`
- report: キーワード別の順位と分析
- action_items: 改善が必要なキーワード・対策
- created_date: 実行日

**競合レポート** (type: `competitor`):
- title: `{YYYY-MM-DD} 競合サイト動向`
- report: 各競合の変化点
- action_items: oheya360.net で取り入れるべき施策
- created_date: 実行日

**SNSトレンドレポート** (type: `sns`):
- title: `{YYYY-MM-DD} SNSトレンド`
- report: 注目トレンドと事例
- action_items: 活用できるトレンドとコンテンツ案
- created_date: 実行日

**ブログネタ提案** (type: `blog-ideas`):
- title: `{YYYY-MM-DD} ブログネタ提案`
- report: 5〜10本のタイトル・概要一覧
- action_items: 優先度高の記事から着手
- created_date: 実行日
