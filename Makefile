.PHONY: up down d bash 

# Start the Docker Compose stack.
up:
	docker-compose up

# Stop the Docker Compose stack.
down:
	docker-compose down

# Start the Docker Compose stack.
d:
	docker-compose up -d

api:
	docker-compose exec api bash
