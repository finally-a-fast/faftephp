<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Boolean;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Base64Decode
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{string: string, strict: bool} $data
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
     * @return string|false
     */
    public function run()
    {
        return base64_decode($this->data['string'], $this->data['strict']);
    }
}
