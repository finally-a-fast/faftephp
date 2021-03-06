<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Number;

/**
 * Class Round
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{value: float, precision: int} $data
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
        return 'Returns the rounded value.';
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
                'aliases' => [
                    'decimals'
                ],
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
     * @return float
     */
    public function run(): float
    {
        //TODO
        //$val, $precision = 0, $mode = PHP_ROUND_HALF_UP
        return round($this->data['value'], $this->data['precision']);
    }
}
