<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use Yiisoft\Validator\Rule\Required;
use jlawrence\eos\Parser as EosParser;

/**
 * Class Calc
 *
 * @package Faf\TemplateEngine\Elements
 * @property array{equation: string} $data
 */
class Calc extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'calc';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['calculate'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Run numeric operations.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'equation',
                'label' => 'Equation',
                'aliases' => [
                    'calc',
                    'c',
                ],
                //'element' => FormatAsDateString::class,
                'content' => true,
                'rules' => [
                    new Required(),
                ]
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return float
     */
    public function run(): float
    {
        $equation = $this->data['equation'];

        $result = EosParser::solve($equation);

        if (is_string($result)) {
            $result = (float)$result;
        }

        return $result;
    }
}
