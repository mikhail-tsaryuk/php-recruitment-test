<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version3
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(
        Database $database
    ) {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createPageVisitsTable();
    }

    public function createPageVisitsTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS `page_visits`
            (
                entity_id int AUTO_INCREMENT,
                page_id varchar(255),
                website_id varchar(255),
                last_visit DATETIME(0),
                primary key (entity_id)
            );";
        $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $statement = $this->database->prepare($query);
        $isSuccess = $this->database->exec($statement->queryString);
    }
}
