<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ConditionTrait;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ConditionalStatementConditionEndsWith
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{params: array<string|int, array|string|int|float|bool|object>} $data
 */
class ConditionalStatementConditionEndsWith extends ParserElement
{
    use ConditionTrait;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-ends-with';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-ends-with', 'ends-with'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 ends with param 2.';
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

        if (!is_string($params[0]) || !is_string($params[1])) {
            return false;
        }

        $length = strlen($params[1]);

        if ($length === 0) {
            return true;
        }

        return (substr($params[0], -$length) === $params[1]);
    }
}
