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

rem workspaceへログイン
docker-compose exec --user=laradock workspace bash
