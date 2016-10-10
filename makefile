.PHONY: save-db restore-db load-fixtures connect-mysql run-dev run-prod build-css composer compass test help

.DEFAULT_GOAL := help

help:
	@test -f /usr/bin/xmlstarlet || echo "Needs: sudo apt-get install --yes xmlstarlet"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# If the first argument is one of the supported commands...
SUPPORTED_COMMANDS := restore-db _restore_db save-db _save_db composer compass wp-cli-replace build-docker build
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
    # use the rest as arguments for the command
    COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
    # ...and turn them into do-nothing targets
    $(eval $(COMMAND_ARGS):;@:)
endif

# If the command need the db password
DB_COMMANDS := _load_fixtures _save_db _restore_db
NEED_DB_PASSWORD := $(findstring $(firstword $(MAKECMDGOALS)), $(DB_COMMANDS))
ifneq "$(NEED_DB_PASSWORD)" ""
    DB_PASSWORD ?= $(shell stty -echo; read -p "Password: " DB_PASSWORD; stty echo; echo $$DB_PASSWORD)
endif

save-db: ## create a dump of the mariadb database arg: <name> default to current date
	@make _save_db $(COMMAND_ARGS) > /dev/null
	@ echo "dump successfully created"

_save_db:
ifdef COMMAND_ARGS
	docker exec bibcnrs_db_1 mysqldump --password=$(DB_PASSWORD) wordpress > backups/$(COMMAND_ARGS).sql
else
	docker exec bibcnrs_db_1 mysqldump --password=$(DB_PASSWORD) wordpress > backups/db_backup_$(shell date +%Y_%m_%d_%H_%M).sql
endif

restore-db: ## restore a given dump to the mariadb database list all dump if none specified
ifdef COMMAND_ARGS
	@make _restore_db $(COMMAND_ARGS) > /dev/null
	@ echo "backup successfully restored"
else
	echo 'please specify backup to restore':
	@ls -h ./backups
endif

_restore_db:
	cat backups/$(COMMAND_ARGS) | docker exec -i bibcnrs_db_1 sh -c 'cat | mysql --password='$(DB_PASSWORD)' wordpress'

load-fixtures: ## load fixtures for wordpress
	@make _load_fixtures > /dev/null;
	@echo "Fixture successfully loaded."

_load_fixtures:
	cat fixtures/portails.sql | docker exec -i bibcnrs_db_1 sh -c  'cat | mysql --password='$(DB_PASSWORD)' wordpress';

connect-mysql: ## connect into mysql
	docker exec -it bibcnrs_db_1 mysql --password wordpress

test: ## launch phpunit test
	docker-compose -f docker-compose.test.yml run --rm phpunit test

run-dev: ## launch bibcnrs for development environment
	docker-compose -f docker-compose.yml -f docker-compose.dev.yml up --force-recreate

run-prod: ## launch bibcnrs for production environment
	docker-compose -f docker-compose.prod.yml up -d --force-recreate

cleanup-docker: ## remove all bibcnrs docker image
	test -z "$$(docker ps -a | grep bibcnrs)" || \
            docker rm --force $$(docker ps -a | grep bibcnrs | awk '{ print $$1 }')

stop: ## stop all bibcnrs docker image
	test -z "$$(docker ps | grep bibcnrs)" || \
            docker stop $$(docker ps -a | grep bibcnrs | awk '{ print $$1 }')

compass: ## allow to run dockerized compass command
	docker-compose run --rm compass $(COMMAND_ARGS)

composer: ## allow to run dockerized composer command
	docker-compose run --rm composer $(COMMAND_ARGS)

wp-cli-replace: ## allow to run replace one string by another inside wordpress database
	docker exec bibcnrs_wordpress_1 ./wp-content/vendor/wp-cli/wp-cli/bin/wp --allow-root --path=/var/www/html search-replace $(COMMAND_ARGS)

build-css: ## build css from sass
	docker-compose run --rm compass compile

composer-update: ## update dependency
	docker-compose run --rm composer update --no-dev --prefer-dist
	sudo cp -Rf ./wp-content/vendor/bibcnrs/wp-ebsco-widget/ ./wp-content/plugins/

build-docker: ## args: <version> build vsregistry.intra.inist.fr:5000/bibcnrs:<version> docker image default <version> to latest
ifdef COMMAND_ARGS
	docker build --no-cache -t 'vsregistry.intra.inist.fr:5000/bibcnrs:$(COMMAND_ARGS)' .
else
	docker build --no-cache -t 'vsregistry.intra.inist.fr:5000/bibcnrs:latest' .
endif

bump: ## create a file with current commit hash
	git rev-parse HEAD > .currentCommit

install: build-css composer-update bump ## install dependency and build css

build: install build-docker $(COMMAND_ARGS) ## install and build docker
