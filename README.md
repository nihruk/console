# Console (IODA)

This is the home of Console (IODA).

## Exploration
Console (IODA) is currently in its exploration phase. Some of the efforts contained in the repository are:

## OpenAPI Documentation

### OpenAPI specification
The specification is kept in `./openapi/index.yaml`, and follows OpenAPI 3.1, along with JSON Schema Draft 2020-12.

### View the API documentation
- Visit https://ioda.vercel.app/ to view the latest stable documentation.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

## The Console (IODA) Web Application
This is currently a bare bones symfony project

## Development
### System Requirements
- Docker
- Bash (required to run usage commands)


### Usage Instructions
- Clone this repository
- Open a Bash terminal (such as Git Bash or WSL if on Windows)
- Run `./bin/dev-start` to start the development environment
- Run `./bin/dev-build` to (re)build the Console (IODA) application
- Go to http://localhost:8000 to access the Console (IODA); [/api/doc](http://localhost:8000/api/doc) for docs

#### Testing
- Run `./bin/dev-test` to run build tests
- Run `./bin/dev-test web` to run live tests


