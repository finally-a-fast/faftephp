<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class HtmlspecialcharsString
 *
 * @package fafte\elements
 */
class HtmlspecialcharsString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlspecialchars-string';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The string being converted.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Htmlspecialchars::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
