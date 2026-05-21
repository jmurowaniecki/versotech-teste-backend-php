#
# λ::Makefile
#
-include ./.../Makefile-help.mk

TODAY = $(shell date +'%Y%m%d%H%M%S')

DEFAULT: help
# For further information see `README.md`.
#
# Repository maintenance options:
install: build fresh # Alias to build application, perform migrations and seeds.

build: build-all # Build application.

build-all: \
	build-docker \
	build-composer \
	build-npm

build-docker: # Build Docker containers and services.
	docker compose build --no-cache --pull

build-%: # Build application with given profile.
	$(call TRACE,Building,$(*))
	@[ "$(*)" = "all" ] || \
	docker compose run --rm \
		--remove-orphans \
		--interactive $(*) install

clean: # Clean dependencies and remove local database.
	$(call TRACE,Cleaning…)
	@docker compose run --rm \
		--remove-orphans \
		--entrypoint  rm \
		--interactive composer -Rf vendor ./app/database/database.sqlite
	@docker compose run --rm \
		--remove-orphans \
		--entrypoint  rm \
		--interactive npm -Rf node_modules

fix: # Fix Artisan/Composer autoload.
	@docker compose run --rm \
		--remove-orphans \
		--interactive composer dump-autoload -o
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan optimize:clear

fresh: # Fresh Artisan migrations.
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan migrate
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan migrate:fresh
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan db:seed

#
# Service management.
start:  # Execute entire project.
	docker compose up --profile worker

tty-%: # Execute application with given profile.
	@docker compose run --rm \
		--remove-orphans \
		--entrypoint sh \
		--interactive $(*)

run-%: # Execute Artisan, Composer or NPM command.
	@docker compose run --rm \
		--remove-orphans \
		--interactive $(*)  $(filter-out $@,$(MAKECMDGOALS))

sync: # Execute Artisan Sync command.
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan sync $(filter-out $@,$(MAKECMDGOALS))

#
# Code Quality and Tests
check: check-all # Ensure all checks - Docker files, lint, styles, …

check-all: \
	check-docker-compose

check-docker-compose: # Check Docker Compose file.
	docker compose build --check
