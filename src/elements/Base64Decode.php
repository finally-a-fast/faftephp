<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Boolean;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Base64Decode
 *
 * @package fafte\elements
 */
class Base64Decode extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'base64-decode';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Base64 decodes defined string';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'string',
                'label' => 'String',
                'content' => true,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'strict',
                'label' => 'Strict',
                'defaultValue' => false,
                'rules' => [
                    new Boolean()
                ]
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return base64_decode($this->data['string'], $this->data['strict']);
    }
}
