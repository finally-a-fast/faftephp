<?php

namespace fafcms\parser\deprecated;

use fafcms\parser\DeprecatedParserElement;
use Closure;
use Symfony\Component\DomCrawler\Crawler;
use Yii;
use jlawrence\eos\Parser as EosParser;

/**
 * Class Calculate
 *
 * @package fafcms\parser\deprecated
 */
class Calculate extends DeprecatedParserElement
{
    public $deprecatedName = 'calculate';
    public $deprecatedReplacement;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->deprecatedReplacement = [
            'replacement' => function($type, $parentTagName, $node, $crawler, $data, $language) {
                $equation = $node->getAttribute('equation');
                if (empty($equation)) {
                    $equation = $this->parser->parseElements($crawler->html(), $this->parser->getName() . '-' . $parentTagName, false);
                }
                try {
                    return EosParser::solve($equation);
                } catch (\Exception $e) {
                    Yii::$app->log->logger->log('Cannot parse calculation: '.$e->getMessage(), Logger::LEVEL_ERROR);
                    return null;
                }
            },
        ];

        parent::init();
    }
}
