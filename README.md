# 環境構築

| Name | Vesion |
| :--| :-- |
| Docker   | 18.x   |
|docker-compose|1.20.x|
| Laravel  | 5.8    |
| PHP      | 7.2    |
|MySQL|8.0|
|redis|5.0.5|
|Vue.js|2.9.6|
|socket.io-client|2.2.0|
|HTML|5|
|CSS|3|
|Bootstrap|4.3.1|

### Windows 環境構築

----

#### Dockerのインストール

Dockerをインストールしていなければ下記のurlからダウンロードし、インストールする

※DockerHubのアカウントが必要

<https://hub.docker.com/editions/community/docker-ce-desktop-windows>

#### 開発環境を立ち上げる

下記コマンドを smile-cycle\laradock で実行

Laradockの.envファイルを作成する

`copy env-example .env`

各コンテナを立ち上げる

`docker-compose up -d`

下記コマンドを smile-cycle\workspace で実行

workspaceの.envファイルを作成する

`copy env-example .env`

http://localhostにアクセスしてみる

