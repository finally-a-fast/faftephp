<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class UcWordsDelimiters
 *
 * @package Faf\TemplateEngine\Elements
 */
class UcWordsDelimiters extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'ucwords-delimiters';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The optional delimiters contains the word separator characters.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [UcWords::class];
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
