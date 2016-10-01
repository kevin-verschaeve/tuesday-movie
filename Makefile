COMPOSE=docker-compose
RUN=$(COMPOSE) run app

install: configure build start composer-install migration-migrate
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

restart: stop start

composer-install:
	$(RUN) composer install

migration-diff:
	$(RUN) bin/console doctrine:migrations:diff

migration-migrate:
	$(RUN) bin/console doctrine:migrations:migrate --no-interaction
