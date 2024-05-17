<?php

namespace App\Modules\AdvancedOptions\Actions;

use App\Modules\AdvancedOptions\Controllers\Auth;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsModel;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsValueModel;

/**
 * Создать значение для опции
 *
 */
class CreateAdvancedOptionsValueAction
{

    private $model;

    public function __construct(AdvancedOptionsModel $options, $parent_id)
    {
        $this->model = AdvancedOptionsValueModel::firstOrNew(
            ['advanced_options_id' => $options->id],
            ['commentable_id' => $parent_id],
        );
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
        if ($this->model->logAndSave('Добавление значения поля')) {
            return $this->model;
        }
        throw new \Exception('Ошибка добавления поля');
    }

}
