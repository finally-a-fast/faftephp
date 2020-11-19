<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Base64Encode
 *
 * @package fafte\elements
 */
class Base64Encode extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'base64-encode';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Base64 encodes defined string';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return base64_encode($this->data['string']);
    }
}
