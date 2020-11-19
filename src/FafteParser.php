<?php

declare(strict_types=1);

namespace fafte;

use Closure;

use fafte\elements\Trim;
use fafte\elements\TrimString;
use fafte\elements\TrimCharlist;
use IntlCalendar;
use IntlDateFormatter;
use IvoPetkov\HTML5DOMElement;
use IvoPetkov\HTML5DOMDocument;
use DOMXPath;

use fafte\elements\{Base64Decode,
    Base64Encode,
    Call,
    CallFunction,
    FormatAsDate,
    FormatAsDateFormat,
    FormatAsDateString,
    FormatAsDatetime,
    FormatAsDatetimeFormat,
    FormatAsDatetimeString,
    FormatAsShortSize,
    FormatAsShortSizeDecimals,
    FormatAsShortSizeValue,
    FormatAsTime,
    FormatAsTimeFormat,
    FormatAsTimeString,
    Get,
    GetFormat,
    Htmlentities,
    HtmlentitiesString,
    HtmlEntityDecode,
    HtmlEntityDecodeString,
    Htmlspecialchars,
    HtmlspecialcharsDecode,
    HtmlspecialcharsDecodeString,
    HtmlspecialcharsString,
    JsonEncode,
    Nl2Br,
    Nl2BrString,
    Param,
    ParamName,
    ParamValue,
    Parse,
    ParseString,
    Round,
    RoundValue,
    Set,
    StripTags,
    StripTagsAllowableTags,
    StripTagsString,
    StrReplace,
    StrReplaceSubject,
    StrToLower,
    StrToLowerString,
    StrToUpper,
    StrToUpperString,
    TimeTag,
    UcWords,
    UcWordsDelimiters,
    UcWordsString,
    VarDump};

use fafte\helpers\BaseObject;
use fafte\helpers\ElementSetting;
use fafte\helpers\ParserElement;
use Locale;
use NumberFormatter;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Exception;
use RuntimeException;
use Yiisoft\Validator\Rules;

class FafteParser extends BaseObject
{
    public const ROOT = 'root';

    public const MODE_PROD = 0;
    public const MODE_DEV = 1;

    public const TYPE_HTML = 0;
    public const TYPE_TEXT = 1;

    protected const FORMAT_TYPE_DATE_TIME = 1;
    protected const FORMAT_TYPE_DATE = 2;
    protected const FORMAT_TYPE_TIME = 3;

    //region properties
    /**
     * @var string
     */
    public string $name = 'fafte';

    /**
     * @var array|string[]
     */
    public array $elements = [
        Base64Encode::class,
        Call::class,
        CallFunction::class,
        FormatAsDate::class,
        FormatAsDateFormat::class,
        FormatAsDateString::class,
        FormatAsDatetime::class,
        FormatAsDatetimeFormat::class,
        FormatAsDatetimeString::class,
        FormatAsShortSize::class,
        FormatAsShortSizeDecimals::class,
        FormatAsShortSizeValue::class,
        FormatAsTime::class,
        FormatAsTimeFormat::class,
        FormatAsTimeString::class,
        Get::class,
        GetFormat::class,
        JsonEncode::class,
        Param::class,
        ParamName::class,
        ParamValue::class,
        Set::class,
        StripTags::class,
        StripTagsAllowableTags::class,
        StripTagsString::class,
        StrToLower::class,
        StrToLowerString::class,
        StrToUpper::class,
        StrToUpperString::class,
        UcWords::class,
        UcWordsDelimiters::class,
        UcWordsString::class,
        Trim::class,
        TrimString::class,
        TrimCharlist::class,
        Nl2Br::class,
        Nl2BrString::class,
        Htmlentities::class,
        HtmlentitiesString::class,
        HtmlEntityDecode::class,
        HtmlEntityDecodeString::class,
        Htmlspecialchars::class,
        HtmlspecialcharsString::class,
        HtmlspecialcharsDecode::class,
        HtmlspecialcharsDecodeString::class,
        Parse::class,
        ParseString::class,
        RoundValue::class,
        Round::class,
        VarDump::class,
        StrReplace::class,
        StrReplaceSubject::class,
        TimeTag::class,
        Base64Decode::class,
    ];

    public ?LoggerInterface $logger = null;

    protected ?CacheInterface $cache = null;

    protected int $cacheTtl = 3600;

    protected int $mode = self::MODE_PROD;

    protected int $type = self::TYPE_HTML;

    protected int $maxDeep = 100;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @var string|null
     */
    protected ?string $language = null;

    /**
     * @var string|null
     */
    private ?string $currentLanguage = null;

    /**
     * @var float
     */
    protected float $debugStartTime;

    /**
     * @var array
     */
    protected array $debugData = [];

    /**
     * @var bool
     */
    protected bool $returnRawData = false;

    /**
     * @var int
     */
    protected int $currentDeep = 0;

    /**
     * @var array
     */
    protected array $nodeDatas = [];

    /**
     * @var array
     */
    protected array $parserElements;

    /**
     * @var array
     */
    protected array $parserElementsByClassName;

    /**
     * @var string
     */
    protected string $tempTagName;

    /**
     * @var array
     */
    protected array $bootstrapCache = [];

    /**
     * @var string
     */
    protected string $currentTagName = self::ROOT;

    /**
     * @var string
     */
    protected string $parentTagName = self::ROOT;

    /**
     * @var array
     */
    protected array $allowedChildElements = [];
    //endregion properties

    //region getter and setter
    /**
     * @return int
     */
    public function getCurrentDeep(): int
    {
        return $this->currentDeep;
    }

    /**
     * @return string
     */
    public function getCurrentTagName(): string
    {
        return $this->currentTagName;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $language
     *
     * @return $this
     */
    public function setLanguage(?string $language): self
    {
        if ($language !== null) {
            $this->language = strtolower($language);
        }

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setData($data): self
    {
        $this->data = &$data;

        return $this;
    }

    /**
     * @param LoggerInterface|null $logger
     *
     * @return $this
     */
    public function setLogger(?LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param CacheInterface|null $cache
     *
     * @return $this
     */
    public function setCache(?CacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param int $mode
     *
     * @return $this
     */
    public function setMode(int $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param $returnRawData
     *
     * @return $this
     */
    public function setReturnRawData($returnRawData): self
    {
        $this->returnRawData = $returnRawData;

        return $this;
    }
    //endregion getter and setter

    //region init
    public function init(): void
    {
        if ($this->logger === null) {
            $this->logger = new NullLogger();
        }

        $this->refresh();
    }

    public function refresh(): void
    {
        if ($this->mode === self::MODE_DEV) {
            $this->debugStartTime = microtime(true);
        }

        $debugId = $this->debugStart('Refresh');

        $elementClasses = $this->elements;

        foreach ($elementClasses as $elementClass) {
            $parserElement = new $elementClass([
                'parser' => $this
            ]);

            foreach ($parserElement->tagNameAliases() as $tagNameAlias) {
                $this->parserElements[$tagNameAlias] = $parserElement;
            }

            $this->parserElements[$parserElement->tagName()] = $parserElement;
            $this->parserElementsByClassName[$elementClass] = $parserElement;
        }

        foreach ($this->parserElements as $currentTagName => $parserElement) {
            if (!isset($this->bootstrapCache[$parserElement->name()])) {
                $parserElement->bootstrap();
                $this->bootstrapCache[$parserElement->name()] = true;
            }
        }

        $this->allowedChildElements = $this->loadAllowedChildElements();

        $this->tempTagName = 'temp-tag-' . $this->name . '-temp-tag';

        if ($this->language === null) {
            $this->language = Locale::getDefault();
        }

        $this->debugEnd($debugId);
    }
    //endregion init

    //region child elements
    protected function loadAllowedChildElements(): array
    {
        $debugId = $this->debugStart('Load allowed child elements');
        $key = 'fafte-allowed-child-elements-' . md5(implode('', array_keys($this->parserElements)));
        $allowedChildElements = null;

        if ($this->cache !== null) {
            try {
                $allowedChildElements = $this->cache->get($key);
            } catch (InvalidArgumentException $e) {
            }
        }

        if ($allowedChildElements === null) {
            $allowedChildElements = [];

            foreach ($this->parserElements as $currentTagName => $parserElement) {
                $allowedTypes = $parserElement->allowedTypes();

                if ($allowedTypes === null) {
                    $allowedTypes = [null];
                }

                foreach ($allowedTypes as $allowedType) {
                    if (!isset($allowedChildElements[$allowedType][$currentTagName])) {
                        $allowedChildElements[$allowedType][$currentTagName] = [];
                    }

                    $allowedParents = $parserElement->allowedParents();

                    if ($allowedParents === null) {
                        $allowedParents = [null];
                    }

                    foreach ($allowedParents as $allowedParent) {
                        if ($allowedParent === null) {
                            $allowedChildElements[$allowedType][null][] = $currentTagName;
                        } elseif ($allowedParent === self::ROOT) {
                            $allowedChildElements[$allowedType][self::ROOT][] = $currentTagName;
                        } elseif (isset($this->parserElementsByClassName[$allowedParent])) {
                            $parentElement = $this->parserElementsByClassName[$allowedParent];

                            foreach ($parentElement->tagNameAliases() as $tagNameAlias) {
                                $allowedChildElements[$allowedType][$tagNameAlias][] = $parserElement;
                            }

                            $allowedChildElements[$allowedType][$parentElement->tagName()][] = $currentTagName;
                        }
                    }
                }
            }

            if ($this->cache !== null) {
                try {
                    $this->cache->set($key, $allowedChildElements, $this->cacheTtl);
                } catch (InvalidArgumentException $e) {
                }
            }
        }

        $this->debugEnd($debugId);
        return $allowedChildElements;
    }

    /**
     * @param int    $type
     * @param string $tagName
     *
     * @return array
     */
    protected function getAllowedChildElements(int $type, string $tagName): array
    {
        $debugId = $this->debugStart('Get allowed child elements for ' . $tagName . ' of type ' . $type);

        $allowedChildElementsByType = array_merge($this->allowedChildElements[null] ?? [], $this->allowedChildElements[$type] ?? []);
        $allowedChildElementsByTag = array_merge($allowedChildElementsByType[null] ?? [], $allowedChildElementsByType[$tagName] ?? []);

        $this->debugEnd($debugId);

        return $allowedChildElementsByTag;
    }
    //endregion child elements

    /**
     * @param int                              $type
     * @param \DateTime|string                 $dateTime
     * @param string|int                       $format
     * @param \IntlTimeZone|\DateTimeZone|null $timeZone
     *
     * @return false|string
     */
    protected function dateTimeFormatter(int $type, $dateTime, $format, $timeZone)
    {
        $calendar = IntlCalendar::fromDateTime($dateTime);
        $calendar->setTimeZone($timeZone);

        $dateType = IntlDateFormatter::NONE;
        $timeType = IntlDateFormatter::NONE;

        $useFormatAsType = false;

        if ($format === null) {
            $format = '';
        } elseif (is_int($format)) {
            $useFormatAsType = true;
        }

        if ($type === self::FORMAT_TYPE_DATE_TIME) {
            $dateType = $useFormatAsType ? $format : IntlDateFormatter::MEDIUM;
            $timeType = $useFormatAsType ? $format : IntlDateFormatter::MEDIUM;
        } elseif ($type === self::FORMAT_TYPE_DATE) {
            $dateType = $useFormatAsType ? $format : IntlDateFormatter::MEDIUM;
        } elseif ($type === self::FORMAT_TYPE_TIME) {
            $timeType = $useFormatAsType ? $format : IntlDateFormatter::MEDIUM;
        }

        if ($useFormatAsType) {
            $format = '';
        }

        $df = new IntlDateFormatter($this->currentLanguage, $dateType, $timeType, $timeZone, $calendar, $format);
        return $df->format($calendar);
    }

    /**
     * @param \DateTime|string                 $dateTime
     * @param string|int                       $format
     * @param \IntlTimeZone|\DateTimeZone|null $timeZone
     *
     * @return false|string
     */
    public function formatDateTime($dateTime, $format, $timeZone = null)
    {
        return $this->dateTimeFormatter(self::FORMAT_TYPE_DATE_TIME, $dateTime, $format, $timeZone);
    }

    /**
     * @param \DateTime|string                 $time
     * @param string|int                       $format
     * @param \IntlTimeZone|\DateTimeZone|null $timeZone
     *
     * @return false|string
     */
    public function formatTime($time, $format, $timeZone = null)
    {
        return $this->dateTimeFormatter(self::FORMAT_TYPE_TIME, $time, $format, $timeZone);
    }

    /**
     * @param \DateTime|string                 $date
     * @param string|int                       $format
     * @param \IntlTimeZone|\DateTimeZone|null $timeZone
     *
     * @return false|string
     */
    public function formatDate($date, $format, $timeZone = null)
    {
        return $this->dateTimeFormatter(self::FORMAT_TYPE_DATE, $date, $format, $timeZone);
    }

    /**
     * @param        $number
     * @param int    $style
     * @param string $pattern
     * @param array  $attributes
     * @param array  $symbols
     * @param array  $textAttributes
     *
     * @return false|string
     */
    public function formatNumber($number, int $style, string $pattern = '', array $attributes = [], array $symbols = [], array $textAttributes = [])
    {
        $numberFormatter = new NumberFormatter($this->currentLanguage, $style, $pattern);

        foreach ($attributes as $name => $value) {
            $numberFormatter->setAttribute($name, $value);
        }

        foreach ($symbols as $name => $value) {
            $numberFormatter->setSymbol($name, $value);
        }

        foreach ($textAttributes as $name => $value) {
            $numberFormatter->setTextAttribute($name, $value);
        }

        return $numberFormatter->format($number);
    }

    /**
     * @param $string
     *
     * @return array|mixed|string|string[]|null
     * @throws Exception
     */
    public function parse($string)
    {
        $debugId = $this->debugStart('Parse');

        $result = $this->parseElements($string, self::ROOT, $this->returnRawData);

        $this->debugEnd($debugId);

        return $result;
    }

    /**
     * @param string $string
     * @param string $currentTagName
     * @param bool   $rawData
     *
     * @return array|string
     * @throws Exception
     */
    public function parseElements(string $string, string $currentTagName, bool $rawData = false)
    {
        $parentLanguage = $this->currentLanguage;
        $this->currentLanguage = $this->language;

        $parentTagName = $this->parentTagName;
        $this->parentTagName = $this->currentTagName;
        $this->currentTagName = $currentTagName;

        $parseElementDebugId = $this->debugStart('Parse element ' . $this->currentTagName . ' (parent: ' . $this->parentTagName . ')');

        $parserElements = $this->getAllowedChildElements($this->type, $this->currentTagName);

        $dom = new HTML5DOMDocument();
        $dom->loadHTML('<!DOCTYPE html><html><body><'.$this->tempTagName.'>' . $this->getSafeHtml($string) . '</'.$this->tempTagName.'></body></html>', LIBXML_NONET);

        $xPath = new DOMXPath($dom);
        $filterReplacements = '//' . implode('|//', $parserElements);
        $unfilteredDomNodes = $xPath->query($filterReplacements);

        $domNodes = [];

        /**
         * @var $unfilteredDomNode HTML5DOMElement
         */
        foreach ($unfilteredDomNodes as $unfilteredDomNode) {
            $nodePath = $unfilteredDomNode->getNodePath();

            $count = substr_count($nodePath, '/' . $this->name);

            if ($count === 1) {
                $domNodes[] = $unfilteredDomNode;
            }
        }

        $domNodeCount = count($domNodes);

        if ($domNodeCount === 0) {
            $result = $string;
        } else {
            $result = [];
            $oldDeep = $this->currentDeep;
            $this->currentDeep++;

            if ($this->currentDeep > $this->maxDeep) {
                $this->logger->emergency('Max deep of ' . $this->maxDeep . ' reached', [
                    'time' => microtime(true),
                    'memory' => memory_get_usage()
                ]);
            }

            foreach ($domNodes as $domNode) {
                $tagName = $domNode->tagName;

                if (isset($this->parserElements[$tagName])) {
                    $tagName = $this->parserElements[$tagName]->tagName();

                    if (!isset($this->nodeDatas[$tagName]['usage'])) {
                        $this->nodeDatas[$tagName]['usage'] = 0;
                    }

                    $this->nodeDatas[$tagName]['usage']++;
                    $this->nodeDatas[$tagName]['number'] = ($this->nodeDatas[$tagName]['number'] ?? 0) + 1;

                    $this->prepareNode($xPath, $domNode, $this->parserElements[$tagName], $tagName);

                    $childCurrentTagName = $this->currentTagName;
                    $childParentTagName = $this->parentTagName;

                    $this->parentTagName = $this->currentTagName;
                    $this->currentTagName = $tagName;

                    $replacement = $this->parserElements[$tagName]->run();

                    $this->parentTagName = $childParentTagName;
                    $this->currentTagName = $childCurrentTagName;

                    if ($rawData) {
                        if ($domNodeCount > 1) {
                            $result[] = $replacement;
                        } else {
                            $result = $replacement;
                        }
                    } else {
                        if ($replacement !== null) {
                            if (!is_string($replacement)) {
                                $replacement = $this->getSafeValue($replacement);
                            }

                            $replacement = $this->getSafeHtml($replacement ?? '');
                        }

                        $domNode->outerHTML = $replacement;
                    }
                }
            }

            $this->currentDeep = $oldDeep;

            if (!$rawData) {
                $result = $dom->saveHTML();
                $getResultDebugId = $this->debugStart('Get result with regex for ' . $this->currentTagName);

                preg_match('/<' . $this->tempTagName . '>(?<content>.*?)<\/' . $this->tempTagName . '>/is', $result, $matches);
                $result = preg_replace('/<'.$this->tempTagName. '-special>(?<content>[^<]+)<\/' .$this->tempTagName.'-special>/mi', '<!$1>', $matches['content'] ?? '');
                $result = preg_replace('/(?<tag><\/?)'.$this->tempTagName. '-(?<name>[\w\d\-]+)/mi', '$1$2', $result);

                $this->debugEnd($getResultDebugId);
            }
        }

        $this->currentLanguage = $parentLanguage;
        $this->currentTagName = $this->parentTagName;
        $this->parentTagName = $parentTagName;

        $this->debugEnd($parseElementDebugId);

        return $result;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function fullTrim(string $string): string
    {
        return trim(str_replace('&nbsp;', mb_chr(0xA0, 'UTF-8'), $string), " \t\n\r\0\x0B" . mb_chr(0xC2, 'UTF-8') . mb_chr(0xA0, 'UTF-8'));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function getSafeHtml(string $string): string
    {
        $string = preg_replace('/<!(?<tag>[^\->]+)>/mi', '<'.$this->tempTagName.'-special>$1</'.$this->tempTagName.'-special>', $string);
        $string = preg_replace('/(?<tag><\/?)(?<name>head|body|html)/mi', '$1'.$this->tempTagName.'-$2', $string);

        return $string;
    }

    /**
     * @param DOMXPath        $xPath
     * @param HTML5DOMElement $domNode
     * @param ParserElement   $parserElement
     * @param string          $currentTagName
     *
     * @throws Exception
     */
    protected function prepareNode(DOMXPath $xPath, HTML5DOMElement $domNode, ParserElement $parserElement, string $currentTagName): void
    {
        $debugId = $this->debugStart('Prepare node ' . $currentTagName);

        $attributes = [];
        $data = [];
        $elements = [];
        $hasChildren = false;
        $contentElementSetting = null;
        $content = null;
        $nodePath = $domNode->getNodePath();

        foreach ($domNode->attributes as $attr) {
            $attributes[$attr->nodeName] = $attr->nodeValue;
        }

        $elementSettings = $parserElement->elementSettings();

        if ($elementSettings !== null) {
            foreach ($elementSettings as $elementSetting) {
                $data[$elementSetting->name] = [];

                //region elements
                if ($elementSetting->element !== null) {
                    $childElementTagName = $this->parserElementsByClassName[$elementSetting->element]->tagName();

                    $unfilteredChildDomNodes = $xPath->query('//' . $childElementTagName);
                    $childDomNodes = [];

                    /**
                     * @var $unfilteredChildDomNode HTML5DOMElement
                     */
                    foreach ($unfilteredChildDomNodes as $unfilteredChildDomNode) {
                        $childNodePath = $unfilteredChildDomNode->getNodePath();

                        if (preg_replace('/^(.*)(\[[\d]*])$/m', '$1', $childNodePath) === $nodePath . '/' . $childElementTagName) {
                            $childDomNodes[] = $unfilteredChildDomNode;
                        }
                    }

                    $childDomNodeCount = count($childDomNodes);

                    if ($childDomNodeCount > 0) {
                        $hasChildren = true;

                        if ($childDomNodeCount > 1 && !$elementSetting->multiple) {
                            throw new RuntimeException('Validation error of element "' . $parserElement->tagName() . '". Element containts multiple "' . $childElementTagName . '" child elements but only one is allowed!');
                        }

                        foreach ($childDomNodes as $childDomNode) {
                            $data[$elementSetting->name][] = &$this->getData($elementSetting, $this->parseElements($childDomNode->outerHTML, $currentTagName, $elementSetting->rawData));
                        }
                    }
                }
                //endregion elements

                //region attribute
                if ($elementSetting->multiple) {
                    $multipleAttributeExpression = strtr($elementSetting->multipleAttributeExpression, [
                        '{{name}}' => $elementSetting->name,
                    ]);

                    $attributeNames = preg_grep($multipleAttributeExpression, array_keys($attributes));
                } else {
                    $attributeNames = array_merge([$elementSetting->name], $elementSetting->getAliases());
                }

                foreach ($attributeNames as $attributeName) {
                    $attributeContent = $attributes[$attributeName] ?? null;

                    if ($attributeContent !== null) {
                        $attributeContent = &$this->getData($elementSetting, $attributeContent);

                        if ($elementSetting->attributeNameAsKey) {
                            $data[$elementSetting->name][$attributeName] = $attributeContent;
                        } else {
                            $data[$elementSetting->name][] = $attributeContent;
                        }
                    }
                }
                //endregion attribute

                if (!$elementSetting->multiple) {
                    $data[$elementSetting->name] = $data[$elementSetting->name][array_key_first($data[$elementSetting->name])] ?? null;
                }

                if ($elementSetting->content) {
                    $contentElementSetting = $elementSetting;
                    $content = $data[$elementSetting->name];
                }
            }
        }

        if ($content === null && !$hasChildren) {
            $content = $domNode->innerHTML;

            if ($parserElement->parseContent) {
                if ($contentElementSetting !== null && $contentElementSetting->element !== null) {
                    $contentElementSettingName = $this->parserElementsByClassName[$contentElementSetting->element]->tagName();
                    $content = $this->parseElements('<' . $contentElementSettingName . '>' . $content . '</' . $contentElementSettingName . '>', $currentTagName, $contentElementSetting->rawData);
                } else {
                    $content = $this->parseElements($content, $currentTagName);
                }
            }

            if ($contentElementSetting !== null) {
                $data[$contentElementSetting->name] = &$this->getData($contentElementSetting, $content);
                $content = &$data[$contentElementSetting->name];
            }
        }

        if ($elementSettings !== null) {
            foreach ($elementSettings as $elementSetting) {
                if ($elementSetting->defaultValue !== null && ($data[$elementSetting->name] === null || $data[$elementSetting->name] === [] || $data[$elementSetting->name] === '')) {
                    $data[$elementSetting->name] = $elementSetting->defaultValue;
                }

                $rules = new Rules($elementSetting->rules);
                $result = $rules->validate($data[$elementSetting->name]);

                if ($result->isValid() === false) {
                    throw new RuntimeException('Validation error of ElementSetting "'  . $elementSetting->name . '" of element "' . $currentTagName . '".' . PHP_EOL . 'Line: ' . $domNode->getLineNo() . PHP_EOL . 'Code: ' . $domNode->outerHTML . PHP_EOL . 'Error: ' . print_r($result->getErrors(), true));
                }
            }
        }

        $parserElement->content = $content;
        $parserElement->attributes = $attributes;
        $parserElement->elements = $elements;
        $parserElement->data = $data;

        $this->debugEnd($debugId);
    }

    /**
     * @param ElementSetting $elementSetting
     * @param mixed          $data
     *
     * @return mixed
     */
    protected function &getData(ElementSetting $elementSetting, $data)
    {
        if (!$elementSetting->safeData) {
            return $data;
        }

        return $this->getRawValue($data);
    }

    /**
     * @param      $name
     * @param null $data
     * @param bool $callLastClosure
     *
     * @return mixed|null
     */
    public function &getAttributeData($name, &$data = null, $callLastClosure = true)
    {
        if ($data === null) {
            $data = &$this->data;
        }

        return self::getValue($data, $name, $callLastClosure);
    }

    /**
     * @param string $name
     * @param        $value
     * @param null   $data
     */
    public function setAttributeData(string $name, &$value, &$data = null): void
    {
        if ($data === null) {
            $data = &$this->data;
        }

        self::setValue($data, $name, $value);
    }

    /**
     * @param        $data
     * @param string $path
     * @param        $value
     */
    public static function setValue(&$data, string $path, &$value): void
    {
        static::checkForClosure($data);

        if ($path === null) {
            $data = $value;
            return;
        }

        $keys = explode('.', $path);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($data[$key])) {
                $data[$key] = [];
            }

            static::checkForClosure($data[$key]);
            $data = &$data[$key];
        }

        $data[array_shift($keys)] = &$value;
    }

    /**
     * @param        $data
     * @param string $key
     * @param bool   $callLastClosure
     *
     * @return Closure|mixed|null
     */
    public static function &getValue(&$data, string $key, $callLastClosure = true)
    {
        static::checkForClosure($data);

        $workData = $data;
        $value = null;

        if (is_array($data)) {
            $magicKeyValue = static::checkForMagicKey($data, $key);

            if ($magicKeyValue !== null) {
                return $magicKeyValue;
            }

            if (isset($data[$key])) {
                static::checkForClosure($data[$key]);

                return $data[$key];
            }
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $mainKey = substr($key, 0, $pos);
            $workData = static::getValue($data, $mainKey, $callLastClosure);
            $data[$mainKey] = $workData;
            $key = substr($key, $pos + 1);
        }

        $magicKeyValue = static::checkForMagicKey($workData, $key);

        if ($magicKeyValue !== null) {
            return $magicKeyValue;
        }

        if (is_object($workData)) {
            if (!$callLastClosure) {
                if (method_exists($workData, $key)) {
                    $methodName = $key;
                } elseif (method_exists($workData, 'get' . ucfirst($key))) {
                    $methodName = 'get' . ucfirst($key);
                }

                if (isset($methodName)) {
                    $value = Closure::fromCallable([$workData, $methodName]);
                    return $value;
                }
            }

            return $workData->$key;
        }

        if (isset($workData[$key])) {
            if (is_array($workData)) {
                $value = &$workData[$key];
            } else {
                $value = $workData[$key];
            }

            static::checkForClosure($value);
        }

        return $value;
    }

    /**
     * @param        $array
     * @param string $key
     *
     * @return mixed|null
     */
    protected static function checkForMagicKey($array, string $key)
    {
        if ($key === '$$count' && is_countable($array)) {
            return count($array);
        }

        return null;
    }

    /**
     * @param $value
     */
    protected static function checkForClosure(&$value): void
    {
        if ($value instanceof Closure) {
            $value = $value();
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function &getRawValue($value)
    {
        if (is_array($value) || is_object($value)) {
            return $value;
        }

        $value = $this->fullTrim($value);

        if (is_numeric($value)) {
            if (mb_strpos($value, '.') === false) {
                $value = (int)$value;
                return $value;
            }

            $value = (float)$value;
            return $value;
        }

        if ($value === 'true' || $value === 't') {
            $value = true;
            return $value;
        }

        if ($value === 'false' || $value === 'f') {
            $value = false;
            return $value;
        }

        if ((mb_strpos($value, '\'') === 0 && mb_strrpos($value, '\'') === mb_strlen($value) - 1) ||
            (mb_strpos($value, '"') === 0 && mb_strrpos($value, '"') === mb_strlen($value) - 1)) {
            $value = mb_substr($value, 1, -1);
            return $value;
        }

        if (preg_match('/^([^ \n]+)$/i', $value)) {
            $dataValue = &$this->getAttributeData($value);

            if ($dataValue !== null) {
                return $dataValue;
            }
        }

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function getSafeValue($value)
    {
        if (is_numeric($value)) {
            $value = (string)$value;
        } elseif ($value === true) {
            $value = 'true';
        } elseif ($value === false) {
            $value = 'false';
        } elseif (is_string($value)) {
            $value = '\'' . $value . '\'';
        } else {
            if (!isset($this->data['temp-data-storage'])) {
                $this->data['temp-data-storage'] = [];
            }

            $count = count($this->data['temp-data-storage']);
            $tempName = 'temp-data-storage.' . $count;
            $this->setAttributeData($tempName, $value);
            $value = $tempName;
        }

        return $value;
    }

    //region debug
    /**
     * @param string $message
     *
     * @return string|null
     */
    protected function debugStart(string $message): ?string
    {
        if ($this->mode === self::MODE_DEV) {
            $debugId = md5(uniqid((string)mt_rand(), true));

            $this->debugData[$debugId] = [
                'message' => $message,
                'memory' => memory_get_usage(),
                'time' => microtime(true)
            ];

            $this->debug(str_repeat('│ ', count($this->debugData) - 1) . '┌─ '. $message);
            return $debugId;
        }

        return null;
    }

    /**
     * @param string|null $debugId
     */
    protected function debugEnd(?string $debugId): void
    {
        if ($this->mode === self::MODE_DEV) {
            $debugData = $this->debugData[$debugId];

            $currentMemory = memory_get_usage();
            $memory = $currentMemory - $debugData['memory'];

            $currentTime = microtime(true);

            unset($this->debugData[$debugId]);

            $this->debug(str_repeat('│ ', count($this->debugData)) . '└─ '. $debugData['message'], [
                'memory' => $this->getHumanSize($memory),
                'time' => $this->getHumanTime($debugData['time'], $currentTime),
            ]);
        }
    }

    /**
     * @param float $start
     * @param float $end
     *
     * @return string
     */
    protected function getHumanTime(float $start, float $end): string
    {
        $microseconds = $end - $start;
        $minutes = (int)($seconds = (int)($milliseconds = ($microseconds * 10000)) / 10000) / 60;

        return (($minutes % 60) > 0 ? ($minutes % 60) . 'min ' : '') .
            (($seconds % 60) > 0 ? ($seconds % 60) . 'sec ' : '') .
            ($milliseconds > 0 ? (($milliseconds % 10000) / 10) . 'ms' : '');
    }

    /**
     * @param int $size
     *
     * @return string
     */
    protected function getHumanSize(int $size): string
    {
        $unit = ['b','kb','mb','gb','tb','pb'];

        if ($size === 0) {
            return '0 b';
        }

        return round($size / (1024 ** ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    /**
     * @param string $message
     * @param array  $extras
     */
    protected function debug(string $message, array $extras = []): void
    {
        if ($this->mode === self::MODE_DEV) {
            foreach ($extras as $name => $value) {
                $message .= ' | ' . $name . ': ' . $value;
            }

            $this->logger->debug($message);
        }
    }
    //endregion debug
}
