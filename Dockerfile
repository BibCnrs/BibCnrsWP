FROM bibcnrs/wordpress:4.5.3-apache

MAINTAINER BibCNRS <bibcnrs@inist.fr>

ADD ./wp-content/themes/portail/ /var/www/html/wp-content/themes/portail
ADD ./wp-content/vendor/ /var/www/html/wp-content/vendor
ADD ./wp-content/plugins/ /var/www/html/wp-content/plugins
ADD ./wp-content/languages/themes/ /var/www/html/wp-content/languages/themes
ADD ./node_modules/ /var/www/html/wp-content/node_modules

WORKDIR /var/www/html

EXPOSE 8080
