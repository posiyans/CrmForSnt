<?php

namespace App\Modules\File\AccessClass;

use App\Modules\BanUser\Actions\CheckUserBanAction;
use App\Modules\File\Repositories\GetObjectForFileRepository;

/**
 * Проверить на право на фаил
 *
 */
class ArticleModelAccessClass extends FileAccessAbstract
{
    private $file;
    private $user;

    public function __construct($opt = [])
    {
        $this->file = $opt[0];
        $this->user = $opt[1];
    }

    public function read()
    {
        if ($this->user && $this->file->user_id == $this->user->id) {
            return true;
        }
        $model = (new GetObjectForFileRepository($this->file))->run();
        if ($model->status == 2) {
            return true;
        }
        if (!$this->user) {
            throw new \Exception('Ошибка доступа');
        }
        if ($this->user->ability('superAdmin', 'article-edit', 'article-show')) {
            return true;
        }
        if ($model->status == 5 && $this->user->hasRole('owners')) {
            return true;
        }
        throw new \Exception('Ошибка доступа');
    }

    public function write()
    {
        (new CheckUserBanAction($this->user))
            ->type('article')
            ->run();
    }

    public function delete()
    {
        throw new \Exception('Ошибка доступа');
    }

}