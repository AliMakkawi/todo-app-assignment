# Setup the application by building images, starting containers, and installing Composer dependencies
setup:
		@echo "Starting setup..."
		@make build
		@make up
		@echo "Setup complete."

# Build Docker images without cache and remove intermediate containers
build:
		@echo "Building Docker images..."
		docker-compose build --no-cache --force-rm
		@echo "Build complete."

# Start all services defined in the Docker Compose file in detached mode
up:
		@echo "Starting all Docker containers..."
		docker-compose up -d
		@echo "Containers started successfully."

# Stop all running containers without removing them
stop:
		@echo "Stopping all Docker containers..."
		docker-compose stop
		@echo "Containers have been stopped."

# Bring down all services and remove containers and networks created by 'up'
down:
		@echo "Shutting down all Docker containers..."
		docker-compose down
		@echo "Shutdown complete. All containers and networks have been removed."

# Generate app key
generate-key:
	docker exec todo-app bash -c "php artisan key:generate"
	@echo "Application key generated successfully."

# Apply database migrations
migrate:
		@echo "Running database migrations..."
		docker exec todo-app bash -c "php artisan migrate"
		@echo "Database migrations completed successfully."

