<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageVisitManager;

class LoginFormAction
{
    /**
     * @var PageVisitManager
     */
    private $visitManager;

    public function __construct(
        PageVisitManager $visitManager
    )
    {
        $this->visitManager = $visitManager;
    }

    public function execute()
    {
        $this->visitManager->insertVisit('login');
        require __DIR__ . '/../view/login.phtml';
    }
}