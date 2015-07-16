<?php

namespace EXS\LocaleProvider\Services;

use KuiKui\MemcacheServiceProvider\SimpleWrapper;
use EXS\LocaleProvider\Repositories\CountryRepository;

/**
 * Gets the country from memcache
 * Or inserts it in DB and set the memcache key (to avoid re inserting)
 *
 * Created 1-May-2015
 * @author Damien Demessence <damiend@ex-situ.com>
 * @copyright   Copyright 2015 ExSitu Marketing.
 */
class CountryService
{
    /**
     * The repository with the queries
     * @var CountryRepository
     */
    protected $repository;
    /**
     * The memcache service
     * @var \KuiKui\MemcacheServiceProvider\SimpleWrapper
     */
    private $memCache;

    /**
     * The key to store countries in memcache
     * @var string
     */
    private $cacheKey = 'countries_';

    /**
     *
     * @param CountryRepository $countryRepository
     * @param MemcacheProviderService $memCache
     */
    public function __construct(CountryRepository $countryRepository,SimpleWrapper $memCache)
    {
        $this->repository = $countryRepository;
        $this->memCache = $memCache;
    }

    /**
     * Gets the country from memcache or inserts it
     * @param array $tag
     * @return array
     */
    public function getCountry($tag,$fallback=false){
        if($tag==''){
            return false;
        }
        $country = $this->memCache->get($this->getCacheKey($tag));
        if(!$country){
            $query = $this->repository->getCountryByAlpha($tag);
            $query->execute();
            $country = $query->fetch();
            if($country){
                $this->memCache->set($this->getCacheKey($tag),$country);
            } elseif(!$fallback) {
                $insert = $this->repository->insertCountryFromAlpha($tag);
                $insert->execute();
                $country = $this->getCountry($tag,true);
            }
        }
        return $country;
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
