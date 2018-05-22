FROM ubuntu:16.04
MAINTAINER Yuriy Tkachenko <tds.tkachenko@gmail.com>

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
RUN apt-get install -y dialog 

RUN \
	apt-get update && \
	apt-get install -y locales locales-all

RUN DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common && \
	locale-gen en_US.UTF-8 && \
	export LANG=en_US.UTF-8 && \
	LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
	
RUN \
	apt-get update && \
	apt-get -y upgrade && \
    apt-get dist-upgrade -y && \
    apt-get install -y \
      apache2 \
	  libapache2-mod-php7.1* \
	  php7.1 \
	  php7.1-apcu \
	  php7.1-opcache \
	  php7.1-zip \
	  php7.1-xmlrpc \
	  php7.1-xsl \
	  php7.1-mbstring \
	  php7.1-mcrypt \
	  php7.1-mysql \
	  php7.1-odbc \
	  php7.1-pgsql \
	  php7.1-pspell \
	  php7.1-readline \
	  php7.1-recode \
	  php7.1-snmp \
	  php7.1-soap \
	  php7.1-xml \
	  php7.1-json \
	  php7.1-ldap \
	  php7.1-intl \
	  php7.1-interbase \
	  php7.1-imap \
	  php7.1-gmp \
	  php7.1-gd \
	  php7.1-enchant \
	  php7.1-dba \
	  php7.1-bz2 \
	  php7.1-bcmath \
	  php7.1-phpdbg \
	  php7.1-cgi \
	  php7.1-cli \
	  php7.1-xdebug \
	  php-memcached \
	  memcached \
	  mariadb-client 

COPY apache_default /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80

CMD /usr/sbin/apache2ctl -D FOREGROUND
