<?php

namespace App\Modules\Owner\Actions;

use App\Modules\Owner\Models\OwnerUserModel;
use App\Modules\User\Actions\ChangeRoleToUserAction;
use Illuminate\Support\Facades\DB;

/**
 * Удалить собственника
 */
class DeleteOwnerAction
{
    private $owner;

    public function __construct(OwnerUserModel $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $this->deleteUserFields();
            $this->deleteSteadInfo();
            $this->checkUser();
            if ($this->owner->logAndDelete('Удаление собственника')) {
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
        }
        DB::rollBack();
        throw new \Exception('Ошибка удаления');
    }

    /**
     * открепляем участки от собственника
     *
     * @return void
     */
    private function deleteSteadInfo()
    {
        $this->owner->steads()->detach();
    }

    /**
     * Удаляем данные собственника
     *
     * @return void
     */
    private function deleteUserFields()
    {
        $fields = $this->owner->values;
        foreach ($fields as $field) {
            $field->logAndDelete('Удаление собственника');
        }
    }

    /**
     * Удалить роль собственника у пользователя при удалении собственника
     *
     * @return void
     */
    private function checkUser()
    {
        $user = $this->owner->user;
        if ($user) {
            (new ChangeRoleToUserAction($user))->deleteRole('owner');
        }
    }


}
