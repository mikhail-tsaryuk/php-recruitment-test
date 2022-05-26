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

    public function createVisitsTable(string $tableName = 'page_visits')
    {
        $query = "CREATE TABLE IF NOT EXISTS `$tableName`
            (
                increment_id int AUTO_INCREMENT,
                user_id varchar(255),
                page_url varchar(255),
                visit_time varchar(255),
                primary key (increment_id)
            );";
        $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $statement = $this->database->prepare($query);
        $isSuccess = $this->database->exec($statement->queryString);
        if ($isSuccess){
            return $tableName;
        }
        return $isSuccess;
    }

    public function insertVisit($pageUrl, $userId = null)
    {
        $this->createVisitsTable();
        if (!$userId){
            $userId = 'Guest';
        }
        $time = $this->time->getCurrentTime();
        $query = "UPDATE `page_visits` SET visit_time = '$time', user_id = '$userId' WHERE page_url = '$pageUrl'";
        $statement = $this->database->prepare($query);
        $result = $this->database->exec($statement->queryString);
        if (!$result){
            $query = "INSERT INTO `page_visits` (user_id, page_url, visit_time) VALUES ('$userId', '$pageUrl', '$time')";
            $statement = $this->database->prepare($query);
            $this->database->exec($statement->queryString);
        }
    }

    public function getPagesVisits()
    {
        $query = "SELECT *  FROM `page_visits`";
        $statement = $this->database->query($query);
        return $statement->fetchAll();
    }
}