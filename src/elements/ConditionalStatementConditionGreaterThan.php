<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;

/**
 * Class ConditionalStatementConditionGreaterThan
 *
 * @package fafte\elements
 */
class ConditionalStatementConditionGreaterThan extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-greater-than';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-greater-than', 'greater-than'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 greater than param 2.';
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

        return ($params[0] > $params[1]);
    }
}
