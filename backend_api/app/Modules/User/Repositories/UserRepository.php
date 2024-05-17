<?php

namespace App\Modules\User\Repositories;


use App\Modules\User\Models\UserModel;

class UserRepository
{

    private \Illuminate\Database\Eloquent\Builder $query;

    public function __construct()
    {
        $this->query = UserModel::query();
    }

    public function byEmail($email): UserRepository
    {
        $this->query->where('email', $email);
        return $this;
    }


    public function find($find)
    {
        if ($find) {
            $this->query->where(function ($query) use ($find) {
                $type_db = env('DB_CONNECTION', 'mysql');
                if ($type_db == 'sqlite') {
                    // LOWER не работает на кириллице
                    $query->orWhereRaw('LOWER("name") like ?', '%' . $find . '%')
                        ->orWhereRaw('LOWER("middle_name") like ?', '%' . $find . '%')
                        ->orWhereRaw('LOWER("last_name") like ?', '%' . $find . '%')
                        ->orWhereRaw('LOWER("email") like ?', '%' . $find . '%');
                } else {
                    $items = explode(' ', $find);
                    foreach ($items as $item) {
                        $query->whereRaw('LOWER(CONCAT_WS(" ",name,middle_name,last_name,email)) like ?', '%' . $item . '%');
                    }
                }
            });
        }
        return $this;
    }

    /**
     * @return UserModel|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     * @throws \Exception
     */
    public function run()
    {
        $model = $this->query->first();
        if ($model) {
            return $model;
        }
        throw new \Exception('Пользователь не найден');
    }


    public function paginate($limit)
    {
        return $this->query->paginate($limit);
    }


}