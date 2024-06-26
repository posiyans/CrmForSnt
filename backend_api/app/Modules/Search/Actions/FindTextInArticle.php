<?php

namespace App\Modules\Search\Actions;

use App\Modules\Article\Repositories\ArticleRepository;
use App\Modules\Search\Resources\ArticleResource;

class FindTextInArticle
{
    private $text;


    public function __construct($text)
    {
        $this->text = $text;
    }

    public function run()
    {
        $articles = (new ArticleRepository())->search($this->text)->all();
        return ArticleResource::collection($articles);
    }
}
