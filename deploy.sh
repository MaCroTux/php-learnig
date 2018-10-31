!#/bin/sh

OLD_DIR=kraken_$(date +%s)

cd ..

git clone https://github.com/MaCroTux/php-learning.git

cd php-learning

docker/composer install

cd db

sqlite3 database.sqli < schema.sql

cd ..
cd ..

mv kraken $OLD_DIR

mv php-learning kraken

cp $OLD_DIR/db/database.sqli kraken/db/
cp $OLD_DIR/logs/app.log kraken/logs/

chown www-data:www-data kraken -R
