<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class TagAttributeValue
 *
 * @package fafte\elements
 */
class TagAttributeValue extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public bool $parseContent = false;

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
     */
    public function run()
    {
        return $this->content;
    }
}
