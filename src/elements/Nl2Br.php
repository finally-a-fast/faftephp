<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Boolean;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Nl2Br
 *
 * @package fafte\elements
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
     */
    public function run()
    {
        return nl2br($this->data['string'], false);
    }
}
