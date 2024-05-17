<?php

namespace App\Modules\AdvancedOptions\Actions;

use App\Modules\AdvancedOptions\Controllers\Auth;
use App\Modules\AdvancedOptions\Models\AdvancedOptionsModel;
use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsObjectRepository;

/**
 * добавить опцию
 *
 */
class CreateAdvancedOptionsAction
{

    private $model;


    public function __construct()
    {
        $this->model = new AdvancedOptionsModel();
    }

    public function fill($data)
    {
        $this->model->fill($data);
        return $this;
    }

    public function object($objectName)
    {
        $this->model->commentable_type = AdvancedOptionsObjectRepository::getTypeClass($objectName);
        return $this;
    }


    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->model->logAndSave('Добавление нового поля')) {
            return $this->model;
        }
        throw new \Exception('Ошибка добавления поля');
    }

}
