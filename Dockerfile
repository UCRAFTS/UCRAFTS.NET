FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=noninteractive
ENV NVM_DIR=/root/.nvm

RUN  apt update \
    && apt install -y software-properties-common \
    && add-apt-repository -y ppa:ondrej/php \
    && apt update \
    && apt install -y npm curl openssh-client php7.4 php7.4-common php7.4-fpm \
       php7.4-redis php7.4-cli php7.4-curl php7.4-gd php7.4-imap php7.4-json \
       php7.4-mbstring php7.4-mysql php7.4-readline php7.4-xml php7.4-soap \
       libmcrypt-dev php7.4-zip php7.4-amqp \
    && rm -rf /var/lib/apt/lists/* \
    && curl https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash \
    && . $HOME/.nvm/nvm.sh && nvm install --lts \
    && ln -fs /usr/share/zoneinfo/Europe/Moscow /etc/localtime \
    && dpkg-reconfigure --frontend noninteractive tzdata \
    && echo "upload_max_filesize=100M" >> /etc/php/7.4/fpm/php.ini \
    && echo "post_max_size=100M" >> /etc/php/7.4/fpm/php.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir -p /var/{www/html/var}

COPY docker/config/www.conf /etc/php/7.4/fpm/pool.d/www.conf

WORKDIR /var/www/html
EXPOSE 9000
CMD ["php-fpm7.4"]