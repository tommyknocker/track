## Установка

```bash
git clone git@github.com:tommyknocker/track.git
```

## Запуск

Зайти в директорию трек и выполнить:

```bash
sudo docker compose build
sudo docker compose up -d
```

Выполнить одноразово

```bash
composer install
php yii migrate
```

Затем открыть в браузере http://localhost:8282

Если появляется ошибка с базой данных, наберите команду:

```bash
sudo docker inspect   -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' track-mysql-1
```

И вставьте полученный IP адрес в config/db.php и в tests/app.suite.yml


## Тестирование

```bash
./vendor/bin/codecept run tests/api
./vendor/phpunit/phpunit/phpunit --configuration=tests/phpunit/phpunit.xml tests/phpunit/functional/
```

