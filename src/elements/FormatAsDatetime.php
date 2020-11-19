<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class FormatAsDatetime
 * @package fafcms\parser\elements
 */
class FormatAsDatetime extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['datetime'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Formats the value as a date.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'string',
                'aliases' => [
                    'date',
                    'time',
                    'datetime',
                    'value'
                ],
                'label' => 'String',
                'element' => FormatAsDatetimeString::class,
                'content' => true,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'format',
                'label' => 'Format',
                'element' => FormatAsDatetimeFormat::class
            ])
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->parser->formatDateTime($this->data['string'], $this->data['format']);
    }
}
