<?php

namespace EXS\LocaleDetectorProvider\Services;

use EXS\LocaleDetectorProvider\Repositories\LocaleRepository;


/**
 * Gets the country from memcache
 * Or inserts it in DB and set the memcache key (to avoid re inserting)
 *
 * Created 1-May-2015
 * @author Damien Demessence <damiend@ex-situ.com>
 * @copyright   Copyright 2015 ExSitu Marketing.
 */
class LocaleService
{
    /**
     * The repository with the queries
     * @var LocaleRepository
     */
    protected $repository;
    /**
     * The memcache service
     * @var \KuiKui\MemcacheServiceProvider\SimpleWrapper
     */
    private $memCache;

    /**
     * The key to store locales in memcache
     * @var string
     */
    private $cacheKey = 'locales_';

    /**
     *
     * @param LocaleRepository $localeRepository
     * @param MemcacheProviderService $memCache
     */
    public function __construct(LocaleRepository $localeRepository,SimpleWrapper $memCache)
    {
        $this->repository = $localeRepository;
        $this->memCache = $memCache;
    }

    /**
     * Gets the locale from memcache or inserts it
     * @param array $tag
     * @return array
     */
    public function getLocale($tag,$fallback=false){
        if($tag==''){
            return false;
        }
        $locale = $this->memCache->get($this->getCacheKey($tag));
        if(!$locale){
            $query = $this->repository->getLocaleByTag($tag);
            $query->execute();
            $locale = $query->fetch();
            if($locale){
                $locale = $locale['id'];
                $this->memCache->set($this->getCacheKey($tag),$locale);
            } elseif(!$fallback) {
                $insert = $this->repository->insertLocaleFromTag($tag);
                $insert->execute();
                $locale = $this->getLocale($tag,true);
            }
        }
        return $locale;
    }

    /**
     * Gets the cache key by id
     * @param int $id
     * @return string
     */
    public function getCacheKey($tag=''){
        return $this->cacheKey.md5($tag);
    }

    /**
     * Setter for cacheKey
     * @param string $key
     */
    public function setCacheKey($key=''){
        $this->cacheKey = $key;
    }
}
