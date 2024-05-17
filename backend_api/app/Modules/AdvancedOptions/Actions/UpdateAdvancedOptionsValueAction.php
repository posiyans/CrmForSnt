<?php

namespace App\Modules\AdvancedOptions\Actions;

use App\Modules\AdvancedOptions\Controllers\Auth;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsValueModel;

/**
 * Изменить значение для опции
 *
 */
class UpdateAdvancedOptionsValueAction
{

    private $model;

    public function __construct(AdvancedOptionsValueModel $option)
    {
        $this->model = $option;
    }

    public function value($value)
    {
        $this->model->value = ['value' => $value];
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->model->logAndSave('Изменение значения поля')) {
            return $this->model;
        }
        throw new \Exception('Ошибка добавления поля');
    }

}
