<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementElse
 *
 * @package fafte\elements
 */
class ConditionalStatementElse extends ParserElement
{
    public bool $parseContent = false;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-else';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['else', 'if-else'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Part which gets executed if the condition is false.';
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
