up:
	docker-compose up -d

stop:
	docker-compose stop

destroy:
	docker-compose down

build:
	docker-compose up --build -d

composer:
	docker-compose exec php_wemail composer install

bash_php:
	docker-compose exec php_wemail bash

bash_nginx:
	docker-compose exec nginx_wemail bash

restart: stop up
