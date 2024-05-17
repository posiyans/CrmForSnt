<?php

namespace App\Modules\Search\Actions;

use App\Modules\Search\Resources\SiteMenuResource;
use App\Modules\SiteMenu\Models\SiteMenuModel;

class FindTextInSiteMenu
{
    private $text;

    public function __construct($text)
    {
        $this->text = trim(strtolower($text));
    }

    public function run()
    {
        $models = SiteMenuModel::whereRaw('LOWER(`label`) LIKE ?', ['%' . $this->text . '%'])->get();
        return SiteMenuResource::collection($models);
    }
}
