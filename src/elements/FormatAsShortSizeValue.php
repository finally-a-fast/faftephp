<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class FormatAsShortSizeValue
 * @package fafcms\parser\elements
 */
class FormatAsShortSizeValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-short-size-value';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Value in bytes to be formatted.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [FormatAsShortSize::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
