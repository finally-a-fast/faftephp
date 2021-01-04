<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class FormatAsShortSizeDecimals
 *
 * @package fafcms\parser\elements
 */
class FormatAsShortSizeDecimals extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-short-size-decimals';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The number of digits after the decimal point.';
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
     * @return array<int|string, mixed>|string|int|float|bool|object|null
     */
    public function run()
    {
        return $this->content;
    }
}
