# Docker
docker-up:
	docker compose up -d
docker-down:
	docker compose down

MAKE =
SYMFONY_CONSOLE = symfony console
SYMFONY_MAKE = ${SYMFONY_CONSOLE} make:${MAKE}


#Symfony
sf-start:
	symfony server:start -d
sf-stop:
	symfony server:stop
sf-make:
	${SYMFONY_MAKE}
sf-migrate:
	symfony console make:migration
	symfony console doctrine:migrations:migrate --no-interaction

#Doctrine
dt-refresh:
	symfony console doctrine:fixtures:load --no-interaction
dt-dump:
	symfony console doctrine:schema:create --dump-sql


