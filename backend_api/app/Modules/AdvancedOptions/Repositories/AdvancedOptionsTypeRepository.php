<?php

namespace App\Modules\AdvancedOptions\Repositories;

/**
 * поддерживаемые типы полей
 */
class AdvancedOptionsTypeRepository
{

    private static array $type = [
        [
            'type' => 'string',
            'label' => 'строка'
        ],
        [
            'type' => 'boolean',
            'label' => 'ДА/НЕТ'
        ],
        [
            'type' => 'select',
            'label' => 'выбор'
        ],
        [
            'type' => 'multi_select',
            'label' => 'множественный выбор'
        ]
    ];

    public static function getTypeKeys()
    {
        return array_map(function ($item) {
            return $item['type'];
        }, self::$type);
    }

    public static function getTypeLabel($key)
    {
        $tmp = self::getType($key);
        return $tmp['label'];
    }

    public static function getType($key)
    {
        foreach (self::$type as $type) {
            if ($type['type'] == $key) {
                $find = $type;
            }
        }
        return $find;
    }

}