# symfony-vehicle-rest

## Requirements
- Docker
- Postman

## Project Booting

### Inside project root folder Run below command to clone `.env`
```bash
cp .env.example .env
```

### Inside project root folder Run below command to start docker
```bash
docker-compose up
```

### After running all docker containers run another command to enter container bash
```bash
docker-compose exec api bash
```
### Inside container bash run below command to install composer modules
```bash
composer install
```

### Inside container bash run below command to run migration
```bash
php bin/console doctrine:migration:migrate -n
```

### Inside container bash run below command to load fixtures
```bash
php bin/console doctrine:fixture:load -n
```

## Testing
Vehicle CURD will run on `http://localhost/` so import `./vehicle.postman_collection.json` to Postman app for the testing of CURD.
