# EXS-silex-locale-detector
Locale detection with country and language breakdown


## Installation

Create a composer.json in your projects root-directory :

```json
{
    "require": {
        "EXS/LocaleDetectorProvider": "~1.0"
    }
}
```

and run :

```shell
$ curl -sS http://getcomposer.org/installer | php
$ php composer.phar install
```

or run this command:
``` shell 
    composer require exs/silex-locale-detector v1.0
```

Composer will now update all dependencies and you should see our bundle in the list:
``` shell
  - Installing exs/silex-locale-detector (dev-master 463eb20)
    Cloning 463eb2081e7205e7556f6f65224c6ba9631e070a
```

## Registering

```php
$app->register(new EXS/LocaleDetectorProvider\ServiceProvider());
```

## Example

```php
$app->register(new EXS/LocaleDetectorProvider\ServiceProvider());

// Simple use
$language = $app['exs.serv.locale.detector']->getLanguage();
$local = $app['exs.serv.locale.detector']->getLocale();

```

## Dependencies

Silex 2.0
Doctrine\Dbal 2.2

## License

The LocaleDetectorPovider for Silex is licensed under the [MIT license](https://github.com/ExSituMarketing/EXS-silex-locale-detector/blob/master/LICENSE).

#### Contributing ####
Anyone and everyone is welcome to contribute.

If you have any questions or suggestions please [let us know][1].

[1]: http://www.ex-situ.com/
