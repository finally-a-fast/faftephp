<?php

declare(strict_types=1);

namespace fafte\helpers;

use fafte\FafteParser;
use Exception;

/**
 * Class DataHelper
 *
 * @package fafcms\parser\helpers
 */
class DataHelper extends BaseObject
{
    /**
     * @var string|int|null
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @var bool
     */
    public bool $keepEmpty;

    /**
     * @param string|int|null $name
     *
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param bool $keepEmpty
     *
     * @return $this
     */
    public function setKeepEmpty(bool $keepEmpty): self
    {
        $this->keepEmpty = $keepEmpty;
        return $this;
    }

    /**
     * @param string      $name
     * @param             $value
     * @param FafteParser $parser
     */
    private static function setData(string $name, $value, FafteParser $parser): void
    {
        $parser->setAttributeData($name, $value);
    }

    /**
     * @param array       $rawParams
     * @param bool        $setAttributeData
     * @param FafteParser $parser
     *
     * @return array
     * @throws Exception
     */
    public static function formatParams(array $rawParams, bool $setAttributeData, FafteParser $parser): array
    {
        $params = [];

        foreach ($rawParams as $name => $value) {
            if ($value instanceof self) {
                $name  = $value->name;
                $value = $value->value;
            }

            if ($name === null) {
                if ($setAttributeData) {
                    throw new Exception('To set data the name attribute is required.');
                }

                $params[] = self::formatValue($value, $parser);
            } else {
                $params[$name] = self::formatValue($value, $parser);

                if ($setAttributeData) {
                    self::setData($name, $params[$name], $parser);
                }
            }
        }

        return $params;
    }

    /**
     * @param mixed       $value
     * @param FafteParser $parser
     *
     * @return mixed
     */
    public static function formatValue($value, FafteParser $parser)
    {
        return $parser->getRawValue($value);
    }
}
