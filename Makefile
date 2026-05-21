#
# λ::Makefile
#
-include ./.../Makefile-help.mk

TODAY = $(shell date +'%Y%m%d%H%M%S')

DEFAULT: help
# For further information see `README.md`.
#
# Repository maintenance options:
install: build # Alias to build application.

build: build-all # Build application.

build-all: \
	build-docker \
	build-composer \
	build-npm

build-docker: # Build Docker containers and services.
	docker compose build --no-cache --pull

build-%: # Build application with given profile.
	$(call TRACE,Building,$(*))
	@docker compose run --rm \
		--remove-orphans \
		--interactive $(*) install

clean: # Clean generated and temporaries.
	$(call TRACE,Cleaning…)
	@docker compose run --rm \
		--remove-orphans \
		--entrypoint sh \
		--interactive composer rm -Rf node_modules vendor

fix: # Fix Artisan/Composer autoload.
	@docker compose run --rm \
		--remove-orphans \
		--interactive composer dump-autoload -o
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan optimize:clear

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

#
# Code Quality and Tests
check: check-all # Ensure all checks - Docker files, lint, styles, …

check-all: \
	check-docker-compose

check-docker-compose: # Check Docker Compose file.
	docker compose build --check
