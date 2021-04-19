# W3I

This project is under development.

It will be intended to interact with the Instagram algorithm to manage its marketing on its social network.

This project is developed in php with Symfony techno!

I decided to separate the client / server logic, so this directory will be the API of the project that will use the REST standard.

To be able to start the project, you must have a FaceBook API key 



# LAUNCH THE PROJECT:

To start run `composer install` in your terminal to install the dependencies.

Create an .env.local file, copy / paste the .env of the project into your .env.local file.

Configure your FaceBook API information.

Configure your database line.

Run the `symfony console doctrine:database:create` command in your terminal to create the database.

Run the `symfony console doctrine:migration:migrate` command in your terminal to send the migrations to the database.

Generate a jwt key pair to be able to authenticate yourself:

  - Run `symfony console lexik:jwt:generate-keypair` to generate a key pair.

  - Copy / paste the "jwt / lexik-bundle" section in your .env which has just been generated, in your .env.local. 

Start the Symfony server by doing a `symfony server:start`.
