<?php

namespace EXS\LocaleProvider\Services;

use EXS\LocaleProvider\Services\LocaleService;
use EXS\LocaleProvider\Services\LanguageService;

/**
 * Identify the language and the country from $_SERVER["HTTP_ACCEPT_LANGUAGE"] and save it in db
 *
 * Created 1-May-2015
 * @author Damien Demessence <damiend@ex-situ.com>
 * @copyright   Copyright 2015 ExSitu Marketing.
 */
class LocaleDetectorService
{
    protected $localeService;
    protected $languageService;
    protected $countryService;

    public function __construct(LocaleService $localeService, LanguageService $languageService,CountryService $countryService){
        $this->localeService = $localeService;
        $this->languageService = $languageService;
        $this->countryService = $countryService;
    }

    /**
     * Will search the locale from the Server in cache or db or will insert it in db.
     * @return array
     */
    public function getLocale(){
        $locale = $this->localeService->getLocale($this->getUserBaseLanguage()[0]['_str']);
        return $locale;
    }

    /**
     * Will search the language from the Server in cache or db or will insert it in db.
     * @return array
     */
    public function getLanguage(){
        $language = $this->languageService->getLanguage($this->getUserBaseLanguage()[0]['lng_base']);
        return $language;
    }

    /**
     * Will search the country from the Server in cache or db or will insert it in db.
     * @return array
     */
    public function getCountry(){
        $country = $this->countryService->getCountry($this->getUserBaseLanguage()[0]['lng_ext']);
        return $country;
    }

    /**
     * Return an array describing the first accepted language from $_SERVER.
     * @return array
     */
    function getUserBaseLanguage() {
        global $_SERVER;
        $accept_languages           = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $accept_languages_arr       = explode(",",$accept_languages);
        foreach($accept_languages_arr as $accept_language) {
            preg_match ("/^(([a-zA-Z]+)(-([a-zA-Z]+)){0,1})(;q=([0-9.]+)){0,1}/" , $accept_language, $matches );
            if (!isset($matches[6])) $matches[6]=1;
                $result[] = array(
                    'lng_base'  => $matches[2],
                    'lng_ext'   => $matches[4],
                    'lng'       => $matches[1],
                    'priority'  => $matches[6],
                    '_str'      => $accept_language,
            );
        }
        return $result;
    }

}
