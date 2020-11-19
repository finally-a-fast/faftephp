<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\DataHelper;
use fafte\helpers\ParserElement;

/**
 * Class Param
 *
 * @package fafcms\parser\elements
 */
class Param extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'param';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Gets a data param.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'name',
                'label' => 'Name',
                'element' => ParamName::class
            ]),
            new ElementSetting([
                'name' => 'value',
                'label' => 'Value',
                'element' => ParamValue::class,
                'content' => true,
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function run()
    {
        $this->data['value'] = $this->parser->getRawValue($this->parser->parseElements($this->parser->getSafeValue($this->data['value']), $this->tagName(), true));
        return new DataHelper($this->data);
    }
}
