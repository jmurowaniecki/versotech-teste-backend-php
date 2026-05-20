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
	build-back \
	build-front

build-docker: # Build Docker containers and services.
	docker compose build --no-cache --pull

build-back:
	@docker compose run --rm \
		--remove-orphans \
		--interactive composer install

build-front:
	@docker compose run --rm \
		--remove-orphans \
		--interactive npm install

build-%: # Build application with given profile.
	$(call TRACE,Building,$(*))

clean: # Clean generated and temporaries.
	$(call TRACE,Cleaning…)

#
# Service management.
start:  # Execute entire project.
	docker compose up --profile worker

tty-%: # Execute application with given profile.
	@docker compose run --rm \
		--remove-orphans \
		--entrypoint sh \
		--interactive $(*)

artisan: # Execute Artisan command.
	@docker compose run --rm \
		--remove-orphans \
		--interactive artisan \
		$(filter-out $@,$(MAKECMDGOALS))

#
# Code Quality and Tests
check: check-all # Ensure all checks - Docker files, lint, styles, …

check-all: \
	check-docker-compose

check-docker-compose: # Check Docker Compose file.
	docker compose build --check

