<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class Htmlentities
 *
 * @package Faf\TemplateEngine\Elements
 */
class Htmlentities extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlentities';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Convert all applicable characters to HTML entities';
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
                'element' => HtmlentitiesString::class,
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

        //TODO $quote_style = null, $charset = null, $double_encode = true
        return htmlentities($this->data['string']);
    }
}
