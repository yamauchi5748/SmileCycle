@echo off
rem このファイルの場所をカレントディレクトリとする
cd /d %~dp0

rem workspaceの.envファイルを作成
cd workspace
copy env-example .env

rem laradockの.envファイルを作成
cd ../laradock
copy env-example .env

rem 各コンテナを起動
docker-compose up -d

rem composerをインストール
docker-compose exec --user=laradock workspace ^
composer install --ignore-platform-reqs

rem npmをインストール
docker-compose exec --user=laradock workspace ^
npm install

rem Laravelの.envのAPP_KEYを生成
docker-compose exec --user=laradock workspace ^
php artisan key:generate

rem LaravelMixによるBuildを実行
docker-compose exec --user=laradock workspace ^
npm run watch