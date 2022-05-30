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
    private $pageVisitManager;

    public function __construct(
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageVisitManager $pageVisitManager
    )
    {
        $this->websiteManager = $websiteManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
        $this->pageVisitManager = $pageVisitManager;
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        }
        return [];
    }

    protected function getLastPageVisit($websiteId)
    {
        if ($this->user){
            return $this->pageVisitManager->getLastWebsiteVisit($websiteId);
        }
        return [];
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }
}