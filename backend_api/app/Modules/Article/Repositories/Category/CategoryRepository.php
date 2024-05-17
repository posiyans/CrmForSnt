<?php

namespace App\Modules\Article\Repositories\Category;

use App\Modules\Article\Models\CategoryModel;
use Illuminate\Support\Collection;

class CategoryRepository
{

    private $query;

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

    public function allChildren($parent_id)
    {
        $rez = new Collection();
        $children = $this->query->where('parent', $parent_id)->get();
        foreach ($children as $child) {
            $rez->push($child);
            $tmp = (new CategoryRepository())->allChildren($child->id);
            foreach ($tmp as $item) {
                $rez->push($item);
            }
        }
        return $rez;
    }

//
//    private function children($parent_id)
//    {
//        return $this->query->where('parent', $parent_id)->get();
//    }
}