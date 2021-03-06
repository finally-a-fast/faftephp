<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ParamName
 *
 * @package fafcms\parser\elements
 */
class ParamName extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'param-name';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The name.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Param::class];
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function run(): string
    {
        if (!is_string($this->content)) {
            return '';
        }

        return $this->parser->fullTrim($this->content);
    }
}
