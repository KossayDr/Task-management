# Task Mamagemety

## Overview

Task management system where users can log in and create, update,
and delete tasks. Each user can only manage their own tasks,
and all operations are secured using Laravel Sanctum.


## Features

- **User Roles**: `Admin`, `Editor`, and `User` with different permissions.
- **Task Management**: Create, edit, delete, and view tasks.
- **Role-Based Permissions**: Admins can manage users and all tasks, while editors and users have restricted access based on their roles.
- **API Integration**: The project includes API endpoints for task management.

## Technologies Used
- Laravel 8
- MySQL
- Spatie Laravel Permission (for role and permission management)
- Sanctum (for API authentication)


## Installation
1. Clone the repository:
    ```bash
    git clone https://github.com/KossayDr/Task-management.git
    cd Task-management

    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up the environment variables:
    - Copy `.env.example` to `.env`
    ```bash
    cp .env.example .env
    ```



4. Set up the database:
    - Update the `.env` file with your database credentials.
    - Set up your database:
    ```bash
    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password
    ```

5. Run the migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

6. Run the project:
    ```bash
    php artisan serve
    ```

7. Access the API or web interface at:
    ```
    http://localhost:8000
    ```

## API Endpoints
- **Login**: `/api/login`
- **Register**: `/api/register`
- **Task Management**: `/api/tasks`
- **Admin**: `/api/admin/roles|users`

## Roles and Permissions

- **Admin**: Has full access to all features, including user and task management.
- **Editor**: Can view, edit, and delete tasks.
- **User**: Can create, view, and manage their own tasks.
