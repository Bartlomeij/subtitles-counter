## Installation

Build and run docker containers:

```
docker-compose build
docker-compose up -d
```

Log into docker container terminal:

`docker exec -it -u dev dev_php bash`

And run command:

`composer install`

Open `http://localhost:8081` in your browser

## Testing

To run tests log into docker container terminal:

`docker exec -it -u dev dev_php bash`

And run command:

`./vendor/bin/phpunit tests`