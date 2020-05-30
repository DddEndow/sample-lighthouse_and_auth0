# sample-lighthouse_and_auth0
LaravelのLighthouseとAuth0の練習用リポジトリ

# Installation
git clnoe したら最初にやること

```
$ make
```

コンテナの立ち上げが完了したら、`http://localhost:10080`でアクセスできます。

```
$ open htpt://localhost:10080
```

# Tips
## make コマンド集
Makefile に書いてあるコマンドは、全部 docker-compose 経由のコマンドをラッパーしているだけです。 慣れてきたら docker-compose で直接叩くほうが、オプションを自由に渡せて捗ると思います。

```
# コンテナ起動
$ make up

# コンテナ停止（db のデータが消えて初期化されます）
$ make down

# Laravel のコンテナに bash でログイン
$ make bash

# Redis のコンテナに bash でログイン
$ make bash-redis

# composer install
$ make composer-install

# マイグレーション実行
$ make migrate

# Seeder 実行
$ make seed

# Tinker (Laravel の REPL) 実行
$ make tinker

# PHPUnit 実行
$ make test

# PHP Code Sniffer (Lint) 実行
$ make cs

# PHP Code Beautifier and Fixer (Lint に基づいた修正) 実行
$ make cbf
```
