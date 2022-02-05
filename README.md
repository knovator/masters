
This package used for get list of defined constant from master 

Migration Added:

- Masters

Features:
- Get list of defined constant

Require the knovator/masters package in your composer.json and update your dependencies:

You want to need add masters repository in your composer.json file.

```"repositories": [
          {
              "type": "vcs",
              "url": "git@github.com:knovator/masters.git"
          }
      ],
```
This package included 
```prettus/l5-repository``` packages.
```
    composer require knovator/masters
 ```
In your ```config/app.php``` add ```knovator\Masters\MasterServiceProvider::class``` to the end of the providers array:

Publish Configuration:

```php artisan vendor:publish --provider "knovator\Masters\MasterServiceProvider"```

website : [ https://github.com/knovator/master ]
