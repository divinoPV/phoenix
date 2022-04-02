SHELL := /bin/bash

CTNR_PHP = php_phoenix-container
CTNR_NODE = node_phoenix-container

COMPOSE = docker-compose
DOCKER_EXEC = docker exec -it
DOCKER_EXEC_PHP = ${DOCKER_EXEC} ${CTNR_PHP}
DOCKER_EXEC_PHP_BC = ${DOCKER_EXEC_PHP} ${PHP_BC}
DOCKER_EXEC_NODE = ${DOCKER_EXEC} ${CTNR_NODE}

PHP_BC = php bin/console

.PHONY: start
# start project
start : up perm bundles assets db cc perm

##
## Docker
##

.PHONY: up
# Build docker image
up:
	make kill
	${COMPOSE} --env-file .env.local up -d --build
	google-chrome http://phoenix.co:80

.PHONY: kill
# kill all containers
kill:
	docker kill $$(docker ps -q) || true

.PHONY: bash
# Run shell inside php-container
bash:
	${DOCKER_EXEC_PHP} /bin/bash

##
## Composer
##
COMPOSER = ${DOCKER_EXEC_PHP} composer

.PHONY: cpr
# Composer in php-container with your command, c='{value}''
cpr:
	${COMPOSER} $(c)

.PHONY: cpr-i
# Install php dependencies
cpr-i:
	${COMPOSER} install

.PHONY: cpr-u
# Update php dependencies
cpr-u:
	${COMPOSER} update

##
## Database
##
DOCTRINE = ${DOCKER_EXEC_PHP_BC} doctrine:
DOCTRINE_DB = ${DOCTRINE}d:
DOCTRINE_SCHEMA = ${DOCTRINE}s:
DOCTRINE_FIXTURES = ${DOCTRINE}f:
DOCTRINE_CACHE = ${DOCTRINE}cache:
DOCTRINE_CACHE_CLEAR = ${DOCTRINE_CACHE}clear-

.PHONY: build
# Drop, create db, update schema and load fixtures
db: db-cache db-d db-c db-su db-fl

.PHONY: db-d
# Drop database
db-d:
	${DOCTRINE_DB}d --if-exists -f
.PHONY: db-c
# Create database
db-c:
	${DOCTRINE_DB}c --if-not-exists

.PHONY: db-su
# Update database schema
db-su:
	${DOCTRINE_SCHEMA}u -f

.PHONY: db-v
# Check database schema
db-v:
	${DOCTRINE_SCHEMA}v

.PHONY: db-fl
# Load fixtures
db-fl:
	${DOCTRINE_FIXTURES}l -n

.PHONY: db-m
# Make migrations
db-m:
	${DOCTRINE}migration:migrate

.PHONY: db-cache
# Clear doctrine cache
db-cache: db-cache-r db-cache-q db-cache-m

.PHONY: db-cache-r
# Clear result
db-cache-r:
	${DOCTRINE_CACHE_CLEAR}result

.PHONY: db-cache-q
# Clear query
db-cache-q:
	${DOCTRINE_CACHE_CLEAR}query

.PHONY: db-cache-m
# Clear metadata
db-cache-m:
	${DOCTRINE_CACHE_CLEAR}metadata

##
## Symfony
##

.PHONY: perm
# Fix permissions of all files
perm:
	sudo chown -R www-data:$(USER) .
	sudo chmod -R g+rwx .

.PHONY: cc
# Clear the cache
cc:
	${DOCKER_EXEC_PHP_BC} c:c --no-warmup
	${DOCKER_EXEC_PHP_BC} c:warmup

.PHONY: bundles
# Display all commands in the project namespace
bundles: cpr-i

##
## Assets
##

YARN = ${DOCKER_EXEC_NODE} yarn

.PHONY: assets
# Run assets
assets: php-assets yarn-assets

.PHONY: assets-watch
# Run assets watch
assets-watch: php-assets
	${YARN} watch

.PHONY: php-assets
# Run php assets
php-assets:
	${DOCKER_EXEC_PHP_BC} assets:install

.PHONY: yarn-assets
# Run yarn assets
yarn-assets:
	${YARN} run encore dev
