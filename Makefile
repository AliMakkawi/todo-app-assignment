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
