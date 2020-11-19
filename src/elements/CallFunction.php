<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class CallFunction
 *
 * @package fafcms\parser\elements
 */
class CallFunction extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'call-function';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The function.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Call::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
