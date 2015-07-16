<?php

namespace EXS\LocaleProvider\Services;

use KuiKui\MemcacheServiceProvider\SimpleWrapper;
use EXS\LocaleProvider\Repositories\LanguageRepository;

/**
 * Gets the language from memcache
 * Or inserts it in DB and set the memcache key (to avoid re inserting)
 *
 * Created 1-May-2015
 * @author Damien Demessence <damiend@ex-situ.com>
 * @copyright   Copyright 2015 ExSitu Marketing.
 */
class LanguageService
{
    /**
     * The repository with the queries
     * @var LanguageRepository
     */
    protected $repository;
    /**
     * The memcache service
     * @var \KuiKui\MemcacheServiceProvider\SimpleWrapper
     */
    private $memCache;

    /**
     * The key to store languages in memcache
     * @var string
     */
    private $cacheKey = 'languages_';

    /**
     *
     * @param LanguageRepository $languageRepository
     * @param MemcacheProviderService $memCache
     */
    public function __construct(LanguageRepository $languageRepository,SimpleWrapper $memCache)
    {
        $this->repository = $languageRepository;
        $this->memCache = $memCache;
    }

    /**
     * Gets the language from memcache or inserts it
     * @param array $tag
     * @return array
     */
    public function getLanguage($tag,$fallback=false){
        if($tag==''){
            return false;
        }
        $language = $this->memCache->get($this->getCacheKey($tag));
        if(!$language){
            $query = $this->repository->getLanguageByTag($tag);
            $query->execute();
            $language = $query->fetch();
            if($language){
                $this->memCache->set($this->getCacheKey($tag),$language);
            } elseif(!$fallback) {
                $insert = $this->repository->insertLanguageFromTag($tag);
                $insert->execute();
                $language = $this->getLanguage($tag,true);
            }
        }
        return $language;
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
