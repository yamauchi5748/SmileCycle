@echo off
rem このファイルの場所をカレントディレクトリとする
cd /d %~dp0

rem mongoへログイン
cd laradock
docker-compose exec mongo ^
mongo

cd ..