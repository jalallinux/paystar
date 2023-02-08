<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://paystar.ir/homepage/image/logo.svg" width="400" alt="Laravel Logo"></a></p>

## Deploy instructions with Docker

### 1. Fill environment variables in [.env.docker](.env.docker)
```dotenv
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

REDIS_HOST=
REDIS_PASSWORD=
REDIS_PORT=
```

### 2. Build and up container
```shell
docker-compose up -d
````

### 3. Go to docker container
```shell
docker exec -it paystar.jalallinux.ir bash
```

### 4. Run migration command (in container)
```shell
php artisan migrate:fresh --seed
```

### Check application on port [9020](http://localhost:9020)
