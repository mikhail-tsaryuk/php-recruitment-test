<?php

namespace Snowdog\DevTest\CacheWarm;

class OldLegacyCacheWarmerActor
{
    private $callable;

    public function setActor($callable) {
        $this->callable = $callable;
    }

    public function act($hostname, $ip, $url)
    {
        call_user_func($this->callable, $hostname, $ip, $url);
    }
}
