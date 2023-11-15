FROM nginx:latest
LABEL maintainer="MrGoose"

RUN requirements="nano cron openssl git" \
    && apt-get update && apt-get install -y --no-install-recommends $requirements && rm -rf /var/lib/apt/lists/* \
    && apt-get purge --auto-remove -y $requirementsToRemove

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/ssl-cert-snakeoil.key -out /etc/ssl/ssl-cert-snakeoil.pem -subj "/C=BR/ST=Sao Paulo/L=Sao Paulo/O=Security/OU=Development/CN=localhost"

EXPOSE 80
EXPOSE 443
