<?php

namespace EXS\LocaleProvider\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

/**
 * Holds the SQL Queries for Language Model
 * @author damiend
 */
class LanguageRepository
{
    /**
     * @param \Doctrine\DBAL\Connection $db
     */
    public function __construct(Connection $db){
        $this->db = $db;
    }

    /**
     * Returns query to select language by tag
     * @param string tag
     * @return Statement
     */
    public function getLanguageByTag($tag=''){
        $sth = $this->db->prepare('SELECT * FROM languages WHERE tag = :tag');
        $sth->bindValue('tag',$tag);

        return $sth;
    }

    /**
     * Returns query to insert languages
     * @param string tag
     * @return Statement
     */
    public function insertLanguageFromTag($tag=''){
        $sth = $this->db->prepare('INSERT INTO language (tag,created,modified) VALUES (:tag,now(),now())');
        $sth->bindValue('tag',strtoupper($tag));

        return $sth;
    }

    /**
     * Get language by id
     * @param int $id
     * @return Statement
     */
    public function getLanguageById($id=0){
        $sth = $this->db->prepare('SELECT * FROM languages WHERE id = :id');
        $sth->bindValue('id',intval($id));
        return $sth;
    }
}
