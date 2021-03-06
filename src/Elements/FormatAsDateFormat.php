<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class FormatAsDateFormat
 *
 * @package Faf\TemplateEngine\Elements
 */
class FormatAsDateFormat extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-date-format';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The format used to convert the value into a date string.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [FormatAsDate::class];
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
