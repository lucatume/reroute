Reroute
========

A small URL router in PHP built out of liquid rage. (There were no decent, lightweight URL routers for PHP 5.2 at the time)

Its core was inspired by the excellent [klein.php](https://github.com/chriso/klein.php) project.

Reroute is known to work on PHP 5.2 and above.



### How it works

Reroute has only 2 public methods: `add` and `run`.

In the site's `index.php` file, using a Reroute instance's `add` method, you build up a 
key-value list of routes and closures.

When you're done adding routes, you call the Reroute instance's `run` method.

When a requested URL matches a known route, the matching closure fires and provides the 
necessary HTML. All other URLs are redirected to a hard-coded closure (your 404 error page).

Reroute was designed for clean URLs and thus doesn't give a hoot about file extension.

`/home`, `/home.html`, and `home.php` are all the same to Reroute, and will result in
`/home`'s content being delivered.



### Testing

If you're using a trick like `$ php -S localhost:8000` to test your website offline, you'll need to 
manually enter your URLs in a form like `http://localhost:8000/index.php?uri=somepage`, since Reroute 
doesn't play nicely with localhost webservers, unless they support the `.htaccess`'s URLRewrite.



### Example

An example `index.php` file for a site with the urls: `/home`, `index`, `/products`, `/docs`, `/events`, `/contact`.

```
<?php

//LOAD REROUTE:
include 'reroute.php';

$router = new Reroute();


//MAIN PAGE:
$router->add('/',           create_function ('' , "\$output = include './pages/home.html'; sprintf(\$output);" ));

$router->add('/home',       create_function ('' , "\$output = include './pages/home.html'; sprintf(\$output);" ));

$router->add('/index',      create_function ('' , "\$output = include './pages/home.html'; sprintf(\$output);" ));


//CORE PAGES:
$router->add('/products',   create_function ('' , "\$output = include './pages/products.html'; sprintf(\$output);" ));

$router->add('/docs',       create_function ('' , "\$output = include './pages/docs.html'; sprintf(\$output);" ));

$router->add('/events',     create_function ('' , "\$output = include './pages/events.html'; sprintf(\$output);" ));

$router->add('/contact',    create_function ('' , "\$output = include './pages/contact.html'; sprintf(\$output);" ));


//START ROUTER/EVENT-HANDLER:
$router->run();

?>
```



### Apache v2 License

    Copyright 2013 Philip Conrad

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
