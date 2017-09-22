# Flypay Test

Simple REST API project for Flypay coding test.

Built in top of Silex and Doctrine ORM.

## Usage

#### GET 'api/payments'
Will return payments processed in the last 24 hours for all locations.

#### GET 'api/payments?location_id=1'
Will return payments processed in the last 24 hours for location with id 1.

Response body will look like this:

```
[{
    "id": 12,
    "amount": 10,
    "tip": 0.5,
    "tableNumber": 17,
    "locationId": 1,
    "paymentReference": "testPaymentLocation1",
    "cardType": "visa",
    "processedAt": "2017-09-21 20:29:22.000000",
    "customerId": 987554658,
    "customerDevice": "iOSDevice"
}, {
    "id": 14,
    "amount": 10,
    "tip": 0,
    "tableNumber": 17,
    "location_id": 1,
    "payment_reference": "testPaymentLocation1",
    "card_type": "visa",
    "processed_at": "2017-09-21 20:29:22.000000",
    "customer_id": 987554658,
   "customer_device": null
}]
```

#### POST 'api/payments'

Will process and store new payments.

A request body like this is expected:

```
{
    "amount": 10,
    "tip": 0.20,
    "tableNumber": 17,
    "locationId": 2,
    "paymentReference": "paymentZxxclHou123b",
    "cardType": "visa",
    "customerId": 46558978552,
    "customerDevice": "androidBlaBlaBlah"
}
```

Will return a `201` response code when successfully processed.

If parameters are missing from the request body or are invalid, a `422` response code will be returned.

## Run locally

Clone repository and run `composer install`.

This project requires a MySQL database. To set up, create an emtpy database, import [schema.sql](resources/database/schema.sql) and update [config](resources/config/prod.php).

Web server should have document root on [public/index.php](public/index.php).

## Running tests

`./vendor/bin/phpunit`

