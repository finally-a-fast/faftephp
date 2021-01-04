<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class LoopAs
 *
 * @package Faf\TemplateEngine\Elements
 */
class LoopAs extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'loop-as';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The current identifier.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Loop::class];
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
