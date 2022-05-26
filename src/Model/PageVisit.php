<?php
namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Model\PageVisitManager;

class PageVisit
{
    private $visits;
    /**
     * @var \Snowdog\DevTest\Model\PageVisitManager
     */
    private $visitManager;

    public function __construct(
        PageVisitManager $visitManager
    )
    {
        $this->visitManager = $visitManager;
        $this->normalize($this->visitManager->getPagesVisits());

    }

    private function normalize(array $visits)
    {
        foreach ($visits as $visit){
            $this->visits[] = [
                'increment_id' => $visit['increment_id'],
                'user_id' => $visit['user_id'],
                'page_url' => $visit['page_url'],
                'visit_time' => $visit['visit_time']
            ];
        }
    }

    public function getVisits()
    {
        return $this->visits;
    }
}