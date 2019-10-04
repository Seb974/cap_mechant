#!/bin/bash

cd ap_hero
composer install
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:start
php bin/console server:dump
