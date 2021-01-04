<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class StrToLowerString
 *
 * @package Faf\TemplateEngine\Elements
 */
class StrToLowerString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'strtolower-string';
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
        return [StrToLower::class];
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
