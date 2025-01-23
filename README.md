# Поиск по директории и сервис коментариев
## Поиск по директории

```bash
   docker-compose run --rm php
```
## Сервис для коментариев
Установка зависимостей
```bash
    docker-compose run --rm composer install
```
Запуск тестов
```bash
  docker-compose run --rm composer test ./tests/CommentServiceTests.php
```