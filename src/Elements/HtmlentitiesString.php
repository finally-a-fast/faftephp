<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class HtmlentitiesString
 *
 * @package Faf\TemplateEngine\Elements
 */
class HtmlentitiesString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlentities-string';
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
        return [Htmlentities::class];
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
