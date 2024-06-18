<a name="readme-top"></a>

<div align="center">
    <h3 align="center">Backend Developer coding test</h3>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-test">About the test</a>
    </li>
    <li>
      <a href="#requirements">Requirements</a>
      <ul>
        <li><a href="#product-specifications">Product specifications</a></li>
        <li><a href="#api-requirements">API Requirements</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#bonus-points">Bonus points</a>
    </li>
  </ol>
</details>

<!-- ABOUT THE TEST -->
## About the test

You're tasked to create a simple REST web service application for a fictional e-commerce business using Laravel.

You need to develop the following REST APIs:

* Products list
* Product detail
* Create product
* Update product
* Delete product

<!-- REQUIREMENTS -->
## Requirements

### Product specifications

A product needs to have the following information:

* Product name
* Product description
* Product price
* Created at
* Updated at

### API requirements

* Products list API
    * The products list API must be paginated.
* Create and Update product API
    * The product name, description, and price must be required.
    * The product name must accept a maximum of 255 characters.
    * The product price must be numeric in type and must accept up to two decimal places.
    * The created at and updated at fields must be in timestamp format.

Others:
* You are required to use MYSQL for the database storage in this test.
* You are free to use any library or component just as long as it can be installed using Composer.
* Don't forget to provide instructions on how to set the application up.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

* Git
* Composer
* PHP ^8.0.2
* MySQL

### Installation

* Create a new repository under your account named `{FIRST NAME}-{LAST NAME}-coding-test`. (e.g. `john-doe-coding-test`)
* Push your code to the new repository.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- BONUS POINTS -->
## Bonus points

#### For bonus points:

* Cache the response of the Product detail API. You are free to use any cache driver.
* Use the Service layer and Repository design patterns.
* Create automated tests for the app.

#### Answer the question below by updating this file.

Q: The management requested a new feature where in the fictional e-commerce app must have a "featured products" section.
How would you go about implementing this feature in the backend?

A: I would add an 'is_featured" field to the products table, allowing administrators to mark or unmark products as featured. An API endpoint will also be created to handle CRUD operations with this new functionality. 

## Run Locally

Clone the Repository

```bash
  git clone https://github.com/geekyari/arrian-tolentino-coding-test.git
```

Install dependencies

```bash
  composer install or composer update
```

Create a database on mysql and update the DB_DATABASE key on .env with the following:

```bash
  arrian-tolentino-coding-test

```

Run migrations

```bash
  php artisan migrate:fresh --seed
```


## API Reference

####  NOTE: Ensure requests are sent with Content-Type: application/json header to receive detailed validation error messages.

#### GET all products

```http
  GET /api/v1/products
```

#### GET a product

```http
  GET /api/v1/products/{id}
```

| Parameter | Type      | Description                       |
| :-------- | :-------- | :-------------------------------- |
| `id`      | `integer` | **Required**. Id of item to fetch |

#### CREATE a product

```http
  POST /api/v1/products
```

#### Request Body

```post
  {
      "productName": "Product Samples",
      "description": "Lorem Ipsum Dolor",
      "price": "13.00"
  }
```

| Parameter     | Type     | Description                        |
| :------------ | :------- | :--------------------------------- |
| `productName` | `string` | **Required**. Name of the product  |
| `description` | `string` | **Required**. Desc of the product  |
| `price`       | `float`  | **Required**. Price of the product |


#### UPDATE a product

```http
  PUT /api/v1/products/{id}
```

#### Request Body

```put
  {
      "productName": "Product Sample",
      "description": "Lorem Ipsum Dolor",
      "price": "13.00"
  }
```

| Parameter     | Type     | Description                        |
| :------------ | :------- | :--------------------------------- |
| `id`          | `integer`| **Required**. Id of item to update |
| `productName` | `string` | **Required**. Name of the product  |
| `description` | `string` | **Required**. Desc of the product  |
| `price`       | `float`  | **Required**. Price of the product |

#### UPDATE a specific field of a product

```http
  PATCH /api/v1/products/{id}
```

#### Request Body

```patch
  {
      "productName": "Product Sample"
  }
```

| Parameter     | Type     | Description                        |
| :------------ | :------- | :--------------------------------- |
| `id`          | `integer`| **Required**. Id of item to update |
| `productName` | `string` | **Optional**. Name of the product  |
| `description` | `string` | **Optional**. Desc of the product  |
| `price`       | `float`  | **Optional**. Price of the product |

#### DELETE a product

```http
  DELETE /api/v1/products/${id}
```

| Parameter     | Type     | Description                        |
| :------------ | :------- | :--------------------------------- |
| `id`          | `integer`| **Required**. Id of item to delete |