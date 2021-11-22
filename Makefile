# —— Inspired by ———————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/

# Setup ————————————————————————————————————————————————————————————————————————
EXEC_PHP      = php
PHPCONTAINER  = php
PHP_CONTAINER_EXEC       	  = docker-compose exec $(PHPCONTAINER)
PHP       	  = docker-compose exec $(PHPCONTAINER) $(EXEC_PHP)
SYMFONY       = docker-compose exec $(PHPCONTAINER) $(EXEC_PHP) bin/console
COMPOSER      = docker-compose exec $(PHPCONTAINER) composer
DOCKER        = docker-compose
.DEFAULT_GOAL = help
#.PHONY       = # Not needed for now

## —— 🐝 The Strangebuzz Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

wait: ## Sleep 5 seconds
	sleep 5

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	$(SYMFONY) cache:clear -vvv

fpm-restart: ## Clear the opcache cache
	$(DOCKER) restart php

purge: ## Purge cache and logs
	rm -rf var/cache/* var/logs/*

autowiring: ## Display all service autowiring in the project namespace
	$(SYMFONY) debug:autowiring --all

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
dev-up: docker-compose.yml ## Start the docker hub
	$(DOCKER) up -d

dev-down: docker-compose.yml ## Start the docker hub
	$(DOCKER) down

dpsn: ## List Docker containers for the project
	$(DOCKER) images
	@echo "--------------------------------------------------------------------------------------------------------------"
	docker ps -a | grep "sb-"
	@echo "--------------------------------------------------------------------------------------------------------------"

## —— Database 🔎 —————————————————————————————————————————————————————————
load-fixtures: ## Build the db, control the schema validity, load fixtures and check the migration status
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:drop --force
	$(SYMFONY) doctrine:schema:create
	$(SYMFONY) doctrine:schema:validate
	$(SYMFONY) hautelook:fixtures:load --no-interaction

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Launch all tests
	$(PHP_CONTAINER_EXEC) ./vendor/bin/phpunit --dont-report-useless-tests --colors=auto tests --stop-on-failure

## —— 🦸 Security 👨‍🌾  ————————————————————————————————————————————————————————
check: ## Check package vulnérabilities
	symfony security:check
