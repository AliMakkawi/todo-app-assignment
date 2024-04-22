# To-Do List Application

## Introduction
This To-Do List application is designed as an interactive web application using Laravel 11 and Livewire 3, utilizing domain-driven design and Docker-based deployment.

## Technical Overview

### Technologies & Packages Used
- **Laravel 11**: Chosen for its robust ecosystem, excellent documentation, and built-in features that accelerate web development.
- **Livewire 3**: Used for its seamless integration with Laravel and its capability to provide a reactive frontend experience without the complexity of a separate JavaScript framework.
- **Docker**: Ensures that the application runs consistently across all environments.
- **MySQL**: Reliable and widely used relational database management system, suitable for handling the data needs of a To-Do application.
- **Laravel Pint**: Used to ensure coding standards are met, and formatting the code to maintain consistency and readability.
- **Tailwind CSS**: Used to streamline and speed up the styling process.
- **Blade Icons**: Used to simplify the usage of icons throughout the application by providing ready-to-use Blade components.

### Design Decisions
- **State Management**: Livewire manages component states and interactions, minimizing the need for additional JavaScript.
- **No Authentication**: As per the assignment requirements, authentication is not implemented to focus on the core functionality of to-dos management.

## Setup Instructions

### Prerequisites
- **Docker**: Ensure Docker is installed to manage and run the containerized environment. For installation instructions, refer to the [official Docker documentation](https://docs.docker.com/get-docker/).

### Installation Instructions

#### Step 1: Environment Setup
Adjust the `.env.example` file to your environment settings and copy it:

```bash
cp .env.example .env
```

#### Step 2: Build and Run Using Docker
Execute the Makefile to build images and start the application:

```bash
make setup
```

This command performs the following actions:

- Builds Docker images without cache.
- Starts all services in detached mode using docker-compose.

#### Step 2: Generate application key
Execute the Makefile to generate the application key:

```bash
make generate-key
```

#### Step 3: Apply database migrations
Execute the Makefile to apply database migrations:

```bash
make migrate
```


### All Make Commands
- **make setup** - Full initial setup including build and up.
- **make build** - Builds Docker images.
- **make up** - Starts all Docker containers.
- **make stop** - Stops all running Docker containers.
- **make down** - Removes containers and networks.
- **make generate-key** - Generates application key.
- **make migrate** - Applies database migrations.


## Application Features

### User Stories
- **View All To-dos**: Users can view all their to-dos.
- **Add, View, Update, and Delete To-dos**: Users can manage their To-dos.
- **Mark To-dos as Done**: To-dos can be marked as completed with a single click.
- **Persistence**: User data is persisted in MySQL, ensuring that to-dos are saved between sessions.
- **Delete All To-dos**: Users can delete all their to-dos.
- **Delete Done To-dos**: Users can delete all their done to-dos.


## Development Notes
Developers can modify the source code and see changes by rebuilding the Docker container. This is facilitated by the make commands provided, ensuring a smooth development workflow within a Docker environment.
