.PHONY: default install run test

# If the first argument is one of the supported commands...
SUPPORTED_COMMANDS := restore-db save-db
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  # use the rest as arguments for the command
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(COMMAND_ARGS):;@:)
endif

save-db:
ifdef COMMAND_ARGS
	docker run --volumes-from bibcnrs_data_1 -v $(shell pwd):/backups ubuntu tar cvf /backups/$(COMMAND_ARGS) /var/lib/mysql
else
	docker run --volumes-from bibcnrs_data_1 -v $(shell pwd)/backups:/backups ubuntu tar cvf /backups/db_backup_$(shell date +%Y_%m_%d).tar /var/lib/mysql
endif

restore-db:
ifdef COMMAND_ARGS
	docker run --volumes-from bibcnrs_data_1 -v $(shell pwd)/backups:/backups ubuntu tar xvf /backups/$(COMMAND_ARGS)
else
	echo 'please specify backup to restore':
	@ls -h ./backups
endif

load-fixtures:
	cat fixtures/portails.sql | docker exec -i bibcnrs_db_1 sh -c 'cat | mysql --password=example wordpress'

connect-mysql:
	docker exec -it bibcnrs_db_1 mysql --password wordpress

install-test:
	COMPOSE_FILE=protractor.yml docker-compose run install

test:
	COMPOSE_FILE=protractor.yml docker-compose run protractor
