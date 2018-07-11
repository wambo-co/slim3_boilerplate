FROM php:7.2-fpm

ENV PHP_EXTRA_CONFIGURE_ARGS \
  --enable-fpm \
  --with-fpm-user=www-data \
  --with-fpm-group=www-data \
  --enable-intl \
  --enable-opcache \
  --enable-zip \
  --enable-calendar

RUN apt-get update && \
  apt-get install -y \
    libcurl4-gnutls-dev \
    libxml2-dev \
    libssl-dev \
    g++ \
    autoconf \
    libbz2-dev \
    libltdl-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxpm-dev \
    libimlib2-dev \
    libicu-dev \
    libmcrypt-dev \
    libxslt1-dev \
    re2c \
    libpng++-dev \
    libvpx-dev \
    zlib1g-dev \
    libgd-dev \
    libtidy-dev \
    libmagic-dev \
    libexif-dev \
    file \
    libssh2-1-dev \
    libjpeg-dev \
    git \
    curl \
    wget \
    librabbitmq-dev \
    libzip-dev

RUN docker-php-ext-configure \
      gd --with-freetype-dir=/usr --with-jpeg-dir=/usr --with-png-dir=/usr

RUN docker-php-ext-install \
      dom \
      pcntl \
      posix \
      pdo \
      sockets \
      pdo_mysql \
      mysqli \
      mbstring \
      hash \
      simplexml \
      xsl \
      soap \
      intl \
      bcmath \
      json \
      opcache \
      zip \
      calendar \
      gd


RUN cd /tmp/ && git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug && phpize && ./configure --enable-xdebug && make \
    && mkdir /usr/lib/php7/ && cp modules/xdebug.so /usr/lib/php7/xdebug.so \
    && touch /usr/local/etc/php/ext-xdebug.ini \
    && rm -r /tmp/xdebug \
    && apt-get purge -y --auto-remove

ENV PHPREDIS_VERSION 4.0.0
RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv  /var/www/html/composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer
