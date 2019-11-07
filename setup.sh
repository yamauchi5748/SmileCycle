# このファイルの場所をカレントディレクトリとする
cd `dirname $0`

# workspaceの.envファイルを作成
cd workspace
\cp -f env-example .env

# laradockの.envファイルを作成
cd ../laradock
\cp -f env-example .env

# 各コンテナを起動
sudo docker-compose up -d

# mongodbをインストール
sudo docker-compose exec workspace \
pecl install mongodb

# composerをインストール
sudo docker-compose exec --user=laradock workspace \
composer install

# npmをインストール
sudo docker-compose exec --user=laradock workspace \
npm install

# Laravelの.envのAPP_KEYを生成
sudo docker-compose exec --user=laradock workspace  \
php artisan key:generate

# シンボリックリンクを張る
sudo docker-compose exec --user=laradock workspace \
php artisan storage:link

# テストデータを生成
sudo docker-compose exec --user=laradock workspace \
php artisan db:seed

# スーパーバイザ起動
sudo docker-compose exec workspace \
service supervisor start

# LaravelMixによるBuildを実行
sudo docker-compose exec --user=laradock workspace \
npm run dev
