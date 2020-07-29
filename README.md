## P5_blogPhp

Project 5 of the "parcours développeur d'application PHP/Symfony" by Openclassrooms.

This project consist of creating a professionnal blog, that have severals required features. You can find them at [Visitors Pages](https://github.com/HaiseB/P5_blogPhp/issues/3) and [Administration Pages](https://github.com/HaiseB/P5_blogPhp/issues/4).

![Codacy Badge](https://api.codacy.com/project/badge/Grade/abf827e58f054b56958a7c7029eccd60) Direct link [Here](https://app.codacy.com/manual/HaiseB/P5_blogPhp/dashboard).

## Table of Contents
1. [Pre required](#Pre-required)
2. [Installation](#Installation)
3. [Settings](#Settings)
4. [How to use](#How-to-use)
5. [Build with](#Build-with)
6. [Author](#Author)

## Pre required
You will need to install those on your server
- *PHP* (7.2.10)
- *Apache* (2.4.35)
- *MySQL* (5.7.23)
- *Composer* (1.10.1)

## Installation
- Get sources files / Clone the repository [Here](https://github.com/HaiseB/P5_blogPhp)
> Make sure the `www` repository, is at the root of your server, you can also create a virtual host that redirect the visitors to the `www` directory.

_Go with a console to the repository and do thoses commands_
- ``composer install``
- ``composer update``
- ``create a new database``

-

- Rename  `.exemple.env` in `.env`

## Settings
- Change all default values in `.env`

_Go with a console to the repository (again) and do thoses commands_
- ``.\vendor\bin\phinx migrate``
- ``.\vendor\bin\phinx seed:run -s FillPostsTable -s FillUsersTable``
- ``.\vendor\bin\phinx seed:run -s FillCommentsTable``

## How to use

- Go to users stories (uml diagramms) in the `diagrammes` repository

- In the actual version, login infos are
    - login : Demo
    - password : demo[BlogPhp!72102435

## Build with
- [twig](https://twig.symfony.com/) - template engine
- [tinyMCE](https://www.tiny.cloud/) - text editor / create post
- [dotenv](https://www.npmjs.com/package/dotenv) - secure critical information
- [phinx](https://phinx.org/) - migrations for db
- [faker](https://github.com/fzaninotto/Faker) - generates fake data
- [swiftMailer](https://swiftmailer.symfony.com/docs/introduction.html) - sending e-mails from PHP applications
- [altorouter](https://altorouter.com/) - A php routing class
- [HttpFoundation](https://symfony.com/doc/current/components/http_foundation.html) - Defines an object-oriented layer for the HTTP specification

### Author
* **Benjamin Haise** _alias_ [@HaiseB](https://github.com/HaiseB)
