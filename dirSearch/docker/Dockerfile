FROM php:8.2-fpm

# Настройка рабочего каталога
RUN mkdir -p /var/www/count

WORKDIR /var/www/count
# Устанавливаем владельца и права доступа
RUN chown -R www-data:www-data /var/www/count

USER www-data


# Указываем, что будет запущено по умолчанию
CMD ["php-fpm"]

# Открываем порт для PHP-FPM
EXPOSE 9000