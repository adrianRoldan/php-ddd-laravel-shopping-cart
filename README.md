<h1 align="center">
  Shopping Cart in Laravel with DDD, CQRS and Ports and Adapters Architecture
</h1>

### Explanation of my solution
I have chosen to implement my solution in PHP 8.1.8 using the Laravel framework to use the routing, dependency container and some infrastructure helpers.
Finally, I have decided to make a Rest API with endpoints that implement the required actions.

I have also chosen to persist in Mysql to emulate a more realistic behavior of a shopping cart.

The business logic is decoupled from the framework in the src/ folder trying to using the DDD approach and best practices.

#### Summary of technologies and code practices:

- PHP8.1.8
- Laravel 9.19
- DDD
- Hexagonal architecture
- CQRS
- MySQL 8
- Event-Driven. System that reflects any relevant business event.
- Stored all events in a store events.
- Docker to up the environment
- PHPstan package to check and fix the code quality
- Makefile to manage environment, tests and phpstan

To test the features, I recommend use a Postman or similar to call endpoints.

#### Code folder strucuture
My code is located in the following directories. The rest of the directories are from the framework.
- Apps/ - Controllers  for the Apps using the Domain. Manage the unique entry points at domain.
    - Api/ - Contain the webcontrollers and actions that interacts with the domain. Is the unic entry point to endpoints api
    - Shared - Utils to receive and manage requests and build responses
- Src/  - domain main folder (DDD)
    - Core/ - logic of the main domain
    - Shared/ - Contains the shared code between domains (bounded contexts). In this case only we have one

### Needed tools
1. Unix environtment. Unix SO or WSL for Windows or 
2. [Install Docker](https://www.docker.com/get-started)
3. Install make. 

### Install and up the project
1. Clone this repository
2. Execute ```$ make start```

This command build and run the docker image and docker-compose, install dependencies and configure all systems. Also execute the database migrations and populate with some date of Products.

You can execute ```$ make bash``` to enter at webapp container console. 

Containers:
- The API runs in http://localhost:80
- The mysql runs in: localhost:3306
- The PhpMyAdmin runs in: localhost:8080

#### MakeFile utils
<p>
    <img src="public/assets/readme/makefile_utils.png" />
</p>

### API Endpoints

The <strong>Api.postman_collection.json</strong> file has the collection of API requests available with the input data to import into [postman](https://www.postman.com/).

*IMPORTANT: This implementation tries to emulate the behavior of a shopping cart, then a shopping cart is linked to a user (userId). A user is assigned an unique open or pending shopping cart at most.
Some endpoints use the user to performs an action on a cartm,so the information of a cart will be obtained from the userId.*

### POST /api/cart/product/add

Add a product in a cart

**Body:** _required_. User of the cart, product id and quantity of products

**Content Type** `application/json`

Sample:

```json

{
    "productId": "f3b25f80-7203-4678-9512-bef61f8c9c30",
    "userId": "093a959c-15e2-4406-8883-a6992a0745b1",
    "quantity": 4
}
```

Responses:

* **200 OK** When the product added correctly
* **400 Bad Request** When there is a failure in the request format, expected
  headers, or the payload can't be unmarshalled.

### DELETE /api/cart/product/remove

Add a product of the cart

**Body** _required_ Product Id and user of the cart

**Content Type** `application/json`

Sample:

```json
{
    "productId" : "175a048a-f514-4b48-b694-bf18ebf24df5",
    "userId"    : "093a959c-15e2-4406-8883-a6992a0745b1"
}
```

Responses:

* **200 OK** When the product has been removed form the cart
* **400 Bad Request** When there is a failure in the request format, expected
  headers, or the payload can't be unmarshalled.

### GET /api/cart/{userId}/show

Shows info of a cart

**Body** _required_ The group of people that wants to perform the journey


Responses:

* **200 OK** With the data of cart.
* Sample:

```json
{
    "productId" : "175a048a-f514-4b48-b694-bf18ebf24df5",
    "userId"    : "093a959c-15e2-4406-8883-a6992a0745b1"
}
```
* **400 Bad Request** When there is a failure in the request format or the
  payload can't be unmarshalled.

### GET /api/product/list



### GET /api/cart/list



### GET /api/cart/{userId}/amount/{currency?}

