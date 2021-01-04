<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class LoopEach
 *
 * @package Faf\TemplateEngine\Elements
 */
class LoopEach extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'loop-each';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The array item.';
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
