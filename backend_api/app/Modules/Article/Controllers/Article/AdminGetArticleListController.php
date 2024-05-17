<?php

namespace App\Modules\Article\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Modules\Article\Repositories\ArticleRepository;
use App\Modules\Article\Resources\AdminArticleListResource;
use Illuminate\Http\Request;

/**
 * получить список статей
 *
 */
class AdminGetArticleListController extends Controller
{


    public function __construct()
    {
        $this->middleware('ability:superAdmin,article-show,article-edit');
    }

    public function index(Request $request)
    {
        $articles = (new ArticleRepository())
            ->category($request->category)
            ->status($request->status)
            ->search($request->find)
            ->sortByIdDesc()
            ->paginate($request->limit);
        return AdminArticleListResource::collection($articles);
    }
}
