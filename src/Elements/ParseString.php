<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ParseString
 *
 * @package Faf\TemplateEngine\Elements
 */
class ParseString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'parse-string';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The input string.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Parse::class];
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
