## Dependências

- Docker

### Execute os seguintes passos separadamente no seu terminal dentro da pasta do projeto:

`docker-compose up --build -d`

`docker run --rm --interactive --tty -v $PWD/lumen:/app composer install`

`docker exec -it php php /var/www/html/artisan migrate`

O ambiente pode ser acessado no http://localhost

### Tests

Na pasta `/lumen` execute em seu terminal:  ./vendor/bin/phpunit

## Collection de Postman na raiz