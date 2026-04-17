#!/usr/bin/env python3
"""Notion → WordPress 同期スクリプト"""

import os
import sys
import json
import base64
import ssl
import urllib.request
import urllib.error
from datetime import datetime
from pathlib import Path


def _ssl_context() -> ssl.SSLContext:
    """macOS python.org ビルドの証明書問題を回避する SSL コンテキストを返す。"""
    try:
        import certifi
        return ssl.create_default_context(cafile=certifi.where())
    except ImportError:
        pass
    ctx = ssl.create_default_context()
    # macOS: /etc/ssl/cert.pem にシステム証明書がある場合はそちらを使う
    if os.path.exists("/etc/ssl/cert.pem"):
        ctx.load_verify_locations("/etc/ssl/cert.pem")
    return ctx


_SSL_CTX = _ssl_context()


def load_env(env_path: str):
    path = Path(env_path)
    if not path.exists():
        return
    for line in path.read_text().splitlines():
        line = line.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, _, val = line.partition("=")
        os.environ.setdefault(key.strip(), val.strip())


def require_env(*keys):
    missing = [k for k in keys if not os.environ.get(k)]
    if missing:
        print(f"❌ 環境変数が未設定です: {', '.join(missing)}")
        print("   .env ファイルを確認してください。")
        sys.exit(1)


def notion_request(path: str, method: str = "GET", body: dict | None = None) -> dict:
    token = os.environ["NOTION_TOKEN"]
    url = f"https://api.notion.com/v1/{path}"
    data = json.dumps(body).encode() if body is not None else None
    req = urllib.request.Request(
        url,
        data=data,
        method=method,
        headers={
            "Authorization": f"Bearer {token}",
            "Notion-Version": "2022-06-28",
            "Content-Type": "application/json",
        },
    )
    try:
        with urllib.request.urlopen(req, timeout=30, context=_SSL_CTX) as resp:
            return json.loads(resp.read())
    except urllib.error.HTTPError as e:
        body_text = e.read().decode()
        raise RuntimeError(f"Notion API エラー {e.code}: {body_text}") from e


def notion_query_all(database_id: str, filter_body: dict) -> list:
    results = []
    cursor = None
    while True:
        body = {"filter": filter_body, "page_size": 100}
        if cursor:
            body["start_cursor"] = cursor
        data = notion_request(f"databases/{database_id}/query", "POST", body)
        results.extend(data.get("results", []))
        if not data.get("has_more"):
            break
        cursor = data.get("next_cursor")
    return results


def notion_update_page(page_id: str, properties: dict):
    notion_request(f"pages/{page_id}", "PATCH", {"properties": properties})


def get_plain_text(prop: dict) -> str:
    if not prop:
        return ""
    ptype = prop.get("type", "")
    if ptype == "title":
        items = prop.get("title", [])
    elif ptype == "rich_text":
        items = prop.get("rich_text", [])
    else:
        return ""
    return "".join(t.get("plain_text", "") for t in items)


def get_select(prop: dict) -> str:
    if not prop:
        return ""
    sel = prop.get("select") or {}
    return sel.get("name", "")


def get_number(prop: dict) -> int | float | None:
    if not prop:
        return None
    return prop.get("number")


def get_checkbox(prop: dict) -> bool:
    if not prop:
        return False
    return prop.get("checkbox", False)


def get_multi_select(prop: dict) -> list[str]:
    if not prop:
        return []
    return [s.get("name", "") for s in prop.get("multi_select", [])]


def wp_auth_header() -> str:
    user = os.environ["WP_APP_USER"]
    pwd = os.environ["WP_APP_PASSWORD"]
    token = base64.b64encode(f"{user}:{pwd}".encode()).decode()
    return f"Basic {token}"


def wp_request(path: str, method: str = "GET", body: dict | None = None) -> dict:
    base = os.environ["WP_SITE_URL"].rstrip("/")
    url = f"{base}/wp-json/{path}"
    data = json.dumps(body).encode() if body is not None else None
    req = urllib.request.Request(
        url,
        data=data,
        method=method,
        headers={
            "Authorization": wp_auth_header(),
            "Content-Type": "application/json",
        },
    )
    try:
        with urllib.request.urlopen(req, timeout=30, context=_SSL_CTX) as resp:
            return json.loads(resp.read())
    except urllib.error.HTTPError as e:
        body_text = e.read().decode()
        raise RuntimeError(f"WP API エラー {e.code}: {body_text}") from e


def sync_content_type(type_name: str, items: list, counts: dict):
    if not items:
        print(f"  {type_name}: 0件（スキップ）")
        return
    try:
        wp_request("oheya360/v1/sync", "POST", {"type": type_name, "items": items})
        counts[type_name] = len(items)
        print(f"  {type_name}: {len(items)}件更新 ✅")
    except RuntimeError as e:
        print(f"  {type_name}: ❌ エラー — {e}")
        counts[type_name] = f"エラー"


# ─── pricing ───────────────────────────────────────────────────────────────

def build_pricing(page: dict) -> dict:
    p = page["properties"]
    features_raw = get_plain_text(p.get("features", {}))
    features = [f.strip() for f in features_raw.split("\n") if f.strip()]
    return {
        "tier": get_plain_text(p.get("tier", {})) or get_select(p.get("tier", {})),
        "title": get_plain_text(p.get("title", p.get("Name", p.get("name", {})))),
        "price": get_number(p.get("price", {})) or 0,
        "featured": get_checkbox(p.get("featured", {})),
        "badge": get_plain_text(p.get("badge", {})),
        "features": features,
        "cta_text": get_plain_text(p.get("cta_text", {})),
        "cta_slug": get_plain_text(p.get("cta_slug", {})),
        "cta_class": get_plain_text(p.get("cta_class", {})),
    }


def build_faq(page: dict) -> dict:
    p = page["properties"]
    return {
        "q": get_plain_text(p.get("q", p.get("question", {}))),
        "a": get_plain_text(p.get("a", p.get("answer", {}))),
        "order": get_number(p.get("order", {})) or 0,
    }


def build_testimonial(page: dict) -> dict:
    p = page["properties"]
    return {
        "quote": get_plain_text(p.get("quote", {})),
        "name": get_plain_text(p.get("name", p.get("Name", {}))),
        "role": get_plain_text(p.get("role", {})),
        "industry": get_plain_text(p.get("industry", {})),
        "order": get_number(p.get("order", {})) or 0,
    }


def build_service(page: dict) -> dict:
    p = page["properties"]
    return {
        "icon": get_plain_text(p.get("icon", {})),
        "title": get_plain_text(p.get("title", p.get("Name", p.get("name", {})))),
        "body": get_plain_text(p.get("body", p.get("description", {}))),
        "order": get_number(p.get("order", {})) or 0,
    }


BUILDERS = {
    "pricing": build_pricing,
    "faq": build_faq,
    "testimonial": build_testimonial,
    "service": build_service,
}


def step1_fetch_content(db_id: str) -> dict[str, list]:
    print("\n【Step 1】コンテンツDB からデータ取得中...")
    try:
        records = notion_query_all(db_id, {"property": "published", "checkbox": {"equals": True}})
    except RuntimeError as e:
        print(f"❌ Notion API 接続失敗: {e}")
        sys.exit(1)

    print(f"  取得: {len(records)}件")
    classified: dict[str, list] = {t: [] for t in BUILDERS}

    for rec in records:
        props = rec.get("properties", {})
        rtype_prop = props.get("type", {})
        rtype = get_select(rtype_prop) or get_plain_text(rtype_prop)
        if rtype in BUILDERS:
            try:
                item = BUILDERS[rtype](rec)
                classified[rtype].append((rec["id"], item))
            except Exception as e:
                print(f"  ⚠ レコード {rec['id'][:8]} 変換エラー: {e}")
        else:
            print(f"  ⚠ 不明な type '{rtype}' — スキップ")

    for t, items in classified.items():
        print(f"  {t}: {len(items)}件")
    return classified


def step2_sync_content(classified: dict[str, list], counts: dict):
    print("\n【Step 2】WordPress へ送信中...")
    now_iso = datetime.now().isoformat()

    for type_name, page_items in classified.items():
        if not page_items:
            print(f"  {type_name}: 0件（スキップ）")
            continue

        page_ids = [pid for pid, _ in page_items]
        items = [item for _, item in page_items]

        try:
            wp_request("oheya360/v1/sync", "POST", {"type": type_name, "items": items})
            counts[type_name] = len(items)
            print(f"  {type_name}: {len(items)}件更新 ✅")
        except RuntimeError as e:
            print(f"  {type_name}: ❌ エラー — {e}（スキップして継続）")
            counts[type_name] = "エラー"
            continue

        # last_synced を更新
        for pid in page_ids:
            try:
                notion_update_page(pid, {
                    "last_synced": {"date": {"start": now_iso}}
                })
            except Exception as e:
                print(f"    ⚠ last_synced 更新失敗 ({pid[:8]}): {e}")


def step3_sync_blog(blog_db_id: str, counts: dict):
    print("\n【Step 3】ブログDB から投稿同期中...")
    try:
        records = notion_query_all(blog_db_id, {"property": "status", "select": {"equals": "publish"}})
    except RuntimeError as e:
        print(f"❌ Notion Blog DB 接続失敗: {e}")
        counts["blog_create"] = "エラー"
        counts["blog_update"] = "エラー"
        return

    print(f"  取得: {len(records)}件")
    created = updated = errors = 0

    for rec in records:
        props = rec.get("properties", {})
        title = get_plain_text(props.get("title", props.get("Title", props.get("Name", {}))))
        content = get_plain_text(props.get("content", props.get("body", {})))
        date_prop = props.get("date", props.get("published_at", {}))
        pub_date = ""
        if date_prop and date_prop.get("type") == "date":
            d = date_prop.get("date") or {}
            pub_date = d.get("start", "")

        wp_id_prop = props.get("wp_post_id", {})
        wp_id = get_number(wp_id_prop)

        post_data = {
            "title": title,
            "content": content,
            "status": "publish",
        }
        if pub_date:
            post_data["date"] = pub_date if "T" in pub_date else f"{pub_date}T00:00:00"

        try:
            if wp_id:
                wp_request(f"wp/v2/posts/{int(wp_id)}", "PUT", post_data)
                updated += 1
            else:
                resp = wp_request("wp/v2/posts", "POST", post_data)
                new_id = resp.get("id")
                if new_id:
                    notion_update_page(rec["id"], {
                        "wp_post_id": {"number": new_id}
                    })
                created += 1
        except RuntimeError as e:
            print(f"  ⚠ 投稿エラー '{title[:20]}': {e}")
            errors += 1

    counts["blog_create"] = created
    counts["blog_update"] = updated
    if errors:
        counts["blog_errors"] = errors
    print(f"  作成: {created}件, 更新: {updated}件" + (f", エラー: {errors}件" if errors else "") + " ✅")


def main():
    env_file = Path(__file__).parent / ".env"
    load_env(str(env_file))

    require_env(
        "NOTION_TOKEN",
        "NOTION_CONTENT_DB_ID",
        "NOTION_BLOG_DB_ID",
        "WP_SITE_URL",
        "WP_APP_USER",
        "WP_APP_PASSWORD",
    )

    print("=" * 50)
    print("  Notion → WordPress 同期開始")
    print(f"  {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    print("=" * 50)

    # WP 認証確認
    try:
        wp_request("wp/v2/users/me", "GET")
    except RuntimeError as e:
        print(f"❌ WordPress 認証失敗: {e}")
        print("   WP_APP_USER / WP_APP_PASSWORD を確認してください。")
        sys.exit(1)

    counts = {}
    classified = step1_fetch_content(os.environ["NOTION_CONTENT_DB_ID"])
    step2_sync_content(classified, counts)
    step3_sync_blog(os.environ["NOTION_BLOG_DB_ID"], counts)

    # サマリー
    now_str = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    has_error = any(v == "エラー" for v in counts.values())
    print()
    if has_error:
        print(f"⚠️  一部エラー ({now_str})")
    else:
        print(f"✅ 同期完了 ({now_str})")

    type_labels = {"pricing": "pricing", "faq": "faq", "testimonial": "testimonial", "service": "service"}
    for t, label in type_labels.items():
        v = counts.get(t, 0)
        mark = "❌" if v == "エラー" else ""
        print(f"  {label:<12}: {v}件更新 {mark}")

    bc = counts.get("blog_create", 0)
    bu = counts.get("blog_update", 0)
    be = counts.get("blog_errors", 0)
    blog_str = f"{bc}件作成, {bu}件更新"
    if be:
        blog_str += f", {be}件エラー"
    print(f"  blog        : {blog_str}")


if __name__ == "__main__":
    main()
