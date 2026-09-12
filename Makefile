.PHONY: up down restart logs ps shell-php seed test

up:
\tdocker compose up -d --build

down:
\tdocker compose down

restart:
\tdocker compose down
\tdocker compose up -d --build

logs:
\tdocker compose logs -f

ps:
\tdocker compose ps

shell-php:
\tdocker compose exec php bash

seed:
\tdocker compose exec php php database/seed.php

test:
\tdocker compose exec php ./vendor/bin/phpunit