
# Wordpress for Production
# by @24HR

FROM wordpress:latest

# Add custom theme
VOLUME /var/www/html/wp-content/themes/docker
ADD ./wp-content/themes/docker /var/www/html/wp-content/themes/docker

# Database default settings
RUN sed -i "s/define('DB_CHARSET', 'utf8');/\/\/define('DB_CHARSET', 'utf8');/g" /usr/src/wordpress/wp-config-sample.php
RUN sed -i "s/define('DB_COLLATE', '');/\/\/define('DB_COLLATE', '');/g" /usr/src/wordpress/wp-config-sample.php
