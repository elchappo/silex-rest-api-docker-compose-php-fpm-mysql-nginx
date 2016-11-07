#todo
- add config provider
- add functional tests

# Project Setup
1. Git Clone

`git clone git@github.com:noren/silex-rest-api-docker-compose-php-fpm-mysql-nginx.git`

2. Go to project directory and start Docker Compose (tested on version 1.8.0)

`cd silex-rest-api-docker-compose-php-fpm-mysql-nginx && docker-compose up`

3. Install composer dependencies
`docker exec -ti php /bin/bash -c 'composer install'`

4. Insert schema data
`docker exec -ti db /bin/bash -c 'mysql -u root -psecret api < /import/schema.sql'`

## GET (collection)
`curl http://127.0.0.1:8080/notes -H 'Content-Type: application/json' -w "\n"`

## GET (single item with id 1)
`curl http://127.0.0.1:8080/notes/1 -H 'Content-Type: application/json' -w "\n"`

## POST (insert)
`curl -X POST http://127.0.0.1:8080/notes -d '{"note":"Hello World!"}' -H 'Content-Type: application/json' -w "\n"`

## PUT (update)
`curl -X PUT http://127.0.0.1:8080/notes/1 -d '{"note":"Uhauuuuuuu!"}' -H 'Content-Type: application/json' -w "\n"`

## DELETE
`curl -X DELETE http://127.0.0.1:8080/notes/1 -H 'Content-Type: application/json' -w "\n"`