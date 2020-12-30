<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Helpers;

/**
 * Class BaseObject
 *
 * @package Faf\TemplateEngine\Helpers
 */
class BaseObject
{
    /**
     * BaseObject constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
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
