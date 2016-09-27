#!/bin/bash
set -e

# Change www-data's uid & guid to be the same as directory in host
usermod -u `stat -c %u /var/www/html` www-data || true
groupmod -g `stat -c %g /var/www/html` www-data || true

if [ "$1" = 'apache2-foreground' ]; then
    rm -f /var/run/apache2/apache2.pid
    exec "$@"
else
    su www-data -s /bin/bash -c "$*"
fi
