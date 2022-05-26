<?php
namespace Snowdog\DevTest\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Snowdog\DevTest\Model\PageVisit;
use Snowdog\DevTest\Model\User;

class ShowLastVisitsCommand
{
    /**
     * @var PageVisit
     */
    private $pageVisit;
    /**
     * @var User
     */
    private $user;

    public function __construct(
        PageVisit $pageVisit,
        User $user
    )
    {
        $this->pageVisit = $pageVisit;
        $this->user = $user;
    }

    public function __invoke(InputInterface $input, OutputInterface $output)
    {
        $visits = $this->pageVisit->getVisits();
        foreach ($visits as $visit){
            $page = $visit['page_url'];
            $userId = $visit['user_id'];
            $time = $visit['visit_time'];
            $output->writeln("Page $page visited last time $time by $userId");
        }
    }
}