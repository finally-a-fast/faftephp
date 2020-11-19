<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class UcWordsDelimiters
 * @package fafcms\parser\elements
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
     */
    public function run()
    {
        return $this->content;
    }
}
