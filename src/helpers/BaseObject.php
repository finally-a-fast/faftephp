<?php

declare(strict_types=1);

namespace fafte\helpers;

class BaseObject
{
    public function __construct($config = [])
    {
        foreach ($config as $name => $value) {
            $this->{'set' . ucfirst($name)}($value);
        }

        $this->init();
    }

    public function init(): void
    {
    }
}
