# EXS-silex-locale-detector

Locale detection with country and language breakdown

It will get the accepted language and country from $_SERVER['HTTP_ACCEPT_LANGUAGE'] and will check it against Db.

If it's not found in Db, it will insert it and return the new entry.

Results are cached with memcache.

## Installation

Create a composer.json in your projects root-directory :

```json
{
    "require": {
        "EXS/silex-locale-detector": "~1.0@dev"        
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
    composer require exs/silex-locale-detector ~1.0@dev
```

Composer will now update all dependencies and you should see our bundle in the list:
``` shell
  - Installing exs/silex-locale-detector (dev-master 463eb20)
    Cloning 463eb2081e7205e7556f6f65224c6ba9631e070a
```
## Update your DB

```sql
CREATE TABLE `locales` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `languages` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_language` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `countries` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `iso3166alpha2` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso3166alpha3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso3166numeric` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fips` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `continent` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_country` (`iso3166alpha2`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

## Registering

```php
    $app->register(new \EXS\LocaleProvider\Providers\ServiceProvider());
```

## Example

```php
    $app->register(new EXS/LocaleDetectorProvider\ServiceProvider());
    // Simple use
    $language = $app['exs.serv.locale.detector']->getLanguage();
    $local = $app['exs.serv.locale.detector']->getLocale();
    $country = $app['exs.serv.locale.detector']->getCountry();
```

## Dependencies

Silex 2.0

Doctrine\Dbal 2.2

kuikui/memcache-service-provider ~2.0

You need a memcache server up and running.

## License

The LocaleDetectorPovider for Silex is licensed under the [MIT license](https://github.com/ExSituMarketing/EXS-silex-locale-detector/blob/master/LICENSE).

#### Contributing ####
Anyone and everyone is welcome to contribute.

If you have any questions or suggestions please [let us know][1].

[1]: http://www.ex-situ.com/
