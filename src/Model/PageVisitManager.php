<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class PageVisitManager
{
    /**
     * @var Database|\PDO
     */
    private $database;

    /**
     * @param Database $database
     */
    public function __construct(
        Database $database
    )
    {
        $this->database = $database;
    }


    /**
     * @param $pageId
     * @param $websiteId
     * @return false|string
     */
    public function insertVisit($pageId, $websiteId)
    {
        $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $query = $this->database->prepare("UPDATE `page_visits` SET last_visit = NOW(), website_id = :website_id WHERE page_id = :page_id");
        $query->bindParam('website_id', $websiteId, \PDO::PARAM_STR);
        $query->bindParam('page_id', $pageId, \PDO::PARAM_STR);
        $query->execute();

        $result = $this->database->lastInsertId();
        if (!$result){
            $query = $this->database->prepare("INSERT INTO `page_visits`  (page_id, website_id, last_visit) VALUES (:page_id, :website_id, NOW())");
            $query->bindParam('page_id', $pageId, \PDO::PARAM_STR);
            $query->bindParam('website_id', $websiteId, \PDO::PARAM_STR);
            $query->execute();
            $result = $this->database->lastInsertId();
        }
        return $result;
    }

    /**
     * @param $websiteId
     * @return mixed|string
     */
    public function getLastWebsiteVisit($websiteId)
    {
        $query = $this->database->prepare("SELECT MAX(last_visit) FROM `page_visits` WHERE website_id = :website_id");
        $query->bindParam('website_id', $websiteId);
        $query->execute();
        $visit = $query->fetchAll();
        return $visit[0]['MAX(last_visit)'] ? : 'Not visited yet' ;
    }

    /**
     * @param $pageId
     * @return mixed|string
     */
    public function getLastPageVisit($pageId)
    {
        $query = $this->database->prepare("SELECT last_visit FROM `page_visits` WHERE page_id = :page_id");
        $query->bindParam('page_id', $pageId);
        $query->execute();
        $visit = $query->fetchAll();
        return $visit[0]['last_visit'] ? : 'Not Visited Yet';
    }

//    public function getPagesVisits()
//    {
//        $query = "SELECT * FROM `page_visits`";
//        $statement = $this->database->query($query);
//        return $statement->fetchAll();
//    }
}
