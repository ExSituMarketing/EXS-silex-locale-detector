<?php

namespace EXS\LocaleProvider\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

/**
 * Holds the SQL Queries for Locale Model
 * @author damiend
 */
class LocaleRepository
{
    /**
     * @param \Doctrine\DBAL\Connection $db
     */
    public function __construct(Connection $db){
        $this->db = $db;
    }

    /**
     * Returns query to select locale by tag
     * @param string tag
     * @return Statement
     */
    public function getLocaleByTag($tag=''){
        $sth = $this->db->prepare('SELECT * FROM locales WHERE tag = :tag');
        $sth->bindValue('tag',$tag);

        return $sth;
    }

    /**
     * Returns query to insert locales
     * @param string tag
     * @return Statement
     */
    public function insertLocaleFromTag($tag=''){
        $sth = $this->db->prepare('INSERT INTO locale (tag,created,modified) VALUES (:tag,now(),now())');
        $sth->bindValue('tag',strtoupper($tag));

        return $sth;
    }

    /**
     * Get locale by id
     * @param int $id
     * @return Statement
     */
    public function getLocaleById($id=0){
        $sth = $this->db->prepare('SELECT * FROM locales WHERE id = :id');
        $sth->bindValue('id',intval($id));
        return $sth;
    }
}
