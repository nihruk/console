# IODA

This is the home of IODA.

## Exploration
IODA is currently in its exploration phase. Some of the efforts contained in the repository are:

## OpenAPI Documentation

### OpenAPI specification
The specification is kept in `./openapi/index.yaml`, and follows OpenAPI 3.1, along with JSON Schema Draft 2020-12.

### View the API documentation
- Visit https://ioda.vercel.app/ to view the latest stable documentation.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

### Development
Run `npm install`.

#### QA
Run `npm run test`.

## The IODA Web Application
This is currently a bare bones symfony project

### System Requirements
- php >= 8.1.*
- composer

### Usage Instructions
- clone this repository
- if you don't have it, install composer from https://getcomposer.org/
- navigate to the cloned project folder 
- run `composer install`