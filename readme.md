# Planning AFIP Stagiaire

This project is a pratical work given by Olivier ROLLET, teacher at AFIP.

* Require >= PHP 7.1
* Require PDO_MYSQL php extension

## Install tutorial

Download project into a folder directly from repository or via your favorite gui git or cli

This project require no external framework or dependencies.

But need to run composer install for generate autoload files

```
composer install --no-dev
```

Create an VirtualHost in your apache vhost config file pointing into the web folder

It is recommended that you use an hostname with .localhost extension, as you have no needs to update your host file for pointing on localhost

```
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName planning.afip.localhost
	DocumentRoot /path/from/root/html/etc/project/web

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Push data in your db, data is stored in fixtures folder

* Push just database scheme
* OR database scheme + extra data

You can start project with empty databse and full fill it from interface

Then,

Edit the env.php file with your information ( /app/config/env.php )

```
putenv('DB_NAME=change-this');
putenv('DB_HOST=change-this');
putenv('DB_USERNAME=change-this');
putenv('DB_PASSWORD=change-this');
```

You are ready to start

## INFORMATION ABOUT PROJECT

### Components

* Messenger : Give ability to store messages to pass beetween pages.

```php
<?php 
Messenger::addMessage('Impossible de faire ça !', Messenger::DANGER);
Messenger::getMessages();
```

* Route & Router : Is a routing service that solve uri and check if router is configured for. Router is regex based and can generate var on the flight based on the current uri.

```php
<?php 
$router
    ->addRoute(
        'GET',
        '/go/to/road/{number}',
        function ($router, $number) {
            echo $number;
        }
    )
;
```

* Renderer : Rending a view. You can pass an array of variables throught the method as variable can be executed in view

```php
<?php 
Renderer::render(
    '/path/to/view.php',
    [
        'varNameIWantToPass1' => 10,
        'varNameIWantToPass2' => 'hello',
    ]
);
```

* Connectivity : A simple class that generate PDO on flight, it check that connection is always available, then recreate it if needed.

```php
<?php 
$pdo = PDOConnect::getConnection();
```


* Models\Traits : Is an minimalist ORM, it assume the abilities of Object to be instanciate from DB data or flush data directly on DB from Object. It also assume facilities for getting data via id or help extending get by a wanted field.

### Application

* Routes are defined in index file in web folder
* Controllers are stored in app/bundle/controllers
* Views are stored in app/bundle/templates

HAVE FUN!

For any question : moreau.marc.web@gmail.com
