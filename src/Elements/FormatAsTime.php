<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use DateTimeZone;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class FormatAsTime
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{string: \DateTime|string, format: string|int} $data
 */
class FormatAsTime extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'format-as-time';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['time'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Formats the value as a time.';
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
                'element' => FormatAsTimeString::class,
                'content' => true,
                'defaultValue' => 'NOW',
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'format',
                'label' => 'Format',
                'element' => FormatAsTimeFormat::class
            ]),
            new ElementSetting([
                'name' => 'input-time-zone',
                'label' => 'Input time zone',
                'defaultValue' => $this->getParser()->getSetting('default-input-time-zone'),
                //'element' => TODO
            ]),
            new ElementSetting([
                'name' => 'display-time-zone',
                'label' => 'Display time zone',
                'defaultValue' => $this->getParser()->getSetting('default-display-time-zone'),
                //'element' => TODO
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return false|string
     */
    public function run()
    {
        $inputTimeZone = null;

        if (!empty($this->data['input-time-zone'])) {
            $inputTimeZone = new DateTimeZone($this->data['input-time-zone']);
        }

        $displayTimeZone = null;

        if (!empty($this->data['display-time-zone'])) {
            $displayTimeZone = new DateTimeZone($this->data['display-time-zone']);
        }

        return $this->parser->formatTime(
            $this->data['string'],
            $this->data['format'],
            $inputTimeZone,
            $displayTimeZone
        );
    }
}
