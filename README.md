# Technical
have a look at the the [PR standard](https://github.com/FreshinUp/fresh-platform/blob/master/docs/pull-request-standards.md)
1. on the PR description you should put 
> close #issue-number
2. move the ticket in zube to in progress
3. PR title should match issue title
4. PR title should contain "WIP" until it is ready for review and then you can remove it then move the ticket in zube to "in review"

## Front end 
1. Create storybook
2. Create test
2. Implement and iterate on component
Sample: https://github.com/FreshinUp/foodfleet/pull/629/commits/ab4afa991ef5b43f193448030e6439c9931187ea

## Back end
1. Write tests
2. Make a WIP PR to validate expectations 
3. Write implementation

# Development setup
1. Clone with ssh. To do so you will need to setup your github account to work with ssh
2. Install yarn version 1.x not 2.x.
3. Install node version 10 (comes with npm version 6)
4. Install composer 1.x not 2.x since that latest can break some dependencies
Now you should be able to setup any FreshinUp projects. There should be a README file for each. Try following the instruction on the development setup section.  

# Expectations
- Accuracy in communication
  * work description
    * invoicing: Did you ever use Jira or other system where you are entering time daily for your work ?
    - Efficiency in work item
    - Understand and being able to extend current code base

    Test project. This is a simple 20min to 1h project to get a sense of your coding standard and confirm your credentials. The tasks are the following:
    - Back end: integrate github API to retrieve commit list for a repository (parameter). In other words, build a backend api that is communicating with github and retrieve commit list
    - Front end: build UI to match screenshot below

    *Front end with VueJS*
    *Back end with Laravel*
    *Don't forget to write tests on both ends*
# Project scope
- build REST API that allows to read commits
- consume GitHub API from NodeJS
> references: https://developer.github.com/v3/

Front end
![image.png](https://zube.io/files/freshinup/396b3e9aae9a2fe3b3d2393edd820da4-image.png)

Back end
![image.png](https://zube.io/files/freshinup/2eabe1e25ef28a227d179b095a3d1022-image.png)

## SOLUTION
To setup this application, follow the instructions as specified under `Development Setup` before proceeding with the next steps.

1. ```bash
    composer install
   ```
2. ```bash 
   php artisan migrate:refresh --seed
    ```
3. ```bash
   php artisan serve --port=8090
   ```

**NB: I chose port 8090 because the default 8080 is already occupied on my localhost. Kindly choose what will suit you.**

The credentials to the dashboard will be available in terminal at which point, you can visit http://localhost:8090/login

To see the available APIs, simply run the following command.

```bash
php artisan route:list
```

A simpler one will be ```php artisan route:list -c``` 

Test with POSTMAN 

## Testing
You can either of the following commands to test the application

```bash
./vendor/bin/phpunit
```

```bash
./vendor/bin/pest
```

I prefer to use `pest`.
