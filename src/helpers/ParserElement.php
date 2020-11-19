<?php

declare(strict_types=1);

namespace fafte\helpers;

use fafte\FafteParser;

/**
 * Class ParserElement
 * @package fafcms\parser
 */
abstract class ParserElement extends BaseObject
{
    /**
     * @var FafteParser
     */
    protected FafteParser $parser;

    /**
     * @param FafteParser $parser
     *
     * @return $this
     */
    public function setParser(FafteParser $parser): self
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * @var bool
     */
    public bool $prefixParserName = true;

    /**
     * @var bool specify if content should be parsed. If set to false content will return raw data.
     */
    public bool $parseContent = true;

    /**
     * @var array Parsed data of element
     */
    public array $data = [];

    /**
     * @var array Raw attributes of element
     */
    public array $attributes = [];

    /**
     * @var array Raw child elements of element
     */
    public array $elements = [];

    /**
     * @var mixed Content of element
     */
    public $content;

    /**
     * @return ElementSetting[]|null
     */
    public function elementSettings(): ?array
    {
        return null;
    }

    /**
     * @return string
     */
    abstract public function name(): string;

    /**
     * @return array
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
     * @return array
     */
    public function editorOptions(): array
    {
        return ['tag' => 'div'];
    }

    /**
     * @return array|null
     */
    public function allowedTypes(): ?array
    {
        return null;
    }

    /**
     * @return array|null
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
     * @return string
     */
    public function tagName(): string
    {
        return ($this->prefixParserName ? $this->parser->name . '-' : '') . $this->name();
    }

    /**
     * @var array|null
     */
    private ?array $tagNameAliases = null;

    /**
     * @return array
     */
    public function tagNameAliases(): array
    {
        if ($this->tagNameAliases === null) {
            $this->tagNameAliases = [];

            foreach ($this->aliases() as $alias) {
                $this->tagNameAliases[] = ($this->prefixParserName ? $this->parser->name . '-' : '') . $alias;
            }
        }

        return $this->tagNameAliases;
    }

    /**
     * @return mixed
     */
    abstract public function run();
}
