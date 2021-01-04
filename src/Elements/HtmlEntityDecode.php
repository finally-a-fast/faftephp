<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class HtmlEntityDecode
 *
 * @package Faf\TemplateEngine\Elements
 */
class HtmlEntityDecode extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'html-entity-decode';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Convert all HTML entities to their applicable characters';
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
                'element' => HtmlEntityDecodeString::class,
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

        //TODO $quote_style = null, $charset = null
        return html_entity_decode($this->data['string']);
    }
}
