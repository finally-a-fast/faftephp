<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\DataHelper;
use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use IntlCalendar;
use IntlDateFormatter;
use Locale;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Tag
 *
 * @package fafte\elements
 */
class Tag extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Creates an html tag.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'name',
                'label' => 'Name',
                'element' => TagName::class,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'attributes',
                'label' => 'Attributes',
                'element' => TagAttribute::class,
                'rawData' => true,
                'attributeNameAsKey' => true,
                'multiple' => true,
                'multipleAttributeExpression' => '/^(.*)?$/i',
            ]),
            new ElementSetting([
                'name' => 'body',
                'label' => 'Body',
                'element' => TagBody::class,
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \JsonException
     */
    public function run()
    {
        $options = $this->data['attributes'];
        unset($options['name'], $options['body']);

        return $this->parser->htmlTag($this->data['name'], $this->data['body'] ?? '', $options);
    }
}
