# このファイルの場所をカレントディレクトリとする
cd `dirname $0`

# workspaceの.envファイルを作成
cd workspace
\cp -f env-example .env

# laradockの.envファイルを作成
cd ../laradock
\cp -f env-example .env

# 各コンテナを起動
docker-compose up -d

# mongodbをインストール
docker-compose exec workspace \
pecl install mongodb

# composerをインストール
docker-compose exec --user=laradock workspace \
composer install

# npmをインストール
docker-compose exec --user=laradock workspace \
npm install

# Laravelの.envのAPP_KEYを生成
docker-compose exec --user=laradock workspace  \
php artisan key:generate

# シンボリックリンクを張る
docker-compose exec --user=laradock workspace \
php artisan storage:link

# テストデータを生成
docker-compose exec --user=laradock workspace \
php artisan db:seed

# スーパーバイザ起動
docker-compose exec workspace \
service supervisor start

# LaravelMixによるBuildを実行
docker-compose exec --user=laradock workspace \
npm run dev
