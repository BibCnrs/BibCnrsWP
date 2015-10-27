.PHONY: save-db restore-db load-fixtures connect-mysql run-dev run-prod build-css composer compass

# If the first argument is one of the supported commands...
SUPPORTED_COMMANDS := restore-db _restore_db save-db _save_db composer compass
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
	DB_PASSWORD := $(shell stty -echo; read -p "Password: " DB_PASSWORD; stty echo; echo $$DB_PASSWORD)
endif

save-db:
	@make _save_db $(COMMAND_ARGS) > /dev/null
	@ echo "dump successfully created"

_save_db:
ifdef COMMAND_ARGS
	docker exec -it bibcnrs_db_1 mysqldump --password=$(DB_PASSWORD) wordpress > backups/$(COMMAND_ARGS).sql
else
	docker exec -it bibcnrs_db_1 mysqldump --password=$(DB_PASSWORD) wordpress > backups/db_backup_$(shell date +%Y_%m_%d_%H_%M).sql
endif

restore-db:
ifdef COMMAND_ARGS
	@make _restore_db $(COMMAND_ARGS) > /dev/null
	@ echo "backup successfully restored"
else
	echo 'please specify backup to restore':
	@ls -h ./backups
endif

_restore_db:
	cat backups/$(COMMAND_ARGS) | docker exec -i bibcnrs_db_1 sh -c 'cat | mysql --password='$(DB_PASSWORD)' wordpress'

load-fixtures:
	@make _load_fixtures > /dev/null;
	@echo "Fixture successfully loaded."

_load_fixtures:
	cat fixtures/portails.sql | docker exec -i bibcnrs_db_1 sh -c  'cat | mysql --password='$(DB_PASSWORD)' wordpress';

connect-mysql:
	docker exec -it bibcnrs_db_1 mysql --password wordpress

run-dev:
	COMPOSE_FILE=development.yml docker-compose up

run-prod:
	COMPOSE_FILE=production.yml docker-compose up

build-css:
	docker-compose run compass compile

compass:
	docker-compose run compass $(COMMAND_ARGS)

composer:
	docker-compose run composer $(COMMAND_ARGS)
