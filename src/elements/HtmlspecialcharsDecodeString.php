<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class HtmlspecialcharsDecodeString
 *
 * @package fafte\elements
 */
class HtmlspecialcharsDecodeString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlspecialchars-decode-string';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The string to decode';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [HtmlspecialcharsDecode::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
