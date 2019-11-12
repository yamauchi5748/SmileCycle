# このファイルの場所をカレントディレクトリとする
cd `dirname $0`
cd laradock

# 保存されたローカルの画像を削除
cd ../workspace/storage/app/private
rm .\images
rm .\videos
cd ../public
rm .\images
rm .\videos

# 各コンテナを停止
cd ../../../../laradock
docker-compose down

cd ..