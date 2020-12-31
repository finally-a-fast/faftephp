<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Exception;
use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use JsonException;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Loop
 *
 * @package Faf\TemplateEngine\Elements
 */
class Loop extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'loop';
    }

    /**
     * {@inheritdoc}
     */
    public function aliases(): array
    {
        return ['for', 'foreach'];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Loops through an array.';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'loop-each',
                'aliases' => [
                    'each'
                ],
                'label' => 'Each',
                'safeData' => false,
                'element' => LoopEach::class,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'loop-as',
                'aliases' => [
                    'as'
                ],
                'label' => 'As',
                'element' => LoopAs::class,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'body',
                'label' => 'Body',
                'element' => LoopBody::class,
                'content' => true
            ]),
            new ElementSetting([
                'name' => 'wrap-tag',
                'label' => 'Wrap tag',
                'element' => TagName::class,
                'defaultValue' => 'div',
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'wrap-attributes',
                'label' => 'Wrap attributes',
                'element' => TagAttribute::class,
                'rawData' => true,
                'attributeNameAsKey' => true,
                'multiple' => true,
                'multipleAttributeExpression' => '/^wrap-tag-(.*)?$/i'
            ]),
            new ElementSetting([
                'name' => 'wrap-step',
                'label' => 'Wrap step',
                //'element' => TagBody::class,
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @return string
     * @throws JsonException
     * @throws Exception
     */
    public function run(): string
    {
        /**
         * @var string $loopEach
         */
        $loopEach = $this->data['loop-each'];

        /**
         * @var string $loopAs
         */
        $loopAs = $this->data['loop-as'];

        /**
         * @var string $body
         */
        $body = $this->data['body'];

        /**
         * @var int|null $wrapStep
         */
        $wrapStep = $this->data['wrap-step'];

        /**
         * @var string $wrapTag
         */
        $wrapTag = $this->data['wrap-tag'];

        /**
         * @var  array<string|int, array|string|int|float|bool|object>|null $wrapOptions
         */
        $wrapOptions = $this->data['wrap-attributes'];

        $result = '';

        /**
         * @var array<string|int, array|string|int|float|bool|object> $loopItems
         */
        $loopItems = $this->parser->getRawValue($loopEach);

        $data = $this->parser->data[$loopAs] ?? null;

        $numericIndex = 0;
        $wrapStore = '';
        $itemCount = count($loopItems) - 1;

        foreach ($loopItems as $loopIndex => $loopItem) {
            /**
             * @var string|int $currentIndex
             */
            $currentIndex = ((is_numeric($loopIndex)) ? $loopIndex + 1 : $loopIndex);

            $this->setLoopItemData($loopEach, $loopAs, $currentIndex, $numericIndex, $loopItem);

            $result .= $this->handleLoopItem(
                $wrapStep,
                $numericIndex,
                $body,
                $itemCount,
                $wrapTag,
                $wrapStore,
                $wrapOptions
            );

            $numericIndex++;
        }

        if ($data !== null) {
            $this->data[$loopAs] = $data;
        }

        return $result;
    }

    /**
     * @param string                                               $loopEach
     * @param string                                               $loopAs
     * @param string|int                                           $currentIndex
     * @param int                                                  $numericIndex
     * @param array<int|string,mixed>|string|int|float|bool|object $loopItem
     */
    protected function setLoopItemData(
        string $loopEach,
        string $loopAs,
        $currentIndex,
        int $numericIndex,
        $loopItem
    ): void {
        $this->parser->data[$loopEach . '.$$index'] = $currentIndex;
        $this->parser->data[$loopAs . '.$$index'] = $currentIndex;
        $this->parser->data[$loopEach . '.$$numericIndex'] = $numericIndex;
        $this->parser->data[$loopAs . '.$$numericIndex'] = $numericIndex;
        $this->parser->data[$loopAs] = $loopItem;
    }

    /**
     * @param int|null                                                   $wrapStep
     * @param int                                                        $numericIndex
     * @param string                                                     $body
     * @param int                                                        $itemCount
     * @param string                                                     $wrapTag
     * @param string                                                     $wrapStore
     * @param array<string|int, array|string|int|float|bool|object>|null $wrapOptions
     *
     * @return string
     * @throws JsonException
     * @throws Exception
     */
    protected function handleLoopItem(
        ?int $wrapStep,
        int $numericIndex,
        string $body,
        int $itemCount,
        string $wrapTag,
        string &$wrapStore,
        ?array $wrapOptions
    ): string {
        if ($wrapStep !== null && $numericIndex % $wrapStep === 0) {
            $wrapStore = '';
        }

        $childResult = $this->parser->parseElements($body, $this->parser->getCurrentTagName());

        if (!is_string($childResult)) {
            return '';
        }

        if ($wrapStep === null) {
            return $childResult;
        }

        $wrapStore .= $childResult;

        if ($numericIndex % $wrapStep === $wrapStep - 1 || $numericIndex === $itemCount) {
            return $this->parser->htmlTag($wrapTag, $wrapStore, $wrapOptions, 'wrap-tag-');
        }

        return '';
    }
}
