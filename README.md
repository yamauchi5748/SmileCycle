# 環境

| Name | Vesion |
| :--| :-- |
| Docker   | 19.03.1 |
|docker-compose|1.24.1|
| Laravel  | 5.8    |
| PHP      | 7.2    |
|MongoDB|4.2.0|
|redis|5.0.5|
|socket.io-client|2.2.0|
|HTML|5|
|CSS|3|

### Windows 環境構築

----

#### Dockerのインストール

Dockerをインストールしていなければ下記のurlからダウンロードし、インストールする

<a href="https://hub.docker.com/editions/community/docker-ce-desktop-windows">DockerHub公式</a>

※DockerHubのアカウントが必要

※DockerHubのアップデートも確認しておく

#### 開発環境を立ち上げる

##### .\smile-cycle直下のバッチファイルを実行

`setup.bat`

http://localhost:8080 にアクセス



#### ※ Makefile

```makefile
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
```

Makefileが扱える環境であればコンテナを立ち上げたいときに　`make up -d`　など便利 

