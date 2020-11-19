<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\FafteParser;
use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Boolean;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Parse
 *
 * @package fafte\elements
 */
class Parse extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'parse';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Parses a string.';
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
                'element' => ParseString::class,
                'content' => true
            ])
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function run()
    {
        /**
         * TODO add option to create new parser and pass data language etc. options
         *
         *  $fafte = new FafteParser([
         *      'logger' => $logger,
         *      'cache' => $cache,
         *      'mode' => FafteParser::MODE_DEV
         *  ]);
         *
         *  $fafte->setData($data);
         */

        $fafte = $this->parser;

        return $fafte->parse($this->data['string']);
    }
}
