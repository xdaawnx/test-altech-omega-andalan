
## Installation Guide

  

Follow these steps to set up and run the project on your local machine.

  

### 1. Clone Project

  

Clone project to your local machine.

  

### 2. Update Configuration

  

Change `.env.example` in the root directory of the project file to `.env` then open it and update the configuration with your credentials.

  

Example:

> DB_CONNECTION=mysql
> 
> DB_HOST=127.0.0.1
> 
> DB_PORT=3306
> 
> DB_DATABASE=your_database_name
> 
> DB_USERNAME=your_database_username
> 
> DB_PASSWORD=your_database_password
> 
> CACHE_DRIVER=redis

  

### 3. Install Dependencies

  

Run the following command to install the project dependencies:

  

`composer install`

  

### 4. Run Migrations

  

Run the database migrations, use the following command:

  

`php artisan migrate`

  

### 5. Run the Application

  

Start the Laravel development server by running the following command:

  

`php artisan serve`

  

### 6. Access the API Documentation

  

Open your web browser and navigate to the following URL to access the API documentation:

  

`http://localhost:8000/api/documentation`

  

### 6. Testing

To run the tests, use the following command:

  

`php artisan test`


# Design Choices

1.  **Repository Pattern**: The repository pattern was used to separate the data access logic from the business logic. This promotes a clean architecture and allows for better testability and scalability. Each repository (for `Author` and `Book`) handles database operations, while the service layer is responsible for the business logic. Controllers communicate with services, which in turn communicate with repositories, making the architecture modular and easier to maintain.
    
2.  **Service Layer**: A service layer was introduced between the controllers and repositories. This abstraction allowed the business logic to be centralized and reused across different parts of the application. By having this intermediary, the controllers are kept lightweight and focused on handling HTTP requests and responses.

# Performance Tuning Techniques

 1. **Caching**: A basic caching layer was introduced to improve the performance of frequently accessed data, such as lists of authors and books. By caching the response for a specified period, the application avoids repeated database queries, which improves the overall speed and reduces the load on the database.