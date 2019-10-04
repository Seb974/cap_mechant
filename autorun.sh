#!/bin/bash

# change directory to symfony project
cd ap_hero

# force to install dependencies if some is missing
composer install

# force database to update schema
php bin/console doctrine:schema:update --force

# load data samples
php bin/console doctrine:fixtures:load

# launch http server
php bin/console server:start

#launch a debugger server; in your controller use ```dump( $var );``` to obtain a var_dump
php bin/console server:dump
