# BibCnrs

## Installation
You need to have docker and docker-compose installed.

You need to run `docker-compose build` to build the image.
You can set proxy with --build-arg http_proxy=proxy.url
You must set the DB_PASSWORD environment variable to configure the wordpress database password

Run `make composer install` to install wordpress plugins defined in composer.json.

### in development
Simply do `make run-dev`
This will launch wordpress, mariadb and compass (that will build the css and the watch for change).
Then you need to visit localhost:8080 to setup wordpress, simply follow the instruction.
Once the installation is successful.
Run `make load-fixtures` to load the themes data in wordpress db.
This command need the DB_PASSWORD env variable to be set with the password, otherwise it will prompt for it
Now you are all set.

### in order to deploy
make build <version>
to build wordpress docker image used in production environment with incorporated dependencies and built css

TODO make deploy... to publish wordpress docker production image

### in production
make run-prod
install wordpress by visiting production address

then load the themes fixtures. (this will overwrite the site name and administrator email, feel free to change them back in admin)
`make load-fixtures`

And then execute the following command to change the host to the correct url
```
make wp-cli-replace http://localhost:8080 <new host>
```

## useful command

### make stop
Stop wordpress and db container in production

### make compass
allow to run compass command in the docker compass
```sh
make compass build // will run `compass build` inside the compass docker
```
see [compass documentation](http://compass-style.org/help/documentation/command-line/) for a list of available command

### make composer
allow to run composer command in the docker composer
```sh
make composer install phpunit // will run `composer.phar install phpunit` inside the composer docker
```
see [composer documentation](https://getcomposer.org/doc/03-cli.md#command-line-interface-commands) for a list of available command

### make save-db
Allow to create a sql dump inside the backups directory.(the db container need to be up)
The command will ask for the password of the database if the DB_PASSWORD environment variable is not set.
By default the dump is named `db_backup_<year>_<month>_<day>_<hour>_<minute>)`.
To provide a custom name simply do: `make save-db custom_name`

### make restore-db
Allow to restore previously saved dump (the db container need to be up)
Without argument it will list all dump present inside the backups directory
Giving a file name will restore the given dump.
The command will ask for the password of the database if the DB_PASSWORD environment variable is not set.

### connect-mysql
Allow to connect into the docker db and launch the mysql client to access the wordpress database.
It will first ask for the database password.
