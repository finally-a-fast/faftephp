<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Elements;

use Faf\TemplateEngine\Helpers\ElementSetting;
use Faf\TemplateEngine\Helpers\ParserElement;
use JsonException;

/**
 * Class JsonDecode
 *
 * @package Faf\TemplateEngine\Elements
 */
class JsonDecode extends ParserElement
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'json-decode';
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return 'Json decodes defined data';
    }

    /**
     * {@inheritdoc}
     */
    public function elementSettings(): array
    {
        return [
            new ElementSetting([
                'name' => 'data',
                'label' => 'Data',
                'content' => true
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws JsonException
     */
    public function run()
    {
        return json_decode($this->data['data'], true, 512, JSON_THROW_ON_ERROR | JSON_HEX_TAG);
    }
}
