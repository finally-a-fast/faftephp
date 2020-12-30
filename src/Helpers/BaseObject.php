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
     * @param array<string, array|string|int|bool|object>|null $config
     */
    public function __construct(?array $config = null)
    {
        if ($config !== null) {
            foreach ($config as $name => $value) {
                $this->{'set' . ucfirst($name)}($value);
            }
        }

        $this->init();
    }

    public function init(): void
    {
    }
}
