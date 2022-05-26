<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Website;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageVisitManager;

class WebsiteAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var Website
     */
    private $website;
    /**
     * @var PageVisitManager
     */
    private $pageVisitManager;

    public function __construct(
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageManager $pageManager,
        PageVisitManager $pageVisitManager
    )
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
        $this->pageVisitManager = $pageVisitManager;
    }

    public function execute($id)
    {
        if (isset($_SESSION['login'])) {
            $user = $this->userManager->getByLogin($_SESSION['login']);

            $website = $this->websiteManager->getById($id);

            if ($website->getUserId() == $user->getUserId()) {
                $this->website = $website;
            }
        }
        $this->pageVisitManager->insertVisit( 'website', $user->getDisplayName());
        require __DIR__ . '/../view/website.phtml';
    }

    protected function getPages()
    {
        if($this->website) {
            return $this->pageManager->getAllByWebsite($this->website);
        } 
        return [];
    }
}