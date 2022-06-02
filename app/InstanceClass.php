<?php

namespace App;

class InstanceClass
{
    private static InstanceClass $instance;

    public function __construct()
    {
        if (self::$instance === null)
            self::$instance = new self();

        return self::$instance;
    }
}
