<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementConditionEndsNotWith
 *
 * @package fafte\elements
 */
class ConditionalStatementConditionEndsNotWith extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-ends-not-with';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-ends-not-with', 'ends-not-with'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 ends not with param 2.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'params',
                'label' => 'Params',
                'element' => Param::class,
                'rawData' => true,
                'content' => true,
                'multiple' => true,
                'multipleAttributeExpression' => '/^(.*)?$/i',
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [
            ConditionalStatementCondition::class,
            ConditionalStatementConditionAnd::class,
            ConditionalStatementConditionOr::class
        ];
    }

    /**
     * {@inheritdoc}
     * @return bool|mixed
     */
    public function run()
    {
        $params = ConditionalStatement::getParams($this->data['params']);

        $length = strlen($params[1]);

        if ($length === 0) {
            return true;
        }

        return (substr($params[0], -$length) !== $params[1]);
    }
}