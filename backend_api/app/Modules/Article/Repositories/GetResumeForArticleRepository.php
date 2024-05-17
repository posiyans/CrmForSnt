<?php

namespace App\Modules\Article\Repositories;

use App\Modules\Article\Models\ArticleModel;

class GetResumeForArticleRepository
{

    private $article;

    public function __construct(ArticleModel $article)
    {
        $this->article = $article;
    }

    public function run()
    {
        if ($this->article->resume) {
            return $this->article->resume;
        }
        if ($this->article->status == 2) {
            $text = explode('</p>', $this->article->text);
            $text = explode('<img', $text[0]);
            return $text[0] . '</p>';
        }
        if ($this->article->status == 5) {
            return 'Статья доступна только собственникам';
        }
        return 'Нет описания';
    }


}