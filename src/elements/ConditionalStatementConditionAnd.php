<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementConditionAnd
 *
 * @package fafte\elements
 */
class ConditionalStatementConditionAnd extends ParserElement
{
    public bool $contentAsRawData = true;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-and';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-and', 'if-condition-and'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if all child conditions are true.';
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [ConditionalStatementCondition::class];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return ConditionalStatement::checkConditionArray('and', $this->content);
    }
}
