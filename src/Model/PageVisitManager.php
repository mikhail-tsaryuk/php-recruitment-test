<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\Time;
class PageVisitManager
{
    /**
     * @var Database|\PDO
     */
    private $database;

    private $tableName = 'page_visits';
    /**
     * @var \Snowdog\DevTest\Model\Time
     */
    private $time;

    public function __construct(
        Database $database,
        Time $time
    )
    {
        $this->database = $database;
        $this->time = $time;
    }


    public function insertVisit($pageId, $websiteId)
    {
        /**
         * @var Time
         */
        $time = $this->time->getCurrentTime();

        $query = "UPDATE `page_visits` SET last_visit = '$time', website_id = '$websiteId' WHERE page_id = '$pageId'";
        $statement = $this->database->prepare($query);
        $result = $this->database->exec($statement->queryString);
        if (!$result){
            $query = "INSERT INTO `page_visits`  (page_id, website_id, last_visit) VALUES ('$pageId', '$websiteId', '$time')";
            $statement = $this->database->prepare($query);
            $this->database->exec($statement->queryString);
        }
    }

    public function getPagesVisits()
    {
        $query = "SELECT * FROM `page_visits`";
        $statement = $this->database->query($query);
        return $statement->fetchAll();
    }

    public function getLastWebsiteVisit($websiteId)
    {
        $query = "SELECT MAX(last_visit) FROM `page_visits` WHERE website_id = '$websiteId'";
        $statement = $this->database->query($query);
        $visit = $statement->fetchAll();
        return $visit[0]['MAX(last_visit)'] ? : 'Not visited yet' ;
    }

    public function getLastPageVisit($pageId)
    {
        $query = "SELECT last_visit FROM `page_visits` WHERE page_id = '$pageId'";
        $statement = $this->database->query($query);
        $visit = $statement->fetchAll();
        return $visit[0]['last_visit'] ? : 'Not Visited Yet';
    }
}