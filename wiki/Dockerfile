# https://github.com/wikimedia/mediawiki-docker/blob/master/1.34/Dockerfile
FROM php:7.3-apache

# System dependencies
RUN set -eux; \
	\
	apt-get update; \
	apt-get install -y --no-install-recommends \
		git \
		librsvg2-bin \
		imagemagick \
		# Required for SyntaxHighlighting
		python3 \
	; \
	rm -rf /var/lib/apt/lists/*

# Install the PHP extensions we need
RUN set -eux; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y --no-install-recommends \
		libicu-dev \
	; \
	\
	docker-php-ext-install -j "$(nproc)" \
		intl \
		mbstring \
		mysqli \
		opcache \
		mysqli \
		pdo \
		pdo_mysql \
	; \
	\
	pecl install apcu-5.1.18; \
	docker-php-ext-enable \
		apcu \
	; \
	\
	# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*

# Enable Short URLs
RUN set -eux; \
	a2enmod rewrite; \
	{ \
		echo '<Directory /var/www/html>'; \
		echo '  RewriteEngine On'; \
		echo '  RewriteCond %{REQUEST_FILENAME} !-f'; \
		echo '  RewriteCond %{REQUEST_FILENAME} !-d'; \
		echo '  RewriteRule ^ %{DOCUMENT_ROOT}/index.php [L]'; \
		echo '</Directory>'; \
	} > "$APACHE_CONFDIR/conf-available/short-url.conf"; \
	a2enconf short-url

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# SQLite Directory Setup
RUN set -eux; \
	mkdir -p /var/www/data; \
	chown -R www-data:www-data /var/www/data

# Version
ENV MEDIAWIKI_MAJOR_VERSION 1.34
ENV MEDIAWIKI_BRANCH REL1_34
ENV MEDIAWIKI_VERSION 1.34.0
ENV MEDIAWIKI_SHA512 b6b1aeec26a1c114eeec0bdf18d4b3160fe02dac2920a39a045acb74e62aa8f8a28e6a81c01fedba7976e4dd0c96463e0f1badfddd3015eef9197b01586a236d

# MediaWiki setup
RUN set -eux; \
	curl -fSL "https://releases.wikimedia.org/mediawiki/${MEDIAWIKI_MAJOR_VERSION}/mediawiki-${MEDIAWIKI_VERSION}.tar.gz" -o mediawiki.tar.gz; \
	echo "${MEDIAWIKI_SHA512} *mediawiki.tar.gz" | sha512sum -c -; \
	tar -x --strip-components=1 -f mediawiki.tar.gz; \
	rm mediawiki.tar.gz; \
	chown -R www-data:www-data extensions skins cache images


# install extensions
COPY vendor/VisualEditor extensions/VisualEditor
COPY LocalSettings.php LocalSettings.php
COPY logo.png logo.png
COPY vendor/MobileFrontend extensions/MobileFrontend
COPY vendor/MinervaNeue skins/MinervaNeue
COPY vendor/MixedNamespaceSearchSuggestions extensions/MixedNamespaceSearchSuggestions
COPY vendor/simplesamlphp-1.18.4 simplesamlphp
COPY vendor/Auth_remoteuser extensions/Auth_remoteuser
COPY vendor/MassEditRegex extensions/MassEditRegex

# SimpleSAML setup
RUN ln -sf simplesamlphp/www simplesaml
COPY simplesamlconfig/config.php simplesamlphp/config/config.php
COPY simplesamlconfig/saml20-idp-remote.php simplesamlphp/metadata/saml20-idp-remote.php
COPY simplesamlconfig/authsources.php simplesamlphp/config/authsources.php

COPY vendor/PluggableAuth extensions/PluggableAuth
COPY vendor/SimpleSAMLphp extensions/SimpleSAMLphp
COPY vendor/Renameuser extensions/Renameuser

# Patch Media-wiki, set 403-code on permission errors
COPY patches /tmp/patches
RUN sed 's/\x0D$//g' -i /var/www/html/includes/OutputPage.php /tmp/patches/OutputPage-403.patch
RUN patch /var/www/html/includes/OutputPage.php < /tmp/patches/OutputPage-403.patch

RUN	chown -R www-data:www-data extensions skins cache images
