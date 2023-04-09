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
Next you have to modify .env file with your sql connection data:
``` .env
SQL_TYPE=mysql
SQL_HOST=localhost
SQL_USER=root
SQL_PASS=******
SQL_DTBS=test
SQL_PORT=3306
SQL_CHAR=UTF8
```

Now you can use the new action in your routes file.

``` json
{
    "sql":{
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
You can have more than one SQL connection setted for one project using envFlag. The envFlag adds the value of the endFlag in the middle of your envFlag key. For example:
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
SQL_CALIFORNIA_TYPE=mysql
SQL_CALIFORNIA_HOST=localhost
SQL_CALIFORNIA_USER=root
SQL_CALIFORNIA_PASS=*******
SQL_CALIFORNIA_DTBS=test
SQL_CALIFORNIA_PORT=3306
SQL_CALIFORNIA_CHAR=UTF8

SQL_TEXAS__TYPE=mysql
SQL_TEXAS__HOST=localhost
SQL_TEXAS__USER=root
SQL_TEXAS__PASS=******
SQL_TEXAS__DTBS=test
SQL_TEXAS__PORT=3306
SQL_TEXAS__CHAR=UTF8
```