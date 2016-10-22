COMPOSE=docker-compose
RUN=$(COMPOSE) run --rm app
FRONT=$(COMPOSE) run --rm front
NPM=$(FRONT) npm

install: configure build start-env composer-install front-install migration-migrate

configure:
	cp app/config/parameters.yml.dist app/config/parameters.yml

build:
	$(COMPOSE) build

start:
	$(COMPOSE) up -d

stop:
	$(COMPOSE) stop

rm:
	$(COMPOSE) rm -fv app front phpmyadmin

clean: stop rm

restart: stop start-env

composer-install:
	$(RUN) composer install

front-install: npm-install styles

npm-install:
	$(NPM) install

styles:
	$(FRONT) gulp styles

watch:
	$(FRONT) gulp

migration-diff:
	$(RUN) bin/console doctrine:migrations:diff

migration-migrate:
	$(RUN) dockerize -wait tcp://mysql:3306 -timeout 60s
	$(RUN) bin/console doctrine:migrations:migrate --no-interaction

start-env:
ifdef env
ifeq "$(env)" "prod"
	@make start-prod
endif
else
	@make start
endif

start-prod:
	$(COMPOSE) -f docker-compose.prod.yml up -d

cc:
	$(RUN) bin/console c:c
