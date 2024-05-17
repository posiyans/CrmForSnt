<?php

namespace App\Modules\Article\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Modules\Article\Repositories\ArticleRepository;
use App\Modules\Article\Resources\ArticleResource;
use Illuminate\Http\Request;

/**
 * получить список статей
 *
 */
class GetArtileListForCategoryController extends Controller
{

    public function __invoke(Request $request)
    {
        $articles = (new ArticleRepository())
            ->category($request->category_id)
            ->public()
            ->sortByIdDesc()
            ->paginate($request->limit);
        return ArticleResource::collection($articles);
    }
}
