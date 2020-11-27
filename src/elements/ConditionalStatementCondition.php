<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementCondition
 *
 * @package fafte\elements
 */
class ConditionalStatementCondition extends ParserElement
{
    public bool $contentAsRawData = true;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition', 'if-condition'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Condition which gets evaluated.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [ConditionalStatement::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->content;
    }
}
