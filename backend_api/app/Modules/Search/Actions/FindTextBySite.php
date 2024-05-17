<?php

namespace App\Modules\Search\Actions;


class FindTextBySite
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }


    public function run()
    {
        $result = collect();
        $result = $result->merge((new FindTextInSiteMenu($this->text))->run());
        $result = $result->merge((new FindTextInArticle($this->text))->run());
        return $result;
    }
}
