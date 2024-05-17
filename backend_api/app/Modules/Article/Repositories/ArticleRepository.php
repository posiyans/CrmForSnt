<?php

namespace App\Modules\Article\Repositories;

use App\Modules\Article\Models\ArticleModel;
use App\Modules\Article\Repositories\Category\CategoryRepository;

class ArticleRepository
{

    private $query;

    public function __construct()
    {
        $this->query = ArticleModel::query();
    }

    public function slug($slug)
    {
        $this->query->where('slug', $slug);
        return $this;
    }

    public function public()
    {
        $this->query->where(function ($query) {
            $query->where('status', 2)->orWhere('status', 5);
        });
        return $this;
    }

    /**
     * для категории и покатегорий
     *
     * @param $category_id
     * @return $this
     */
    public function category($category_id)
    {
        if ($category_id) {
            $ids = [$category_id];
            $category = (new CategoryRepository())->allChildren($category_id);
            foreach ($category as $item) {
                $ids[] = $item->id;
            }
            $this->query->whereIn('category_id', $ids);
        }
        return $this;
    }

    public function status($status)
    {
        if ($status) {
            $this->query->where('status', $status);
        }
        return $this;
    }


    public function search($find)
    {
        if ($find) {
            $find = explode(' ', mb_strtolower($find));
            foreach ($find as $item) {
                if (!empty(trim($item))) {
                    $this->query->whereRaw('LOWER(CONCAT_WS(" ",title, resume, text)) like ?', '%' . $item . ' %');
                }
            }
        }

        return $this;
    }

    public function sortByIdDesc()
    {
        $this->query->orderBy('id', 'DESC');
        return $this;
    }

    public function run()
    {
        $model = $this->query->first();
        if ($model) {
            return $model;
        }
        throw new \Exception('Статья  не найдена');
    }

    /**
     * @return ArticleModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @deprecated
     *
     */
    public function all()
    {
        return $this->get();
    }

//    public function get()
//    {
//        return $this->query->get();
//    }
//
//    public function paginate($limit)
//    {
//        return $this->query->paginate($limit);
//    }


    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(array($this->query, $name), $arguments);
    }

}