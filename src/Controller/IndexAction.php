<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageVisitManager;

class IndexAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var User
     */
    private $user;
    /**
     * @var PageVisitManager
     */
    private $visitManager;

    public function __construct(
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageVisitManager $visitManager
    )
    {
        $this->websiteManager = $websiteManager;
        $this->visitManager = $visitManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    public function execute()
    {
        if ($this->user){
            $userName = $this->user->getDisplayName();
        } else {
            $userName = null;
        }
        $this->visitManager->insertVisit('index', $userName);
        require __DIR__ . '/../view/index.phtml';
    }
}