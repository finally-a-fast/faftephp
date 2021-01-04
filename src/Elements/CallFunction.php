<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class CallFunction
 *
 * @package fafcms\parser\elements
 */
class CallFunction extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'call-function';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The function.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Call::class];
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
