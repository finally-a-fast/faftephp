<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class StrToUpper
 * @package fafcms\parser\elements
 */
class StrToUpper extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'strtoupper';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Make a string uppercase';
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
                'element' => StrToUpperString::class,
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

        return strtoupper($this->data['string']);
    }
}
