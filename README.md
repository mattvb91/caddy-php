# PHP Caddy Client

### Control your Caddy instance through PHP

This is more of a proof of concept rather than a fully working project. This tries to replicate
the [caddy JSON API](https://caddyserver.com/docs/json/)
structure to work through chainable PHP classes.

At the moment there is only a tiny subset of commands available from Caddy 2.0. Have a look through the source code to
get
an idea and feel free to open a pull request if you want to add more structures to it.

### Install

```shell
composer require mattvb91/php-caddy
```

### Usage

A basic example of a http server with a static response:

```php
$caddy = new Caddy();

$caddy->addApp(
    (new Http())->addServer(
        'server1', (new Http\Server())->addRoute(
        (new Route())->addHandle(
            new StaticResponse('Hello world', 200)
        )
    )->setListen([':80']))
);

$caddy->load();
```

This will result in the following Caddy config:

```json
{
  "admin": {
    "disabled": false,
    "listen": ":2019"
  },
  "apps": {
    "http": {
      "servers": {
        "server1": {
          "listen": [
            ":80"
          ],
          "routes": [
            {
              "handle": [
                {
                  "handler": "static_response",
                  "body": "Hello world",
                  "status_code": 200
                }
              ]
            }
          ]
        }
      }
    }
  }
}
```

```shell
curl -v localhost

-----
< HTTP/1.1 200 OK
< Server: Caddy
Hello world       
```


Take a look in the tests for more examples.

