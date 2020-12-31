<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Helpers;

/**
 * Trait TagTrait
 *
 * @package Faf\TemplateEngine\Helpers
 */
trait TagTrait
{
    /**
     * @return string
     */
    public function tagName(): string
    {
        return ($this->prefixParserName ? $this->parser->name . '-' : '') . $this->name();
    }

    /**
     * @var string[]|null
     */
    private ?array $tagNameAliases = null;

    /**
     * @return string[]
     */
    public function tagNameAliases(): array
    {
        if ($this->tagNameAliases === null) {
            $this->tagNameAliases = [];

            foreach ($this->aliases() as $alias) {
                $this->tagNameAliases[] = ($this->prefixParserName ? $this->parser->name . '-' : '') . $alias;
            }
        }

        return $this->tagNameAliases;
    }
}
