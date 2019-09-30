#!/bin/bash

cd ap_hero
php bin/console doctrine:migrations:migrate
php bin/console server:run