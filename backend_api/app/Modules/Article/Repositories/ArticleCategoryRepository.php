<?php

namespace App\Modules\Article\Repositories;

use App\Modules\Article\Models\CategoryModel;

/**
 * @deprecated
 * перенесено в подпапку CategoryRepository
 */
class ArticleCategoryRepository
{

    private $query;
    private $mark_default;

    public function __construct()
    {
        $this->query = CategoryModel::query();
    }

    public function public()
    {
        $this->query->where('public', true);
        return $this;
    }


    public function all()
    {
        return $this->query->get();
    }


}