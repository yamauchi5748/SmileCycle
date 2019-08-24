cd workspace
copy env-example .env
cd ..
cd laradock
copy env-example .env
docker-compose up -d
docker-compose exec --user=laradock workspace bash