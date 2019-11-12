# このファイルの場所をカレントディレクトリとする
cd `dirname $0`

docker-compose exec --user=laradock workspace npm run dev