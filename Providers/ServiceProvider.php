<?php

namespace EXS\LocaleProvider\Providers;

use EXS\LocaleProvider\Repositories\CountryRepository;
use EXS\LocaleProvider\Services\CountryService;
use EXS\LocaleProvider\Repositories\LocaleRepository;
use EXS\LocaleProvider\Services\LocaleService;
use EXS\LocaleProvider\Repositories\LanguageRepository;
use EXS\LocaleProvider\Services\LanguageService;
use EXS\LocaleProvider\Services\LocaleDetectorService;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

/**
 * Register the service to detect Accepted Language in Silex 2.0
 *
 * Created 1-Jul-2015
 * @author Charles Weiss <charlesw@ex-situ.com>
 * @copyright   Copyright 2015 ExSitu Marketing.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['exs.repo.locale'] = ( function ($container) {
            return new LocaleRepository($container['db']);
        });
        $container['exs.serv.locale'] = ( function ($container) {
            return new LocaleService($container['exs.repo.locale'],$container['memcache']);
        });
        $container['exs.repo.language'] = (function($container){
            return new LanguageRepository($container['db']);
        });
        $container['exs.serv.language'] = (function($container){
            return new LanguageService($container['exs.repo.language'],$container['memcache']);
        });
        $container['exs.repo.country'] = ( function ($container) {
            return new CountryRepository($container['db']);
        });
        $container['exs.serv.country'] = ( function ($container) {
            return new CountryService($container['exs.repo.country'],$container['memcache']);
        });
        $container['exs.serv.locale.detector'] = (function($container){
            return new LocaleDetectorService($container['exs.serv.locale'],$container['exs.serv.language'],$container['exs.serv.country']);
        });
    }
}
