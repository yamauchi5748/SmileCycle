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

### Windows 開発環境構築

----

#### Dockerのインストール

Dockerをインストールしていなければ下記のurlからダウンロードし、インストールする

<a href="https://hub.docker.com/editions/community/docker-ce-desktop-windows">DockerHub公式</a>

※DockerHubのアカウントが必要

※DockerHubのアップデートも確認しておく

#### 開発環境を立ち上げる

プロジェクトをHTTPSでクローン

`git clone https://gitlab.com/kbc-itw/smile-cycle.git  `

クローンしたプロジェクトの直下で下記コマンドを実行

`setup.bat`

http://localhost:3000 にアクセス



#### Makefile

下記コマンドでmakefileが作成できる

`copy makefile-example makefile`

Makefileが扱える環境であればコンテナを立ち上げたいときに　`make up`　など便利 

※細かい内容はmakefileを確認

