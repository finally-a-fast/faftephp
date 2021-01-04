<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class Nl2Br
 *
 * @package Faf\TemplateEngine\Elements
 */
class Nl2Br extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'nl2br';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Inserts HTML line breaks before all newlines in a string';
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
                'element' => Nl2BrString::class,
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

        return nl2br($this->data['string'], false);
    }
}
