# 📝말덕노트（Maldeok Note）- Backend API

> 韓国語の表現を「誰が・いつ・どこで使ったか」と一緒に記録する、コレクション型学習アプリのバックエンドAPI

---

## 📖 プロジェクト概要

韓国語を学ぶ中で「推しや友達が実際に使っていた表現を、思い出ごと残したい」という課題から生まれたアプリです。

単語帳アプリとは異なり、**誰がどんな場面で使ったか**まで記録できるのが特徴です。登録数に応じてバッジが解放される実績システムも備えており、コレクションする楽しさも取り入れています。

---

## ⚙️ 技術スタック

| 項目 | 内容 |
|------|------|
| 言語 | PHP 8.4 |
| フレームワーク | Laravel 12 |
| 認証 | JWT（firebase/php-jwt） |
| DB（開発） | SQLite |
| 実行環境 | Docker（Laravel Sail） |

---

## 🗂 主な機能

- **認証** - 会員登録 / ログイン / ログアウト
- **表現CRUD** - 表現の登録・一覧・詳細・編集・削除
- **お気に入り** - 表現のお気に入りON/OFF
- **検索** - フレーズ・意味によるキーワード検索
- **絞り込み** - 話者カテゴリ・お気に入りでフィルタリング
- **並び替え** - 登録日・聞いた日での並び替え
- **バッジ** - 登録数に応じた実績バッジの解放（データ層実装済み）

---

## 🌐 API エンドポイント

### 認証

| メソッド | パス | 説明 |
|----------|------|------|
| POST | `/api/register` | 会員登録 |
| POST | `/api/login` | ログイン |
| POST | `/api/logout` | ログアウト |

### 話者カテゴリ

| メソッド | パス | 説明 |
|----------|------|------|
| GET | `/api/speaker-categories` | 一覧取得 |
| POST | `/api/speaker-categories` | 作成 |
| PATCH | `/api/speaker-categories/{id}` | 更新 |
| DELETE | `/api/speaker-categories/{id}` | 削除 |

### 表現

| メソッド | パス | 説明 |
|----------|------|------|
| GET | `/api/expressions` | 一覧取得（検索・絞り込み・並び替え対応） |
| POST | `/api/expressions` | 登録 |
| GET | `/api/expressions/{id}` | 詳細取得 |
| PATCH | `/api/expressions/{id}` | 更新 |
| DELETE | `/api/expressions/{id}` | 削除 |
| PATCH | `/api/expressions/{id}/favorite` | お気に入りトグル |

#### クエリパラメータ（一覧取得）

| パラメータ | 説明 | 例 |
|------------|------|----|
| `search` | キーワード検索（phrase / meaning） | `?search=진짜` |
| `speaker_category_id` | 話者カテゴリで絞り込み | `?speaker_category_id=1` |
| `is_favorite` | お気に入りで絞り込み | `?is_favorite=true` |
| `sort` | 並び替え | `?sort=newest` / `oldest` / `heard_at_desc` / `heard_at_asc` |

### バッジ

| メソッド | パス | 説明 |
|----------|------|------|
| GET | `/api/badges` | 全バッジ一覧 |
| GET | `/api/badges/my` | 自分の獲得バッジ一覧 |

---

## 🚀 ローカル環境セットアップ

### 前提条件

- Docker Desktop がインストール済みであること

### 手順

```bash
# 1. リポジトリをクローン
git clone https://github.com/maldeok-note-project/maldeok-note-backend-laravel.git
cd maldeok-note-backend-laravel

# 2. 依存パッケージをインストール
composer install

# 3. 環境変数ファイルを作成
cp .env.example .env

# 4. アプリケーションキーを生成
./vendor/bin/sail artisan key:generate

# 5. Sailを起動
./vendor/bin/sail up -d

# 6. マイグレーション＆シード実行
./vendor/bin/sail artisan migrate --seed
```

起動後、`http://localhost` でAPIにアクセスできます。

---

## 🏗 アーキテクチャ

```
Route → Controller → Service → Model
```

- **Controller** - リクエストの受け取りとレスポンスの返却のみ担当
- **Service** - ビジネスロジック（実際の処理内容）を担当
- **Model** - データベースとのやり取りを担当

### 認証フロー

JWTトークンをAuthorizationヘッダーで受け取り、`JwtAuthMiddleware`で検証します。認証済みユーザーは `$request->attributes->get('auth_user')` で取得します。

---

## 🏅 バッジ一覧

| バッジ名 | 解放条件 |
|----------|----------|
| 입덕 | 表現を1個登録 |
| 찐팬 予備軍 | 表現を10個登録 |
| 현장러 | 表現を30個登録 |
| 고인물 | 表現を50個登録 |
| 진짜 말덕 | 表現を100個登録 |

---

## 📁 ブランチ戦略

`main` ← `develop` ← `feature/xxx`

1機能 = 1ブランチで開発し、PRレビューを経てマージします。

---

## 📝 ライセンス

このプロジェクトはポートフォリオ目的で開発されています。
