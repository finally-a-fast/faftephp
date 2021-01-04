<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Helpers;

use Faf\TemplateEngine\Parser;
use IvoPetkov\HTML5DOMElement;

/**
 * Class ParserElement
 *
 * @package Faf\TemplateEngine\Helpers
 */
abstract class ParserElement extends BaseObject
{
    use TagTrait;

    /**
     * @var Parser
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected Parser $parser;

    /**
     * @var bool
     */
    protected bool $prefixParserName = true;

    /**
     * @var bool specify if content should be parsed. If set to false content will return raw html.
     */
    protected bool $parseContent = true;

    /**
     * @var bool specify if parsed content should return raw data.
     */
    protected bool $contentAsRawData = false;

    /**
     * @var array<string|int, array|string|int|float|bool|object> Parsed data of element
     */
    protected array $data = [];

    /**
     * @var array<string, string> Raw attributes of element
     */
    protected array $attributes = [];

    /**
     * @var array<int|string, mixed>|string|int|float|bool|object|null Content of element
     */
    protected $content;

    /**
     * @var HTML5DOMElement The current dom node
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected HTML5DOMElement $domNode;

    //region getter and setter
    /**
     * @return Parser
     */
    public function getParser(): Parser
    {
        return $this->parser;
    }

    /**
     * @param Parser $parser
     *
     * @return $this
     */
    public function setParser(Parser $parser): self
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * @return HTML5DOMElement
     */
    public function getDomNode(): HTML5DOMElement
    {
        return $this->domNode;
    }

    /**
     * @param HTML5DOMElement $domNode
     *
     * @return $this
     */
    public function setDomNode(HTML5DOMElement $domNode): self
    {
        $this->domNode = $domNode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrefixParserName(): bool
    {
        return $this->prefixParserName;
    }

    /**
     * @param bool $prefixParserName
     *
     * @return $this
     */
    public function setPrefixParserName(bool $prefixParserName): self
    {
        $this->prefixParserName = $prefixParserName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isContentParsed(): bool
    {
        return $this->parseContent;
    }

    /**
     * @return bool
     */
    public function isContentRawData(): bool
    {
        return $this->contentAsRawData;
    }

    /**
     * @return array<string|int, array|string|int|float|bool|object>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array<string|int, array|string|int|float|bool|object> $data
     *
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array<string, string> $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return array<int|string, mixed>|string|int|float|bool|object|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param array<int|string, mixed>|string|int|float|bool|object|null $content
     *
     * @return $this
     */
    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
    //endregion getter and setter

    /**
     * @return ElementSetting[]
     */
    public function elementSettings(): array
    {
        return [];
    }

    /**
     * @return string
     */
    abstract public function name(): string;

    /**
     * @return string[]
     */
    public function aliases(): array
    {
        return [];
    }

    /**
     * @return string
     */
    abstract public function description(): string;

    /**
     * @return array[]|string[]
     */
    public function editorOptions(): array
    {
        return ['tag' => 'div'];
    }

    /**
     * @return int[]|null
     */
    public function allowedTypes(): ?array
    {
        return null;
    }

    /**
     * @return string[]|null
     */
    public function allowedParents(): ?array
    {
        return null;
    }

    /**
     * Initializes parser element and executes bootstrap components.
     * This method is called by parser component after loading available parser elements.
     * If you override this method, make sure you also call the parent implementation.
     */
    public function bootstrap(): void
    {
    }

    /**
     * @return mixed|void
     */
    abstract public function run();
}
