<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ConditionTrait;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ConditionalStatementConditionTrue
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{params: array<string|int, array|string|int|float|bool|object>} $data
 */
class ConditionalStatementConditionTrue extends ParserElement
{
    use ConditionTrait;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-true';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-true', 'true'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 is equal to true.';
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

        /** @noinspection TypeUnsafeComparisonInspection */
        return ($params[0] == true);
    }
}
