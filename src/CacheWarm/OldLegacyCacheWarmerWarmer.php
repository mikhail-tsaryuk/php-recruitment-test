<?php
namespace Snowdog\DevTest\CacheWarm;

use Snowdog\DevTest\CacheWarm\OldLegacyCacheWarmerResolverMethod;

class OldLegacyCacheWarmerWarmer
{
    /** @var OldLegacyCacheWarmerActor */
    private $actor;
    /** @var OldLegacyCacheWarmerResolverMethod */
    private $resolver;
    /** @var string */
    private $hostname;

    /**
     * @param OldLegacyCacheWarmerActor $actor
     */
    public function setActor(OldLegacyCacheWarmerActor $actor)
    {
        $this->actor = $actor;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @param OldLegacyCacheWarmerResolverMethod $resolver
     */
    public function setResolver($resolver)
    {
        $this->resolver = $resolver;
    }

    public function warm($url) {
        $ip = $this->resolver->getIp($this->hostname);
        sleep(1); // this emulates visit to http://$hostname/$url via $ip
        $this->actor->act($this->hostname, $ip, $url);
    }
}