<?php

namespace EXS\src\LocaleDetectorProvider\Providers;

use EXS\LocaleDetectorProvider\Services\LanguageService;
use EXS\LocaleDetectorProvider\Services\LocaleDetectorService;
use EXS\LocaleDetectorProvider\Services\LocaleService;
use EXS\LocaleDetectorProvider\Repositories\LanguageRepository;
use EXS\LocaleDetectorProvider\Repositories\LocaleRepository;
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
        $container['exs.serv.locale.detector'] = (function($container){
            return new LocaleDetectorService($container['exs.serv.locale'],$container['exs.serv.language']);
        });
    }
}
