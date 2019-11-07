@echo off
rem このファイルの場所をカレントディレクトリとする
cd /d %~dp0

rem workspaceへログイン
cd laradock
docker-compose exec --user=laradock workspace bash

cd ..