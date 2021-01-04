<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class HtmlEntityDecodeString
 *
 * @package Faf\TemplateEngine\Elements
 */
class HtmlEntityDecodeString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'html-entity-decode-string';
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
        return [HtmlEntityDecode::class];
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
