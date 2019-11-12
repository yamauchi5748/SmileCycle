# このファイルの場所をカレントディレクトリとする
cd `dirname $0`
cd laradock

docker-compose exec --user=laradock workspace npm run dev