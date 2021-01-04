<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class StripTags
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{string: string, allowable-tags: array|string|null} $data
 */
class StripTags extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'strip-tags';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Strip HTML and PHP tags from a string';
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
                'element' => StripTagsString::class,
                'content' => true
            ]),
            new ElementSetting([
                'name' => 'allowable-tags',
                'label' => 'Allowable tags',
                'element' => UcWordsDelimiters::class,
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function run(): string
    {
        /**
         * @phpstan-ignore-next-line
         * @psalm-suppress PossiblyInvalidArgument
         */
        return strip_tags($this->data['string'], $this->data['allowable-tags']);
    }
}
