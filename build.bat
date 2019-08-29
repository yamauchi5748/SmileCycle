@echo off
rem laradockディレクトリへ移動
cd /d %~dp0
cd laradock

rem LaravelMixによるBuildを実行
docker-compose exec --user=laradock workspace ^
npm run watch-poll

cd ..