<?php

namespace Database\Seeders\Demo;

use App\Modules\Owner\Actions\AddSteadToOwnerAction;
use App\Modules\Owner\Actions\CompareOwnerAndUserAction;
use App\Modules\Owner\Actions\CreateOwnerAction;
use App\Modules\Stead\Models\SteadModel;
use App\Modules\User\Models\UserModel;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SteadModelDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo get_class($this) . "\n";
        $steads = SteadModel::factory()->count(5)->create();
        $owner = null;
        foreach ($steads as $stead) {
            if ($owner && rand(0, 10) > 8) {
                // Данный участок предыдущему собственнику
            } else {
                $faker = (new Factory())->create('ru_RU');
                $name = explode(' ', $faker->name);
                $data = [
                    'surname' => $name[0],
                    'name' => $name[1],
                    'middle_name' => $name[2],
                    'general_phone' => $faker->phoneNumber,
                    'email' => $faker->safeEmail
                ];
                $owner = (new CreateOwnerAction($data))->run();
            }
            (new AddSteadToOwnerAction($stead, $owner))->run();
        }
        $steads = SteadModel::factory()->count(3)->create();
        foreach ($steads as $stead) {
            (new AddSteadToOwnerAction($stead, $owner))->run();
        }
        $user = UserModel::where('email', 'owner@examples.com')->first();

        (new CompareOwnerAndUserAction($owner, $user))->run();
    }


}


