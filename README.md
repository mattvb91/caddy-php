<p align="center">
<img src="https://user-images.githubusercontent.com/11991564/180657106-aec2eb78-def3-4bad-aa4e-44f1e6ef1628.png" />
</p>

[![.github/workflows/ci_cd.yml](https://github.com/mattvb91/caddy-php/actions/workflows/ci_cd.yml/badge.svg)](https://github.com/mattvb91/caddy-php/actions/workflows/ci_cd.yml)
[![codecov](https://codecov.io/gh/mattvb91/caddy-php/branch/develop/graph/badge.svg?token=RYFGX2AW6J)](https://codecov.io/gh/mattvb91/caddy-php)
<a href="https://packagist.org/packages/mattvb91/caddy-php"><img src="https://img.shields.io/packagist/dt/mattvb91/caddy-php" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mattvb91/caddy-php"><img src="https://img.shields.io/packagist/v/mattvb91/caddy-php" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mattvb91/caddy-php"><img src="https://img.shields.io/packagist/l/mattvb91/caddy-php" alt="License"></a>

### Control your Caddy instance through PHP

This is more of a proof of concept rather than a fully working project. This tries to replicate
the [caddy JSON API](https://caddyserver.com/docs/json/)
structure to work through chainable PHP classes.

At the moment there is only a tiny subset of commands available from Caddy 2.0 that covered my currently needed use case.

### Install

```shell
composer require mattvb91/caddy-php
```

### Basic Usage

A basic example of a http server with a static response:

```php
$caddy = new Caddy();

$caddy->addApp(
    (new Http())->addServer(
        'server1', (new Http\Server())->addRoute(
        (new Route())->addHandle(
            new StaticResponse('Hello world', 200)
        )
    ))
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

### 

Take a look in the tests for more examples.

