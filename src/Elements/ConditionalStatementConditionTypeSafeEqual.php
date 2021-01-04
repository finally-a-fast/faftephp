<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ConditionTrait;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;

/**
 * Class ConditionalStatementConditionTypeSafeEqual
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{params: array<string|int, array|string|int|float|bool|object>} $data
 * @SuppressWarnings(PHPMD.LongClassName)
 */
class ConditionalStatementConditionTypeSafeEqual extends ParserElement
{
    use ConditionTrait;

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'conditional-statement-condition-type-safe-equal';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['condition-type-safe-equal', 'type-safe-equal'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Returns true if param 1 is equal to param 2 and have the same type.';
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

        return ($params[0] === $params[1]);
    }
}
