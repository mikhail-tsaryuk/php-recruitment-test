<?php

namespace Snowdog\DevTest\CacheWarm;

class OldLegacyCacheWarmerResolverMethod
{
    public function getIp($hostname)
    {
        return gethostbyname($hostname);
    }
}
