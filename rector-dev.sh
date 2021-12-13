#!/bin/bash

cd /var/www/html/till-payments-php7 || exit
rm -rf * .*
cp -pr /var/www/html/till-payments/. /var/www/html/till-payments-php7
rm -rf _src

#git add . --all
#git commit -m "WIP"

cp -pr src _src

./vendor/bin/rector process _src
./vendor/bin/phpcbf _src
#sed -i 's/: self//' _src/Boot/BootCommandInterface.php
#sed -i 's/: self//' _src/Boot/BootCommandLaravel.php
#sed -i 's/: self//' _src/Boot/BootRemoteBuildInterface.php
#sed -i 's/: self//' _src/Boot/BootRemoteBuildLaravel.php
#sed -i 's/: self//' _src/Boot/BootTestInterface.php
#sed -i 's/: self//' _src/Boot/BootTestAbstract.php
#sed -i 's/: self//' _src/Boot/BootTestLaravel.php
#sed -i 's/public function boot(\$router)/public function boot(Router \$router)/' _src/AdaptLaravelServiceProvider.php

#git checkout master-test

#git merge latest-test --no-commit

# fix conflicts

rm -rf src

mv _src src
