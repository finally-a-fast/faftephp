<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class UcWords
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{string: string, delimiters: string} $data
 */
class UcWords extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'ucwords';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Uppercase the first character of each word in a string';
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
                'element' => UcWordsString::class,
                'content' => true,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'delimiters',
                'label' => 'Delimiters',
                'element' => UcWordsDelimiters::class,
                'defaultValue' => " \t\r\n\f\v",
                'rules' => [
                    new Required(),
                ]
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function run(): string
    {
        return ucwords($this->data['string'], $this->data['delimiters']);
    }
}
