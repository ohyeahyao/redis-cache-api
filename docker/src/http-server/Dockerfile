FROM nginx:1.16-alpine

# 因應 PHP-FPM 的使用者 www-data
RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data

EXPOSE 80