<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class StrReplaceSubject
 *
 * @package fafte\elements
 */
class StrReplaceSubject extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'str-replace-subject';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'The string or array being searched and replaced on, otherwise known as the haystack.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [StrReplace::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
