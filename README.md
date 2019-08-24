# 環境

| Name | Vesion |
| :--| :-- |
| Docker   | 18.x   |
|docker-compose|1.20.x|
| Laravel  | 5.8    |
| PHP      | 7.2    |
|MySQL|8.0|
|redis|5.0.5|
|socket.io-client|2.2.0|
|HTML|5|
|CSS|3|

### Windows 環境構築

----

#### Dockerのインストール

Dockerをインストールしていなければ下記のurlからダウンロードし、インストールする

※DockerHubのアカウントが必要

<https://hub.docker.com/editions/community/docker-ce-desktop-windows>

#### 開発環境を立ち上げる

##### 下記コマンドを .\smile-cycle で実行

`setup.bat`

必要な各パッケージをインストール

`composer install --ignore-platform-reqs`

`npm install`

Laravelの.envのAPP_KEYを生成

`php artisan key:generate`

LaravelMixによるBuildを実行

`npm run watch`



http://localhost:8080 にアクセス

