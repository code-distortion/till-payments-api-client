#!/bin/bash

cd /var/www/html/till-payments-php7 || exit
mv vendor ..
rm -rf * .*
cp -pr /var/www/html/till-payments/. /var/www/html/till-payments-php7
rm -rf _src _tests

git add . --all
git commit -m "WIP"

cp -pr src _src
cp -pr tests _tests

./vendor/bin/rector process --clear-cache _src _tests
./vendor/bin/phpcbf _src _tests
#sed -i 's/public function setUp()/public function setUp(): void/' _tests/Browser/LaravelBrowserTest.php
#sed -i 's/public function setUp()/public function setUp(): void/' _tests/LaravelDuskTestCase.php

git checkout main

git merge latest --no-commit

# fix conflicts

rm -rf src tests

mv _src src
mv _tests tests

rm -rf vendor
mv ../vendor .
