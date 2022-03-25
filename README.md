# URL shortener API

## Как развернуть проект

- Выкачать проект
- Скопировать файл .env.example в .env и поправить в новом файле настройки под себя
- В корне проекта выполнить ```docker-compose up --build -d```
- зайти в корень докер-контейнера ```docker exec -it petrovich bash```

В корне докер-контейнера выполнить:
- ```composer install```
- ```composer dump-autoload```
- ```./vendor/bin/doctrine-migrations migrate```

## Как работать с API

- Для генерации короткого URL, передайте GET-параметр `url`:
- ```http://localhost/?url=https://docs.docker.com/engine/reference/d/kill/```

- Если запрос корректный, то вернется JSON ответ с параметром `short_url`

```
{
    "message": "OK",
    "code": 200,
    "data": {
        "short_url": "http://localhost/dc20fcbc"
    }
}
```

## Как обратиться к API из другого Docker-контейнера

- Отправлять GET-запрос на `host.docker.internal`
- ```host.docker.internal/?url=https://docs.docker.com/```
