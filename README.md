# Library Digital Management System

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
  * Description: Close the session by deleting the cookies used by the front en developer, remember that if you continue passing your BearerToken it will continue to work
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
 ```json {
    "id": 1,
    "name": "Nando Agustin Bravo",
    "email": "nicnando123@gmail.com",
    "email_verified_at": null,
    "created_at": "2024-01-16T17:46:34.000000Z",
    "updated_at": "2024-01-16T17:46:34.000000Z"
  }
