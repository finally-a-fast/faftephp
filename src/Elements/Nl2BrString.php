<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class Nl2BrString
 *
 * @package Faf\TemplateEngine\Elements
 */
class Nl2BrString extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'nl2br-string';
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
        return [Nl2Br::class];
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
