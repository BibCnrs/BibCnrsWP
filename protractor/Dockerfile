FROM node:4.1.2

ENV http_proxy http://proxyout.inist.fr:8080

USER root

WORKDIR /test

RUN npm install -g --unsafe-perm protractor@'2.2.0'
RUN npm install -g --unsafe-perm mocha@'2.3.3'
