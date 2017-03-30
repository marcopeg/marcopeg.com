
# Wordpress for Production
# by @24HR

FROM wordpress:4.7
ADD conf/mpm_prefork.conf /etc/apache2/mods-enabled/
ADD conf/apache2.conf /etc/apache2/apache2.conf
ADD conf/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Add custom theme
VOLUME /var/www/html/wp-content/themes/docker
ADD ./wp-content/themes/docker /var/www/html/wp-content/themes/docker

# Add gallery plugin
VOLUME /var/www/html/wp-content/plugins/post-gallery-lite
ADD ./wp-content/plugins/post-gallery-lite /var/www/html/wp-content/plugins/post-gallery-lite

# Database default settings
RUN sed -i "s/define('DB_CHARSET', 'utf8');/\/\/define('DB_CHARSET', 'utf8');/g" /usr/src/wordpress/wp-config-sample.php
RUN sed -i "s/define('DB_COLLATE', '');/\/\/define('DB_COLLATE', '');/g" /usr/src/wordpress/wp-config-sample.php
