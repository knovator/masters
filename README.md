
This package used for get list of defined constant from master 

Migration Added:

- Masters

Features:
- Get list of defined constant

Require the knovators/masters package in your composer.json and update your dependencies:

You want to need add masters repository in your composer.json file.

```"repositories": [
          {
              "type": "vcs",
              "url": "git@git.knovator.in:knovators/master.git"
          }
      ],
```
This package included 
```prettus/l5-repository``` packages.
```
    composer require knovators/masters
 ```
In your ```config/app.php``` add ```Knovators\Masters\MasterServiceProvider::class``` to the end of the providers array:

Publish Configuration:

```php artisan vendor:publish --provider "Knovators\Masters\MasterServiceProvider"```

website : [ https://git.knovator.in/knovators/master ]