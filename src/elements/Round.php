<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Number;

/**
 * Class Round
 *
 * @package fafte\elements
 */
class Round extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'round';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns the rounded value of val to specified precision (number of digits after the decimal point). Precision can also be negative or zero (default)';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'value',
                'label' => 'Value',
                'element' => RoundValue::class,
                'content' => true,
            ]),
            new ElementSetting([
                'name' => 'precision',
                'label' => 'Precision',
                // TODO element
                //The optional number of decimal digits to round to.
                'defaultValue' => 0,
                'rules' => [
                    new Number()
                ]
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        //TODO
        //$val, $precision = 0, $mode = PHP_ROUND_HALF_UP
        return round($this->data['value'], $this->data['precision']);
    }
}
