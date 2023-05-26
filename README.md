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

## The IODA Web Application
This is currently a bare bones symfony project

## Development
### System Requirements
- php >= 8.1.*
- Composer
- Node.js/npm


### Usage Instructions
- clone this repository
- if you don't have it, install composer from https://getcomposer.org/
- navigate to the cloned project folder
- run `composer install`
- run `npm install`

#### QA
- To run tests against IODA documentation, run `npm run test`
- To run all available phpUnit tests against the IODA application, run `bin/phpunit`
- To run unit tests against the IODA application, run:  
  `bin/phpunit --testsuite unit`
- To run integration tests against the IODA application, run:  
  `bin/phpunit --testsuite integration`


