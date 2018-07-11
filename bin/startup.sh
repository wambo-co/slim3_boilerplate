#!/bin/sh

# check for docker requirements

docker run --rm -v $(pwd):/app composer/composer install --ignore-platform-reqs
docker-compose up -d