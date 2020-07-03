## P5_blogPhp

[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com) [![forthebadge](https://forthebadge.com/images/badges/60-percent-of-the-time-works-every-time.svg)](https://forthebadge.com) [![forthebadge](https://forthebadge.com/images/badges/powered-by-electricity.svg)](https://forthebadge.com)

Project 5 of the "parcours développeur d'application PHP/Symfony" by Openclassrooms.

This project consist of creating a professionnal blog, that have severals required features. You can find them at [Visitors Pages](https://github.com/HaiseB/P5_blogPhp/issues/3) and [Administration Pages](https://github.com/HaiseB/P5_blogPhp/issues/4).

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
- ``.\vendor\bin\phinx migrate``

- Rename  `.exemple.env` in `.env`

## Settings
- Change all default values in `.env`

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

### Author
* **Benjamin Haise** _alias_ [@HaiseB](https://github.com/HaiseB)