@echo off
rem このファイルの場所をカレントディレクトリとする
cd /d %~dp0
cd laradock

rem テストデータ作成
docker-compose exec --user=laradock workspace ^
php artisan db:seed --class=TestSeeder

rem テスト実行
docker-compose exec --user=laradock workspace ^
phpunit

rem テストデータ削除
docker-compose exec --user=laradock workspace ^
php artisan db:wipe

cd ..