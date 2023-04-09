# SQLAction
*This package is an extension of Agrandesr/agile-router (v1.0+).*

This Custom Action is a first easy implementation of PDO for mysql over Agile Router to send emails in a very easy way using the Custom Actions of Agile Router.

## Installation
First we need to require the package:
``` bash
composer require agrandesr/sql-custom-action
```
Next, we need to add to the Router before the run method.

``` php
require './vendor/autoload.php';

use Agrandesr\Router;

$router = new Router();

$router->addCustomAction('mail','App\\CustomActions\\SQLAction');

$router->run();
```
Next you have to modify .env file with your mail server data:
``` .env
SQL_TYPE=
SQL_HOST=
SQL_USER=
SQL_PASS=
SQL_DTBS=
SQL_PORT=
SQL_CHAR=
```

Now you can use the new action in your routes file.

``` json
{
    "mail":{
        "query":{
            "execute":[
                {
                    "name":"user",
                    "type":"sql-action",
                    "content":{
                        "sql":"SELECT * FROM users WHERE id like ?",
                        "params":[
                            "1"
                        ]
                    }
                },
                {
                    "type":"json",
                    "content":{
                        "body":{
                            "user":"||user.0.mail||"
                        }
                    }
                }
            ]
        }
    }
}
```
And that is all, you can create a endpoint to send a email very easy.

## Content parameters
Like you can see in the example, the action "PhpMailer" have the next parameters:
 - sql['required']: This is the sql sentence that you want to execute. You can follow PDO to make queries.
 - values['optional']: This is the place to add the values to the query.

## ENV variables
You can have more than one mail server setted for one project using envFlag. The envFlag adds the value of the endFlag in the middle of your envFlag key. For example:
``` json
{
    "sql":{
        "GET":{
            "execute":[
                {
                    "type":"sql",
                    "content":{
                        "envFlag":"CALIFORNIA",
                        "sql":"SELECT * FROM id=?",
                        "values":[1]
                    }
                },
                {
                    "type":"sql",
                    "content":{
                        "envFlag":"TEXAS",
                        "sql":"SELECT * FROM id=:id",
                        "values":{
                            "id":1
                        }
                    }
                }
            ]
        }
    }
}
```
For the last example you have to complete other env variables:
``` .env
SQL_CALIFORNIA_TYPE=
SQL_CALIFORNIA_HOST=
SQL_CALIFORNIA_USER=
SQL_CALIFORNIA_PASS=
SQL_CALIFORNIA_DTBS=
SQL_CALIFORNIA_PORT=
SQL_CALIFORNIA_CHAR=

SQL_TEXAS__TYPE=
SQL_TEXAS__HOST=
SQL_TEXAS__USER=
SQL_TEXAS__PASS=
SQL_TEXAS__DTBS=
SQL_TEXAS__PORT=
SQL_TEXAS__CHAR=
```