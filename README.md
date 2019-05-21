# 環境

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

##### 下記コマンドを smile-cycle\laradock で実行

laradockの.envファイルを作成

`copy env-example .env`

各コンテナを起動

`docker-compose up -d`

workspaceへログイン

`docker-compose exec --user=laradock workspace bash`

必要な各パッケージをインストール

`composer install`

`npm install`

Laravelの.envのAPP_KEYを生成

`php artisan key:generate`

##### 下記コマンドを smile-cycle\workspace で実行

workspaceの.envファイルを作成

`copy env-example .env`



http://localhost にアクセス

