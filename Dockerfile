FROM bibcnrs/wordpress

MAINTAINER BibCNRS <bibcnrs@inist.fr>

ADD ./wp-content/themes/portail /var/www/html/wp-content/themes/portail
ADD ./wp-content/vendor /var/www/html/wp-content/vendor
ADD ./wp-content/plugins /var/www/html/wp-content/plugins

WORKDIR /var/www/html

EXPOSE 8080
