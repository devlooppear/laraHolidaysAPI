# laraHolidaysAPI 🌴

![Laravel Sail](https://img.shields.io/badge/Laravel-Sail-blue?logo=laravel)
![Postgres](https://img.shields.io/badge/Database-PostgreSQL-blue?logo=postgresql)
![Redis](https://img.shields.io/badge/Cache-Redis-blue?logo=redis)
![Docker](https://img.shields.io/badge/Container-Docker-blue?logo=docker)

This repository contains the backend codebase for a REST API that manages holiday plans, users, and related entities. It provides API endpoints for CRUD operations on holiday plans, users, holiday plan logs, participants groups.

## Features

-   CRUD operations on holiday plans, users, holiday plan logs, and participants groups.
-   Generation of PDF for holiday plans.
-   Sending emails when a holiday plan is created.
-   Authentication using OAuth tokens.
-   Error handling and logging.

## Entities

The main entities in this project are:

-   **HolidayPlan**: Manages the holiday plans.
-   **HolidayPlanLog**: Logs actions related to holiday plans.
-   **ParticipantsGroup**: Manages participants groups for holiday plans.
-   **User**: Stores user information.

## Dependencies

This project uses several technologies:

-   **Laravel**: A PHP framework for web application development.
-   **Postgres**: A relational database for storing application data.
-   **Redis**: An in-memory data structure store, used as a database, cache, and message broker. Redis is used for caching and speeding up responses.
-   **Docker**: A platform to develop, ship, and run applications inside containers. Docker ensures that the application runs the same way in every environment.
-   **Laravel Sail**: A light-weight command-line interface for interacting with Laravel's default Docker environment.

You will need Docker installed on your machine. You can see how to install it on your OS here.

## Get Started

Follow these steps to set up the project:

1. Install dependencies using a composer from a Laravel Sail image in Dockerhub:
    ```bash
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
    ```
    
2. Create a `.env`:
    ```bash
    cp .env.example .env
    ```

3. Generate a api key:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

4. Up the Docker environment:
    ```bash
    ./vendor/bin/sail up
    ```
5. Run tests (optional):
    ```bash
    ./vendor/bin/sail artisan test
    ```
6. Populate the database:
    ```bash
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```
7. (Optional) You can create a connection in a SGBD Manager, like DBeaver or Datagrip:
    - Create the connection with the '.env' db variables:
    ```
    
    ```

## Example when create a HolidayPlan and recive a email

<html>
    <div
        class="image-container"
        style="padding: 1em; display: block; margin: 0 auto; width: 90vw"
    >
        <img
            src="images-holiday-api/Screenshot from 2024-03-14 12-43-44.png"
            alt="img email pdf"
            style="
                display: block;
                max-width: 100%;
                width: 90 vw;
                margin: 0 auto;
                height: auto;
                border-radius: 12px;
                box-shadow: -2px 0px 8px 6px rgba(0, 0, 0, 0.2);
            "
        />
    </div>
</html>

## Example when create a HolidayPlan and recive a pdf

<html>
    <div
        class="image-container"
        style="padding: 1em; display: block; margin: 0 auto; width: 90vw"
    >
        <img
            src="images-holiday-api/Screenshot from 2024-03-14 12-21-11.png"
            alt="img about pdf"
            style="
                display: block;
                max-width: 100%;
                width: 90 vw;
                margin: 0 auto;
                height: auto;
                border-radius: 12px;
                box-shadow: -2px 0px 8px 6px rgba(0, 0, 0, 0.2);
            "
        />
    </div>
</html>



## Database Tables

The project uses the following database tables:

-   `failed_jobs`: Records failed queue jobs.
-   `holiday_plan_logs`: Logs actions related to holiday plans.
-   `holiday_plans`: Stores information about holiday plans.
-   `migrations`: Tracks database migrations.
-   `oauth_*`: Tables for OAuth authentication.
-   `participants_groups`: Manages participants groups for holiday plans.
-   `password_reset_tokens`: Stores password reset tokens.
-   `personal_access_tokens`: Manages personal access tokens for authentication.
-   `users`: Stores user information.

## Databse Schema

<html>
    <div
        class="image-container"
        style="padding: 1em; display: block; margin: 0 auto; width: 90vw"
    >
        <img
            src="images-holiday-api/Screenshot from 2024-03-14 13-51-00.png"
            alt="img database schema"
            style="
                display: block;
                max-width: 100%;
                width: 90 vw;
                margin: 0 auto;
                height: auto;
                border-radius: 12px;
                box-shadow: -2px 0px 8px 6px rgba(0, 0, 0, 0.2);
            "
        />
    </div>
</html>

## Notes

-   Remember if you run test it will refresh the database.
