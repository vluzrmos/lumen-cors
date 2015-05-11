# Lumen Cors Package

A Simple Cross Origin Resource Share for Lumen Framework.

# Install

```bash 
composer require vluzrmos/lumen-cors
``` 

# Configure

On <code>boostrap/app.php</code> register the service provider:

```php
$app->register('Vluzrmos/LumenCors/Providers/CorsServiceProvider');
``` 

And the middleware:

```php
$app->middlewares([
	//...,
	'Vluzrmos/LumenCors/Middlewares/CorsMiddleware'
]);
```   


And that is it!

# License

[DBAD](http://www.dbad-license.org/).