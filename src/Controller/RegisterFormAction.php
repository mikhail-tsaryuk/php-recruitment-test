<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageVisitManager;

class RegisterFormAction
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

    public function execute() {
        $this->visitManager->insertVisit('register');
        require __DIR__ . '/../view/register.phtml';
    }
}