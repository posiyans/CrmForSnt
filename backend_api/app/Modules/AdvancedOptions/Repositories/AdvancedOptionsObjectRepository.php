<?php

namespace App\Modules\AdvancedOptions\Repositories;

use App\Modules\Stead\Models\SteadModel;

class AdvancedOptionsObjectRepository
{

    private static array $object = [
        'stead' => [
            'class' => SteadModel::class,
            'types' => ['options'], // подклассификация
            'types_value' => null,
            'permissions' => ['stead-edit']
        ]
    ];

    public static function getObjectName()
    {
        return array_keys(self::$object);
    }

    public static function getTypeClass($objectName): string
    {
        if (isset(self::$object[$objectName]['class']) && !empty(self::$object[$objectName]['class'])) {
            return self::$object[$objectName]['class'];
        }
        return throw new \Exception('Не указан класса обьекта');
    }

    public static function getTypeName($objectName): array
    {
        if (isset(self::$object[$objectName]['types_value']) && !empty(self::$object[$objectName]['types_value'])) {
            return self::$object[$objectName]['types_value'];
        }
        return AdvancedOptionsTypeRepository::getTypeKeys();
    }

    public static function getTypeOptions($objectName): array
    {
        if (isset(self::$object[$objectName]['types']) && !empty(self::$object[$objectName]['types'])) {
            return self::$object[$objectName]['types'];
        }
        return [];
    }

    public static function getTypePermissions($objectName): array
    {
        if (isset(self::$object[$objectName]['permissions']) && !empty(self::$object[$objectName]['permissions'])) {
            return self::$object[$objectName]['permissions'];
        }
        return [];
    }

    public static function getObjectByClassName($className)
    {
        foreach (self::$object as $key => $object) {
            if (isset($object['class']) && $object['class'] == $className) {
                return $key;
            }
        }
        throw new \Exception('Неизвестный объект');
    }

}