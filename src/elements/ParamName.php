<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

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
     */
    public function run()
    {
        return $this->parser->fullTrim($this->content);
    }
}
