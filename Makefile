help: ## Prints this help.
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

up: ## Build and run all docker containers
	docker-compose up --build -d

start: ## Start all docker containers
	docker-compose start

stop: ## Stop all docker containers
	docker-compose stop

destroy: ## Down all docker containers
	docker-compose down

rebuild: destroy up ## Down all docker containers and build again

bash: ## Execute and enter in webapp bash
	docker-compose exec webapp bash

bash-db: ## Execute and enter in database bash
	docker-compose exec db bash

phpstan: ## Execute code analyzer phpstan
	docker-compose exec webapp ./vendor/bin/phpstan analyse src --level 9

test: ## Execute test with phpunit
	docker-compose exec webapp ./vendor/bin/phpunit
