FROM ghcr.io/it-bens/it-bens/shopware-remote-api-test-runner:6.5.8.11_de-de_eur

ADD docker/test/e2e-test-shopware/fixtures.sql /fixtures.sql

RUN service apache2 start && \
    service mariadb start && \
    mysql -uroot -proot shopware_test < '/fixtures.sql' && \
    php -d memory_limit=-1 bin/console dal:refresh:index && \
    php -d memory_limit=-1 bin/console cache:clear && \
    php -d memory_limit=-1 backup_database.php

VOLUME /var/www/html
WORKDIR /var/www/html