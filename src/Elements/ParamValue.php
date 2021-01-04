<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ParamValue
 *
 * @package fafcms\parser\elements
 */
class ParamValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public bool $parseContent = false;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'param-value';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The value.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Param::class];
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
