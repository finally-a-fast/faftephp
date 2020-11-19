<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class FormatAsTimeFormat
 * @package fafcms\parser\elements
 */
class FormatAsTimeFormat extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-time-format';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The format used to convert the value into a time string.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [FormatAsTime::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
