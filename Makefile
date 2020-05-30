.PHONY: init
init: up src/vendor key-generate migrate seed

.PHONY: up
up: src/vendor
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: build
build:
	docker-compose build

.PHONY: re
re:
	make down && make up

.PHONY: ps
ps:
	docker-compose ps

.PHONY: bash
bash:
	docker-compose exec app bash

.PHONY: bash-redis
bash-redis:
	docker-compose exec redis bash

.PHONY: composer-install
composer-install:
	docker-compose run --rm app composer install --no-progress --no-suggest

.PHONY: composer-update
composer-update:
	docker-compose run --rm app composer update

src/vendor:
	docker-compose run --rm app composer install --no-progress --no-suggest

.PHONY: ide-helper
ide-helper:
	docker-compose run --rm app make ide-helper

src/.env:
	@cp src/.env.example src/.env

.PHONY: key-generate
key-generate: src/.env
	docker-compose run --rm app php artisan key:generate

.PHONY: migrate
migrate: src/.env
	docker-compose run --rm app php artisan migrate

.PHONY: seed
seed: src/.env
	docker-compose run --rm app php artisan db:seed

.PHONY: tinker
tinker: src/.env
	docker-compose run --rm app php artisan tinker

.PHONY: test
test: src/.env
	docker-compose run --rm app ./vendor/bin/phpunit --testdox ./tests

.PHONY: cs
cs: src/.env
	docker-compose run --rm app ./vendor/bin/phpcs -s --colors --standard=/project/phpcs.xml ./app

.PHONY: cbf
cbf: src/.env
	docker-compose run --rm app ./vendor/bin/phpcbf -s --colors --standard=/project/phpcs.xml ./app
