start:
	docker-compose up -d

stop:
	docker-compose stop

restart: stop start

migration-diff:
	docker-compose run app bin/console doctrine:migrations:diff

migration-migrate:
	docker-compose run app bin/console doctrine:migrations:migrate --no-interaction
