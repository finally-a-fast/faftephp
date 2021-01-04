<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class StrToLower
 *
 * @package Faf\TemplateEngine\Elements
 */
class StrToLower extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'strtolower';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Make a string lowercase';
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
                'element' => StrToLowerString::class,
                'content' => true,
                'rules' => [
                    new Required(),
                ]
            ])
        ];
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function run(): string
    {
        if (!is_string($this->data['string'])) {
            return '';
        }

        return strtolower($this->data['string']);
    }
}
