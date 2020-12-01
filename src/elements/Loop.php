<?php

declare(strict_types=1);

namespace fafte\elements;

use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use IntlDateFormatter;
use Yiisoft\Validator\Rule\Required;

/**
 * Class Loop
 *
 * @package fafte\elements
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
                'name' => 'each',
                'aliases' => [],
                'label' => 'Each',
                'safeData' => false,
                'element' => LoopEach::class,
                'rules' => [
                    new Required(),
                ]
            ]),
            new ElementSetting([
                'name' => 'as',
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
            ])
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function run()
    {
        $each = $this->data['each'];
        $as = $this->data['as'];
        $body = $this->data['body'];

        $wrapOptions = [];
        $result = '';
  /*
        $wrapStep = $node->hasAttribute('wrap-step')?(int)$node->getAttribute('wrap-step'):null;
        $wrapTag = $node->hasAttribute('wrap-tag')?$node->getAttribute('wrap-tag'):null;
        $wrapAttributeChildren = $crawler->filterXPath($this->parser->getName().'-'.$parentTagName.'/'.$this->parser->getName().'-'.$parentTagName.'-wrap-attribute');

        if (count($wrapAttributeChildren) > 0) {
            $useInnerHTML = false;
            $wrapAttributeChildren->each(function (Crawler $attributeCrawler) use ($type, $parentTagName, $data, $language, &$wrapOptions) {
                $attributeNode = $attributeCrawler->getNode(0);
                $attributeName = $attributeNode->hasAttribute('name')?$attributeNode->getAttribute('name'):null;
                $attributeEmpty = $attributeNode->hasAttribute('empty')?$attributeNode->getAttribute('empty'):null;
                if ($attributeEmpty === null) {
                    $attributeEmpty = $attributeCrawler->filterXPath($this->parser->getName().'-'.$parentTagName.'-wrap-attribute/'.$this->parser->getName().'-'.$parentTagName.'-wrap-attribute-empty');
                    $attributeEmpty = $this->parser->parseElements((count($attributeEmpty) > 0?$attributeEmpty->html():''), $this->parser->getName() . '-' . $parentTagName);
                }
                if ($attributeName === null) {
                    $attributeName = $attributeCrawler->filterXPath($this->parser->getName().'-'.$parentTagName.'-wrap-attribute/'.$this->parser->getName().'-'.$parentTagName.'-wrap-attribute-name');
                    $attributeValue = $attributeCrawler->filterXPath($this->parser->getName().'-'.$parentTagName.'-wrap-attribute/'.$this->parser->getName().'-'.$parentTagName.'-wrap-attribute-value');
                    $attributeName = $this->parser->parseElements((count($attributeName) > 0?$attributeName->html():''), $this->parser->getName() . '-' . $parentTagName);
                    $attributeValue = $this->parser->parseElements((count($attributeValue) > 0?$attributeValue->html():''), $this->parser->getName() . '-' . $parentTagName);
                } else {
                    $attributeValue = $this->parser->parseElements($attributeCrawler->html(), $this->parser->getName() . '-' . $parentTagName);
                }
                $attributeName = $this->parser->fullTrim($attributeName);
                $attributeValue = $this->parser->fullTrim($attributeValue);
                if ($attributeEmpty === 'true' || $attributeValue !== '') {
                    $wrapOptions[$attributeName] = $attributeValue;
                }
            });
        }

        foreach ($node->attributes as $attr) {
            if (mb_stripos($attr->nodeName, 'wrap-tag-') === 0) {
                $wrapOptions[strtolower(mb_substr($attr->nodeName, 9))] = $attr->nodeValue;
            }
        }
*/
        $loopDatas = $this->parser->getRawValue($each);

        if ($loopDatas !== null) {
            $data = $this->parser->data[$as] ?? null;
            $numericIndex = 0;

            foreach ($loopDatas as $loopIndex => $loopData) {
                $currentIndex = ((is_numeric($loopIndex)) ? $loopIndex + 1 : $loopIndex);
                $this->parser->data[$each . '.$$index'] = $currentIndex;
                $this->parser->data[$as . '.$$index'] = $currentIndex;
                $this->parser->data[$each . '.$$numericIndex'] = $numericIndex;
                $this->parser->data[$as . '.$$numericIndex'] = $numericIndex;
                $this->parser->data[$as] = $loopData;

                /*if ($wrapStep !== null && $wrapTag !== null && $numericIndex % $wrapStep === 0) {
                    $result .= Html::beginTag($wrapTag, $wrapOptions);
                }*/

                $childResult = $this->parser->parseElements($body, $this->parser->getCurrentTagName());

                $result .= $childResult;

                /*if ($wrapStep !== null && $wrapTag !== null && ($numericIndex % $wrapStep === $wrapStep - 1 || $numericIndex === count($loopDatas))) {
                    $result .= Html::endTag($wrapTag);
                }*/

                $numericIndex++;
            }

            $this->data[$as] = $data;
        }

        return $result;
    }
}
