# Console (IODA)
This is the home of Console (Formerly IODA).

## Development
Console is currently in its development phase. Some of the efforts contained in the repository are:

### OpenAPI Documentation

### OpenAPI specification
The specification is kept in `./openapi/index.yaml`, and follows OpenAPI 3.1, along with JSON Schema Draft 2020-12.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

### View the API documentation
- Visit https://ioda.vercel.app/ to view the latest stable documentation.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

## The Console (IODA) Web Application
## System Requirements
 - Docker
 - Bash (required to run usage commands)
 - Linux or WSL
   
The application will run on Windows but this is not recommended due to performance issues. 

## Usage Instructions

### Windows (with WSL)
 - Open a terminal for your distro (Ubuntu default)
 - Ensure you are in your Linux home folder
 - Ensure you have set up GitHub SSH keys for you Linux distro.  These can be copied over from Windows, but you may need to restrict permissions (chmod 640)

In Windows File Explorer the location of the code should look like:  `\\wsl.localhost\Ubuntu\home\<your account>\console`\
In the WSL terminal: `/home/<your account>/console`

You can use Windows Explorer to open the code in your favourite IDE

### All platforms
 - Clone this repository
 - Open a Bash terminal and navigate to the repo folder 
 - Run `./bin/dev-start` to start the development environment
 - Run `./bin/dev-build` to (re)build the Console (IODA) application

## Testing
Run `./bin/dev-test`


