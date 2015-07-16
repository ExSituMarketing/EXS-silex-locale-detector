<?php

namespace EXS\LocaleProvider\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

/**
 * Holds the SQL Queries for Country Model
 * @author damiend
 */
class CountryRepository
{
    /**
     * @param \Doctrine\DBAL\Connection $db
     */
    public function __construct(Connection $db){
        $this->db = $db;
    }

    /**
     * Returns query to select country by tag
     * @param string $tag
     * @return Statement
     */
    public function getCountryByAlpha($alpha2=''){
        $sth = $this->db->prepare('SELECT * FROM countries WHERE UPPER(iso3166alpha2) = :alpha2');
        $sth->bindValue('alpha2',strtoupper($alpha2));

        return $sth;
    }

    /**
     * Returns query to insert countries
     * @param string $tag
     * @return Statement
     */
    public function insertCountryFromAlpha($alpha2=''){
        $sth = $this->db->prepare('INSERT INTO countries (iso3166alpha2,created,modified) VALUES (:alpha2,now(),now())');
        $sth->bindValue('alpha2',strtoupper($alpha2));

        return $sth;
    }

    /**
     * Get country by id
     * @param int $id
     * @return Statement
     */
    public function getCountryById($id=0){
        $sth = $this->db->prepare('SELECT * FROM countries WHERE id = :id');
        $sth->bindValue('id',intval($id));
        return $sth;
    }
}
