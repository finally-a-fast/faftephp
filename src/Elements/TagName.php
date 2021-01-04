<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class TagName
 *
 * @package Faf\TemplateEngine\Elements
 */
class TagName extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'tag-name';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The tag name.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [Tag::class];
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
