# Docker
up:
	docker compose up -d
down:
	docker compose down

MAKE =
SYMFONY_CONSOLE = symfony console
SYMFONY_MAKE = ${SYMFONY_CONSOLE} make:${MAKE}


#Symfony
start:
	symfony server:start -d
stop:
	symfony server:stop
make:
	${SYMFONY_MAKE}
migrate:
	symfony console make:migration
	symfony console doctrine:migrations:migrate --no-interaction

#Doctrine
refresh:
	symfony console doctrine:fixtures:load --no-interaction
dump:
	symfony console doctrine:schema:create --dump-sql
entity:
	${SYMFONY_MAKE}entity

#Test
make-test:
	${SYMFONY_MAKE}test
test:
	php bin/phpunit

