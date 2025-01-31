# Laravel News Aggregator API

## Overview
This is a RESTful API for a news aggregator service that pulls articles from multiple sources and provides endpoints for a frontend application to consume.

## Features
- **User Authentication**: Laravel Sanctum-based authentication (registration, login, logout, password reset)
- **Article Management**: Fetch articles with pagination, search by keyword, date, category, and source
- **User Preferences**: Users can set and retrieve preferred news sources, categories, and authors
- **Data Aggregation**: Fetch and store articles from at least three news APIs
- **API Documentation**: Comprehensive API documentation using Swagger/OpenAPI
- **Docker Support**: Dockerized environment for easy setup
- **Security & Performance**: Data caching, rate limiting, and protection against common vulnerabilities

## Technologies Used
- Laravel
- Laravel Sanctum (API authentication)
- MySQL (or any preferred database)
- Docker
- Swagger/OpenAPI (API documentation)
- PHPUnit (for unit and feature testing)
- Laravel Scheduler (for periodic data fetching)

## Setup Instructions

### Prerequisites
- Docker and Docker Compose installed
- Composer installed

### Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/akhilnvsnemala/WarriorNEWS.git
   cd WarriorNEWS
   ```
2. Copy environment file:
   ```sh
   cp .env.example .env
   ```
3. Update `.env` with database and API keys
4. Install dependencies:
   ```sh
   composer install
   ```
5. Generate application key:
   ```sh
   php artisan key:generate
   ```
6. Run migrations and seed database:
   ```sh
   php artisan migrate --seed
   ```

### Running with Docker
1. Build and start the application:
   ```sh
   docker-compose up --build -d
   ```
2. Run migrations inside the container:
   ```sh
   docker exec -it news-aggregator-app php artisan migrate --seed
   ```
3. Access the application at `http://localhost`

### API Documentation
Swagger documentation is available at:
```
http://localhost/api/documentation
```

### Running Tests
To execute unit and feature tests:
```sh
php artisan test
```

## Submission Guidelines
1. Ensure your GitHub repository is public.
2. Include a clear commit history.
3. Submit the repository link for review.

## Notes
- Fetched articles are stored locally for optimized searching.
- API keys for news sources must be configured in the `.env` file.

We look forward to your implementation. Good luck!

