#!/bin/bash

cd ap_hero
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
