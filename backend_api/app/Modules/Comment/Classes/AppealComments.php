<?php

namespace App\Modules\Comment\Classes;

use App\Modules\Appeal\Models\AppealModel as Model;
use App\Modules\Comment\Models\CommentModel;
use App\Modules\User\Models\UserModel;

class AppealComments extends AbstractComments
{

    public function __construct(Model $object)
    {
        $this->object = $object;
    }

    public function descriptionForComment(): array
    {
        return [
            'label' => 'обращения ' . $this->object->title,
            'url' => '/admin/appeal/show/' . $this->object->id,
        ];
    }

    public function commentRead($user): bool
    {
        if (!$user) {
            return false;
        }
        return $this->object->accessRead($user);
    }

    public function commentWrite(\App\Modules\User\Models\UserModel $user): bool
    {
        return $this->object->commentWrite($user);
    }

    public function commentDelete(UserModel $user, CommentModel|null $comment = null): bool
    {
        return false;
    }
}