<?php

namespace App\Modules\Article\Actions;

use App\Modules\Article\Models\ArticleModel;
use Illuminate\Support\Facades\Auth;
use Str;

class CreateArticleAction
{
    private $article;

    public function __construct(array $opt = [])
    {
        $this->article = new ArticleModel();
        $this->article->status = 1;
        $this->article->allow_comments = 1;
        $this->article->user_id = Auth::id() ?? 0;
        $this->article->fill($opt);
    }

    public function status(int $status)
    {
        $this->article->status = $status;
        return $this;
    }

    public function forModeration()
    {
        $this->article->status = 3;
        return $this;
    }

    public function run()
    {
        $this->article->slug = substr(Str::slug($this->article->title), 0, 240);
        if ($this->article->logAndSave('Создание статьи')) {
            return $this->article;
        }
        throw new \Exception($this->article->errors);
    }


}