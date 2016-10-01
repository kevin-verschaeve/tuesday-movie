COMPOSE=docker-compose
RUN=$(COMPOSE) run app

install: configure clean build start-env composer-install migration-migrate
	@echo "########################################################"
	@echo "#                                                      #"
	@echo "# Application disponible ici: http://localhost:8000    #"
	@echo "# PhpMyAdmin: http://localhost:8001"                   #"
	@echo "#                                                      #"
	@echo "########################################################"

configure:
	cp app/config/parameters.yml.dist app/config/parameters.yml

build:
	$(COMPOSE) build

start:
	$(COMPOSE) up -d

stop:
	$(COMPOSE) stop

rm:
	$(COMPOSE) rm -fv

clean: stop rm

restart: stop start-env

composer-install:
	$(RUN) composer install

migration-diff:
	$(RUN) bin/console doctrine:migrations:diff

migration-migrate:
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
