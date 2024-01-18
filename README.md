# Library Digital Management System
# Installation
1. clone the repository
     ```bash
     git clone --recursive https://github.com/NAB-TAG/nortbook-api2.git
2. It is required to have docker desktop installed and started
3. open a terminal
4. Navigate to the project directory
     ```bash
     cd route/to/project
5. Crea y levanta los contenedores
     ```bash
     docker-compose up -d
6. once finished install the dependencies using laravel
     ```bash
     docker-compose exec myapp composer install
7. now copy the .env.example and copy and paste it into a new file called .env
8. now create an api key
     ```bash
     docker-compose exec myapp php artisan key:generate
9. make the migrations and plant the seeds
    ```bash
    docker-compose exec app php artisan migrate:refresh
    docker-compose exec app php artisan db:seed
10. everything is ready to use!!!



# Introduction
This project is a Laravel and MySQL-based backend application for managing a digital library. It includes user authentication, CRUD operations for books and reviews, search functionality, and optional features such as Dockerization. The system adheres to best practices for code clarity, maintainability, security, and error handling.

## Modeling Data
1. users:
  * id (unique)
  * name (string, max: 100)
  * pseudonym (string, max: 100)
  * email (unique, email)
  * password (password, max: 200)

2. books:
   * id (unique)
   * title (string, max: 100)
   * author (string)
   * publication_year (int)

3. reviews:
   * id (unique)
   * user_id (int)
   * book_id (int)
   * review_text (string, max: 625)
   * rating (int)


## API Endpoints
Note: For methods PUT, DELETE, and POST, the response format will be an array of strings with three elements: [ "type", "title", "message" ]. This is designed particularly for handling response messages with SweetAlert2

### Register a new user
  * Endpoint: '/api/register'
  * Method: POST
  * Description: Registers a new user.
  * Parameters:
    * name (string)
    * pseudonym (string)
    * email (email)
    * password (string)
    * confirmation_password (string)
  * Responses
    * 201: Successful registration.
    * 422: I do not spend a validation.
    * 500: Error on the server.

### Log in
  * Endpoint: '/api/login'
  * Method: POST
  * Description: Login a user. Copy the token generated and paste it in the BearerToken in all request to simulate a connected   user
  * Parameters:
    * email (email)
    * password (string)
  * Responses
    * 201: Log in successful.
    * 401: You do not have permissions for this action
    * 422: I do not spend a validation.

### Log out
  * Endpoint: '/api/logout'
  * Method: GET
  * Description: Close the session by deleting the cookies used by the front en developer.
  * Parameters:
    * none
  * Responses
    * 200: Log out successful.
   
 ### User Profile
  * Endpoint: '/api/user_profile'
  * Method: GET
  * Description: Shows you the connected user
  * Parameters:
    * none
  * Responses
    * 200:
      ```json
      {
        "id": 1,
        "name": "Nando Agustin Bravo",
        "email": "nicnando123@gmail.com",
        "email_verified_at": null,
        "created_at": "2024-01-16T17:46:34.000000Z",
        "updated_at": "2024-01-16T17:46:34.000000Z"
      }
    * 401: incorrect password and/or email

### Decrypt Token
  * Endpoint: '/api/decrypt'
  * Method: GET
  * Description: Decrypt the cookie used by the front-end developer for later use
  * Parameters:
    * none
  * Responses
    * 200:
      ```json
      ['3|PgfmOAy9K5shxAIVzWcQA4nHPHavD9xBApFAvUQj75b1b8aa']

### Create a book
  * Endpoint: '/api/book/create'
  * Method: POST
  * Description: Create a book
  * Parameters:
    * title (string)
    * publication_year (integer)
  * Responses
    * 201: successful book creation.
    * 403: There is no user logged in
    * 422: I do not spend a validation.
    * 500: Error on the server.

### Update a book
  * Endpoint: '/api/book/edit/{id}'
  * Method: PUT
  * Description: Update a specific book
  * Parameters:
    * title (string)
    * publication_year (integer)
  * Responses
    * 201: successful book creation.
    * 403: There is no user logged in
    * 422: I do not spend a validation.
    * 500: Error on the server.
      
### Show all books
  * Endpoint: '/api/books'
  * Method: GET
  * Description: show all books in a laravel page
  * Parameters:
    * none
  * Responses
    * 200:
      ```bash
      {
      "current_page": 1,
      "data": [
        {
          "id": 1,
          "title": "Harry Potter",
          "author": "Nando Agustin Bravo",
          "publication_year": 2000,
          "created_at": "2024-01-18T13:40:21.000000Z",
          "updated_at": "2024-01-18T13:40:21.000000Z"
        }
      ],
      "first_page_url": "http://localhost:8000/api/books?page=1",
      "from": 1,
      "last_page": 1,
      "last_page_url": "http://localhost:8000/api/books?page=1",
      "links": [
        {
          "url": null,
          "label": "&laquo; Previous",
          "active": false
        },
        {
          "url": "http://localhost:8000/api/books?page=1",
          "label": "1",
          "active": true
        },
        {
          "url": null,
          "label": "Next &raquo;",
          "active": false
        }
      ],
      "next_page_url": null,
      "path": "http://localhost:8000/api/books",
      "per_page": 12,
      "prev_page_url": null,
      "to": 1,
      "total": 1
    }

### search books
  * Endpoint: '/api/books/{search}'
  * Method: GET
  * Description: show all books that match the search (author, title, publication_year) on a Laravel page
  * Parameters:
    * none
  * Responses
    * 200:
      ```bash
      {
      "current_page": 1,
      "data": [
        {
          "id": 1,
          "title": "Harry Potter",
          "author": "Nando Agustin Bravo",
          "publication_year": 2000,
          "created_at": "2024-01-18T13:40:21.000000Z",
          "updated_at": "2024-01-18T13:40:21.000000Z"
        }
      ],
      "first_page_url": "http://localhost:8000/api/books?page=1",
      "from": 1,
      "last_page": 1,
      "last_page_url": "http://localhost:8000/api/books?page=1",
      "links": [
        {
          "url": null,
          "label": "&laquo; Previous",
          "active": false
        },
        {
          "url": "http://localhost:8000/api/books?page=1",
          "label": "1",
          "active": true
        },
        {
          "url": null,
          "label": "Next &raquo;",
          "active": false
        }
      ],
      "next_page_url": null,
      "path": "http://localhost:8000/api/books",
      "per_page": 12,
      "prev_page_url": null,
      "to": 1,
      "total": 1
    }

### Delete a book
  * Endpoint: '/api/book/delete/{id}'
  * Method: DELETE
  * Description: Delete a specific book
  * Parameters:
    * none
  * Responses
    * 201: deleted successful book.
    * 403: There is no user logged in
    * 500: Error on the server.

### Show reviews of a certain book
  * Endpoint: '/api/reviews/book/{id_book}'
  * Method: GET
  * Description: Show reviews of a certain book
  * Parameters:
    * none
  * Responses
    * 200: 
    ```bash
    [
      {
        "id": 1,
        "user_id": 1,
        "book_id": 1,
        "review_text": "Muy bueno",
        "rating": 3,
        "created_at": "2024-01-18T14:07:42.000000Z",
        "updated_at": "2024-01-18T14:07:42.000000Z"
      }
    ]

### Create a review of a certain book
  * Endpoint: '/api/reviews/create/{id_book}'
  * Method: POST
  * Description: create a review for a specific book
  * Parameters:
    * review_text (string)
    * rating (int)
  * Responses
    * 201: successful review creation.
    * 403: There is no user logged in
    * 422: I do not spend a validation.
    * 500: Error on the server.

### Update a review of a certain book
  * Endpoint: '/api/reviews/edit/{id_book}'
  * Method: PUT
  * Description: Update a review for a specific book
  * Parameters:
    * review_text (string)
    * rating (int)
  * Responses
    * 201: successful review update.
    * 403: There is no user logged in
    * 422: I do not spend a validation.
    * 500: Error on the server.
    * 505: You did not publish this review
   
### Delete a review of yours
  * Endpoint: '/api/reviews/delete/{id_book}'
  * Method: DELETE
  * Description: Delete a review for a specific book
  * Parameters:
    * none
  * Responses
    * 201: successful review update.
    * 403: There is no user logged in
    * 422: I do not spend a validation.
    * 500: Error on the server.
    * 505: You did not publish this review
   
