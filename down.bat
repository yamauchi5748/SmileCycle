@echo off
rem laradockディレクトリへ移動
cd /d %~dp0
cd laradock

rem 保存されたローカルの画像を削除
cd ../workspace/storage/app/private
rd /s /q .\images
rd /s /q .\videos
cd ../public
rd /s /q .\images
rd /s /q .\videos

rem 各コンテナを停止
cd ../../../../laradock
docker-compose down

cd ..