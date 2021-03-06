<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class Htmlspecialchars
 *
 * @package Faf\TemplateEngine\Elements
 */
class Htmlspecialchars extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'htmlspecialchars';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Convert special characters to HTML entities';
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
                'element' => HtmlspecialcharsString::class,
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

        //TODO $flags = ENT_COMPAT | ENT_HTML401, $encoding = 'UTF-8', $double_encode = true
        return htmlspecialchars($this->data['string']);
    }
}
