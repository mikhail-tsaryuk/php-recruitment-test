<?php

namespace Snowdog\DevTest\Command;

use Snowdog\DevTest\CacheWarm\OldLegacyCacheWarmerActor;
use Snowdog\DevTest\CacheWarm\OldLegacyCacheWarmerResolverMethod;
use Snowdog\DevTest\CacheWarm\OldLegacyCacheWarmerWarmer;
use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Symfony\Component\Console\Output\OutputInterface;

class WarmCommand
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
     * @var OldLegacyCacheWarmerActor
     */
    private $actor;
    /**
     * @var OldLegacyCacheWarmerResolverMethod
     */
    private $resolver;

    public function __construct(
        WebsiteManager                         $websiteManager,
        PageManager                            $pageManager,
        OldLegacyCacheWarmerActor           $actor,
        OldLegacyCacheWarmerResolverMethod $resolver,
        OldLegacyCacheWarmerWarmer          $warmer
    )
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->actor = $actor;
        $this->resolver = $resolver;
        $this->warmer = $warmer;
    }

    /**
     * @var OldLegacyCacheWarmerWarmer
     */
    private $warmer;

    public function __invoke($id, OutputInterface $output)
    {
        $website = $this->websiteManager->getById($id);
        if (! $website) {
            $output->writeln('<error>Website with ID ' . $id . ' does not exists!</error>');

            return;
        }

        $pages = $this->pageManager->getAllByWebsite($website);

        $resolver = $this->resolver;
        $actor = $this->actor;
        $actor->setActor(function ($hostname, $ip, $url) use ($output) {
            $output->writeln(
                'Visited <info>http://'
                . $hostname . '/'
                . $url . '</info> via IP: <comment>'
                . $ip . '</comment>'
            );
        });
        $warmer = $this->warmer;
        $warmer->setResolver($resolver);
        $warmer->setHostname($website->getHostname());
        $warmer->setActor($actor);

        foreach ($pages as $page) {
            $warmer->warm($page->getUrl());
        }
    }
}