FROM ubuntu:18.04

ENV  DEBIAN_FRONTEND=noninteractive

RUN  apt-get update && apt-get install -y xvfb wkhtmltopdf libglu1-mesa-dev freeglut3-dev mesa-common-dev npm curl -y \
     && rm -rf /var/lib/apt/lists/*

RUN curl https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . $HOME/.nvm/nvm.sh && nvm install --lts

RUN  apt update && apt install -y software-properties-common && add-apt-repository -y ppa:ondrej/php \
     && apt update && apt install -y php7.4 php7.4-common php7.4-fpm php7.4-redis php7.4-cli php7.4-curl php7.4-gd php7.4-imap php7.4-json \
     php7.4-mbstring php7.4-mysql php7.4-readline php7.4-xml php7.4-soap \
     libmcrypt-dev php7.4-xdebug php7.4-pgsql php7.4-zip php7.4-amqp \
     && rm -rf /var/lib/apt/lists/*

RUN  ln -fs /usr/share/zoneinfo/Europe/Moscow /etc/localtime && dpkg-reconfigure --frontend noninteractive tzdata
COPY www.conf /etc/php/7.4/fpm/pool.d/www.conf

RUN echo "opcache.memory_consumption=256" >> /etc/php/7.4/fpm/php.ini
RUN echo "opcache.max_accelerated_files=20000" >> /etc/php/7.4/fpm/php.ini
RUN echo "realpath_cache_size=4096K" >> /etc/php/7.4/fpm/php.ini
RUN echo "opcache.memory_consumption=256" >> /etc/php/7.4/fpm/php.ini
RUN echo "opcache.max_accelerated_files=20000" >> /etc/php/7.4/fpm/php.ini
RUN echo "realpath_cache_size=4096K" >> /etc/php/7.4/fpm/php.ini
RUN echo "upload_max_filesize=100M" >> /etc/php/7.4/fpm/php.ini
RUN echo "post_max_size=100M" >> /etc/php/7.4/fpm/php.ini

#RUN echo "xdebug.remote_enable=1" >> /etc/php/7.4/fpm/php.ini
#RUN echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/fpm/php.ini
#RUN echo "xdebug.remote_port=9000" >> /etc/php/7.4/fpm/php.ini
#RUN echo "xdebug.remote_autostart=1" >> /etc/php/7.4/fpm/php.ini
#RUN echo "xdebug.remote_connect_back=0" >> /etc/php/7.4/fpm/php.ini
#RUN echo "xdebug.idekey=PHPSTORM" >> /etc/php/7.4/fpm/php.ini
## Для Linux: 192.168.221.1
#RUN echo "xdebug.remote_host=host.docker.internal" >> /etc/php/7.4/fpm/php.ini

RUN  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     php -r "if (hash_file('sha384', 'composer-setup.php') === \
     'c5b9b6d368201a9db6f74e2611495f369991b72d9c8cbd3ffbc63edff210eb73d46ffbfce88669ad33695ef77dc76976') \
     { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
     && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv /composer.phar /usr/local/bin/composer

RUN mkdir -p /var/{www/html/var}

EXPOSE 9000
CMD ["php-fpm7.4"]