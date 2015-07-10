# Lumen Cors Package

[![Join the chat at https://gitter.im/vluzrmos/lumen-cors](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/vluzrmos/lumen-cors?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Lumen Version](https://img.shields.io/badge/Lumen-5.0%20%7C%205.1-orange.svg)](https://packagist.org/packages/vluzrmos/lumen-cors) [![Latest Stable Version](https://poser.pugx.org/vluzrmos/lumen-cors/v/stable)](https://packagist.org/packages/vluzrmos/lumen-cors) [![Total Downloads](https://poser.pugx.org/vluzrmos/lumen-cors/downloads)](https://packagist.org/packages/vluzrmos/lumen-cors) [![License](https://poser.pugx.org/vluzrmos/lumen-cors/license)](https://packagist.org/packages/vluzrmos/lumen-cors) [![Build Status](https://travis-ci.org/vluzrmos/lumen-cors.svg)](https://travis-ci.org/vluzrmos/lumen-cors) [![StyleCI](https://styleci.io/repos/35399055/shield)](https://styleci.io/repos/35399055)

A Simple [Cross Origin Resource Sharing](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) for Lumen Framework.

> Note: That should works fine on Laravel Framework too, but the tests are performed to Lumen.

# Install

```bash
composer require "vluzrmos/lumen-cors=2.1.*"
```

# Configure

On <code>boostrap/app.php</code> register the middleware:

```php
$app->middleware([
	//...,
	'Vluzrmos\LumenCors\CorsMiddleware'
]);
```

> You are free to use ::class notation.


And that is it!

# Considerations

That package stands to be free of configurations, then if you want a more
configurable package please consider to see one of these:

- [Barryvdh/LaravelCors](https://github.com/barryvdh/laravel-cors)
- [Nordsoftware/LumenCors](https://github.com/nordsoftware/lumen-cors)
