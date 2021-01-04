<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Exception;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;

/**
 * Class VarDump
 *
 * @package Faf\TemplateEngine\Elements
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
    public function aliases(): array
    {
        return ['vardump'];
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
     * @throws Exception
     * @return false|string
     */
    public function run()
    {
        ob_start();

        /**
         * @psalm-suppress PossiblyFalseArgument
         * @noinspection PhpStrictTypeCheckingInspection
         * @phpstan-ignore-next-line
         */
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);

        /**
         * @psalm-suppress ForbiddenCode
         * @noinspection   ForgottenDebugOutputInspection
         */
        var_dump($this->data['params']);

        return ob_get_clean();
    }
}
