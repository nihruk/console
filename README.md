# Console (IODA)
This is the home of Console (IODA).

## Development
Console (Formerly IODA) is currently in its development phase. Some of the efforts contained in the repository are:

### OpenAPI Documentation

### OpenAPI specification
The specification is kept in `./openapi/index.yaml`, and follows OpenAPI 3.1, along with JSON Schema Draft 2020-12.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

### View the API documentation
- Visit https://ioda.vercel.app/ to view the latest stable documentation.

- Run `npm run docs` in a Git clone to see the absolute latest documentation of the checked out version.

## The Console (IODA) Web Application
## Development
### System Requirements
 - Docker
 - Bash (required to run usage commands)
 - Linux or WSL
The application will run on Windows but this is not recommended due to performance issues. 

### Usage Instructions
#### Linux
 - Clone this repository
 - Open a Bash terminal and navigate to the repo folder 
 - Run ./bin/dev-start to start the development environment
 - Run ./bin/dev-build to (re)build the Console (IODA) application

#### Windows (with WSL)
 - Ensure you have set up GitHub SSH keys. These can be copied over from Windows, but you may need to restrict permissions (chmod 640)
 - Open a terminal for your distro (Ubuntu default)
 - Ensure you are in your home folder
 - Clone this repository in your home folder
   
In Windows File Explorer the location of the code should look like: `\\wsl.localhost\Ubuntu\home\<your account>\console`
In the WSL terminal: `/home/<your account>/console`

 - Run `./bin/dev-start` to start the development environment
 - Run `./bin/dev-build` to (re)build the PHP application

You can use Window Explorer to open the code in your favourite IDE

#### Testing
Run ./bin/dev-test


