## About The App
This is a small application to send notifications to users via SMS or Email. It provides a set of public APIs to manage clients (create, update and delete clients) and some private APIs to manage notifications.


## Requirements
This project uses:
- PHP8.0+
- Nginx
- Postgres
- RabbitMQ
- Mailhog

The application has been set up with docker and you need to install:
- docker
- docker-compose

on your machine to run the project.

## How to Run
In order to run the application you have to build the docker images and run the containers:

```bash
docker-compose up --build -d
```

The composer packages are installed automatically and it may takes a while to be completed.

The app is served at [localhost:8005](http://localhost:8005) when the containers are up and running and composer packages installation is done.

Now in order to run RabbitMQ workers run:

```bash
docker-compose exec app php artisan queue:work
```
And that's it. Let's enjoy :)

## REST APIs
There are two sets of APIs, public APIs and private APIs. 

### Public APIs

```
POST    api/clients             Create a client   
GET     api/clients/{client}    Get a client details   
PATCH   api/clients/{client}    Update a client
DELETE  api/clients/{client}    Delete a client
POST    api/agents              Creates an agent 
```

### Private APIs
```
GET     api/agents/clients                           View the list of created clients
GET     api/agents/clients/{client}                  View an already created client
POST    api/agents/notifications                     Send notification to a client
GET     api/agents/notifications                     Get the list of created notifications
GET     api/agents/notifications/{notification}      Get a notification details
```