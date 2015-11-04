FROM ubuntu:14.04

RUN apt-get update && apt-get install -y \
    ruby-dev \
    make

RUN gem install listen
RUN gem install compass -v 1.0.3
RUN gem install compass-core -v 1.0.3

VOLUME /src

WORKDIR /src

ENTRYPOINT [ "compass" ]
