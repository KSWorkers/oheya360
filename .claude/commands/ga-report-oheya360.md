# oheya360 月次 GA 分析レポート

Google Analytics（oheya360.net）の前月データを分析し、結果と改善提案を Notion に保存します。

## 事前確認

`/Users/k.s.workers/Claude-cowork/oheya360/.env` の以下を確認:
- `NOTION_TOKEN`
- `NOTION_RESEARCH_DB_ID`
- `GA_PROPERTY_ID` （Google Analytics プロパティ ID: G-XXXXXXXXXX）

Google Analytics Data API へのアクセス権限が設定されていることを確認。

## 実行手順

### 1. 期間設定

前月の開始日〜終了日を計算する（例: 今日が 2026-04-09 なら 2026-03-01〜2026-03-31）。

### 2. GA データ取得

Google Analytics Reporting API または Google Analytics 管理画面（`https://analytics.google.com/`）から以下のデータを取得する:

**流入データ:**
- チャネル別セッション数（Organic / Direct / Referral / Social / Email）
- 前月比（%）

**コンバージョン:**
- お問い合わせフォーム送信数（contact page view or form submission）
- コンバージョン率

**上位流入キーワード（Organic）:**
- 上位10キーワードとクリック数・表示回数・CTR・平均順位

**ページ別パフォーマンス:**
- PV上位10ページ
- 直帰率が高いページ上位5件（要改善候補）

**デバイス別:**
- モバイル / デスクトップ / タブレット の比率

### 3. 分析と改善提案

取得データをもとに以下を分析:
- 前月比で改善 / 悪化した指標
- 直帰率が高いページの原因仮説と改善案
- コンバージョン率向上のための具体的な施策（3〜5件）

## 出力先

Notion リサーチDB（NOTION_RESEARCH_DB_ID）に1レコード追加:

- title: `{YYYY年MM月} GAレポート`
- type: `ga-report`
- report: 数値データと分析内容（Markdown 表形式推奨）
- action_items: 改善施策3〜5件（優先度順）
- created_date: 実行日
