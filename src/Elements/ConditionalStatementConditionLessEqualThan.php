<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ConditionTrait;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ConditionalStatementConditionLessEqualThan
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{params: array<string|int, array|string|int|float|bool|object>} $data
 * @SuppressWarnings(PHPMD.LongClassName)
 */
class ConditionalStatementConditionLessEqualThan extends ParserElement
{
    use ConditionTrait;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-less-equal-than';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-less-equal-than', 'less-equal-than'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 less than or equal to param 2.';
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
                'multiple' => true,
                'multipleAttributeExpression' => '/^(.*)?$/i',
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function allowedParents(): ?array
    {
        return [
            ConditionalStatementCondition::class,
            ConditionalStatementConditionAnd::class,
            ConditionalStatementConditionOr::class
        ];
    }

    /**
     * {@inheritdoc}
     * @return bool
     */
    public function run(): bool
    {
        $params = $this->getParams($this->data['params']);

        return ($params[0] <= $params[1]);
    }
}
