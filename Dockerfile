FROM php:8.3.6-cli-alpine3.19 AS php_base

RUN apk --no-cache add bash\
    && rm -rf /var/cache/apk/*

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN set -eux; \
    install-php-extensions \
      zip \
      pcntl \
      bcmath \
      pdo pdo_pgsql \
    && rm -rf /tmp/*
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer/composer:2-bin /composer /usr/bin/composer

WORKDIR /app

FROM php_base AS php_dev

RUN set -eux; \
	install-php-extensions \
		xdebug;

ARG GID=1000
ARG UID=1000
ARG USER=local
ARG GROUP=local
RUN addgroup -g ${GID} ${GROUP} \
    && adduser -D -u ${UID} -G ${GROUP} ${USER} \
    && chown -R ${USER}:${GROUP} /app

USER ${USER}
