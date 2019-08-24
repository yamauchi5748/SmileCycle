FIG = docker-compose

# コンテナ操作コマンド等
build:
	@$(FIG) build
ps:
	@$(FIG) ps
up:
	@$(FIG) up -d
down:
	@$(FIG) down
restart:
	@$(FIG) stop
	@$(FIG) start
clean:
	@docker image prune
	@docker volume prune
delete:
	@docker image prune -a