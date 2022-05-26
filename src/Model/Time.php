<?php
namespace Snowdog\DevTest\Model;


class Time
{
    private $date;

    public function __construct()
    {
        $this->date = date('Y-m-d H:i:s');
    }

    public function __toString()
    {
        return $this->date;
    }

    public function getCurrentTime()
    {
        return $this->date;
    }
}
