FROM centos:centos6
MAINTAINER Chris Collins <collins.christopher@gmail.com>

ENV http_proxy=proxyout.inist.fr:8080
ENV https_proxy=proxyout.inist.fr:8080

ENV WPCLI_PATH https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar
ENV WPCLI_FILE wp-cli.phar
ENV WP_UPGRADE_SCRIPT https://gist.github.com/682edb10de8d1002f1e1.git
ENV REPO http://dl.iuscommunity.org/pub/ius/stable/CentOS/\$releasever/\$basearch/
ENV PKGS sudo git curl php56u-cli php56u-mysql mysql

RUN echo -e "\
[ius]\n\
name=IUS Community Repository\n\
baseurl=$REPO\n\
enabled=1\n\
gpgcheck=0\n\
priority=1\n\
" >> /etc/yum.repos.d/ius.repo

RUN yum install -y $PKGS && yum clean all
WORKDIR /bin
RUN curl -sSL -O $WPCLI_PATH/$WPCLI_FILE && chmod +x $WPCLI_FILE
RUN ln -s $WPCLI_FILE wp
WORKDIR /

# Uncomment the relevant lines below to make wp-cli run as the Apache user
# Pick the Distro that your Webserver is running in (not this Docker image)
#
# RHEL/CentOS:
# RUN useradd -u 48 -U --home /var/www -M --shell /sbin/nologin apache
# USER apache
#
# Debian/Ubuntu:
# RUN useradd -u 33 -U --home /var/www/ -M --shell /sbin/nologin www-data
# USER www-data

RUN mkdir ~/.wp-cli && echo -e "\
core config:\n\
    extra-php: |\n\
        define( 'FORCE_SSL_ADMIN', true);\n\
" >> ~/.wp-cli/config.yml

ADD scripts /scripts
RUN git clone $WP_UPGRADE_SCRIPT /tmp/clone && mv /tmp/clone/wp-upgrade.sh /scripts
RUN chmod -R +x /scripts

CMD [ "wp-cli.phar", "--allow-root", "--help" ]
