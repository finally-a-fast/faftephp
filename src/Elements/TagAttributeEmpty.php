<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class TagAttributeEmpty
 *
 * @package Faf\TemplateEngine\Elements
 */
class TagAttributeEmpty extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'tag-attribute-empty';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Keep empty tag.';
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
