<?php

declare(strict_types=1);

namespace Faf\TemplateEngine\Helpers;

/**
 * Trait ConditionTrait
 *
 * @package Faf\TemplateEngine\Helpers
 */
trait ConditionTrait
{
    /**
     * @param string             $type
     * @param array<int, bool> $conditions
     *
     * @return bool
     */
    public function checkConditionArray(string $type, array $conditions): bool
    {
        $result = false;

        foreach ($conditions as $condition) {
            if ($condition) {
                $result = true;

                if ($type === 'or') {
                    break;
                }
            } elseif ($type === 'and') {
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * @param array<string|int, array|string|int|float|bool|object|DataHelper> $rawParams
     *
     * @return array<string|int, array|string|int|float|bool|object>
     */
    public function getParams(array $rawParams): array
    {
        $params = [];

        foreach ($rawParams as $index => $value) {
            if ($value instanceof DataHelper) {
                $value = $value->value;
            }

            $params[$index] = $value;
        }

        return $params;
    }
}
