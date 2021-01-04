<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class RoundValue
 *
 * @package Faf\TemplateEngine\Elements
 */
class RoundValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'round-value';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The value to round.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Round::class];
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
