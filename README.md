@todo
- config provider
- tests

http://127.0.0.1:8080/notes


https://github.com/vesparny/silex-simple-rest
https://github.com/petrepatrasc/docker-php-fpm
https://github.com/willgarcia/silex-api-boilerplate



docker exec -ti php /bin/bash -c 'composer install'

docker exec -ti db /bin/bash -c 'mysql -u root -psecret api < /import/schema.sql'

#GET (collection)
curl http://127.0.0.1:8080/notes -H 'Content-Type: application/json' -w "\n"

#GET (single item with id 1)
curl http://127.0.0.1:8080/notes/1 -H 'Content-Type: application/json' -w "\n"

#POST (insert)
curl -X POST http://127.0.0.1:8080/notes -d '{"note":"Hello World!"}' -H 'Content-Type: application/json' -w "\n"

#PUT (update)
curl -X PUT http://127.0.0.1:8080/notes/1 -d '{"note":"Uhauuuuuuu!"}' -H 'Content-Type: application/json' -w "\n"

#DELETE
curl -X DELETE http://127.0.0.1:8080/notes/1 -H 'Content-Type: application/json' -w "\n"