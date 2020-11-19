<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class StripTagsAllowableTags
 *
 * @package fafte\elements
 */
class StripTagsAllowableTags extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'strip-tags-allowable-tags';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'You can use the optional second parameter to specify tags which should not be stripped.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [StripTags::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
