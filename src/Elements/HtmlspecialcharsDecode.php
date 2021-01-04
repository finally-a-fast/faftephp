<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class HtmlspecialcharsDecode
 *
 * @package Faf\TemplateEngine\Elements
 */
class HtmlspecialcharsDecode extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlspecialchars-decode';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Convert special HTML entities back to characters';
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
                'element' => HtmlspecialcharsDecodeString::class,
                'content' => true
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

        //TODO $quote_style = null
        return htmlspecialchars_decode($this->data['string']);
    }
}
