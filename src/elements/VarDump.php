<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class VarDump
 *
 * @package fafte\elements
 */
class VarDump extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'var-dump';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Dumps information about a variable.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [

            new ElementSetting([
                'name' => 'params',
                'label' => 'Params',
                'element' => Param::class,
                'rawData' => true,
                'content' => true,
                'attributeNameAsKey' => true,
                'multiple' => true,
                'multipleAttributeExpression' => '/^(.*)?$/i',
                'rules' => [
                    new Required(),
                ]
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function run()
    {
        ob_start();
        ob_implicit_flush(0);
        var_dump($this->data['params']);
        return ob_get_clean();
    }
}
