<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementThen
 *
 * @package fafte\elements
 */
class ConditionalStatementThen extends ParserElement
{
    public bool $parseContent = false;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-then';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['then', 'if-then'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Part which gets executed if the condition is true.';
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
