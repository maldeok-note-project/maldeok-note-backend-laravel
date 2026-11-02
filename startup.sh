#!/bin/sh
# Azure App Service(PHP 8.x / Linux)の起動時に実行するスクリプト
# Azure のスタートアップコマンドに「sh /home/site/wwwroot/startup.sh」を設定して使う

# アプリが置かれている場所
APP_DIR=/home/site/wwwroot

# ① nginx の設定を、リポジトリの default ファイルで上書きする
#    (Laravel の public フォルダを入口にするため)
cp "$APP_DIR/default" /etc/nginx/sites-available/default

# ② Laravel が書き込みに使うフォルダを作る
#    GitHub Actions の成果物アップロードで隠しファイル(.gitignore)が除外され、
#    空フォルダがデプロイのたびに消えるため、起動時に毎回作り直す
#    -p:途中のフォルダもまとめて作る。すでにあってもエラーにしない
mkdir -p "$APP_DIR/storage/framework/cache/data" \
         "$APP_DIR/storage/framework/sessions" \
         "$APP_DIR/storage/framework/views" \
         "$APP_DIR/storage/logs" \
         "$APP_DIR/bootstrap/cache"

# ③ nginx に新しい設定を読み込ませる
service nginx reload