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

At the moment there is only a tiny subset of commands available from Caddy 2.0 that covered my currently needed use
case.

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

## Managing Hostnames

If you are managing hostnames dynamically (in a database) and can't build out the config with a list of
existing hostnames because you need to manage them at runtime you can do the following:

The important part in this example is the `host_group_name` identifier which is later
used to add / remove domains to this host.

```php
$caddy = new Caddy();
$caddy->addApp(
    (new Http())->addServer(
        'server1', (new Http\Server())->addRoute(
        (new Route())->addHandle(
            new StaticResponse('host test', 200)
        )->addMatch((new Host('host_group_name'))
            ->setHosts(['localhost'])
        )
    )->addRoute((new Route())
        ->addHandle(new StaticResponse('Not found', 404))
        ->addMatch((new Host('notFound'))
            ->setHosts(['*.localhost'])
        )
    ))
);
$caddy->load();
```

### Adding Hostnames

Now later on in a script or event on your system you can get your caddy configuration object and post
a new domain to it under that route:

```php
$caddy->addHostname('host_group_name', 'new.localhost')
$caddy->addHostname('host_group_name', 'another.localhost')
```

```shell
curl -v new.localhost
> GET / HTTP/1.1
> Host: new.localhost
> 
< HTTP/1.1 200 OK

curl -v another.localhost
> GET / HTTP/1.1
> Host: another.localhost
> 
< HTTP/1.1 200 OK
```

### Removing Hostnames

```php
$caddy->syncHosts('host_group_name'); //Sync from caddy current hostname list

$caddy->removeHostname('host_group_name', 'new.localhost');
$caddy->removeHostname('host_group_name', 'another.localhost');
```

```shell
curl -v new.localhost
> GET / HTTP/1.1
> Host: new.localhost
> 
< HTTP/1.1 404 Not Found

curl -v another.localhost
> GET / HTTP/1.1
> Host: another.localhost
> 
< HTTP/1.1 404 Not Found
```

### Advanced Example

Let's take a case where you want to have a Node frontend and a PHP backend taking requests on the `/api/*` route.
In this case the example breaks down to 2 reverse proxy's with a route matcher to filter the `/api/*` to the PHP
upstream.

This assumes the 3 hosts (Caddy, Node, PHP) are all docker containers and accessible by container name within
the same docker network, so you may have to adjust your hostnames as required.

```php
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Apps\Http\Server;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Transport\FastCGI;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Upstream;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Subroute;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Host;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Path;

$apiReverseProxy = (new ReverseProxy())
    ->addUpstream((new Upstream())
        ->setDial('laravel-api:9000')
    )->addTransport((new FastCGI())
        ->setRoot('/app/public/index.php')
        ->setSplitPath([''])
    );

$apiMatchPath = (new Path())
    ->setPaths([
        '/api/*',
    ]);

$backendAPIRoute = (new Route())
    ->addHandle($apiReverseProxy)
    ->addMatch($apiMatchPath);

$route = new Route();
$route->addHandle((new Subroute())
    ->addRoute($backendAPIRoute)
    ->addRoute((new Route())
        ->addHandle((new ReverseProxy())
            ->addUpstream((new Upstream())
                ->setDial('nextjs:3000')
            )
        )
    )
)->addMatch((new Host())
    ->setHosts([
        'localhost',
    ])
)->setTerminal(true);

$caddy = new Caddy();
$caddy->addApp((new Http())
    ->addServer('myplatform', (new Server())
        ->addRoute($route)
    )
);
$caddy->load();

```

This will post the following caddy config:

```json
{
  "admin": {
    "disabled": false,
    "listen": ":2019"
  },
  "apps": {
    "http": {
      "servers": {
        "myplatform": {
          "listen": [
            ":80"
          ],
          "routes": [
            {
              "handle": [
                {
                  "handler": "subroute",
                  "routes": [
                    {
                      "handle": [
                        {
                          "handler": "reverse_proxy",
                          "transport": {
                            "protocol": "fastcgi",
                            "root": "/app/public/index.php",
                            "split_path": [
                              ""
                            ]
                          },
                          "upstreams": [
                            {
                              "dial": "laravel-api:9000"
                            }
                          ]
                        }
                      ],
                      "match": [
                        {
                          "path": [
                            "/api/*"
                          ]
                        }
                      ]
                    },
                    {
                      "handle": [
                        {
                          "handler": "reverse_proxy",
                          "upstreams": [
                            {
                              "dial": "nextjs:3000"
                            }
                          ]
                        }
                      ]
                    }
                  ]
                }
              ],
              "match": [
                {
                  "host": [
                    "localhost"
                  ]
                }
              ],
              "terminal": true
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

< HTTP/1.1 200 OK
< Content-Type: text/html; charset=utf-8
< Server: Caddy
< X-Powered-By: Next.js
< Transfer-Encoding: chunked
< 
<!DOCTYPE html><html>....
```

```shell
curl -v localhost/api/testroute

< HTTP/1.1 200 OK
< Content-Type: application/json
< Server: Caddy
< X-Powered-By: PHP/8.1.7
< 
{"status":200}

```

Take a look in the tests for more examples.

