<?php

namespace Database\Seeders\Demo;

use App\Modules\Article\Actions\CreateArticleAction;
use App\Modules\Article\Models\ArticleModel;
use Illuminate\Database\Seeder;
use Str;

class ArticleModelDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo 'Demo ArticleModelSeeder ' . "\n";
        ArticleModel::factory()->count(100)->create();
        $demo = env('DEMO', false);
        if ($demo) {
            $opt = [
                'title' => 'Demo доступ',
                'uid' => Str::uuid(),
                'user_id' => 1,
                'resume' => 'Параметры для доступа в Демо',
                'text' => '<p>Вход как Администрация</p><p>email: admin@examples.com</p><p>пароль: 123admin</p><p>&nbsp;</p><p>Вход как собственник</p><p>email: owner@examples.com</p><p>пароль: 123admin</p><p>&nbsp;</p><p>Код проекта <a href="https://github.com/posiyans/CrmForSnt">https://github.com/posiyans/CrmForSnt</a></p>',
                'category_id' => 1,
                'allow_comments' => 3
            ];
            (new CreateArticleAction($opt))
                ->status(2)
                ->run();
        }
    }
}
