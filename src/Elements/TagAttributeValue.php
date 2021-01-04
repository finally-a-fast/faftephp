<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class TagAttributeValue
 *
 * @package Faf\TemplateEngine\Elements
 */
class TagAttributeValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'tag-attribute-value';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The tag value.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [TagAttribute::class];
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
