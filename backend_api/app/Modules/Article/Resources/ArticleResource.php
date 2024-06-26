<?php

namespace App\Modules\Article\Resources;

use App\Modules\Article\Repositories\GetResumeForArticleRepository;
use App\Modules\Comment\Repositories\GetCommentsForObject;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'uid' => $this->uid,
            'title' => $this->title,
            'resume' => (new GetResumeForArticleRepository($this->resource))->run(),
            'category_id' => $this->category_id,
            'allow_comments' => $this->allow_comments,
            'count_comments' => (new GetCommentsForObject($this->resource))->run()->count(),
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'slug' => $this->slug,
            'author' => null
        ];
        if ($this->author) {
            $data['author'] = [
                'uid' => $this->author->uid,
                'name' => $this->author->name,
            ];
        }
        return $data;
    }
}
