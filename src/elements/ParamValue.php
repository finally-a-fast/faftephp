<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class ParamValue
 *
 * @package fafcms\parser\elements
 */
class ParamValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public bool $parseContent = false;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'param-value';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The value.';
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
        return $this->content;
    }
}
